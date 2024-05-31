<?php

use App\Helpers\Helpers;

echo "Third view <br>";
echo "Server Addr: " . $_SERVER['PHP_SELF'] . "<br>";
echo "URI: " . $_SERVER['REQUEST_URI'];
echo "<br>Current URL: " . current_url();
if (isset($_REQUEST)) {
  if (isset($_REQUEST['home_button'])) {
    Helpers::redirect_to("/");
  }
  if (isset($_REQUEST['info_button'])) {
    Helpers::redirect_to("info");
  }
}

?>
<form method="get">
  <button name="home_button">To Home</button>
</form>
<form method="get">
  <button name="info_button">To Info</button>
</form>