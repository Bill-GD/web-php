<?php
use App\Helpers\GitHubAuthManager;

if (isset($_GET['code'])) {
  $code = $_GET['code'];

  $github = new GitHubAuthManager();
  $access_token = $github->get_access_token($code);
  $user_info = $github->get_user_info($access_token);

  echo "Username: " . $user_info['username'] . "<br>";
  echo "Email: " . $user_info['email'] . "<br>";
  echo "<img src='" . $user_info['avatar_url'] . "' alt='Avatar'>";
} else {
  echo "No code provided";
}