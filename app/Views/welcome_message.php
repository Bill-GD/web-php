<?php
use App\Database\Database;
use App\Helpers\Helpers;
use App\Models\User;

echo "Database version: " . Database::instance()->get_version() . "<br>";
// try {
//   User::register("admin@gmail.co", "saaaa", "daaaaaaaa", "daaaaaaaa");
// } catch (Throwable $th) {
//   echo $th->getMessage() . "<br>";
// }

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