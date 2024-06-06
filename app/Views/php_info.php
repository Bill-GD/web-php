<?php
use App\Helpers\Helper;

if (isset($_REQUEST['info_input'])) {
  echo $_REQUEST['info_input'] . "<br>";
}

echo 'Hello from php_info.php<br>';
if (isset($_REQUEST)) {
  if (isset($_REQUEST['home_button'])) {
    Helper::redirect_to("/");
  }
  if (isset($_REQUEST['third_button'])) {
    Helper::redirect_to("third");
  }
}
Helper::echo_server_address_info();
?>

<form method="get">
  <button name="home_button">To Home</button>
</form>
<form method="get">
  <button name="third_button">To Third View</button>
</form>

<?php
phpinfo();