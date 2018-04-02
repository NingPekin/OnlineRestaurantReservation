<?php
require_once "classDatabase.PDO.php";

class Favourite{
	private static $database;
	
	private $restaurantId;
	private $id;
	private $userId;

	
	function __construct($restaurantId,$userId,$id = null)
	{
		$this->restaurantId = $restaurantId;
		$this->id = $id;
		$this->userId = $userId;

	}

	private static function init_database(){
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}

	public static function AddFavouriteToUser($restaurantId,$userId)
	{
		self::init_database();
		$connection = self::$database->GetConnection();
	try
	{
        $sql="INSERT INTO favourites (restaurantId,userId) ";
        $sql.="VALUES(?,?)";
		// echo $sql;
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1,$restaurantId);
		$stmt->bindParam(2,$userId);

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