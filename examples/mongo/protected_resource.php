<?php

use JK\OAuth2\MongoDB\OAuth2StorageMongo;
use JK\OAuth2\OAuth2;
use JK\OAuth2\OAuth2ServerException;

require dirname(__DIR__).'/bootstrap.php';

require __DIR__ . 'config.php';

$oauth = new OAuth2(new OAuth2StorageMongo($CONFIG['DSN'], $CONFIG['MONGO_CONFIG']));

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
