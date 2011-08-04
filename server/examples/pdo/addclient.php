<?php

/**
 * @file
 * Sample client add script.
 *
 * Obviously not production-ready code, just simple and to the point.
 */

include "lib/PDOOAuth2.php";

if ($_POST && isset($_POST["client_id"]) && isset($_POST["client_secret"]) && isset($_POST["redirect_uri"])) {
  $oauth = new PDOOAuth2();
  $oauth->addClient($_POST["client_id"], $_POST["client_secret"], $_POST["redirect_uri"]);
}

function new_key() {
	$fp = fopen('/dev/urandom','rb');
	$entropy = fread($fp, 32);
	fclose($fp);
	// in case /dev/urandom is reusing entropy from its pool, let's add a bit more entropy
	$entropy .= uniqid(mt_rand(), true);
	$hash = sha1($entropy);  // sha1 gives us a 40-byte hash
	// The first 30 bytes should be plenty for the consumer_key
	// We use the last 10 for the shared secret
	return substr($hash,0,30);	
}

?>

<html>
  <head>Add Client</head>
  <body>
    <form method="post" action="addclient.php">
      <p>
        <label for="client_id">Client ID:</label>
        <input type="text" name="client_id" id="client_id" value="<?= new_key(); ?>" size="40" />
      </p>
      <p>
        <label for="client_secret">Client Secret (password/key):</label>
        <input type="text" name="client_secret" id="client_secret" value="<?= new_key(); ?>" size="40" />
      </p>
      <p>
        <label for="redirect_uri">Redirect URI:</label>
        <input type="text" name="redirect_uri" id="redirect_uri" size="50" />
      </p>
      <input type="submit" value="Submit" />
    </form>
  </body>
</html>
