<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php use App\Helpers\PageComponent; ?>

  <?= PageComponent::import_styles() ?>
  <link rel="stylesheet" href="<?= App\Helpers\Helper::get_resource_path('public/style/error_style.css') ?>">
  <title>Create Issues</title>
</head>

<body class="bg-dark-subtle text-white">
  <?= App\Helpers\PageComponent::page_header() ?>
  <div class="clearfix mt-4 container-xl">
    <form class="new_issues" id="new_issues" action="/create" accept-charset="UTF-8" method="post">
      <input type="hidden" id="current_date" name="current_date" value="">
      <?php
      if (isset($_COOKIE['username'])) {
        echo '<input type="hidden" name="username" value="' . $_COOKIE['username'] . '">';
      } ?>

      <div class="Layout">
        <div class="Layout-main">

          <img src="<?= App\Helpers\Helper::get_resource_path('public/assets/default_avatar.png') ?>" alt="avatar"
            class="rounded-5 float-left" width="40px" height="40px">



          <div style="padding-left: 56px">
            <h3>Add a title</h3>
            <div style="margin-bottom: 16px">
              <input type="text" name="title" id="issue_title" class="form-control form-input bg-dark-light"
                placeholder="Title" required>
            </div>
            <legend>
              <h3>Add a description</h3>
            </legend>
            <div class="Box" style="margin-bottom: 16px">
              <div class="tab-container">
                <div class="comment-box-header">
                  <div class="tablink" id="defaultOpen"><span style="margin: auto 15px">Write</span></div>
                </div>
                <div class="tabcontent">
                  <textarea name="description" id="issue_description" class="issue_description form-control form-input"
                    placeholder="Add your description here..." required></textarea>
                </div>

              </div>
              <div class="flex-items-center flex-justify-end d-none d-md-flex my-3">
                <button type="submit" id="submit-button" class="btn btn-success">Submit new issue</button>
              </div>
            </div>
          </div>
        </div>
        <div class="Layout-side-bar">
          <div style="position: relative">
            <div class="sidebar-item">
              <?php
              $userModel = new \App\Models\UserModel();
              $users = $userModel->getAllUsers(); // Replace with your actual method to get all users
              $dropdownItems = [];

              foreach ($users as $user) {
                $dropdownItems[] = '
    <a class="dropdown-item" href="#" data-value="'.$user->user_id.'">
      <i class="fa-solid"></i>
      <img src="https://avatars.githubusercontent.com/u/96820104?s=40" width="20" height="20" />
      ' . $user->username . '
    </a>';
              }

              echo PageComponent::dropdown(
                'Assignees',
                '<h6 class="dropdown-header">Assign up to 10 people to this issue</h6>',
                $dropdownItems,
                'mx-3',
                'text-white'
              );
              ?>
              <div class="mx-3 mt-4">None yet</div>
            </div>

            <div class="sidebar-item border-tb mt-3 pt-3 pb-3">
              <?php
              $projectModel = new \App\Models\Project();
              $projects = $projectModel->getAllProjects(); // Replace with your actual method to get all projects
              $dropdownItems = [];

              foreach ($projects as $project) {
                $dropdownItems[] = '
                  <a class="dropdown-item" href="#" data-value="' .$project->project_id.'">
                    <i class="fa-solid fa-check"></i>
                    ' . $project->name . '
                  </a>';
              }

              echo PageComponent::dropdown(
                'Projects',
                '<h6 class="dropdown-header">Assign to a project</h6>',
                $dropdownItems,
                'mx-3',
                'text-white'
              );
              ?>
              <div class="mx-3 mt-4">None yet</div>
            </div>

            <div class="sidebar-item border-tb mt-3 pt-3 pb-3">
              <?php
              $statuses = ['Error', 'Canceled', 'Pending', 'Tested', 'Closed'];
              $dropdownItems = [];

              foreach ($statuses as $status) {
                $dropdownItems[] = '
                  <a class="dropdown-item status-item" href="#" data-value="' . $status . '">
                    <i class="fa-solid"></i>
                    ' . $status . '
                  </a>';
              }

              echo PageComponent::dropdown(
                'Status',
                '<h6 class="dropdown-header">Set the status of this issue</h6>',
                $dropdownItems,
                'mx-3',
                'text-white'
              );

              ?>
              <input type="hidden" id="selectedStatus" name="selectedStatus">
              <div class="mx-3 mt-4">None yet</div>
            </div>


            <div class="sidebar-item border-b mt-3 pb-3">
              <?php
              $priorities = ['Low', 'Medium', 'High'];
              $dropdownItems = [];

              foreach ($priorities as $priority) {
                $dropdownItems[] = '
                  <a class="dropdown-item priority-item" href="#" data-value="' . $priority . '">
                    <i class="fa-solid"></i>
                    ' . $priority . '
                  </a>';
              }

              echo PageComponent::dropdown(
                'Priority',
                '<h6 class="dropdown-header">Set the priority of this issue</h6>',
                $dropdownItems,
                'mx-3',
                'text-white'
              );

              ?>
              <input type="hidden" id="selectedPriority" name="selectedPriority">



              <div class="mx-3 mt-4">None yet</div>
            </div>


          </div>
        </div>
      </div>
    </form>
