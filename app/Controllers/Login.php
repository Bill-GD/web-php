<?php
namespace App\Controllers;

class Login extends BaseController {
  public function basic_login(): string {
    return view('account/login');
  }

  public function login_validate() {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    $user = new \App\Models\User();
    try {
      $user->login($email, $password);
    } catch (\Exception $e) {
      \App\Helpers\Helper::redirect_to('login?error_message=' . $e->getMessage());
    }
    \App\Helpers\Helper::redirect_to('/');
  }
}