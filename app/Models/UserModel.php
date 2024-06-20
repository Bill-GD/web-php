<?php
namespace App\Models;

use App\Database\DatabaseManager;
use App\Helpers\Helper;
use DateTime;
use PDO;

class UserModel {
  public int $user_id;
  public string $email;
  public string $username;
  public string $avatar_url;
  public bool $is_admin;
  public string $date_created;
  public bool $is_github_auth_user;

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

    $q_str = "SELECT * FROM `user` WHERE email = :email AND `password` = :password";
    $res = DatabaseManager::instance()->query(
      $q_str,
      [
        'email' => $email,
        'password' => $hashed_password,
      ]
    )->fetch(PDO::FETCH_ASSOC);

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

  function register(string $email, string $username, string $password, string $confirm_password, string $avatar_url, bool $is_admin = false): void {
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
    if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9-_]*$/', $username)) {
      throw new \Exception('Username must start with a letter or underscore and contain only letters, numbers, underscores and dashes');
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
    $github_access_token = isset($_COOKIE['github_access_token']) ? "'" . self::encode_gh_token($_COOKIE['github_access_token']) . "'" : 'NULL';
    $current_time = Helper::get_local_time();

    $q_str = "INSERT INTO `user` (email, username, `password`, avatar_url, is_admin, date_created, github_access_token) VALUES
    ('{$email}', '{$username}', '{$hashed_password}', '{$avatar_url}', " . ($is_admin ? 1 : 0) . ", '{$current_time}', {$github_access_token})";
    DatabaseManager::instance()->query($q_str);
  }

  static private function encode_gh_token(string $token): string {
    return implode(
      array_map(fn(string $char): string => dechex(ord($char)), str_split($token))
    );
  }

  // when needed to use the token
  static private function decode_gh_token(string $token): string {
    return implode(
      array_map(fn(string $hex): string => chr(hexdec($hex)), str_split($token, 2))
    );
  }

  static function find_user(?int $user_id = null, ?string $email = null, ?string $username = null): ?UserModel {
    if (empty($user_id) && empty($email) && empty($username)) {
      throw new \Exception('User ID, email or username is required');
    }
    $q_str = "SELECT * FROM user WHERE ";
    $q_str .= $user_id ? "user_id = :user_id" : "";
    $q_str .= $email ? ($user_id ? " AND email = :email" : "email = :email") : "";
    $q_str .= $username ? (($user_id || $email) ? " AND username = :username" : "username = :username") : "";

    $res = DatabaseManager::instance()->query(
      $q_str,
      array_filter(
        ['user_id' => $user_id, 'email' => $email, 'username' => $username],
        fn($e) => $e !== null,
      ),
    )->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
      return null;
      // throw new \Exception('User not found');
    }

    $new_user = new UserModel();
    $new_user->user_id = $res['user_id'];
    $new_user->email = $res['email'];
    $new_user->username = $res['username'];
    $new_user->is_admin = $res['is_admin'];
    $new_user->avatar_url = $res['avatar_url'];
    return $new_user;
  }

  static function get_all_users(): array {
    $q_str = "SELECT user_id, email, username, avatar_url, is_admin, date_created,
              CASE WHEN github_access_token IS NULL THEN 0 ELSE 1 END AS has_github_access_token
              FROM `user`";
    $res = DatabaseManager::instance()->query($q_str)->fetchAll(PDO::FETCH_ASSOC);

    $users = [];
    foreach ($res as $user_data) {
      $new_user = new UserModel();
      $new_user->user_id = $user_data['user_id'];
      $new_user->email = $user_data['email'];
      $new_user->username = $user_data['username'];
      $new_user->avatar_url = $user_data['avatar_url'];
      $new_user->is_admin = $user_data['is_admin'];
      $new_user->date_created = $user_data['date_created'];
      $new_user->is_github_auth_user = $user_data['has_github_access_token'] == 1;
      $users[] = $new_user;
    }

    return $users;
  }
}