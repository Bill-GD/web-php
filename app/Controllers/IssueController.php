<?php
namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\IssueModel;
use App\Models\IssuePriority;
use App\Models\IssueStatus;
use App\Models\ProjectModel;
use App\Models\UserModel;

class IssueController extends BaseController {
  public function index(): string {
    if (!Helper::is_logged_in()) {
      Helper::redirect_to('/');
    }

    if (isset($_GET['s'])) {
      return $this->filter_status($_GET['s']);
    }

    $data = [];

    $data['issue_count'] = IssueModel::issue_type_count();
    $i = [];

    if (isset($_GET['t'])) {
      $i = IssueModel::get_all_issues($_GET['t'] === 'newest');
    } else {
      $i = IssueModel::get_all_issues();

      if (isset($_GET['i'])) {
        $i = array_filter($i, fn($i) => str_contains(strtolower($i->title), strtolower($_GET['i'])));
      }
    }

    $data['issues'] = $i;
    return view('issue/issue_list', $data);
  }

  public function filter(string $filter): string {
    if (!Helper::is_logged_in()) {
      Helper::redirect_to('/');
    }

    $data = [];
    $params = [
      $_COOKIE['user_id'],
      !isset($_GET['t']) ? null : ($_GET['t'] === 'newest' ? true : false),
      !isset($_GET['s']) ? null : IssueStatus::from($_GET['s'])->name,
    ];

    $data['issue_count'] = IssueModel::issue_type_count();
    $i = $filter === 'created' ? IssueModel::get_created_issues(...$params) : IssueModel::get_assigned_issues(...$params);

    if (isset($_GET['i'])) {
      $i = array_filter($i, fn($issue) => str_contains(strtolower($issue->title), strtolower($_GET['i'])));
    }

    $data['filter'] = ucfirst($filter);
    $data['issues'] = $i;

    return view('issue/issue_list', $data);
  }

  public function filter_status(string $status): string {
    if (!Helper::is_logged_in()) {
      Helper::redirect_to('/');
    }

    $data = [];

    $data['issue_count'] = IssueModel::issue_type_count();
    $data['issues'] = IssueModel::filter_issues(IssueStatus::from($status));
    $data['filter'] = ucfirst($status);

    return view('issue/issue_list', $data);
  }

  public function create(int $project_id): string {
    if (Helper::is_admin()) {
      Helper::redirect_to('/projects?error_message=' . urlencode('Admins cannot create issues'));
    }

    $data = [];
    try {
      $data['issuer_id'] = $_COOKIE['user_id'];
      $data['issuer_name'] = $_COOKIE['username'];
      $data['issuer_avatar'] = Helper::get_profile_picture_url($_COOKIE['avatar_url']);
      $data['project_id'] = $project_id;
      $data['project_name'] = ProjectModel::get_project($project_id)->project_name;
    } catch (\Exception $e) {
      Helper::redirect_to("/projects?error_message=" . urlencode($e->getMessage()));
    }
    return view('issue/create_issue', $data);
  }

  public function create_issue(int $project_id): void {
    try {
      $title = $_POST['issue_title'];
      $description = $_POST['issue_description'];
      $priority = IssuePriority::from($_POST['issue_priority']);

      IssueModel::create_issue(
        project_id: $project_id,
        title: $title,
        description: $description,
        status: IssueStatus::open,
        priority: $priority,
        issuer: $_COOKIE['user_id'],
      );
    } catch (\Exception $e) {
      Helper::redirect_to('create-issue?error_message=' . urlencode($e->getMessage()));
    }
    Helper::redirect_to("/projects/{$project_id}");
  }

  public function view_issue(int $project_id, int $issue_id): string {
    // if (Helper::is_admin()) {
    //   Helper::redirect_to('/issues?error_message=' . urlencode('Admins cannot view issues'));
    // }

    $data = [];
    try {
      $issue = IssueModel::get_issue($project_id, $issue_id);
      $issuer = UserModel::find_user(user_id: $issue->issuer);
      // $assignee = $issue->assignee ? UserModel::find_user(user_id: $issue->assignee) : null;

      $data['issue'] = $issue;
      $data['project_id'] = $project_id;
      $data['project'] = ProjectModel::get_project($project_id);
      $data['is_viewer_owner'] = ProjectModel::is_member_owner($project_id, $_COOKIE['user_id']);
      $data['issuer_avatar'] = Helper::get_profile_picture_url($issuer->avatar_url);
      $data['members'] = ProjectModel::get_members($project_id);
    } catch (\Exception $e) {
      Helper::redirect_to("/issues?error_message=" . urlencode($e->getMessage()));
    }

    return view('issue/view_issue', $data);
  }

  public function update_issue(int $project_id, int $issue_id): void {
    if (Helper::is_admin()) {
      Helper::redirect_to('/issues?error_message=' . urlencode('Admins cannot update issues'));
    }

    try {
      $assignee = $_POST['issue_assignee'] === 'null' ? null : $_POST['issue_assignee'];
      $priority = IssuePriority::from($_POST['issue_priority']);
      $status = IssueStatus::from($_POST['issue_status']);

      IssueModel::update_issue(
        issue_id: $issue_id,
        assignee: $assignee,
        priority: $priority,
        status: $status,
      );
    } catch (\Exception $e) {
      Helper::redirect_to("/projects/{$project_id}/issues/{$issue_id}?error_message=" . urlencode($e->getMessage()));
    }
    Helper::redirect_to("/projects/{$project_id}/issues/{$issue_id}");
  }
}