<?php
require_once "classDatabase.PDO.php";

class Restaurant{
	private static $database;
	
	private $restaurantId;
	private $name;
	private $address;
	private $openningHour;
	private $closingHour;
	private $style;
	private $phoneNumber;
	private $picture;

	
	function __construct($name,$address,$openingHour,
						 $closingHour,$style,$phoneNumber,$picture,$restaurantId = null)
	{
		$this->restaurantId = $restaurantId;
		$this->name = $name;
		$this->address = $address;
		$this->openingHour = $openingHour;
		$this->closingHour = $closingHour;
		$this->style = $style;
		$this->phoneNumber = $phoneNumber;
		$this->picture = $picture;
	}

	private static function init_database(){
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}

	public function GetRestaurants()
	{
		$arrayRestaurant = array();

		$sql  = "SELECT * FROM restaurants";
		$result = $connection->query($sql);
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc()){
				array_push($arrayRestaurant ,  $row);
				// print_r($row);
				// $arrayCars += [$row['Make'] => $row];
			}
		}
		$connection->CloseConnection();
		return $arrayRestaurant;
		
	}

	public static function GetRestaurantByCategory($category)
	{
		self::init_database();
		$connection = self::$database->GetConnection();
	try
	{

		$sql="select * from restaurants where restaurantId in (select restaurantId from restaurantCategory where categoryId in (select categoryId from categories where name=?))";
		// echo $sql;
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$category);
		$stmt->execute();
		$Obj = $stmt->fetchAll(PDO::FETCH_OBJ);
		if($Obj)

		{
			return $Obj;
		}
		// $result = $connection->query($sql);
		// if($result->num_rows > 0)
		// {
		// 	while($row = $result->fetch_assoc()){
		// 		array_push($arrayRestaurant ,  $row);
		// 		// print_r($result);
		// 	}
		// }

		// return $arrayRestaurant;
	}
	catch(PDOException $e)
	{
		echo "Query Failed ".  $e->getMessage();
	}

	}

	public static function GetRestaurantByName($name)
	{
		self::init_database();
		$connection = self::$database->GetConnection();
		try 
		{
		$arrayRestaurant = array();
		$sql='SELECT * from restaurants where name =?';

		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$name);
		$stmt->execute();
		$Obj = $stmt->fetchAll(PDO::FETCH_OBJ);
		if($Obj)

		{
			return $Obj;
		}
		// $result = $connection->query($sql);
		// if($result->num_rows > 0)
		// {
		// 	while($row = $result->fetch_assoc())
		// 	{
		// 		array_push($arrayRestaurant ,  $row);
		// 	}
		// }
		// // print_r($result);
		// // $connection->CloseConnection();
		// return $arrayRestaurant;
	}
	catch(PDOException $e)
	{
		echo "Query Failed ".  $e->getMessage();
	}

	
	}




}


?>