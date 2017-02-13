<?php
	class Add_Order extends MongoDB_Main {

		public function __construct($data) {
			$document = array();
			foreach ($data as $key => $value) {
				if ($key == 'submit') continue;
				$document[$key] = $value;
			}

			parent::addCollection('orders')->insert($document);
			//$display = parent::displayDoc(parent::findDocs(parent::addCollection('orders')));
		}
	}