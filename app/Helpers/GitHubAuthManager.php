<?php
namespace App\Helpers;

use Exception;
use CodeIgniter\Config\Services;
use App\Helpers\Globals;

/// Redirect to this url (https://github.com/login/oauth/authorize?scope=user&client_id=<client_id>&redirect_uri=<redirect_uri>) to start the OAuth process
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

    $decoded_response = json_decode($response->getBody(), true);

    if (!isset($decoded_response['access_token'])) {
      throw new Exception("GitHub code has expired or is invalid. Please try again.");
    }

    return $decoded_response['access_token'];
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
    // $avatar_url = $user_info['avatar_url'];
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
      'avatar_url' => 'https://github.com/' . $username . '.png',
      'email' => $email,
    ];
  }
}