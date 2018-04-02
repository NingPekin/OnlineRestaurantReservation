<?php
require_once "classDatabase.PDO.php";

class Reservation{
	private static $database;
	
	private $reservationId;
	private $userId;
	private $reservedDate;
	private $reservedTime;
	private $numberOfPeople;
	private $tableId;


	
	function __construct($userId,$reservedDate,$reservedTime,$numberOfPeople,$tableId,$reservationId = null)
	{
		$this->reservationId = $reservationId;
		$this->userId = $userId;
		$this->reservedDate = $reservedDate;
		$this->reservedTime = $reservedTime;
		$this->numberOfPeople = $numberOfPeople;
		$this->tableId = $tableId;

	}

	private static function init_database(){
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}

	public static function Create($userId,$reservedDate,$reservedTime,$numberOfPeople,$tableId)
	{
		self::init_database();
		$connection = self::$database->GetConnection();
	try
	{
        $sql="INSERT INTO reservations (userId,reservedDate,reservedTime,numberOfPeople,tableId) ";
        $sql.="VALUES(?,?,?,?,?)";
		// echo $sql;
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$userId);
		$stmt->bindParam(2,$reservedDate);
		$stmt->bindParam(3,$reservedTime);
		$stmt->bindParam(4,$numberOfPeople);
		$stmt->bindParam(5,$tableId);

        $stmt->execute();
        return $connection-> lastInsertId();

	}
	catch(PDOException $e)
	{
		echo "Query Failed ".  $e->getMessage();
	}

	}




}


?>