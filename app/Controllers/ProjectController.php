<?php
namespace App\Controllers;

use App\Models\ProjectModel;
use App\Helpers\Helper;

class ProjectController extends BaseController {
  public function index(): string {
    $is_logged_in = Helper::is_logged_in();
    $is_admin = Helper::is_admin();
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

  public function create_project(): void {
    if (Helper::is_admin()) {
      Helper::redirect_to('create-project?error_message=' . urlencode('Admins cannot create project'));
    }
    try {
      $project_name = $_POST['project_name'];
      $description = $_POST['project_description'];
      $owner = $_COOKIE['user_id'];

      ProjectModel::create_project($project_name, $description, $owner);
    } catch (\Exception $e) {
      Helper::redirect_to('create-project?error_message=' . urlencode($e->getMessage()));
    }
    Helper::redirect_to('projects');
  }
}