<?php
namespace App\Controllers;

use App\Models\ProjectModel;

class ProjectController extends BaseController {
  public function index(): string {
    $is_logged_in = \App\Helpers\Helper::is_logged_in();
    $is_admin = \App\Helpers\Helper::is_admin();
    $data = ['is_logged_in' => $is_logged_in];

    if ($is_logged_in) {
      $user_id = $is_admin ? null : $_COOKIE['user_id'];

      $data['projects'] = ProjectModel::get_all_projects($user_id);
    }
    return view('project/project_list', $data);
  }

  public function create(): string {
    return view('project/create_project');
  }
}