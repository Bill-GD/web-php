<?php
namespace App\Helpers;

use App\Helpers\Globals;

class Helper {
  static function redirect_to(string $route): void {
    if ($route === '/' || $route[0] !== '/') {
      header("Location: {$route}");
      exit;
    }
    $uri = str_contains($_SERVER['REQUEST_URI'], 'public') ? 'public' : '';
    header("Location: {$uri}{$route}");
    exit;
  }

  static function get_resource_path(string $relative_path): string {
    if (empty(Globals::$environment)) {
      Globals::init();
    }
    $relative_path[0] !== '/' ? $relative_path = "/{$relative_path}" : 0;
    $is_prod = Globals::$environment === 'production';
    return ($is_prod ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $relative_path;
  }

  static function set_cookies(array $cookies): void {
    foreach ($cookies as $key => $value) {
      setcookie($key, $value, time() + 3600, '/');
    }
  }

  static function set_session_vars(array $session_values): void {
    \Config\Services::session()->set($session_values);
  }

  static function remove_session_vars(array $session_keys): void {
    \Config\Services::session()->remove($session_keys);
  }

  static function echo_server_address_info(): void {
    $lines = [
      "Executing script: " . $_SERVER['PHP_SELF'],
      "Server Protocol: " . $_SERVER['SERVER_PROTOCOL'],
      "Host Address: " . $_SERVER['HTTP_HOST'],
      "Access URI: " . $_SERVER['REQUEST_URI'],
    ];
    foreach ($lines as $value) {
      echo $value . "<br>";
    }
  }

  static function get_github_auth_url(): string {
    if (empty(Globals::$github_client_id)) {
      Globals::init();
    }
    $client_id = Globals::$github_client_id;
    $redirect_uri = urlencode(Globals::$github_redirect_uri);
    return "https://github.com/login/oauth/authorize?scope=user&client_id={$client_id}&redirect_uri={$redirect_uri}";
  }
}