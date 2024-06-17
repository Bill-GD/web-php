<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Projects<?= isset($filter) ? $filter : ' - All' ?></title>
    <?= App\Helpers\PageComponent::import_styles() ?>
    <link rel="stylesheet" href="<?= App\Helpers\Helper::get_resource_path('public/style/error_style.css') ?>">
  </head>
  <body class="bg-dark-subtle">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="clearfix container px-lg-5 mt-2">
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
      } ?>
      <div class="d-flex gx-2">
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
        <a href="create-project" role="button" class="btn btn-success col-2"> New project </a>
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
              <div class="ps-4 pt-3 pb-4 position-relative">
                <a class="link-deco-hover fs-3" href="/public/projects/$project->project_id">{$project->project_name}</a>
                <div class="text-dark-light fs-5">{$project->description}</div>
                <div class="text-dark-light">
                  <i class="fa-solid fa-user text-dark-light"></i>  {$project->owner}
                  <i class="fa-solid fa-clock text-dark-light ms-3"></i>  {$date}
                </div>
                <div class="position-absolute text-white bottom-40 end-5 fs-4">
                  {$project->issue_count}
                  <i class="fa-solid fa-bug"></i>
                </div>
              </div>
            HTML;

            if ($i < $count - 1) {
              echo <<<HTML
                <div class="border-bottom border-dark-subtle">
                  {$content}
                </div>
              HTML;
              continue;
            }
            echo <<<HTML
              <div class="border-dark-subtle">
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