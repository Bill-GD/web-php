<?php
namespace App\Models;

use App\Database\DatabaseManager;
use App\Helpers\Helper;
use PDO;

class UserModel {
  public string $user_id;
  public string $email;
  public string $username;
  public bool $is_admin;

  function login(string $email, string $password): void {
    if (empty($email)) {
      throw new \Exception('Email is required');
    }
    if (empty($password)) {
      throw new \Exception('Password is required');
    }
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)) {
      throw new \Exception('Invalid email format');
    }

    $hashed_password = md5($password);
    $email = DatabaseManager::mysql_escape($email);

    $q_str = "SELECT * FROM `user` WHERE email = '{$email}' AND `password` = '{$hashed_password}'";
    $res = DatabaseManager::instance()->query($q_str)->fetch(PDO::FETCH_ASSOC);

    if (!$res || count($res) <= 0) {
      throw new \Exception("Wrong email or password");
    }

    Helper::set_cookies([
      'is_logged_in' => true,
      'user_id' => $res['user_id'],
      'email' => $res['email'],
      'username' => $res['username'],
      'avatar_url' => $res['avatar_url'],
      'is_admin' => $res['is_admin'],
    ]);
  }

  static function register(string $email, string $username, string $password, string $confirm_password, string $avatar_url, bool $is_admin = false): void {
    // empty input
    if (empty($email)) {
      throw new \Exception('Email is required');
    }
    if (empty($username)) {
      throw new \Exception('Username is required');
    }
    if (empty($password)) {
      throw new \Exception('Password is required');
    }
    if (empty($confirm_password)) {
      throw new \Exception('Please confirm the password');
    }
    if ($password !== $confirm_password) {
      throw new \Exception('Passwords do not match');
    }
    if (empty($avatar_url)) {
      throw new \Exception('Avatar URL is required and you should not be touching this');
    }

    // check value
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)) {
      throw new \Exception('Invalid email format');
    }
    $email_domain = explode('@', $email)[1];
    if (!checkdnsrr($email_domain)) {
      throw new \Exception('Invalid email domain');
    }
    $res = DatabaseManager::instance()->query("SELECT * FROM `user` WHERE email = '{$email}'");
    if ($res->rowCount() > 0 || !$res) {
      throw new \Exception('Email already exists');
    }
    $res = DatabaseManager::instance()->query("SELECT * FROM `user` WHERE username = '{$username}'");
    if ($res->rowCount() > 0 || !$res) {
      throw new \Exception('Username already exists');
    }
    if (strlen($username) > 32) {
      throw new \Exception('Username must be less than 32 characters');
    }
    if (strlen($password) < 8) {
      throw new \Exception('Password should be at least 8 characters');
    }
    if (str_contains($avatar_url, 'assets') && !file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $avatar_url)) {
      throw new \Exception("Avatar file not found, shouldn't be the case");
    } else if (str_contains($avatar_url, 'http')) {
      assert(str_contains($avatar_url, 'github.com'), 'GitHub pfp should be from GitHub');
      assert(str_contains($avatar_url, '.png'), 'GitHub pfp should be a PNG file');
    }

    $hashed_password = md5($password);
    [$email, $username] = DatabaseManager::mysql_escape([$email, $username]);

    $q_str = "INSERT INTO `user` (email, username, `password`, avatar_url, is_admin, date_created) VALUES ('{$email}', '{$username}', '{$hashed_password}', '{$avatar_url}', " . ($is_admin ? 1 : 0) . ", now())";
    DatabaseManager::instance()->query($q_str);
  }

  static function find_user_by_email(string $email): UserModel {
    $q_str = "SELECT * FROM `user` WHERE email = '{$email}'";
    $res = DatabaseManager::instance()->query($q_str)->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
      throw new \Exception('User not found');
    }

    $new_user = new UserModel();
    $new_user->user_id = $res['user_id'];
    $new_user->email = $res['email'];
    $new_user->username = $res['username'];
    $new_user->is_admin = $res['is_admin'];
    return $new_user;
  }

  static function find_user_by_username(string $username): UserModel {
    $q_str = "SELECT * FROM `user` WHERE username = '{$username}'";
    $res = DatabaseManager::instance()->query($q_str)->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
      throw new \Exception('User not found');
    }

    $new_user = new UserModel();
    $new_user->user_id = $res['user_id'];
    $new_user->email = $res['email'];
    $new_user->username = $res['username'];
    $new_user->is_admin = $res['is_admin'];
    return $new_user;
  }
}