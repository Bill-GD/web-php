<?php
namespace App\Controllers;

use App\Database\DatabaseManager;

class Home extends BaseController {
  public function index(): string {
    $is_logged_in = \App\Helpers\Helper::is_logged_in();
    $is_admin = \App\Helpers\Helper::is_admin();
    $data = ['is_logged_in' => $is_logged_in];

    if ($is_logged_in) {
      $user_id = $_COOKIE['user_id'];

      $data['projects'] = DatabaseManager::instance()->query(
        "SELECT project_name, `description`, date_created, `owner` 
        FROM project" .
        ($is_admin ? '' : " WHERE `owner` = :id"),
        $is_admin ? [] : ['id' => $user_id],
      )->fetchAll();

      $data['issues'] = DatabaseManager::instance()->query(
        "SELECT i.issue_id, p.project_name, p.owner, i.title as issue_title, i.description, i.status, i.priority, i.issuer, i.date_created, i.date_updated 
        FROM issue as i, project as p 
        WHERE i.project_id = p.project_id" . ($is_admin ? ' ' : " AND `owner` = :id ") .
        "ORDER BY i.date_updated DESC",
        $is_admin ? [] : ['id' => $user_id],
      )->fetchAll();
    }
    return view('home', $data);
  }
}
