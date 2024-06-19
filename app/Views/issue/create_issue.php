<?php
use App\Helpers\PageComponent;
use App\Models\IssuePriority;
use App\Models\IssueStatus;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= PageComponent::import_styles() ?>
    <link rel="stylesheet" href="<?= App\Helpers\Helper::get_resource_path('public/style/error_style.css') ?>">
    <title>Create Issue</title>
  </head>

  <body class="bg-dark-subtle text-white">
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
    <div class="clearfix mt-4 container">
      <form action="create-new-issue" accept-charset="UTF-8" method="post">
        <div class="row">
          <div class="col-auto">
            <img src="<?= $issuer_avatar ?>" title="<?= $issuer_name ?>" class="rounded-5 float-left" width="40px"
              height="40px">
            <br>
            <span class="text-white"><?= $issuer_name ?></span>
          </div>
          <div class="col">
            <div class="container">
              <?php if (isset($_GET['error_message'])) {
                echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
              } ?>
              <div class="form-group mb-3">
                <h5>Add a title</h5>
                <input type="text" name="issue_title" class="form-control form-input bg-dark-light" placeholder="Title"
                  required>
              </div>
              <div class="form-group">
                <h5>Add a description</h5>
                <textarea name="issue_description" class="form-control form-input bg-dark-light"
                  placeholder="Add your description here..." required></textarea>
              </div>
              <div class="form-group mt-3 row w-40 align-items-center">
                <h5 class="col-2">Project</h5>
                <select class="form-select bg-dark-light border-dark-subtle text-white ms-4 col w-100">
                  <option><?= $project_name ?></option>
                </select>
              </div>
              <div class="form-group mt-3 row w-40">
                <h5 class="col-2">Priority</h5>
                <select class="form-select bg-dark-light border-dark-subtle text-white ms-4 col w-100"
                  name="issue_priority">
                  <?php
                  foreach (IssuePriority::cases() as $priority) {
                    echo "<option value='{$priority->name}'>" . ucfirst($priority->name) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success">Submit new issue</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>