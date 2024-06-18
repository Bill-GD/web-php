<?php
$title = 'Projects';
$title .= isset($_GET['p']) ? ' - Search' : (isset($filter) ? $filter : ' - All');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark-subtle">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="clearfix container px-lg-5 mt-2">
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
      } ?>
      <div class="d-flex mt-3">
        <div class="input-group me-2" style="max-width:fit-content;min-width:fit-content;">
          <a href="/public/projects" class="btn btn-dark bg-dark-subtle fw-medium border border-dark-subtle"
            role="button">All</a>
          <a href="/public/projects/created" class="btn btn-dark bg-dark-subtle fw-medium border border-dark-subtle"
            role="button">Created</a>
          <a href="/public/projects/joined" class="btn btn-dark bg-dark-subtle fw-medium border border-dark-subtle"
            role="button">Joined</a>
        </div>
        <form action="/public/projects" method="get" class="w-100 me-2">
          <input type="text" name="p" class="form-control form-input h-100 bg-dark-light"
            value="<?= isset($_GET['p']) ? $_GET['p'] : '' ?>" placeholder="Search project">
        </form>
        <a <?= \App\Helpers\Helper::is_admin() ? '' : 'href="/public/create-project"' ?> role="button"
          class="btn btn-success col-2 <?= \App\Helpers\Helper::is_admin() ? 'disabled' : '' ?>"> New project </a>
      </div>

      <div class="mt-3 border border-dark-subtle rounded-2">
        <?php
        assert(isset($projects) & is_array($projects), 'Projects must be an array');
        $count = count($projects);
        if ($count === 0) {
          echo <<<HTML
            <div class="text-center text-white m-6">
              <h3>No projects found</h3>
            </div>
          HTML;
        } else {
          assert($count > 0, 'There must be at least one project to display');
          $i = -1;
          foreach ($projects as $project) {
            $i++;
            $date = date_create($project->date_created);
            $date = date_format($date, 'H:i M d, Y');

            $content = <<<HTML
              <div class="pt-3 pb-4 row">
                <div class="col mx-4">
                  <a class="link-deco-hover fs-2" href="/public/projects/$project->project_id">{$project->project_name}</a>
                  <div class="text-dark-light fs-5 flex-wrap">{$project->description}</div>
                  <div class="text-dark-light">
                    <i class="fa-solid fa-user text-dark-light"></i>  {$project->owner}
                    <i class="fa-solid fa-clock text-dark-light ms-3"></i>  {$date}
                  </div>
                </div>
                <div class="col-auto text-white fs-4 ms-4 me-5 align-self-center">
                  {$project->issue_count}
                  <i class="fa-solid fa-bug"></i>
                </div>
              </div>
            HTML;

            $border = $i < $count - 1 ? 'border-bottom border-dark-subtle' : '';
            echo <<<HTML
              <div class="$border">
                {$content}
              </div>
            HTML;
          }
        }
        ?>
      </div>
    </div>
  </body>
</html>