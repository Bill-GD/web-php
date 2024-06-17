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
            <div class="text-center m-6">
              <h2 class="text-muted">No projects found</h2>
            </div>
          HTML;
        } else {
          for ($i = 0; $i < $count; $i++) {
            $project = $projects[$i];
            $date = date_create($project->date_created);
            $date = date_format($date, 'M d, Y');

            $content = <<<HTML
              <div class="px-4 py-3">
                <a class="link-deco-hover fs-3" href="#">{$project->project_name}</a>
                <div class="text-white">
                  {$project->owner}
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