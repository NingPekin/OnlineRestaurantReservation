<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');

class Database1{
	private $connection;
	
	function __construct($NAME_DB){
		
		$this->OpenConnection($NAME_DB);
	}
	function __destruct(){
		$this->CloseConnection();
	}
	private function OpenConnection($NAME_DB){
		$this->connection = new mysqli(HOST, USER, PASSWORD, $NAME_DB);
		if($this->connection->connect_error){
			die("Connection failed : ". $this->connection->connect_error);
		}
	}
	private function CloseConnection(){
		$this->connection->close();
	}
	public function GetConnection(){
		return $this->connection;
	}
}
?>