<?php
require_once "classDatabase.PDO.php";

class RestaurantUser{
	private static $database;
	private $id;
	private $restaurantId;
	private $userId;
	private $createTime;
	private $review;
	private $rate;
	
	function __construct($restaurantId,$userId,$review,$rate,$id = null)
	{
		$this->restaurantId = $restaurantId;
		$this->userId = $userId;
		$this->createTime = date('Y-m-d H:i:s');
		$this->review = $review;
		$this->rate = $rate;
		$this->id = $id;

	}

	private static function init_database(){
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}

	public static function Create($restaurantId,$userId,$createTime,$review,$rate)
	{
		self::init_database();
		$connection = self::$database->GetConnection();
	try
	{
        $sql="INSERT INTO restaurantUser (restaurantId,userId,createTime,review,rate) ";
        $sql.="VALUES(?,?,?,?,?)";
		// echo $sql;
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$restaurantId);
		$stmt->bindParam(2,$userId);
		$stmt->bindParam(3,$createTime);
		$stmt->bindParam(4,$review);
		$stmt->bindParam(5,$rate);

        $stmt->execute();
        return $connection-> lastInsertId();

	}
	catch(PDOException $e)
	{
		echo "Query Failed ".  $e->getMessage();
	}
}

	public static function GetRateByRestaurant($restaurantId)
	{
		self::init_database();
		$connection = self::$database->GetConnection();
	try
	{
		$sql = "SELECT AVG(rate) FROM restaurantUser  WHERE restaurantId = ?";

		// echo $sql;
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$restaurantId);
        $stmt->execute();
		$average = $stmt->fetch(PDO::FETCH_ASSOC);
		// print_r($average);
		return $average;
	}
	catch(PDOException $e)
	{
		echo "Query Failed ".  $e->getMessage();
	}

	}


	public static function GetReviewByRestaurant($restaurantId)
	{
		self::init_database();
		$connection = self::$database->GetConnection();
	try
	{
		$sql = "SELECT * FROM restaurantUser  WHERE restaurantId = ?";

		// echo $sql;
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$restaurantId);
        $stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// print_r($average);
		return $result;
	}
	catch(PDOException $e)
	{
		echo "Query Failed ".  $e->getMessage();
	}

	}

}


?>