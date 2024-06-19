<?php
namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\IssueModel;
use App\Models\IssueStatus;

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
    // $user_id = $is_admin ? null : $_COOKIE['user_id'];

    $i = IssueModel::get_all_issues();
    // array_push($p, ...ProjectModel::get_joined_projects($user_id));
    // // $p = array_unique($p, SORT_REGULAR); // filter duplicated project_id

    if (isset($_GET['i'])) {
      $i = array_filter($i, fn($project) => str_contains(strtolower($project->project_name), strtolower($_GET['i'])));
    }

    // $data['projects'] = $p;
    return view('issue/issue_list', $data);
  }

  public function filter(string $filter): string {
    // filter created (issuer) and assigned (assignee)
    $is_logged_in = Helper::is_logged_in();
    $data = ['is_logged_in' => $is_logged_in];

    if (!$is_logged_in) {
      Helper::redirect_to('/');
    }

    $data['issue_count'] = IssueModel::issue_type_count();
    $data['issues'] = $filter === 'created' ? IssueModel::get_created_issues($_COOKIE['user_id']) : IssueModel::get_assigned_issues($_COOKIE['user_id']);

    $data['filter'] = ' - ' . ucfirst($filter);

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
    $data['filter'] = ' - ' . ucfirst($status);

    return view('issue/issue_list', $data);
  }

  public function create(): string {
    return view('issue/create_error');
  }
}