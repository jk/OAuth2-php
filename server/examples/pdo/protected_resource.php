<?php

/**
 * @file
 * Sample protected resource.
 *
 * Obviously not production-ready code, just simple and to the point.
 *
 * In reality, you'd probably use a nifty framework to handle most of the crud for you.
 */

require_once "lib/OAuth2StoragePDO.php";
require_once "config.php";


$oauth = new OAuth2(new OAuth2StoragePDO($CONFIG['pdo']));
$token = $oauth->getBearerToken();

try {
  $oauth->verifyAccessToken($token);
} catch (OAuth2ServerException $oauthError) {
  $oauthError->sendHttpResponse();
}

// With a particular scope, you'd do:
// $oauth->verifyAccessToken($token, "scope_name");

?>

<html>
  <head>
    <title>Hello!</title>
  </head>
  <body>
    <p>This is a secret.</p>
  </body>
</html>
