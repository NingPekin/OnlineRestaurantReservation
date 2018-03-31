<?php
require_once "classDatabase.PDO.php";

class Category{
	private static $database;
	private $categoryId;
	private $name;
	private $picture;

	
	function __construct($name,$picture,$categoryId = null)
	{
		$this->categoryId = $categoryId;
		$this->name = $name;
		$this->picture = $picture;

	}

	private static function init_database(){
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}

	public function Create(){
		self::init_database();
		$connection = self::$database->GetConnection();
		try
		{
		$query  = "INSERT INTO categories (name, picture)";
		$query .= " VALUES (?,?)";
		// print_r ($query);
		$stmt = $connection->prepare($query);
		$stmt->bindParam(1,$this->name);
		$stmt->bindParam(2,$this->picture);
		$stmt->execute();
		return $connection-> lastInsertId();

		}
		catch(PDOException $e){
			echo "Query Failed ".  $e->getMessage();
		}
	}
	public static function GetAllCategory( ) 
	{

		self::init_database();
		$connection = self::$database->GetConnection();
		try
		{
		$sql = "SELECT * FROM categories";
		$stmt = $connection->prepare($sql);	
		$stmt->execute();
		$obj = $stmt->fetchAll(PDO::FETCH_OBJ);
		// $result = mysqli_query($connection,$sql); 
		if($obj)
		{
			return $obj;
		}
		
		}
		catch(PDOException $e)
		{
			echo "Query Failed ".  $e->getMessage();
		}

	}

	public static function GetCategoryByRestaurant($chosenRestaurant)
	{
		self::init_database();
		$connection = self::$database->GetConnection();

		try
		{
		$sql='SELECT categories.name from categories where categories.categoryId in (select restaurantCategory.categoryId from restaurantCategory where restaurantCategory.restaurantId in (SELECT restaurants.restaurantId from restaurants where restaurants.name="'.$chosenRestaurant.'"))';
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		$Obj = $stmt->fetchAll(PDO::FETCH_OBJ);
		if($Obj)

		{
			return $Obj;
		}

		}
		catch(PDOException $e)
		{
			echo "Query Failed ".  $e->getMessage();
		}

	}
}


//-------------------
//$myCar = new Car(2012, "Jeep", "Cherokee", 0, 15000, 450000, "Grey", "Jeep.jpg");
//$myCar->Create();
?>