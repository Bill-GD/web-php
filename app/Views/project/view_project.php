<?php
use App\Models\ProjectRole;

$access_uri = $_SERVER['REQUEST_URI'];
$view_members = str_contains($access_uri, 'members');
$view_settings = str_contains($access_uri, 'settings');
$view_overview = !($view_members || $view_settings);

$active_overview = $view_overview ? 'active' : 'text-white';
$active_members = $view_members ? 'active' : 'text-white';
$active_settings = $view_settings ? 'active' : 'text-white';

$is_viewer_owner = App\Models\ProjectModel::is_member_owner($project_id, $_COOKIE['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $project->project_name ?> | <?= $project->owner ?></title>
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark-subtle">
    <?= App\Helpers\PageComponent::page_header(
      <<<HTML
        <div class="container d-flex justify-content-center">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link $active_overview" href="/public/projects/$project_id">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link $active_members" href="/public/projects/$project_id/members">Members</a>
            </li>
            <li class="nav-item">
              <a class="nav-link $active_settings" href="/public/projects/$project_id/settings">Settings</a>
            </li>
          </ul>
        </div>
      HTML
    ) ?>
    <div class="clearfix container text-white mt-5 <?= $view_overview ? '' : 'w-40' ?>">
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
      } ?>
      <?php if ($view_overview) { ?>
        <div class="row gx-5">
          <div class="col">
            <h2>
              <?= $project->project_name ?>
            </h2>
            <p class="my-4">
              <?= $project->description ?>
            </p>
            <p class="text-dark-light">
              Owner: <?= $project->owner ?>
            </p>
          </div>
          <div class="col h-auto">
            <div class="d-flex mb-3">
              <form method="get" class="w-100 me-2">
                <input type="text" name="i" class="form-control form-input h-100 bg-dark-light"
                  value="<?= isset($_GET['i']) ? $_GET['i'] : '' ?>" placeholder="Search issue">
              </form>
              <a href="/public/projects/<?= $project_id ?>/create-issue" role="button" class="btn btn-success col-auto">
                New issue </a>
            </div>
            <div class="border rounded-2 border-dark-subtle">
              <?php
              assert(isset($issues) & is_array($issues), 'profiles must be an array');
              $count = count($issues);
              if ($count === 0) {
                echo <<<HTML
                  <div class="text-center text-white m-6">
                    <h3>No issues found</h3>
                  </div>
                HTML;
              } else {
                assert($count > 0, 'There must be at least one profile to display');
                $i = -1;
                foreach ($issues as $issue) {
                  $i++;
                  $date_created = date_create($issue->date_created);
                  $date_created = date_format($date_created, 'H:i M d, Y');
                  $date_updated = date_create($issue->date_updated);
                  $date_updated = date_format($date_updated, 'H:i M d, Y');

                  $assignee = $issue->assignee ? $issue->assignee : 'Unassigned';

                  $content = <<<HTML
                    <div class="pt-1 pb-2 ps-4">
                      <a class="link-deco-hover fs-3" href="/public/projects/$project_id/issues/$issue->issue_id">{$issue->title}</a>
                      <div class="text-dark-light fs-5">{$issue->description}</div>
                      <div class="text-dark-light">
                        <i class="fa-solid fa-user-pen text-dark-light"></i>  {$issue->issuer}
                        <i class="fa-solid fa-user-tag text-dark-light ms-3"></i>  $assignee
                        <br>
                        <i class="fa-solid fa-clock text-dark-light"></i> Created: {$date_created}
                        <i class="fa-regular fa-clock text-dark-light"></i> Updated: {$date_updated}
                      </div>
                    </div>
                  HTML;

                  $border = $i < $count - 1 ? 'border-bottom border-dark-subtle' : '';
                  echo <<<HTML
                    <div class="$border">
                      {$content}
                    </div>
                  HTML;
                }
              }
              ?>
            </div>
          </div>
        </div>
      <?php } else if ($view_members) { ?>
        <?php if ($is_viewer_owner) { ?>
            <form action="/public/projects/<?= $project_id ?>/add-member" method="post" class="row mt-3">
              <div class="col">
                <input type="text" name="add_email" class="form-control form-input h-100 bg-dark-light"
                  placeholder="Enter email">
              </div>
              <div class="col-auto">
                <select class="form-select bg-dark-light border-dark-subtle text-white h-100" name="new_member_role">
                  <?php
                  $roles = array_filter(ProjectRole::cases(), fn(ProjectRole $role) => $role !== ProjectRole::owner);
                  foreach ($roles as $role) {
                    echo "<option value='{$role->name}'>" . ucfirst($role->name) . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-success" style="min-width:fit-content;">Add member</button>
              </div>
            </form>
        <?php } ?>
          <div class="border border-dark-subtle rounded-2 mt-3 container p-0">
            <?php
            assert(isset($members) & is_array($members), 'Members must be an array');
            $count = count($members);
            if ($count === 0) {
              echo <<<HTML
                <div class="text-center text-white m-6">
                  <h3>No members found</h3>
                </div>
              HTML;
            } else {
              assert($count > 0, 'There must be at least one member to display');
              $i = -1;
              foreach ($members as $member) {
                $i++;
                $role = ucfirst($member['user_role']->name);
                $border = $i < $count - 1 ? 'border-bottom border-dark-subtle' : '';
                $del_member = $member["user_id"] != $project->owner_id && $is_viewer_owner
                  ? <<<HTML
                      <a href="remove-member/{$member['user_id']}" class="text-decoration-none me-3" data-bs-toggle="modal" data-bs-target="#confirm-delete-user-modal">
                        <i class="fa-solid fa-trash text-danger"></i>
                      </a>
                      <div class="modal fade" id="confirm-delete-user-modal" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content bg-dark-light border border-dark-subtle">
                            <div class="modal-header border-0">
                              <i class="fa-solid fa-exclamation-triangle text-danger fs-4 me-4"></i>
                              <h1 class="modal-title fs-4 text-danger" id="exampleModalLabel">Modal title</h1>
                              <!-- <button type="button" class="btn-close"></button> -->
                            </div>
                            <div class="modal-body">
                              Are you sure you want to remove user
                              <span class="text-primary">{$member['username']}</span> from this project?
                              <br>
                              This is irreversible and all data will be lost.
                            </div>
                            <div class="modal-footer border-0">
                              <a role="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                              <a href="delete" role="button" class="btn btn-danger">Delete</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    HTML
                  : '';
                $content = <<<HTML
                  <div class="px-4 py-3 d-flex align-items-center $border">
                    <span class="fs-4 me-3">{$member['username']}</span>
                    <span class="text-dark-light fs-6">{$member['email']}</span>
                    <span class="text-dark-light ms-auto">
                      $del_member
                      <i class="fa-solid fa-user"></i> {$role}
                    </span>
                  </div>
                HTML;
                echo $content;
              }
            }
            ?>
          </div>
      <?php } else if ($view_settings) { ?>
        <?php if ($is_viewer_owner) { ?>
              <div class="d-flex flex-row justify-content-around align-items-center">
                <!-- <span class="fs-5">
                Delete project
              </span> -->
                <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete-project-modal"
                  role="button">Delete
                  project</a>
              </div>
              <div class="modal fade" id="confirm-delete-project-modal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content bg-dark-light border border-dark-subtle">
                    <div class="modal-header border-0">
                      <i class="fa-solid fa-exclamation-triangle text-danger fs-4 me-4"></i>
                      <h1 class="modal-title fs-4 text-danger" id="exampleModalLabel">Modal title</h1>
                      <!-- <button type="button" class="btn-close"></button> -->
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete project
                      <span class="text-primary"><?= $project->project_name ?></span>?
                      <br>
                      This is irreversible and all data will be lost.
                    </div>
                    <div class="modal-footer border-0">
                      <a role="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                      <a href="delete" role="button" class="btn btn-danger">Delete</a>
                    </div>
                  </div>
                </div>
              </div>
        <?php } ?>
      <?php } ?>
    </div>
  </body>
</html>