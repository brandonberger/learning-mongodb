<?php
	// Covered Query
	// Fetches faster from using indexes instead of scanning documents
	// All fields in the Query must be an indexed field.
	
	// Creating a compound index i.e
	# db.{collection_name}.ensureIndex({field_1:1, field_2:1})
	
	// Querying
	# db.{collection_name}.find({field_1:value},{field_2: 1})

		