<?php
	class MongoDB_Main {

		protected static $connection;
		protected static $db;
		protected static $collection;
		protected static $find;
		protected static $display;
		protected static $uri;

		public function __construct() {
			self::$connection = $this->connection();
			self::$db = $this->addDB();
			//self::$collection = $this->addCollection();
			//self::$find = $this->findDocs();
			//self::$display = $this->displayDoc();
		}

		public function connection() {

			/** 
			 * Added custom uri because: 
			 * Fatal error: Uncaught exception 'MongoConnectionException' with message 'Failed to connect to:
			 * localhost:27017: Operation timed out
			 * Stack trace: #0
			 * MongoClient->__construct() #1
			 * MongoDB_Main->connection() #2 
			 * MongoDB_Main->__construct() #3 {main} 
			 * thrown
			 *
		     * Solution: 
				I would recommend in PHP connecting not to the socket which your process might not have permissions to access. If you modify the permission of the socket it's only temporary. When you stop the mongo db it will delete the socket, the next time you start it, the permissions will be back to whatever the default is (700 I think).
				Instead connect to the to the default port (27017) mongo opens on 127.0.0.1.
			*/

			$uri = 'mongodb://127.0.0.1';
			$con = new MongoClient($uri);
			return $con;
		}

		public function addDB() {
			$db = self::$connection->GPC;
			return $db;
		}

		public function addCollection($name) {
			self::$db->createCollection($name);
			$collection = self::$db->{$name};
			return $collection;
		}

		public function findDocs($collection, $query = false) {
			($query) ? $find = $collection->find($query) : $find = $collection->find();
			return $find;
		}

		public function displayDoc($find) {
			foreach ($find as $row) {
				$display[] = $row;
			}
			return $display;
		}
	}


	

