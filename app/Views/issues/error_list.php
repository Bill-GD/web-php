<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= App\Helpers\PageComponent::import_styles() ?>
    <link rel="stylesheet" href="<?= App\Helpers\Helper::get_resource_path('public/style/error_style.css') ?>">
    <title>Document</title>
  </head>
  <body class="bg-dark-subtle text-white">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="clearfix container-xl px-lg-5 mt-2">
      <div class="input-group position-relative">
        <button class="btn btn-dark border-dark-subtle">Filter</button>
        <i class="fa-solid fa-search subnav-search-icon svg-dark-light"></i>
        <input type="text" name="q" class="form-control form-input bg-dark-light" placeholder="Search all issues">
        <!-- go to create error -->
        <a href="create-issue" role="button" class="btn btn-success"> New issue </a>
      </div>

      <div class="mt-3 border border-dark-subtle rounded-2">
        <div class="bg-dark-light p-3 border-bottom rounded-top-2 border-dark-subtle">
          <div class="d-flex">
            <div class="flex-auto justify-content-evenly">
              <a href="#" class="text-white">
                <?= App\Helpers\PageComponent::open_issue_svg(16) ?>
                0 Open
              </a>
              <a href="#" class="text-white">
                <?= App\Helpers\PageComponent::closed_issue_svg(16) ?>
                1 Closed
              </a>
            </div>

            <div class="d-flex justify-content-end">
              <?= App\Helpers\PageComponent::dropdown(
                'Author',
                '<h6 class="dropdown-header">Filter by author</h6>',
                // get project members from database
                [
                  '<a class="dropdown-item" href="#">
                    <i class="fa-solid fa-check"></i>
                    <img src="https://avatars.githubusercontent.com/u/96820104?s=40" width="20" height="20" />
                    duongducbinh
                  </a>'
                ],
                'mx-3',
                'text-white'
              ) ?>

              <?= App\Helpers\PageComponent::dropdown(
                'Project',
                '<h6 class="dropdown-header">Filter by project</h6>',
                [
                  '<span class="d-flex justify-content-center">No project</span>'
                ],
                'mx-3',
                'text-white'
              ) ?>

              <?= App\Helpers\PageComponent::dropdown(
                'Priority',
                '<h6 class="dropdown-header">Filter by priority</h6>',
                // get project members from database
                [
                  '<a class="dropdown-item" href="#">
                    <i class="fa-solid fa-check invisible"></i>
                    High
                  </a>',
                  '<a class="dropdown-item" href="#">
                    <i class="fa-solid fa-check"></i>
                    Mid
                  </a>',
                  '<a class="dropdown-item" href="#">
                    <i class="fa-solid fa-check invisible"></i>
                    Low
                  </a>'
                ],
                'mx-3',
                'text-white'
              ) ?>

              <?= App\Helpers\PageComponent::dropdown(
                'Assignee',
                '<h6 class="dropdown-header">Filter by who’s assigned</h6>',
                // get project members from database
                [
                  '<a class="dropdown-item" href="#">Assigned to nobody</a>',
                  '<a class="dropdown-item" href="#">
                    <i class="fa-solid fa-check"></i>
                    <img src="https://avatars.githubusercontent.com/u/96820104?s=40" width="20" height="20" />
                    duongducbinh
                  </a>'
                ],
                'mx-3',
                'text-white'
              ) ?>

              <?= App\Helpers\PageComponent::dropdown(
                'Sort',
                '<h6 class="dropdown-header">Sort by</h6>',
                [
                  // put class invisible if not selected
                  '<a class="dropdown-item" href="#">
                    <i class="fa-solid fa-check invisible"></i>
                    Newest
                  </a>',
                  '<a class="dropdown-item" href="#">
                    <i class="fa-solid fa-check"></i>
                    Oldest
                  </a>'
                ],
                'mx-3',
                'text-white'
              ) ?>
            </div>
          </div>
        </div>
        <div class="d-flex flex-column m-6 align-items-center justify-content-center">
          <?= App\Helpers\PageComponent::open_issue_svg(24) ?>
          <h3>There aren’t any open issues.</h3>
          <!-- put issues here based on filters -->
        </div>
      </div>
    </div>
  </body>
</html>