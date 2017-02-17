<?php
	$m = new MongoClient();
	$db = $m->bula;
	$collection = $db->bar;
	$document = array(
		"title" => "Bula",
		"Location" => "Cocoa Beach",
		"Product_Overview" => "Kava & Kratom");

	$collection->insert($document);