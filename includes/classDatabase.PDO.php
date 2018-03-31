<?php

$HOST =  'localhost';
$USER = 'root';
$PASSWORD = '';

class Database{
	private $connection;
	
	function __construct($NAME_DB){
		
		$this->OpenConnection($NAME_DB);
	}
	function __destruct(){
		$this->CloseConnection();
	}
	private function OpenConnection($NAME_DB){
		global $HOST, $USER, $PASSWORD;
		try{
			$this->connection = new PDO("mysql:host=$HOST; dbname=$NAME_DB", $USER, $PASSWORD);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		}catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}
	}
	private function CloseConnection(){
		$this->connection = null;
	}
	public function GetConnection(){
		return $this->connection;
	}
}
?>