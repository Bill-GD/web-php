<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= App\Helpers\PageComponent::import_styles() ?>
    <title>Sign in to BugTrackr</title>
    <style>
      a {
        text-decoration: none;
      }
    </style>
  </head>
  <body class="bg-dark">
    <?= App\Helpers\PageComponent::home_button() ?>
    <div class="auth-form fg-white">
      <h3 class="text-center mb-3">Sign in to BugTrackr</h3>
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
      } ?>
      <div class="bg-dark-subtle border border-dark-subtle rounded-2 p-3">
        <form action="login-validate" method="post">
          <div class="form-group">
            <label class="form-label" for="email">Email address</label>
            <input type="email" class="form-control form-input" id="email" name="email" placeholder="" required>
          </div>
          <div class="form-group my-2">
            <label class="form-label" for="password">Password</label>
            <input type="password" class="form-control form-input" id="password" name="password" placeholder=""
              required>
          </div>
          <button type="submit" class="btn btn-success w-100 mt-3">Sign in</button>
        </form>
      </div>
      <div class="bg-dark-subtle border border-dark-subtle rounded-2 p-3 mt-2 text-center">
        New to BugTrackr? <a class="link-underline-opacity-0" href="signup">Create an account</a>
      </div>
    </div>
  </body>
</html>