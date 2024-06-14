<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>BugTrackr</title>
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark text-white">
    <?= App\Helpers\PageComponent::page_header() ?>
    <?= App\Helpers\PageComponent::code_background($is_logged_in) ?>

    <?php if ($is_logged_in === false) { ?>
      <div class="container align-items-center">
        <h1 class="text-center mt-5">Welcome to BugTrackr</h1>
        <p class="text-center">Please sign in or sign up to get started</p>
      </div>
    <?php } else { ?>
      <p>Projects</p>
      <?php
      foreach ($projects as $project) {
        echo "<div class='project-card'>";
        echo "<h2>{$project['project_name']}</h2>";
        echo "<p>{$project['description']}</p>";
        echo "<p>Owner: {$project['owner']}</p>";
        echo "<p>Created: {$project['date_created']}</p>";
        echo "</div>";
      }
      ?>
      <p>Issues</p>
      <?php
      foreach ($issues as $issue) {
        echo "<div class='issue-card'>";
        echo "<h2>{$issue['issue_title']}</h2>";
        echo "<p>{$issue['issue_id']}</p>";
        echo "<h3>{$issue['project_name']}</h3>";
        echo "<p>{$issue['description']}</p>";
        echo "<p>Status: {$issue['status']}</p>";
        echo "<p>Priority: {$issue['priority']}</p>";
        echo "<p>Issuer: {$issue['issuer']}</p>";
        echo "<p>Created: {$issue['date_created']}</p>";
        echo "<p>Updated: {$issue['date_updated']}</p>";
        echo "</div>";
      }
      ?>
    <?php } ?>
  </body>
</html>