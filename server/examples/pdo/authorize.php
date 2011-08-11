<?php
/**
 * @file
 * Sample authorize endpoint.
 *
 * Obviously not production-ready code, just simple and to the point.
 *
 * In reality, you'd probably use a nifty framework to handle most of the crud for you.
 */

require_once "lib/OAuth2StoragePDO.php";
require_once "config.php";

/*
 * You would need to authenticate the user before authorization.
 * 
 * Below is some psudeo-code to show what you might do:
 * 
session_start();
if (!isLoggedIn()) {
	redirectToLoginPage();
	exit();
}
 */

$oauth = new OAuth2(new OAuth2StoragePDO($CONFIG['pdo']));

if ($_POST) {
	// $userId = $_SESSION['user_id']; // Use whatever method you have for identifying users.
	$userId = 42;
	$oauth->finishClientAuthorization($_POST["accept"] == "Yep", $userId, $_POST);
}

$auth_params = $oauth->getAuthorizeParams();

?>
<html>
  <head>Authorize</head>
  <body>
    <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
      <?php foreach ($auth_params as $k => $v) { ?>
      <input type="hidden" name="<?php echo $k ?>" value="<?php echo $v ?>" />
      <?php } ?>
      Do you authorize the app to do its thing?
      <p>
        <input type="submit" name="accept" value="Yep" />
        <input type="submit" name="accept" value="Nope" />
      </p>
    </form>
  </body>
</html>
