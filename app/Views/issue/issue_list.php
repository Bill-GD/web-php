<?php
use App\Helpers\Helper;

$title = 'Issues';
$title .= isset($_GET['p']) ? ' - Search' : (isset($filter) ? " - {$filter}" : '');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= App\Helpers\PageComponent::import_styles() ?>
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
        <form method="get" class="w-100">
          <input type="text" name="i" class="form-control form-input h-100 bg-dark-light"
            value="<?= isset($_GET['i']) ? $_GET['i'] : '' ?>" placeholder="Search issue">
        </form>
      </div>
      <?php
      $issue_list = '';
      if (count($issues) <= 0) {
        $issue_list = '<div class="m-6 align-items-center justify-content-center d-flex flex-column">
          ' . $issue_list = App\Helpers\PageComponent::open_issue_svg(24) . '
          <h4>There are no result.</h4>
        </div>';
      } else {
        $i = -1;
        foreach ($issues as $issue) {
          $issue_id = $issue->issue_id;
          $issue_title = $issue->title;
          // $issue_description = $issue->description;
          $issue_priority = $issue->priority;
          $issue_status = $issue->status;
          $issue_created_at = date_format(date_create($issue->date_created), 'H:i M d, Y');
          $issue_updated_at = date_format(date_create($issue->date_updated), 'H:i M d, Y');
          $issue_creator = $issue->issuer_name;
          $issue_assignee = $issue->assignee ? "assigned to {$issue->assignee_name}" : 'unassigned';

          $issue_status_color = Helper::get_status_badge_classes($issue_status);
          $issue_priority_color = Helper::get_priority_badge_classes($issue_priority);

          $i++;
          $b = $i < count($issues) - 1 ? 'border-bottom border-dark-subtle' : '';
          $status = ucfirst($issue_status->name);
          $priority = ucfirst($issue_priority->name);

          $issue_list .= <<<HTML
            <div class="$b px-4 py-2">
              <div class="row">
                <div class="col-1 d-flex flex-column justify-content-evenly me-1">
                  <span class="badge p-1 $issue_status_color">$status</span>
                  <span class="badge p-1 $issue_priority_color">$priority</span>
                </div>
                <div class="col-auto d-flex flex-column">
                  <a class="link-deco-hover fs-4" href="/public/projects/{$issue->project_id}/issues/$issue_id">$issue_title</a>
                  <div class="text-dark-light">
                    opened on $issue_created_at by $issue_creator, $issue_assignee
                  </div>
                </div>
              </div>
            </div>
          HTML;
        }
      }

      echo App\Helpers\PageComponent::table_with_header(
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
              <i class="fa-solid fa-check' . (str_contains($_SERVER['REQUEST_URI'], 'newest') ? '' : ' invisible') . '"></i>
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
        $issue_list
      ); ?>
    </div>
  </body>
</html>