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
      VALUES (:project_name, :description, '" . Helper::get_local_time() . "', :owner)",
      ['project_name' => $project_name, 'description' => $description, 'owner' => $owner]
    );

    $project_id = DatabaseManager::instance()->get_last_id();
    DatabaseManager::instance()->query(
      "INSERT INTO project_role (project_id, user_id, user_role)
      VALUES (:project_id, :user_id, :owner)",
      ['project_id' => $project_id, 'user_id' => $owner, 'owner' => ProjectRole::owner->name]
    );
  }

  static function get_owned_projects(?int $owner = null): array {
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

  static function get_joined_projects(?int $user_id): array {
    if ($user_id == null) {
      return [];
    }
    
    $res = DatabaseManager::instance()->query(
      "SELECT p.project_id, p.project_name, p.`description`, p.date_created, u.username as owner_name, p.owner, COUNT(i.issue_id) as issue_count
      FROM project as p
      JOIN project_role as r ON p.project_id = r.project_id
      JOIN user as u ON u.user_id = p.owner
      LEFT JOIN issue as i ON p.project_id = i.project_id
      WHERE r.user_id = :user_id
      GROUP BY p.project_id, p.project_name, p.`description`, p.date_created, u.username",
      ['user_id' => $user_id]
    )->fetchAll();

    $projects = [];
    foreach ($res as $project) {
      if ($project['owner'] == $user_id) {
        continue;
      }
      $projects[] = new ProjectModel(
        $project['project_id'],
        $project['project_name'],
        $project['description'],
        $project['date_created'],
        $project['owner_name'],
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

  static function add_member(int $project_id, string $email, string $role): void {
    if (empty($email)) {
      throw new \Exception('Email is required');
    }
    $user_info = UserModel::find_user($email);
    if (!$user_info) {
      throw new \Exception('User not found');
    }

    $user_id = $user_info->user_id;
    $res = DatabaseManager::instance()->query(
      "SELECT user_id FROM project_role WHERE user_id = :user_id and project_id = :project_id",
      ['user_id' => $user_id, 'project_id' => $project_id]
    )->fetch();

    if (!$res) {
      ProjectRole::find_by_name($role);

      DatabaseManager::instance()->query(
        "INSERT INTO project_role (project_id, user_id, user_role) VALUES (:project_id, :user_id, :role)",
        ['project_id' => $project_id, 'user_id' => $user_id, 'role' => $role]
      );
      return;
    }
    throw new \Exception('User is already a member');
  }

  static function get_members(int $project_id) {
    $res = DatabaseManager::instance()->query(
      "SELECT u.avatar_url, u.username, u.email, r.user_role
      FROM project_role as r
      JOIN user as u ON r.user_id = u.user_id
      WHERE r.project_id = :project_id",
      ['project_id' => $project_id]
    )->fetchAll();

    $members = [];
    foreach ($res as $member) {
      $members[] = [
        'avatar_url' => $member['avatar_url'],
        'username' => $member['username'],
        'email' => $member['email'],
        'user_role' => ProjectRole::find_by_name($member['user_role']),
      ];
    }
    return $members;
  }

  static function is_member_owner(int $project_id, int $user_id): bool {
    $res = DatabaseManager::instance()->query(
      "SELECT user_role FROM project_role WHERE project_id = :project_id AND user_id = :user_id",
      ['project_id' => $project_id, 'user_id' => $user_id]
    )->fetch();

    return $res['user_role'] === ProjectRole::owner->name;
  }
}