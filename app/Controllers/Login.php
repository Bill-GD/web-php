<?php
namespace App\Controllers;

class Login extends BaseController {
  public function basic_login(): string {
    return view('login');
  }

  public function github_login(string $username, string $email): string {
    return view('login', [
      'username' => urldecode($username),
      'email' => urldecode($email),
    ]);
  }
}