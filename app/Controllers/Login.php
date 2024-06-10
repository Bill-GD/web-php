<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\Helper;

class Login extends BaseController {
  public function basic_login(): string {
    return view('account/login');
  }

  public function login_validate() {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new UserModel();
    try {
      $user->login($email, $password);
    } catch (\Exception $e) {
      Helper::redirect_to('login?error_message=' . $e->getMessage());
    }
    Helper::redirect_to('/');
  }
}