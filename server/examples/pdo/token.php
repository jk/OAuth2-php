<?php

/**
 * @file
 * Sample token endpoint.
 *
 * Obviously not production-ready code, just simple and to the point.
 *
 * In reality, you'd probably use a nifty framework to handle most of the crud for you.
 */

require_once "lib/OAuth2StoragePDO.php";
require_once "config.php";

$oauth = new OAuth2(new OAuth2StoragePDO($CONFIG['pdo']));
try {
  $oauth->grantAccessToken();
}
catch (OAuth2ServerException $oauthError) {
  $oauthError->sendHttpResponse();
}
?>
