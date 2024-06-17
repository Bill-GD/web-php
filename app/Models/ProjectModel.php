<?php
namespace App\Models;

use App\Database\DatabaseManager;

class ProjectModel {
  // create table if not exists project (
  //   project_id int auto_increment primary key,
  //   project_name varchar(50) not null,
  //   `description` text not null,
  //   date_created datetime not null,
  //   `owner` int not null,
  //   foreign key (`owner`) references `user` (user_id) on delete cascade -- delete account -> delete all owned projects
  // );

  // create the fields
  public int $project_id;
  public string $project_name;
  public string $description;
  public string $date_created;
  public string $owner;

  // create the constructor
  private function __construct(
    int $project_id,
    string $project_name,
    string $description,
    string $date_created,
    string $owner
  ) {
    $this->project_id = $project_id;
    $this->project_name = $project_name;
    $this->description = $description;
    $this->date_created = $date_created;
    $this->owner = $owner;
  }

  static function get_all_projects(?string $owner = null): array {
    $query = "SELECT p.project_id, p.project_name, p.`description`, p.date_created, u.username as owner
              FROM project as p, user as u
              WHERE p.owner = u.user_id";
    $query .= $owner ? ' AND `owner` = :owner' : '';

    $res = DatabaseManager::instance()->query(
      $query,
      $owner ? ['owner' => $owner] : []
    )->fetchAll();

    $projects = [];
    foreach ($res as $project) {
      $projects[] = new ProjectModel(
        $project['project_id'],
        $project['project_name'],
        $project['description'],
        $project['date_created'],
        $project['owner'],
      );
    }
    return $projects;
  }
}