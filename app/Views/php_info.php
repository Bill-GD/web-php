<?php
use App\Helpers\Helpers;

if (isset($_REQUEST['info_input'])) {
  echo $_REQUEST['info_input'] . "<br>";
}

echo 'Hello from php_info.php<br>';
if (isset($_REQUEST)) {
  if (isset($_REQUEST['home_button'])) {
    Helpers::redirect_to("/");
  }
  if (isset($_REQUEST['third_button'])) {
    Helpers::redirect_to("third");
  }
}
echo $_SERVER['REQUEST_URI'];
echo "<br>" . current_url();
?>

<form method="get">
  <button name="home_button">To Home</button>
</form>
<form method="get">
  <button name="third_button">To Third View</button>
</form>

<?php
phpinfo();