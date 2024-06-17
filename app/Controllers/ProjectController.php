<?php
namespace App\Controllers;

use App\Models\ProjectModel;
use App\Helpers\Helper;

class ProjectController extends BaseController {
  public function index(): string {
    $is_logged_in = Helper::is_logged_in();
    $is_admin = Helper::is_admin();
    $data = ['is_logged_in' => $is_logged_in];

    if (!$is_logged_in) {
      Helper::redirect_to('/');
    }
    $user_id = $is_admin ? null : $_COOKIE['user_id'];
    $p = ProjectModel::get_owned_projects($user_id);

    if (isset($_GET['p'])) {
      $p = array_filter($p, fn($project) => str_contains(strtolower($project->project_name), strtolower($_GET['p'])));
    }

    $data['projects'] = $p;
    return view('project/project_list', $data);
  }

  public function filter(string $filter): string {
    if (Helper::is_admin()) {
      return $this->index();
    }

    $is_logged_in = Helper::is_logged_in();
    $data = ['is_logged_in' => $is_logged_in];

    if (!$is_logged_in) {
      Helper::redirect_to('/');
    }
    $user_id = $_COOKIE['user_id'];
    $data['projects'] = $filter === 'joined' ? ProjectModel::get_joined_projects($user_id) : ProjectModel::get_owned_projects($user_id);
    // add filter to data, first letter capital, rest lower case, dash in front, with white spaces
    $data['filter'] = ' - ' . ucfirst($filter);

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
      $project_name = $_GET['project_name'];
      $description = $_GET['project_description'];
      $owner = $_COOKIE['user_id'];

      ProjectModel::create_project($project_name, $description, $owner);
    } catch (\Exception $e) {
      Helper::redirect_to('create-project?error_message=' . urlencode($e->getMessage()));
    }
    Helper::redirect_to('projects');
  }

  public function view_project(string $project_id): string {
    if (!Helper::is_logged_in()) {
      Helper::redirect_to('/');
    }
    if (Helper::is_admin()) {
      Helper::redirect_to('projects?error_message=' . urlencode('Admins cannot view project'));
    }

    $p = ProjectModel::get_project($project_id);
    // get project issues

    $data = ['project' => $p];
    return view('project/view_project', $data);
  }
}