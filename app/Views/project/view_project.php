<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $project->project_name ?> | <?= $project->owner ?></title>
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark-subtle">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="container text-white mt-3">
      <div class="row gx-5">
        <div class="col h-100">
          <h3>
            <?= $project->project_name ?>
          </h3>
          <p>
            <?= $project->description ?>
          </p>
          <p class="text-dark-light">
            Owner: <?= $project->owner ?>
          </p>
        </div>
        <div class="col h-100">
          put issues here
        </div>
      </div>
    </div>
  </body>
</html>