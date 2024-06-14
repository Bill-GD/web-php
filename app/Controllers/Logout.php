<?php
namespace App\Controllers;

use App\Helpers\Helper;

class Logout extends BaseController {
  public function index(): string {
    Helper::set_cookies([
      'is_logged_in' => false,
      'user_id' => -1,
      'email' => '',
      'username' => '',
      'is_admin' => false,
    ], -1);
    Helper::redirect_to('/');
    return view('home');
  }
}