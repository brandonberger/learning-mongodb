<?php
	// Connect to mongodb
	$m = new MongoClient();

	// select database
	$db = $m->newdb;

	// select collection (table)
	$collection = $db->newdb;

	// select all from collection
	$cursor = $collection->find();

	// loop through collection documents (rows)
	foreach ($cursor as $document) {
		echo $document['first_name']."<br>";
	}


?>