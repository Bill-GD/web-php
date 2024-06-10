<?php
namespace App\Controllers;

class SignUp extends BaseController {
  public function basic_signup(): string {
    return view('account/signup');
  }

  public function signup_validate() {
    $email = $_REQUEST['email'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $confirm_password = $_REQUEST['confirm-password'];

    $user = new \App\Models\User();
    try {
      $user->register($email, $username, $password, $confirm_password);
    } catch (\Exception $e) {
      \App\Helpers\Helper::redirect_to('signup?error_message=' . $e->getMessage());
    }
    \App\Helpers\Helper::redirect_to('/');
  }

  public function github_signup(string $username, string $email): string {
    return view('account/signup', [
      'username' => urldecode($username),
      'email' => urldecode($email),
    ]);
  }
}