<?php

namespace Lulucode;

class Database {
	
	private $dbConnection = null;

	public function __construct() {
		$host 	= getenv('DB_HOST');
		$port 	= getenv('DB_PORT');
		$dbname = getenv('DB_NAME');
		$user 	= getenv('DB_USERNAME');
		$paswd 	= getenv('DB_PASSWORD');

		try {
			$this->dbConnection = new \PDO("mysql:host=$host;port=$port;dbname=$dbname",$user,$paswd);
			// $this->dbConnection = new \PDO("pgsql:host=$host;port=$port;dbname=$dbname",$user,$paswd);
			// echo "Connected successfully"; 
		}catch (\PDOException $e) {
			// exit($e->getMessage());
			echo "Connection failed: " . $e->getMessage();
		}
	}

	public function connect(){
		return $this->dbConnection;
	}


}