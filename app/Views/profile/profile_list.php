<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Profiles</title>
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark-subtle">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="clearfix container px-lg-5 mt-2 w-30">
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
      } ?>
      <div class="mt-3 border border-dark-subtle rounded-2">
        <?php
        assert(isset($profiles) & is_array($profiles), 'profiles must be an array');
        $count = count($profiles);
        if ($count === 0) {
          echo <<<HTML
            <div class="text-center text-white m-6">
              <h3>No profiles found</h3>
            </div>
          HTML;
        } else {
          assert($count > 0, 'There must be at least one profile to display');
          $i = -1;
          foreach ($profiles as $profile) {
            $i++;
            $date = date_create($profile->date_created);
            $date = date_format($date, 'H:i M d, Y');
            $acc_type = $profile->is_admin ? 'Admin' : 'User';
            $gh = $profile->is_github_auth_user ? '<i class="fa-brands fa-github fs-4 ms-1 text-dark-light"></i>' : '';
            $user_pfp = $profile->avatar_url;
            if (!str_contains($user_pfp, 'http')) {
              assert(str_contains($user_pfp, 'assets'), 'User profile picture should be in assets folder, got ' . $user_pfp);
              $user_pfp = App\Helpers\Helper::get_resource_path($user_pfp);
            }

            $content = <<<HTML
              <div class="pt-1 pb-2 row">
                <div class="col-auto ms-4 align-self-center">
                  <img class="rounded-5" src="$user_pfp" width=60, height=60>
                </div>
                <div class="col">
                  <p class="text-white fs-2 m-0">
                    {$profile->username} {$gh}
                  </p>
                  <div class="text-dark-light fs-6 mb-1">{$profile->email}</div>
                  <div class="text-dark-light">
                    <i class="fa-solid fa-image-portrait"></i>  {$profile->user_id}
                    <i class="fa-solid fa-user text-dark-light ms-3"></i>  {$acc_type}
                    <i class="fa-solid fa-clock text-dark-light ms-3"></i>  {$date}
                  </div>
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
  </body>
</html>