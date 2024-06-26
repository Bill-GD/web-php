<?php
use App\Helpers\GitHubAuthManager;
use App\Helpers\Helper;

if (isset($_GET['code'])) {
  try {
    $github = new GitHubAuthManager();
    $access_token = $github->get_access_token($_GET['code']);
    $user_info = $github->get_user_info($access_token);
    
    Helper::set_cookies([
      'github_username' => $user_info['username'],
      'github_email' => $user_info['email'],
      'github_avatar_url' => $user_info['avatar_url'],
      'github_access_token' => $access_token,
    ], 3600);

    Helper::redirect_to('signup/github');
  } catch (Exception $e) {
    Helper::redirect_to('signup?error_message=' . urlencode($e->getMessage()));
  }
} else {
  Helper::redirect_to("/");
}