<?php
use App\Config\Globals;
use App\Database\DatabaseManager;
use App\Helpers\Helper;

echo "Database version: " . DatabaseManager::instance()->get_version() . "<br>";
$client_id = Globals::$github_client_id;
$redirect_uri = urlencode(Globals::$github_redirect_uri);

$github_auth_url = "https://github.com/login/oauth/authorize?scope=user&client_id={$client_id}&redirect_uri={$redirect_uri}";

Helper::echo_server_address_info();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Document</title>
  </head>
  <body>
    <form method="get">
      <button name="info_button">To info</button>
    </form>
    <form method="get">
      <button name="third_button">To Third View</button>
    </form>

    <a href="<?= $github_auth_url ?>"> Get Your GitHub info </a>
    <?php
    if (isset($_REQUEST)) {
      if (isset($_REQUEST['info_button'])) {
        Helper::redirect_to("info");
      }
      if (isset($_REQUEST['third_button'])) {
        Helper::redirect_to("third");
      }
    }
    ?>
  </body>
</html>