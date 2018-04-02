<?php
require_once "classDatabase.PDO.php";

class Table{
	private static $database;
	private $tableId;
	private $numberOfSeats;
	private $restaurantId;

	
	function __construct($numberOfSeats,$restaurantId,$tableId = null)
	{
		$this->tableId = $tableId;
		$this->numberOfSeats = $numberOfSeats;
		$this->restaurantId = $restaurantId;

	}

	private static function init_database(){
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}

    // check in chosen date and time, there is any reservation. has rdv==true, obj return not empty
	public static function Exist_Reservation($reservedDate,$reservedTime) 
	{

		self::init_database();
		$connection= self::$database->GetConnection();
		try
		{
		$sql = "SELECT reservations.tableId from reservations WHERE reservations.reservedDate=? AND reservations.reservedTime=?;";
    
        $stmt = $connection->prepare($sql);	
        $stmt->bindParam(1,$reservedDate);
		$stmt->bindParam(2,$reservedTime);
		$stmt->execute();
        $obj = $stmt->fetchAll(PDO::FETCH_OBJ);
        // print_r($obj);

        return !empty($obj);
		
		}
		catch(PDOException $e)
		{
			echo "Query Failed ".  $e->getMessage();
        }
    

    }
    
    public static function ValidTableCompare($restaurantId,$numberOfPeople,$reservedDate,$reservedTime) 
	{
        self::init_database();
        $connection = self::$database->GetConnection();
        //there is rdv in chosen date time, now check if there is any other table match criteria, and select one, if has valid table,return 
		try
		{
		$sql = "SELECT * from tables where restaurantId=? AND numberOfSeats>=? and tables.tableId not in (SELECT reservations.tableId from reservations WHERE (reservations.reservedDate=? AND reservations.reservedTime=?)) limit 1";
    
        $stmt = $connection->prepare($sql);	
        $stmt->bindParam(1,$restaurantId);
        $stmt->bindParam(2,$numberOfPeople);
        $stmt->bindParam(3,$reservedDate);
		$stmt->bindParam(4,$reservedTime);
		$stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_OBJ);
        // print_r($obj->tableId);
        return $obj;
		}
		catch(PDOException $e)
		{
			echo "Query Failed ".  $e->getMessage();
		}

         
	}


    public static function ValidTable($restaurantId,$numberOfPeople) 
	{
        self::init_database();
        $connection = self::$database->GetConnection();
        //get all table under criteria
		try
		{
		$sql = "SELECT * from tables where restaurantId=? AND numberOfSeats>=? limit 1";
    
        $stmt = $connection->prepare($sql);	
        $stmt->bindParam(1,$restaurantId);
        $stmt->bindParam(2,$numberOfPeople);

		$stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_OBJ);
        // print_r($obj);

        return $obj;
		
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