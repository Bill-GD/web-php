<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Projects</title>
    <?= App\Helpers\PageComponent::import_styles() ?>
    <link rel="stylesheet" href="<?= App\Helpers\Helper::get_resource_path('public/style/error_style.css') ?>">
  </head>
  <body class="bg-dark-subtle">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="clearfix container px-lg-5 mt-2">
      <div class="d-flex gx-2">
        <div class="input-group" style="max-width:fit-content;min-width:fit-content;">
          <a href="#" class="btn btn-dark bg-dark-subtle fw-medium border border-dark-subtle" role="button">Created</a>
          <a href="#" class="btn btn-dark bg-dark-subtle fw-medium border border-dark-subtle" role="button">Joined</a>
        </div>
        <form action="" method="get" class="w-100 mx-2">
          <input type="text" name="q" class="form-control form-input h-100 bg-dark-light" placeholder="Search project">
        </form>
        <a href="create-project" role="button" class="btn btn-success col-2"> New project </a>
      </div>

      <div class="mt-3 border border-dark-subtle rounded-2">
        <?php
        $count = count($projects);
        if ($count === 0) {
          echo <<<HTML
            <div class="text-center text-white m-6">
              <h3>No projects found</h3>
            </div>
          HTML;
        } else {
          for ($i = 0; $i < $count; $i++) {
            $project = $projects[$i];
            $date = date_create($project->date_created);
            $date = date_format($date, 'H:i M d, Y');

            $content = <<<HTML
              <div class="ps-4 pt-3 pb-4 position-relative">
                <a class="link-deco-hover fs-3" href="#">{$project->project_name}</a>
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