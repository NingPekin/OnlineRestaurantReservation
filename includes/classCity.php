<?php
require_once "classDatabase.php";

class User{
	private static $database;
	
	private $userId;
	private $username;
	private $password;
	private $email;
	private $hash;

	
	function __construct($username,$password,$email,
						 $hash,$userId = null)
	{
		$this->userId = $userId;
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		$this->hash = $hash;

	}

	private static function init_database(){
		if(!isset(self::$database)){
			self::$database = new Database("restaurant_reservation_db");
		}
	}
	public function Create(){
		self::init_database();
		$connection = self::$database->GetConnection();
		$query  = "INSERT INTO users (username, email, password, hash)";
		$query .= " VALUES ('$this->username','$this->email','$this->password', '$this->hash')";
		print_r ($query);
		$result = $connection->query($query);
		return $result;
	}
	public static function ReadUsers(){
		$arrayUsers = array();
		self::init_database();
		$connection = self::$database->GetConnection();
		$sql  = "SELECT * FROM users";
		$result = $connection->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				array_push($arrayUsers ,  $row);
				// print_r($row);
				// $arrayCars += [$row['Make'] => $row];
			}
		}
		return $arrayUsers;
	}
	public function CheckUserByEmail($email)
	{

		self::init_database();
		$connection = self::$database->GetConnection();
		$sql  = "SELECT * FROM users WHERE email='$email'";
		$result = $connection->query($sql);

		return $result;


	}
	public function CheckUserByUserName($username)
	{

		self::init_database();
		$connection = self::$database->GetConnection();
		$sql  = "SELECT * FROM users WHERE username='$username'";
		$result = $connection->query($sql);

		return $result;


	}
	public static function Register()
	{
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['user_name'] = $_POST['user_name'];
		$_SESSION['password'] = $_POST['password'];


	}

}


//-------------------
//$myCar = new Car(2012, "Jeep", "Cherokee", 0, 15000, 450000, "Grey", "Jeep.jpg");
//$myCar->Create();
?>