<?php
namespace App\Controllers;

use App\Models\ProjectModel;
use App\Helpers\Helper;
use App\Models\IssueModel;

class ProjectController extends BaseController {
  public function index(): string {
    $is_logged_in = Helper::is_logged_in();
    $is_admin = Helper::is_admin();
    $data = ['is_logged_in' => $is_logged_in];

    if (!$is_logged_in) {
      Helper::redirect_to('/');
    }
    $user_id = $is_admin ? null : $_COOKIE['user_id'];

    $p = ProjectModel::get_all_projects($user_id);

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
    $data['filter'] = ' - ' . ucfirst($filter);

    return view('project/project_list', $data);
  }

  public function create(): string {
    if (Helper::is_admin()) {
      Helper::redirect_to('/projects?error_message=' . urlencode('Admins cannot create project'));
    }
    return view('project/create_project');
  }

  public function create_project(): void {
    try {
      $project_name = $_POST['project_name'];
      $description = $_POST['project_description'];
      $owner = $_COOKIE['user_id'];

      ProjectModel::create_project($project_name, $description, $owner);
    } catch (\Exception $e) {
      Helper::redirect_to('/create-project?error_message=' . urlencode($e->getMessage()));
    }
    Helper::redirect_to('projects');
  }

  public function view_project(string $project_id, ?string $tab = null): string {
    if (!Helper::is_logged_in()) {
      Helper::redirect_to('/');
    }
    // if (Helper::is_admin()) {
    //   Helper::redirect_to('/projects?error_message=' . urlencode('Admins cannot view project'));
    // }
    
    $data = [];
    try {
      $data['project_id'] = $project_id;
      $data['project'] = ProjectModel::get_project($project_id);
    } catch (\Exception $e) {
      Helper::redirect_to("/projects?error_message=" . urlencode($e->getMessage()));
    }

    if (!$tab) {
      $data['issues'] = IssueModel::get_issues($project_id);
      if (isset($_GET['i'])) {
        $data['issues'] = array_filter($data['issues'], fn($issue) => str_contains(strtolower($issue->title), strtolower($_GET['i'])));
      }
    }
    if ($tab === 'members') {
      $data['members'] = ProjectModel::get_members($project_id);
    }
    return view('project/view_project', $data);
  }

  public function add_member(string $project_id) {
    if (Helper::is_admin()) {
      Helper::redirect_to("/projects/{$project_id}/members?error_message=" . urlencode('Admins cannot add members'));
    }

    try {
      $email = $_POST['add_email'];
      $role = $_POST['new_member_role'];
      ProjectModel::add_member($project_id, $email, $role);
    } catch (\Exception $e) {
      Helper::redirect_to("/projects/{$project_id}/members?error_message=" . urlencode($e->getMessage()));
    }
    Helper::redirect_to("/projects/{$project_id}/members");
  }

  public function remove_member(string $project_id, string $user_id) {
    if (Helper::is_admin()) {
      Helper::redirect_to("/projects/{$project_id}/members?error_message=" . urlencode('Admins cannot remove members'));
    }

    ProjectModel::remove_member($project_id, $user_id);
    Helper::redirect_to("/projects/{$project_id}/members");
  }

  public function delete_project(string $project_id): void {
    if (Helper::is_admin()) {
      Helper::redirect_to("/projects/{$project_id}?error_message=" . urlencode('Admins cannot delete project'));
    }

    ProjectModel::delete_project($project_id);
    Helper::redirect_to('/projects');
  }
}