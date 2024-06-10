<?php
namespace App\Controllers;

class Logout {
  public function index(): void {
    \App\Helpers\Helper::set_cookies([
      'is_logged_in' => false,
      'user_id' => -1,
      'email' => '',
      'username' => '',
      'is_admin' => false,
    ]);
    \App\Helpers\Helper::redirect_to('/');
  }
}