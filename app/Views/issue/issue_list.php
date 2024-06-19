<?php
$title = 'Issues';
$title .= isset($_GET['p']) ? ' - Search' : (isset($filter) ? $filter : ' - All');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= App\Helpers\PageComponent::import_styles() ?>
    <link rel="stylesheet" href="<?= App\Helpers\Helper::get_resource_path('public/style/error_style.css') ?>">
    <title><?= $title ?></title>
  </head>
  <body class="bg-dark-subtle text-white">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="clearfix container px-lg-5 mt-2">
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
      } ?>
      <div class="d-flex mt-3">
        <div class="input-group me-2" style="max-width:fit-content;min-width:fit-content;">
          <a href="/public/issues/created" class="btn btn-dark bg-dark-subtle fw-medium border border-dark-subtle"
            role="button">Created</a>
          <a href="/public/issues/assigned" class="btn btn-dark bg-dark-subtle fw-medium border border-dark-subtle"
            role="button">Assigned</a>
        </div>
        <form method="get" class="w-100 me-2">
          <input type="text" name="i" class="form-control form-input h-100 bg-dark-light"
            value="<?= isset($_GET['i']) ? $_GET['i'] : '' ?>" placeholder="Search issue">
        </form>
        <a <?= \App\Helpers\Helper::is_admin() ? '' : 'href="/public/create-issue"' ?> role="button"
          class="btn btn-success col-2 <?= \App\Helpers\Helper::is_admin() ? 'disabled' : '' ?>"> New issue </a>
      </div>

      <?= App\Helpers\PageComponent::table_with_header(
        'mt-3',
        '<div class="d-flex justify-content-end">
          <div class="flex-auto">
            <a href="?s=open" class="text-white text-decoration-none me-2">
              ' . $issue_count['open'] . ' Open
            </a>
            <a href="?s=cancelled" class="text-white text-decoration-none me-2">
              ' . $issue_count['cancelled'] . ' Cancelled
            </a>
            <a href="?s=pending" class="text-white text-decoration-none me-2">
              ' . $issue_count['pending'] . ' Pending
            </a>
            <a href="?s=tested" class="text-white text-decoration-none me-2">
              ' . $issue_count['tested'] . ' Tested
            </a>
            <a href="?s=closed" class="text-white text-decoration-none me-2">
              ' . $issue_count['closed'] . ' Closed
            </a>
          </div>' .
        App\Helpers\PageComponent::dropdown(
          'Sort',
          '<h6 class="dropdown-header">Sort by</h6>',
          [
            // put class invisible if not selected
            '<a class="dropdown-item" href="?t=newest">
              <i class="fa-solid fa-check'. (str_contains($_SERVER['REQUEST_URI'], 'newest') ? '' : ' invisible') .'"></i>
              Newest
            </a>',
            '<a class="dropdown-item" href="?t=oldest">
              <i class="fa-solid fa-check' . (str_contains($_SERVER['REQUEST_URI'], 'oldest') ? '' : ' invisible') . '"></i>
              Oldest
            </a>'
          ],
          'mx-3',
          'text-white'
        ) . '</div>',
        App\Helpers\PageComponent::open_issue_svg(24) . <<<HTML
          <h4>There are no result.</h4>
        HTML
      ) ?>
    </div>
  </body>
</html>