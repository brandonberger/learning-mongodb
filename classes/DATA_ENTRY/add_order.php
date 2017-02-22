<?php
	class Add_Order extends MongoDB_Main {

		public function __construct($data) {
			$document = array();
			foreach ($data as $key => $value) {
				if ($key == 'submit') continue;
				$document[$key] = $value;
			}


			parent::addCollection('orders')->insert($document);
			//$this->order_id = $document['_id']->{'$id'};
			$this->order = $document;
			$this->transportation = $this->AddTransportation();
			//$display = parent::displayDoc(parent::findDocs(parent::addCollection('orders')));
		}

		public function AddTransportation() {
			foreach ($this->order as $key => $value) {
				if ($key == '_id' || $key == 'pickup_date') {
					$transportation[$key] = $value;
				}
			}

			$date = date('Y-m-d', strtotime($transportation['pickup_date']));
			//$transportation = array_combine($key, $values);

			//$transportation = json_encode($array);
			//$transportation = json_decode($transportation);

			/*$transportation = array('date' => $date),
							  array('$set' => array('test' => 'test')), 
							  null, 
							  array('new' => true);*/

			$test = parent::addCollection('transportation')->findAndModify(
							array('date' => $date),
							null,
							array('$set' => 
								array( 'traveling' => array('order_id' => $transportation['_id']))
							), 
							array('new' => true)
						);

			var_dump($test);exit;

		}
	}