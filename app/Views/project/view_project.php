<?php
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
          <div class="col h-100 border rounded-2 border-dark-subtle">
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
                $content = <<<HTML
                  <div class="pt-1 pb-2">
                    <a class="link-deco-hover fs-3 m-0" href="#">{$issue->title}</a>
                    <div class="text-dark-light fs-5">{$issue->description}</div>
                    <div class="text-dark-light">
                      <i class="fa-solid fa-user-pen text-dark-light"></i>  {$issue->issuer}
                      <i class="fa-solid fa-user-tag text-dark-light ms-3"></i>  {$issue->assignee}
                      <br>
                      <i class="fa-solid fa-clock text-dark-light"></i> Created: {$date_created}
                      <br>
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
      <?php } else if ($view_members) { ?>
        <?php if ($is_viewer_owner) { ?>
            <form action="/public/projects/<?= $project_id ?>/add-member" method="post" class="row mt-3">
              <div class="col">
                <input type="text" name="add_email" class="form-control form-input h-100 bg-dark-light"
                  placeholder="Enter email">
              </div>
              <div class="col-auto">
                <select class="form-select bg-dark-light text-white h-100" name="new_member_role">
                  <?php
                  $roles = array_filter(App\Models\ProjectRole::cases(), fn($role) => $role->name !== 'owner');
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
                $content = <<<HTML
                  <div class="px-4 py-3 d-flex align-items-center $border">
                    <span class="fs-4 me-3">{$member['username']}</span>
                    <span class="text-dark-light fs-6">{$member['email']}</span>
                    <span class="text-dark-light ms-auto"><i class="fa-solid fa-user"></i> {$role}</span>
                  </div>
                HTML;
                echo $content;
              }
            }
            ?>
          </div>
      <?php } else if ($view_settings) { ?>

      <?php } ?>
    </div>
  </body>
</html>