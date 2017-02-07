<?php

	$m = new MongoClient();

	$db = $m->newdb;
	$collection = $db->newdb;

	$cursor = $collection->find();

	foreach ($cursor as $document) {
		echo $document['first_name']."<br>";
	}


?>