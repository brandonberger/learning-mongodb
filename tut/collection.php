<?php
	// Mongo Connection
	$m = new MongoClient();
	// Select db (will create it if doesnt exist)
	$db = $m->bula;
	// Creates a new collection
	$collection = $db->createCollection("bar");	

?>	