<?php
namespace App\Helpers;

class Globals {
  public static string $environment = '';
  public static string $aiven_username = '';
  public static string $aiven_password = '';
  public static string $github_client_id = '';
  public static string $github_client_secret = '';
  public static string $github_redirect_uri = '';

  public static function init() {
    Globals::$environment = getenv('CI_ENVIRONMENT');
    Globals::$aiven_username = getenv('AIVENUSERNAME');
    Globals::$aiven_password = getenv('AIVENPASSWORD');

    $is_dev = Globals::$environment === 'development';

    Globals::$github_client_id = $is_dev ? getenv('GITHUBCLIENTIDDEV') : getenv('GITHUBCLIENTID');
    Globals::$github_client_secret = $is_dev ? getenv('GITHUBCLIENTSECRETDEV') : getenv('GITHUBCLIENTSECRET');
    Globals::$github_redirect_uri = $is_dev ? 'http://localhost:8000/public/github-oauth' : 'https://web-php-bill-gd-e914d913.koyeb.app/public/github-oauth';
  }
}