<?php
use App\Helpers\Helpers;

$aiven_username = getenv("AIVENUSERNAME");
$aiven_password = getenv("AIVENPASSWORD");

$uri = "mysql://{$aiven_username}:{$aiven_password}@mysql-issue-tracker-dc87b75-issue-tracking-app.h.aivencloud.com:13387/issue_tracker_db?ssl-mode=REQUIRED";

$fields = parse_url($uri);

// build the DSN including SSL settings
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];
;
$conn .= ";dbname=defaultdb";
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem";

try {
  $db = new PDO($conn, $fields["user"], $fields["pass"]);
  echo "Connected to the database<br>";
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

echo "Server Addr: " . $_SERVER['PHP_SELF'] . "<br>";
echo "URI: " . $_SERVER['REQUEST_URI'];
echo "<br>Current URL: " . current_url();
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
    <?php

    if (isset($_REQUEST)) {
      if (isset($_REQUEST['info_button'])) {
        Helpers::redirect_to("info");
      }
      if (isset($_REQUEST['third_button'])) {
        Helpers::redirect_to("third");
      }
    }
    ?>
  </body>
</html>