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
			self::$collection = $this->addCollection();
			self::$find = $this->findDocs();
			self::$display = $this->displayDoc();
		}

		public function connection() {
			$con = new MongoClient();
			return $con;
		}

		public function addDB() {
			$db = self::$connection->GPC;
			return $db;
		}

		public static function addCollection() {
			self::$db->createCollection("hotels");
			$hotels = self::$db->hotels;
			return $hotels;
		}

		public function findDocs() {
			$find = self::$collection->find();
			return $find;
		}

		public function displayDoc() {
			foreach (self::$find as $row) {
				$display[] = $row;
			}

			return $display;
		}
	}


	

