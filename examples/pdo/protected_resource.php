<?php

use JK\OAuth2\OAuth2;
use JK\OAuth2\OAuth2ServerException;
use JK\OAuth2\Pdo\OAuth2StoragePDO;

require dirname(__DIR__).'/bootstrap.php';

require_once __DIR__ . "config.php";

$oauth = new OAuth2(new OAuth2StoragePDO($CONFIG['pdo']));

try {
	$token = $oauth->getBearerToken();
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
