<?php
namespace App\Helpers;

use CodeIgniter\Config\Services;
use App\Config\Globals;

/// Redirect to this url (https://github.com/login/oauth/authorize?scope=user&client_id=<client_id>&redirect_uri=<redirect_uri>)
class GitHubAuthManager {
  private $client;

  public function __construct() {
    if (empty(Globals::$github_client_id)) {
      Globals::init();
    }
    $this->client = Services::curlrequest();
  }

  public function get_access_token(string $code): string {
    $client_id = Globals::$github_client_id;
    $client_secret = Globals::$github_client_secret;

    $response = $this->client->post(
      'https://github.com/login/oauth/access_token',
      [
        'form_params' => [
          'client_id' => $client_id,
          'client_secret' => $client_secret,
          'code' => $code,
        ],
        'headers' => [
          'Accept' => 'application/json',
        ]
      ]
    );

    return json_decode($response->getBody(), true)['access_token'];
  }

  public function get_user_info(string $access_token): array {
    $response = $this->client->get(
      'https://api.github.com/user',
      [
        'headers' => [
          'Authorization' => 'Bearer ' . $access_token,
          'User-Agent' => 'issue_tracker',
          'Accept' => 'application/json',
        ]
      ]
    );

    $user_info = json_decode($response->getBody(), true);

    $username = $user_info['login'];
    $avatar_url = $user_info['avatar_url'];
    $email = $user_info['email'];

    if ($email == null) {
      $response = $this->client->get(
        'https://api.github.com/user/emails',
        [
          'headers' => [
            'Authorization' => 'Bearer ' . $access_token,
            'User-Agent' => 'issue_tracker',
            'Accept' => 'application/json',
          ]
        ]
      );

      $all_emails = json_decode($response->getBody(), true);
      foreach ($all_emails as $email) {
        if ($email['primary'] === true) {
          $email = $email['email'];
          break;
        }
      }
    }

    return [
      'username' => $username,
      'avatar_url' => $avatar_url,
      'email' => $email,
    ];
  }
}