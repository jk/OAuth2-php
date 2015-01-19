<?php

use JK\OAuth2\OAuth2;
use JK\OAuth2\OAuth2ServerException;
use JK\OAuth2\Pdo\OAuth2StoragePDO;

require_once __DIR__ . "config.php";

$oauth = new OAuth2(new OAuth2StoragePDO($CONFIG['pdo']));
try {
  $oauth->grantAccessToken();
}
catch (OAuth2ServerException $oauthError) {
  $oauthError->sendHttpResponse();
}
?>
