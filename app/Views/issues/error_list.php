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
    <div class="clearfix container px-lg-5 mt-2">
      <div class="input-group position-relative">
        <button class="btn btn-dark border-dark-subtle">Filter</button>
        <input type="text" name="q" class="form-control form-input bg-dark-light" placeholder="Search all issues">
        <i class="fa-solid fa-search search-icon-prefix svg-dark-light"></i>
        <!-- go to create error -->
        <a href="create-issue" role="button" class="btn btn-success"> New issue </a>
      </div>

      <?= App\Helpers\PageComponent::table_with_header(
        'mt-3',
        '<div class="flex-auto justify-content-evenly">
          <a href="#" class="text-white link-no-deco">
            ' . App\Helpers\PageComponent::open_issue_svg(16) . '
            0 Open
          </a>
          <a href="#" class="text-white link-no-deco">
            ' . App\Helpers\PageComponent::closed_issue_svg(16) . '
            1 Closed
          </a>
        </div>
        <div class="d-flex justify-content-end">' .
        App\Helpers\PageComponent::dropdown(
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
        ) .
        App\Helpers\PageComponent::dropdown(
          'Project',
          '<h6 class="dropdown-header">Filter by project</h6>',
          [
            '<span class="d-flex justify-content-center">No project</span>'
          ],
          'mx-3',
          'text-white'
        ) .
        App\Helpers\PageComponent::dropdown(
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
        ) .
        App\Helpers\PageComponent::dropdown(
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
        ) .
        App\Helpers\PageComponent::dropdown(
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
        ) . '</div>',
        App\Helpers\PageComponent::open_issue_svg(24) . <<<HTML
          <h4>There aren’t any open issues.</h4>
        HTML
      ) ?>
    </div>
  </body>
</html>