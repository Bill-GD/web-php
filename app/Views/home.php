<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>BugTrackr</title>
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark text-white">
    <?= App\Helpers\PageComponent::page_header() ?>
    <?= App\Helpers\PageComponent::home_background($is_logged_in) ?>

    <?php if ($is_logged_in === false) { ?>
      <div>
        <h1 class="text-center mt-5">Welcome to BugTrackr</h1>
        <p class="text-center">Please sign in or sign up to get started</p>
      </div>
    <?php } else if ($is_admin === true) { ?>
        <div>
          <h1 class="text-center mt-5">Welcome to BugTrackr</h1>
          <p class="text-center">You are an admin</p>
        </div>
    <?php } else { ?>
    <?php } ?>
  </body>
</html>