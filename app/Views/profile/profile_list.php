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
            $content = <<<HTML
              <div class="pt-1 pb-2 text-center">
                <p class="text-white fs-3 m-0">{$profile->username}</p>
                <div class="text-dark-light fs-5">{$profile->email}</div>
                <div class="text-dark-light">
                  <i class="fa-solid fa-user text-dark-light"></i>  {$acc_type}
                  <i class="fa-solid fa-clock text-dark-light ms-3"></i>  {$date}
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