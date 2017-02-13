<?php
	class MongoDB_Main {

		protected static $connection;
		protected static $db;
		protected static $collection;
		protected static $find;
		protected static $display;

		public function __construct() {
			self::$connection = $this->connection();
			self::$db = $this->addDB();
			//self::$collection = $this->addCollection();
			//self::$find = $this->findDocs();
			//self::$display = $this->displayDoc();
		}

		public function connection() {
			$con = new MongoClient();
			return $con;
		}

		public function addDB() {
			$db = self::$connection->GPC;
			return $db;
		}

		public static function addCollection($name) {
			self::$db->createCollection($name);
			$collection = self::$db->{$name};
			return $collection;
		}

		public function findDocs($collection, $query = false) {
			print_r((object)json_encode($query));
			($query) ? $find = $collection->find(json_encode($query)) : $find = $collection->find();
			return $find;
		}

		public function displayDoc($find) {
			foreach ($find as $row) {
				$display[] = $row;
			}
			return $display;
		}
	}


	

