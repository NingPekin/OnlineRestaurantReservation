<?php
require_once "classDatabase.PDO.php";

class City{
	private static $database;
	private $cityId;
	private $name;
	private $picture;

	function __construct($name,$picture,
						 $cityId = null)
	{
		$this->cityId = $cityId;
		$this->name = $name;
		$this->picture = $picture;

	}

	private static function init_database()
	{
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}
	public function Create()
	{
		self::init_database();
		$connection = self::$database->GetConnection();
		try{
		$query  = "INSERT INTO cities (name, picture)";
		$query .= " VALUES (?,?)";
		$stmt = $connection->prepare($query);
		$stmt->bindParam(1,$this->name);
		$stmt->bindParam(2,$this->picture);
		$stmt->execute();
		return $connection-> lastInsertId();

		}
		catch(PDOException $e)
		{
			echo "Query Failed ".  $e->getMessage();
		}
	}

	public static function GetAllCities()
	{
		self::init_database();
		$connection = self::$database->GetConnection();

		// $arrayCities = array();
		try{
		$sql  = "SELECT * FROM cities";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		$result=$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$rows=$stmt->fetchAll();
		// print_r($rows);
		if($rows)
		{
			return $rows;
		}
		// print_r($result);
		// if($arrayCities)
		// {
		// 	return 
		// }
		// if($result->num_rows > 0){
		// 	while($row = $result->fetch_assoc())
		// 	{
		// 		array_push($arrayCities ,  $row);
		// 		// print_r($row);

		// 	}
		// }
		// return $arrayCities;
		}
		catch(PDOException $e){
			echo "Query Failed ".$e->getMessage();
		}
	}
	public function GetCityByRestaurant($chosenRestaurant)
	{
		// echo $chosenRestaurant;
		// $arrayCity = array();
		self::init_database();
		$connection = self::$database->GetConnection();
		try{
		$sql='SELECT cities.name from cities where cities.cityId in (select restaurantCity.cityId from restaurantCity where restaurantCity.restaurantId in (SELECT restaurants.restaurantId from restaurants where restaurants.name=?));';

		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$chosenRestaurant);
		$stmt->execute();
		$cityObject=$stmt->fetchAll(PDO::FETCH_OBJ);
		// echo $sql;
		// print_r($cityObject);
		if($cityObject)
		{
		return $cityObject;
		}
		// $result = $connection->query($sql);
		// if($result->num_rows > 0)
		// {
		// 	while($row = $result->fetch_assoc())
		// 	{
		// 		array_push($arrayCity ,  $row);
		// 		// print_r($row);

		// 	}
		// }
		// return $arrayCity;

	}
	catch(PDOException $e){
		echo "Query Failed ".$e->getMessage();
	} 
	}



}


?>