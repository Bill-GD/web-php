<?php
namespace App\Controllers;

use App\Database\DatabaseManager;
use App\Models\ProjectModel;

class Home extends BaseController {
  public function index(): string {
    $is_logged_in = \App\Helpers\Helper::is_logged_in();
    $is_admin = \App\Helpers\Helper::is_admin();
    $data = ['is_logged_in' => $is_logged_in, 'is_admin' => $is_admin];

    if ($is_admin && $is_logged_in) {
      $user_id = $_COOKIE['user_id'];
      $data['projects'] = ProjectModel::get_all_projects($user_id);
    }

    return view('home', $data);
  }
}
