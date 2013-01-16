<?php

/**
 * @file
 * Sample authorize endpoint.
 *
 * Obviously not production-ready code, just simple and to the point.
 *
 * In reality, you'd probably use a nifty framework to handle most of the crud for you.
 */

require __DIR__.'lib/OAuth2StorageMongo.php';
require __DIR__.'config.php';

// Clickjacking prevention (supported by IE8+, FF3.6.9+, Opera10.5+, Safari4+, Chrome 4.1.249.1042+)
header('X-Frame-Options: DENY');

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

$oauth = new OAuth2(new OAuth2StorageMongo($CONFIG['DSN'], $CONFIG['MONGO_CONFIG']));

if ($_POST) {
  // $userId = $_SESSION['user_id']; // Use whatever method you have for identifying users.
  $userId = 42;
  $oauth->finishClientAuthorization($_POST["accept"] == "Yep", $userId, $_POST);
}

try {
  $auth_params = array();
  $auth_params = $oauth->getAuthorizeParams();
} catch (OAuth2ServerException $oauthError) {
  $oauthError->sendHttpResponse();
}

?>
<html>
  <head>
  <title>Authorize</title>
  <script>
  if (top != self) {
    window.document.write("<div style='background:black; opacity:0.5; filter: alpha (opacity = 50); position: absolute; top:0px; left: 0px;"
    + "width: 9999px; height: 9999px; zindex: 1000001' onClick='top.location.href=window.location.href'></div>");
  }
  </script>
  </head>
  <body>
    <form method="post" action="#">
      <?php foreach ($auth_params as $key => $value) : ?>
        <input type="hidden" name="<?=filter_var($key, FILTER_SANITIZE_FULL_SPECIAL_CHARS)?>" value="<?=filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS)?>" />
      <?php endforeach; ?>
      Do you authorize the app to do its thing?
      <p>
        <input type="submit" name="accept" value="Yep" />
        <input type="submit" name="accept" value="Nope" />
      </p>
    </form>
  </body>
</html>