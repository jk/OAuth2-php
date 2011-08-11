<?php

/**
 * @file
 * Sample client add script.
 *
 * Obviously not production-ready code, just simple and to the point.
 */

require_once "lib/OAuth2StoragePdo.php";
require_once "config.php";

$oauth = new OAuth2StoragePDO($CONFIG['pdo']);

if (isset($_GET['delete'])) {
	try {
		$oauth->deleteClient($_GET['delete']);
	} catch (PDOException $e) {
		echo 'Can\'t delete client id: '.$_GET['delete']."<br>\n";
	}
}
?>

<html>
  <head>
  	<title>List Client</title>
	<style type="text/css" media="screen">
		body {
			font-family: "Helvetica Neue", Helvetica, sans-serif;
			font-size: 10pt;
		}
		.key {
			font-family: "Courier New", Courier, monospace;
			size: 12pt;
		}
		thead > tr {
			background-color: black;
		}
		thead > tr > td {
			font-weight: bold;
			color: white;
			padding-left: 5px;
			padding-right: 5px;
		}
	</style>
  </head>
  <body>
	<h1>List all clients</h1>
	<ul><li><a href="addclient.php">Add a client</a></li></ul>
	<table border="1" width="100%">
		<thead>
			<tr>
				<td>#</td>
				<td>client_id</td>
				<td>client_secret</td>
				<td>redirect_uri</td>
				<td>Delete?</td>
			</tr>
		</thead>
		<tbody>
<?php
$i = 0;
foreach ($oauth->listClients() as $client) {
?>
			<tr>
				<td><?=$i++?></td>
				<td><span class="key"><?=$client['client_id']?></span></td>
				<td>(crypted)</td>
				<td><a href="<?=$client['redirect_uri']?>" target="_blank"><?=$client['redirect_uri']?></a></td>
				<td><a href="?delete=<?=$client['client_id']?>">Delete</a></td>
			</tr>
<?
}
?>
		</tbody>
	</table>
  </body>
</html>
