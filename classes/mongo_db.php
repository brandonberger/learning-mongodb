<?php
	class CreateDatabase {
		public function __construct() {
			$this->connection = $this->connection();
			$this->db = $this->addDB();
			$this->collection = $this->addCollection();
			$this->find = $this->findDocs();
			$this->display = $this->displayDoc();
		}

		protected function connection() {
			$con = new MongoClient();
			return $con;
		}

		public function addDB() {
			$db = $this->connection->GPC;
			return $db;
		}

		public function addCollection() {
			$this->db->createCollection("hotels");
			$hotels = $this->db->hotels;
			return $hotels;
		}

		public function addDocument($name, $location, $price) {
			$document = array('name' => $name, 'location' => $location, 'price' => $price);
			$this->collection->insert($document);
			return $document;
		}

		public function findDocs() {
			$find = $this->collection->find();
			return $find;
		}

		public function displayDoc() {
			foreach ($this->find as $row) {
				$display[] = $row;
			}

			return $display;
		}
	}

	$obj = new CreateDatabase;
	foreach ($obj->display as $data) {
		echo $data['name'] . ' ' . $data['location'] . ' ' . $data['price'];
		echo '<br><br>';
	}


	

