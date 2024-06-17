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
        <!-- only show projects if is not admin -->
        <aside>
          <p>Projects</p>
          <?php
          foreach ($projects as $project) {
            echo "<div class='project-card'>";
            echo "<h2>{$project->project_name}</h2>";
            echo "<p>{$project->project_id}</p>";
            echo "<p>{$project->description}</p>";
            echo "<p>Owner: {$project->owner}</p>";
            echo "<p>Created: {$project->date_created}</p>";
            echo "</div>";
          }
          ?>
        </aside>
    <?php } ?>
  </body>
</html>