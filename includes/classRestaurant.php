<?php
require_once "classDatabase.php";

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

	public function GetRestaurants($connection )
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

	public function GetRestaurantByCategory($category,$connection)
	{
		$arrayRestaurant = array();
		$sql="select * from restaurants where restaurantId in (select restaurantId from restaurantCategory where categoryId in (select categoryId from categories where name='$category'))";
		// echo $sql;
		$result = $connection->query($sql);
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc()){
				array_push($arrayRestaurant ,  $row);
				// print_r($result);
			}
		}

		return $arrayRestaurant;


	}

	public function GetRestaurantByName($name,$connection)
	{
		$arrayRestaurant = array();
		$sql='SELECT * from restaurants where name ="'.$name.'"';
		$result = $connection->query($sql);
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				array_push($arrayRestaurant ,  $row);
			}
		}
		// print_r($result);
		// $connection->CloseConnection();
		return $arrayRestaurant;
	}




}


?>