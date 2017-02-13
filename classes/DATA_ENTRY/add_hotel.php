<?php
	class Add_Hotel extends MongoDB_Main {
		public function __construct($data) {
			$document = array();
			foreach ($data as $key => $value) {
				if ($key == 'submit') continue;
				$document[$key] = $value;
			}
			parent::addCollection('hotels')->insert($document);
		}

	}