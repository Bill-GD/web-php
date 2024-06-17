<?php
namespace App\Models;

use App\Database\DatabaseManager;
use App\Helpers\Helper;

class ProjectModel {
  public int $project_id;
  public string $project_name;
  public string $description;
  public string $date_created;
  public string $owner;
  public int $issue_count;

  // create the constructor
  private function __construct(
    int $project_id,
    string $project_name,
    string $description,
    string $date_created,
    string $owner,
    int $issue_count,
  ) {
    $this->project_id = $project_id;
    $this->project_name = $project_name;
    $this->description = $description;
    $this->date_created = $date_created;
    $this->owner = $owner;
    $this->issue_count = $issue_count;
  }

  static function create_project(string $project_name, string $description, int $owner): void {
    if (empty($project_name) || empty($description)) {
      throw new \Exception('Project name and description are required');
    }
    if (strlen($project_name) > 50) {
      throw new \Exception('Project name must be less than 50 characters');
    }
    if (!preg_match("/^[a-zA-Z0-9 _-]*$/", $project_name)) {
      throw new \Exception('Only letters, numbers, white space, underscore, hyphen allowed in project name');
    }

    [$project_name, $description] = DatabaseManager::mysql_escape([$project_name, $description]);

    DatabaseManager::instance()->query(
      "INSERT INTO project (project_name, `description`, date_created, `owner`)
      VALUES (:project_name, :description, '". Helper::get_local_time() ."', :owner)",
      ['project_name' => $project_name, 'description' => $description, 'owner' => $owner]
    );
  }

  static function get_all_projects(?int $owner = null): array {
    $query = "SELECT p.project_id, p.project_name, p.`description`, p.date_created, u.username as owner, COUNT(i.issue_id) as issue_count
              FROM project as p
              JOIN user as u ON p.owner = u.user_id
              LEFT JOIN issue as i ON p.project_id = i.project_id
              WHERE p.owner = u.user_id";
    $query .= $owner != null ? ' AND u.user_id = :owner' : '';
    $query .= " GROUP BY p.project_id, p.project_name, p.`description`, p.date_created, u.username";

    $res = DatabaseManager::instance()->query(
      $query,
      $owner != null ? ['owner' => $owner] : []
    )->fetchAll();

    $projects = [];
    foreach ($res as $project) {
      $projects[] = new ProjectModel(
        $project['project_id'],
        $project['project_name'],
        $project['description'],
        $project['date_created'],
        $project['owner'],
        $project['issue_count'],
      );
    }
    return $projects;
  }

  static function get_project(int $project_id): ProjectModel {
    $res = DatabaseManager::instance()->query(
      "SELECT p.project_id, p.project_name, p.`description`, p.date_created, u.username as owner, COUNT(i.issue_id) as issue_count
      FROM project as p
      JOIN user as u ON p.owner = u.user_id
      LEFT JOIN issue as i ON p.project_id = i.project_id
      WHERE p.project_id = :project_id
      GROUP BY p.project_id, p.project_name, p.`description`, p.date_created, u.username",
      ['project_id' => $project_id]
    )->fetch();

    if (!$res) {
      throw new \Exception('Project not found');
    }
    return new ProjectModel(
      $res['project_id'],
      $res['project_name'],
      $res['description'],
      $res['date_created'],
      $res['owner'],
      $res['issue_count'],
    );
  }
}