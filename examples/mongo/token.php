<?php

use JK\OAuth2\MongoDB\OAuth2StorageMongo;
use JK\OAuth2\OAuth2;
use JK\OAuth2\OAuth2ServerException;

require dirname(__DIR__).'/bootstrap.php';

require __DIR__ . 'config.php';

$oauth = new OAuth2(new OAuth2StorageMongo($CONFIG['DSN'], $CONFIG['MONGO_CONFIG']));
try {
  $oauth->grantAccessToken();
}
catch (OAuth2ServerException $oauthError) {
  $oauthError->sendHttpResponse();
}
