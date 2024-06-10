<?php
$e_attr = '';
$u_attr = '';
$pfp_url = 'assets/default_avatar.png';
if (isset($_SESSION['github_username'], $_SESSION['github_email'], $_SESSION['github_avatar_url'])) {
  $e_attr = 'value="' . $_SESSION['github_email'] . '" readonly';
  $u_attr = 'value="' . $_SESSION['github_username'] . '" readonly';
  $pfp_url = $_SESSION['github_avatar_url'];
  \App\Helpers\Helper::remove_session_vars(['github_username', 'github_email', 'github_avatar_url']);
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
    <div class="auth-form fg-white">
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
          <div class="form-group visually-hidden">
            <label class="form-label" for="avatar-url">Avatar URL</label>
            <input type="text" class="form-control form-input" id="avatar-url" name="avatar-url" value="<?= $pfp_url ?>"
              required readonly>
          </div>
          <button type="submit" class="btn btn-success w-100 mt-3">Sign up</button>
        </form>
        <a class="btn btn-dark fg-white mt-3 w-100" href="<?= App\Helpers\Helper::get_github_auth_url() ?>">
          Sign up with GitHub
          <svg class="ps-2" height="32" width="32" viewBox="0 0 16 16">
            <path fill="#fff"
              d="M8 0c4.42 0 8 3.58 8 8a8.013 8.013 0 0 1-5.45 7.59c-.4.08-.55-.17-.55-.38 0-.27.01-1.13.01-2.2 0-.75-.25-1.23-.54-1.48 1.78-.2 3.65-.88 3.65-3.95 0-.88-.31-1.59-.82-2.15.08-.2.36-1.02-.08-2.12 0 0-.67-.22-2.2.82-.64-.18-1.32-.27-2-.27-.68 0-1.36.09-2 .27-1.53-1.03-2.2-.82-2.2-.82-.44 1.1-.16 1.92-.08 2.12-.51.56-.82 1.28-.82 2.15 0 3.06 1.86 3.75 3.64 3.95-.23.2-.44.55-.51 1.07-.46.21-1.61.55-2.33-.66-.15-.24-.6-.83-1.23-.82-.67.01-.27.38.01.53.34.19.73.9.82 1.13.16.45.68 1.31 2.69.94 0 .67.01 1.3.01 1.49 0 .21-.15.45-.55.38A7.995 7.995 0 0 1 0 8c0-4.42 3.58-8 8-8Z">
            </path>
          </svg>
        </a>
      </div>
      <div class="bg-dark-subtle border border-dark-subtle rounded-2 p-3 mt-2 text-center">
        Already have an account? <a class="link-underline-opacity-0" href="/public/login">Sign in</a>
      </div>
    </div>
  </body>
</html>