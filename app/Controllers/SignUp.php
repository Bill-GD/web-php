<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\Helper;

class SignUp extends BaseController {
  public function basic_signup(): string {
    return view('account/signup');
  }

  public function signup_validate() {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $avatar_url = isset($_COOKIE['github_avatar_url']) ? $_COOKIE['github_avatar_url'] : 'public/assets/default_avatar.png';

    $user = new UserModel();
    try {
      $user->register($email, $username, $password, $confirm_password, $avatar_url);
    } catch (\Exception $e) {
      Helper::redirect_to('signup?error_message=' . urlencode($e->getMessage()));
    }
    Helper::set_cookies(['github_username' => '', 'github_email' => '', 'github_avatar_url' => ''], -1);
    Helper::redirect_to('login');
  }

  public function github_signup(): string {
    if (!isset($_SESSION['github_username'], $_SESSION['github_email'], $_SESSION['github_avatar_url'])) {
      redirect('signup')->with('error_message', urlencode('GitHub login failed'));
    }
    return view('account/signup');
  }
}