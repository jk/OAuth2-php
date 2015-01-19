<?php
$CONFIG['DSN'] = 'mongodb://oauth2:oauth2@localhost:27020,localhost:27021,localhost:27022/oauth2';
// See config details in http://php.net/manual/en/mongo.construct.php
$CONFIG['MONGO_CONFIG'] = array(
	'replicaSet' => 'foo',
	);
?>