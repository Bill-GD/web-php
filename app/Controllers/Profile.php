<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\Helper;

class Profile extends BaseController {
  public function index(): string {
    if (!Helper::is_logged_in()) {
      Helper::redirect_to('/');
    }
    if (!Helper::is_admin()) {
      Helper::redirect_to('/projects');
    }
    $data = ['profiles' => UserModel::get_all_users()];
    return view('profile/profile_list', $data);
  }

  // unused right now
  public function view_profile(int $user_id): string {
    throw new \Exception('Not implemented');
    if (!Helper::is_logged_in()) {
      Helper::redirect_to('/');
    }
    return view('profile/view_profile', [
      'user_id' => $user_id,
      'profile' => UserModel::find_user(user_id: $user_id)
    ]);
  }
}
