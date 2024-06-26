<?php
use App\Helpers\Helper;
use App\Models\IssueStatus;
use App\Models\IssuePriority;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $issue->title ?> | <?= $project->owner ?>/<?= $project->project_name ?></title>
    <?= App\Helpers\PageComponent::import_styles() ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" />
  </head>
  <body class="bg-dark-subtle">
    <?= App\Helpers\PageComponent::page_header(
      <<<HTML
        <div class="container d-flex justify-content-center">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link text-white" href="/public/projects/$project_id">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/public/projects/$project_id/members">Members</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/public/projects/$project_id/settings">Settings</a>
            </li>
          </ul>
        </div>
      HTML
    ) ?>
    <div class="container text-white mt-5">
      <div class="border-bottom border-dark-subtle pb-4">
        <h3><?= $issue->title ?></h3>
        <div class="d-flex">
          <div class="d-flex justify-content-around me-3 align-items-center">
            <span
              class="badge px-2 py-2 <?= Helper::get_status_badge_classes($issue->status) ?> me-2"><?= ucfirst($issue->status->name) ?></span>
            <span
              class="badge px-2 py-2 <?= Helper::get_priority_badge_classes($issue->priority) ?>"><?= ucfirst($issue->priority->name) ?></span>
          </div>
          <span class="d-flex text-dark-light align-items-center">
            <?= $issue->issuer_name ?> opened this issue on
            <?= date_format(date_create($issue->date_created), 'M d, Y') ?>,
            <?= $issue->assignee_name ? "assigned to {$issue->assignee_name}" : 'unassigned' ?>
          </span>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col">
          <div class="border border-dark-subtle rounded-2">
            <div class="border-bottom border-dark-subtle align-items-center ps-4 py-2">
              Description
            </div>
            <div class="px-4 py-3">
              <?= $issue->description ?>
            </div>
          </div>
        </div>
        <div class="col-3 text-center">
          <?php if (isset($_GET['error_message'])) {
            echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
          } ?>
          <form action="/public/projects/<?= $project_id ?>/issues/<?= $issue->issue_id ?>/update-issue" method="post">
            <?php if ($is_viewer_owner) { ?>
              <div class="form-group mb-3">
                <h6 class="justify-content-start d-flex">Assignee</h6>
                <select class="form-select bg-dark-light border-dark-subtle text-white" name="issue_assignee">
                  <?php
                  foreach ($members as $member) {
                    $selected = $issue->assignee === $member['user_id'] ? 'selected' : '';
                    echo "<option value='{$member['user_id']}' {$selected}>
                <img src='" . Helper::get_profile_picture_url($member['avatar_url']) . "'>
                {$member['username']}
                </option>";
                  }
                  if ($issue->assignee === null) {
                    echo "<option value='null' selected>Unassigned</option>";
                  }
                  ?>
                </select>
              </div>
            <?php } ?>
            <div class="form-group mb-3">
              <h6 class="justify-content-start d-flex">Priority</h6>
              <select class="form-select bg-dark-light border-dark-subtle text-white" name="issue_priority">
                <?php
                foreach (IssuePriority::cases() as $priority) {
                  $selected = $issue->priority === $priority ? 'selected' : '';
                  echo "<option value='{$priority->name}' {$selected}>" . ucfirst($priority->name) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <h6 class="justify-content-start d-flex">Status</h6>
              <select class="form-select bg-dark-light border-dark-subtle text-white" name="issue_status">
                <?php
                foreach (IssueStatus::cases() as $status) {
                  $selected = $issue->status === $status ? 'selected' : '';
                  echo "<option value='{$status->name}' {$selected}>" . ucfirst($status->name) . "</option>";
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-success float-end mt-3">Update Issue</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>