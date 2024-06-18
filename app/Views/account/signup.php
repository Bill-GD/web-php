<?php
$e_attr = '';
$u_attr = '';
if (isset($_COOKIE['github_username'], $_COOKIE['github_email'])) {
  $e_attr = 'value="' . $_COOKIE['github_email'] . '" readonly';
  $u_attr = 'value="' . $_COOKIE['github_username'] . '" readonly';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= App\Helpers\PageComponent::import_styles() ?>
    <title>Sign up to BugTrackr</title>
    <style>
      a {
        text-decoration: none;
      }
    </style>
  </head>
  <body class="bg-dark">
    <?= App\Helpers\PageComponent::home_button() ?>
    <div class="auth-form text-white">
      <h3 class="text-center py-2">Sign up to BugTrackr</h3>
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_GET['error_message']);
      } ?>
      <div class="bg-dark-subtle border border-dark-subtle rounded-2 p-3">
        <form action="/public/signup-validate" method="post">
          <div class="form-group">
            <label class="form-label" for="email">Email address</label>
            <input type="email" class="form-control form-input" id="email" name="email" required <?= $e_attr ?>>
          </div>
          <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <input type="text" class="form-control form-input" id="username" name="username" required <?= $u_attr ?>>
          </div>
          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" class="form-control form-input" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="confirm-password">Confirm Password</label>
            <input type="password" class="form-control form-input" id="confirm-password" name="confirm-password"
              required>
          </div>
          <button type="submit" class="btn btn-success w-100 mt-3">Sign up</button>
        </form>
        <a class="btn btn-dark text-white mt-3 w-100" href="<?= App\Helpers\Helper::get_github_auth_url() ?>">
          <span>Sign up with GitHub</span>
          <i class="fa-brands fa-github ps-2 fs-4 svg-white"></i>
        </a>
      </div>
      <div class="bg-dark-subtle border border-dark-subtle rounded-2 p-3 mt-2 text-center">
        Already have an account? <a class="link-underline-opacity-0" href="/public/login">Sign in</a>
      </div>
    </div>
  </body>
</html>