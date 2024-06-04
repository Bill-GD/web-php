<?php
namespace App\Models;

use App\Database\Database;
use App\Helpers\Helpers;
use PDO;
use Exception;

class User {
  public string $user_id;
  public string $email;
  public string $username;
  public bool $is_admin;

  function login(string $email, string $password): void {
    if (empty($email)) {
      throw new Exception('Email is required');
    }
    if (empty($password)) {
      throw new Exception('Password is required');
    }
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)) {
      throw new Exception('Invalid email format');
    }
    [$email, $password] = Database::mysql_escape([$email, $password]);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $q_str = "SELECT * FROM `user` WHERE email = '{$email}' AND `password` = '{$hashed_password}'";
    $res = Database::instance()->query($q_str)->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
      throw new Exception('Invalid email or password');
    }

    Helpers::set_cookies([
      'user_id' => $res[0]['user_id'],
      'email' => $res[0]['email'],
      'username' => $res[0]['username'],
      'is_admin' => $res[0]['is_admin']
    ]);
  }

  static function register(string $email, string $username, string $password, string $confirm_password, bool $is_admin = false): void {
    // empty input
    if (empty($email)) {
      throw new Exception('Email is required');
    }
    if (empty($username)) {
      throw new Exception('Username is required');
    }
    if (empty($password)) {
      throw new Exception('Password is required');
    }
    if (empty($confirm_password)) {
      throw new Exception('Please confirm the password');
    }
    if ($password !== $confirm_password) {
      throw new Exception('Passwords do not match');
    }

    // check value
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)) {
      throw new Exception('Invalid email format');
    }
    $res = Database::instance()->query("SELECT * FROM `user` WHERE email = '{$email}'");
    if ($res->rowCount() > 0 || !$res) {
      throw new Exception('Email already exists');
    }
    if (strlen($username) > 50) {
      throw new Exception('Username must be less than 50 characters');
    }
    if (strlen($password) < 8) {
      throw new Exception('Password should be at least 8 characters');
    }

    // sanitize input
    [$email, $username, $password] = Database::mysql_escape([$email, $username, $password]);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $q_str = "INSERT INTO `user` (email, username, `password`, is_admin, date_created) VALUES ('{$email}', '{$username}', '{$hashed_password}', " . ($is_admin ? 1 : 0) . ", now())";
    Database::instance()->query($q_str);
  }

  static function find_user_by_email(string $email): User {
    $q_str = "SELECT * FROM `user` WHERE email = '{$email}'";
    $res = Database::instance()->query($q_str)->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
      throw new Exception('User not found');
    }

    $new_user = new User();
    $new_user->user_id = $res[0]['user_id'];
    $new_user->email = $res[0]['email'];
    $new_user->username = $res[0]['username'];
    $new_user->is_admin = $res[0]['is_admin'];
    return $new_user;
  }

  static function find_user_by_username(string $username): User {
    $q_str = "SELECT * FROM `user` WHERE username = '{$username}'";
    $res = Database::instance()->query($q_str)->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
      throw new Exception('User not found');
    }

    $new_user = new User();
    $new_user->user_id = $res[0]['user_id'];
    $new_user->email = $res[0]['email'];
    $new_user->username = $res[0]['username'];
    $new_user->is_admin = $res[0]['is_admin'];
    return $new_user;
  }
}