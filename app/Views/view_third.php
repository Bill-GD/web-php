<?php

use App\Helpers\Helper;

Helper::echo_server_address_info();
if (isset($_REQUEST)) {
  if (isset($_REQUEST['home_button'])) {
    Helper::redirect_to("/");
  }
  if (isset($_REQUEST['info_button'])) {
    Helper::redirect_to("info");
  }
}

?>
<form method="get">
  <button name="home_button">To Home</button>
</form>
<form method="get">
  <button name="info_button">To Info</button>
</form>