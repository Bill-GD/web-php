<?php
namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\IssueModel;
use App\Models\IssuePriority;
use App\Models\IssueStatus;
use App\Models\ProjectModel;

class IssueController extends BaseController {
  public function index(): string {
    if (isset($_GET['s'])) {
      return $this->filter_status($_GET['s']);
    }

    $is_logged_in = Helper::is_logged_in();
    $data = ['is_logged_in' => $is_logged_in];

    if (!$is_logged_in) {
      Helper::redirect_to('/');
    }

    $data['issue_count'] = IssueModel::issue_type_count();
    $i = [];

    if (isset($_GET['t'])) {
      $i = IssueModel::get_all_issues($_GET['t'] === 'newest');
    } else {
      $i = IssueModel::get_all_issues();

      if (isset($_GET['i'])) {
        $i = array_filter($i, fn($project) => str_contains(strtolower($project->project_name), strtolower($_GET['i'])));
      }
    }

    $data['issues'] = $i;
    return view('issue/issue_list', $data);
  }

  public function filter(string $filter): string {
    $is_logged_in = Helper::is_logged_in();
    $data = ['is_logged_in' => $is_logged_in];

    if (!$is_logged_in) {
      Helper::redirect_to('/');
    }
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
    $is_logged_in = Helper::is_logged_in();
    $data = ['is_logged_in' => $is_logged_in];

    if (!$is_logged_in) {
      Helper::redirect_to('/');
    }

    $data['issue_count'] = IssueModel::issue_type_count();
    $data['issues'] = IssueModel::filter_issues(IssueStatus::from($status));
    $data['filter'] = ucfirst($status);

    return view('issue/issue_list', $data);
  }

  public function create(int $project_id): string {
    $data = [
      'issuer_id' => $_COOKIE['user_id'],
      'issuer_name' => $_COOKIE['username'],
      'issuer_avatar' => Helper::get_profile_picture_url($_COOKIE['avatar_url']),
      'project_id' => $project_id,
      'project_name' => ProjectModel::get_project($project_id)->project_name,
    ];
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

  
}