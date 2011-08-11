<?php

/**
 * @file
 * Sample client add script.
 *
 * Obviously not production-ready code, just simple and to the point.
 */

require_once "lib/OAuth2StoragePdo.php";
require_once "config.php";

if ($_POST && isset($_POST["client_id"]) && isset($_POST["client_secret"]) && isset($_POST["redirect_uri"])) {
  $oauthStorage = new OAuth2StoragePDO($CONFIG['pdo']);
  $oauthStorage->addClient($_POST["client_id"], $_POST["client_secret"], $_POST["redirect_uri"]);
}

function new_key() {
	$length = 32;
	$fp = fopen('/dev/urandom','rb');
	$entropy = fread($fp, $length);
	fclose($fp);
	// in case /dev/urandom is reusing entropy from its pool, let's add a bit more entropy
	$entropy .= uniqid(mt_rand(), true);
	$hash = hash('sha256', $entropy);  // sha1 gives us a 40-byte hash
	return substr($hash,0,$length);	
}


$client_id = new_key();
$client_secret = new_key();
?>

<html>
  <head>
	<title>Add Client</title>
	<style type="text/css" media="screen">
		.key {
			font-family: "Courier New", Courier, monospace;
			font-size: 12pt;
			
		}
	</style>
  </head>
  <body>
    <form method="post" action="addclient.php">
      <p>
        <label for="client_id">Client ID:</label><br>
        <input type="text" name="client_id" id="client_id" value="<?= $client_id; ?>" size="30" class='key' /><br>
      </p>
      <p>
        <label for="client_secret">Client Secret (password/key):</label><br>
        <input type="text" name="client_secret" id="client_secret" value="<?= $client_secret; ?>" size="30" class='key' />
      </p>
      <p>
        <label for="redirect_uri">Redirect URI:</label><br>
        <input type="text" name="redirect_uri" id="redirect_uri" size="50" value="http://" />
      </p>
	<p>
		<label for="title" style='color: darkgrey'>Title / Comment:</label><br>
		<input type="text" name="title" value="e.g. My App" id="title" size="50" disabled>
	</p>
		
      <input type="submit" value="Submit" />
    </form>
  </body>
</html>
