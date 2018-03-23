<?php 
	include 'includes/DB_Config.php';

	function OpenConnection() 	
	{
		global $DB_HOST , $DB_USER , $DB_PASSWORD , $DB_NAME;
		$connection = mysqli_connect($DB_HOST , $DB_USER , $DB_PASSWORD , $DB_NAME)
		or die("Connection Failed ".mysqli_connect_error);
		return $connection;

	}
	//========================================================================
	function CloseConnection($connection){
		mysqli_close($connection);
	}
     	function getAllCities( ) 
	{
		$arrayCities = array();
		$connection = OpenConnection();
		$sql = "SELECT * FROM cities";
		$result = mysqli_query($connection,$sql); 
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				array_push($arrayCities, $row);
				
			}
			
		}
		// print_r($arrayCities);
		CloseConnection($connection);
		return $arrayCities;
		
	}

	//========================================================================
	function displayAllCitiest()
	{
		$arrayCities = array();
		$arrayCities =getAllCities();
		foreach($arrayCities as $value)
		{
		// echo $value['picture'];
		$arry_string=explode("/", $value['picture']);
		$cityname=explode(".",$arry_string[3])[0];
		//index=2 category of city	
		if($arry_string[2]=='canada')
		{
			$cityCategory='canada';
			// echo $cityCategory;
		}
		if($arry_string[2]=='usa')
		{
			$cityCategory='usa';

		}
		if($arry_string[2]=='china')
		{
			$cityCategory='china';
		}

		echo 
		'<article class="col-md-4 isotopeItem '.$cityCategory.'">
			<div class="portfolio-item">
			<img src="'.$value['picture'].'" alt="">
			<div class="portfolio-desc align-center">
				<div class="folio-info">
				<h5><a name="cityname" href="city.php?chosenCity='.$cityname.'" >'.$cityname.'</a></h5>
				<a href="'.$value['picture'].'" class="fancybox"></a>
				</form>
				</div>
			</div>
			</div>
		  </article>';	
		//   action="city.php" href="city.php"
		}
	

	}
	//========================================================================

	function getAllCuisineCategory( ) 
	{
		$arrayCusinie = array();
		$connection = OpenConnection();
		$sql = "SELECT * FROM categories";
		$result = mysqli_query($connection,$sql); 
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				array_push($arrayCusinie, $row);	
			}
			
		}
		// print_r($arrayCusinie);
		CloseConnection($connection);
		return $arrayCusinie;
		
	}
	//========================================================================

	function displayAllCuisines()
	{
		$arrayCuisines = array();
		$arrayCuisines =getAllCuisineCategory();
		foreach($arrayCuisines as $value)
		{			
		// echo $value['picture'];
		$arry_string=explode("/", $value['picture']);
		$cusineName=explode(".",$arry_string[2])[0];	
		
		echo 	
		'<div class="col-md-3">
		<div class="team-member">
		  <figure class="member-photo"><img src="'.$value['picture'].'" alt="" width="150" height="150" ></figure>
		  <div class="team-detail">
			<h4><a name="cusineName" href="category.php?chosenCategory='.$cusineName.'" >'.$cusineName.'</a></h4>
		  </div>
		</div>
	  </div>';


	  //   <h4><a name="cusineName" href="category.php?chosenCategory='.$cusineName.'" >'.$cusineName.'</a></h4>

	}
	}
	//========================================================================

	function GetRestaurantByCategory($chosenCategory)
	{
		$arrayRestaurant = array();
		// $chosenCategory=$_GET['chosenCategory'];
		// echo $chosenCategory;
		$connection=openConnection();
		$sql="select * from restaurants where restaurantId in (select restaurantId from restaurantCategory where categoryId in (select categoryId from categories where name='$chosenCategory'))";
		$result = mysqli_query($connection,$sql); 
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($arrayRestaurant, $row);	
			}		
		}
		// print_r($arrayRestaurant);
		CloseConnection($connection);
		return $arrayRestaurant;
	}
	//========================================================================


	function DisplayAllRestaurants($chosenCategory)
	{

		$arrayRestaurant = array();
		$arrayRestaurant =GetRestaurantByCategory($chosenCategory);
		foreach($arrayRestaurant as $value)
		{	
			// echo '(href="restaurant.php?chosenRestaurant='.$value["name"].'">)';

		echo '
		<a name="chosenRestaurant" href="restaurant.php?chosenRestaurant='.$value["name"].'">
			<div class="row" style="border-bottom:1px solid">	
			<div class="col-sm-4" style="margin:auto">
			<img src="'.$value["picture"].'" style="width:auto;height:150px;"></div>
			<div class="col-sm-6" style="text-align:center;margin:auto">
			<br>
			<br>
			<b>'.$value["name"].'</b><br>
			'.$value["address"].'<br>
			'.$chosenCategory.'<br>
			</div>
		  </div>
		</a>';
	
		}

	}
	//========================================================================

	function GetCategoryByRestaurant($chosenRestaurant)
	{
		$arrayCategory = array();
		// $chosenCategory=$_GET['chosenCategory'];
		// echo $chosenCategory;
		$connection=openConnection();
		$sql='SELECT categories.name from categories where categories.categoryId in (select restaurantCategory.categoryId from restaurantCategory where restaurantCategory.restaurantId in (SELECT restaurants.restaurantId from restaurants where restaurants.name="'.$chosenRestaurant.'"))';
		$result = mysqli_query($connection,$sql); 
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($arrayCategory, $row);	
			}		
		}
		// print_r($arrayCategory);
		CloseConnection($connection);
		return $arrayCategory;
	}

		//========================================================================

		function GetCityyByRestaurant($chosenRestaurant)
		{
			$arrayCity = array();
			// $chosenCategory=$_GET['chosenCategory'];
			// echo $chosenCategory;
			$connection=openConnection();
			$sql='SELECT cities.name from cities where cities.cityId in (select restaurantCity.cityId from restaurantCity where restaurantCity.restaurantId in (SELECT restaurants.restaurantId from restaurants where restaurants.name="'.$chosenRestaurant.'"))';
			$result = mysqli_query($connection,$sql); 
			if(mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($arrayCity, $row);	
				}		
			}
			// print_r($arrayCategory);
			CloseConnection($connection);
			return $arrayCity;
		}
	//========================================================================
	function GetRestaurantByName($name)
	{
		$restaurantDetail = array();
		// $chosenCategory=$_GET['chosenCategory'];
		// echo $chosenCategory;
		$connection=openConnection();
		$sql='SELECT * from restaurants where name ="'.$name.'"';
		$result = mysqli_query($connection,$sql); 
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($restaurantDetail, $row);	
			}		
		}
		// print_r($restaurantDetail);
		CloseConnection($connection);
		return $restaurantDetail;
	}

	function function_error()
	{
		if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
			echo $_SESSION['message'];    
		else:
			header( "location: index.php" );
		endif;
	}

	function function_success()
	{
		if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
			echo $_SESSION['message'];    
		else:
			header( "location: index.php" );
		endif;
	}
	//======================================================================
	function Login_function()
	{
		global $DB_HOST , $DB_USER , $DB_PASSWORD , $DB_NAME;
		$mysqli = new mysqli($DB_HOST , $DB_USER , $DB_PASSWORD , $DB_NAME) or die($mysqli->error);
	/* User login process, checks if user exists and password is correct */

	// Escape email to protect against SQL injections
	$user_email = $mysqli->escape_string($_POST['user_email']);
	//check if email exist
	$result = $mysqli->query("SELECT * FROM users WHERE email='$user_email'");
	if ( $result->num_rows == 0 )
	{ // email doesn't exist
	 // check if user name exist
		$result = $mysqli->query("SELECT * FROM users WHERE username='$user_email'");
		if($result->num_rows == 0)
		{
			$_SESSION['message'] = "User doesn't exist!";
			function_error();
		}
		else
		{
			goto exist;
		}

	}
	else 

	{ 
	exist:	
		// User exists
	$user = $result->fetch_assoc();
	// echo $user['password'];
	// echo $_POST['password'];
	if ( password_verify($_POST['password'],$user['password']) ) 
	{
		
	$_SESSION['email'] = $user['email'];
	$_SESSION['user_name'] = $user['username'];
	// $_SESSION['active'] = $user['active'];
	// This is how we'll know the user is logged in
	$_SESSION['logged_in'] = true;
	// echo "good";
	function_success();
	}
	else 
	{
		// echo "fail";
	$_SESSION['message'] = "You have entered wrong password, try again!";
	function_error();
	}
	}
	}

	function register_function()
	{
		global $DB_HOST , $DB_USER , $DB_PASSWORD , $DB_NAME;
		$mysqli = new mysqli($DB_HOST , $DB_USER , $DB_PASSWORD , $DB_NAME) or die($mysqli->error);

		/* Registration process, inserts user info into the database 
		and sends account confirmation email message
		*/
		// Set session variables to be used on profile.php page
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['user_name'] = $_POST['user_name'];
		$_SESSION['password'] = $_POST['password'];
		// echo $_SESSION['user_name'];
		// echo $_SESSION['password'];
		// echo $_SESSION['email'];

		// Escape all $_POST variables to protect against SQL injections
		$user_name = $mysqli->escape_string($_POST['user_name']);
		$email = $mysqli->escape_string($_POST['email']);
		$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
		$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
		// Check if user with that email already exists
		$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
		// We know user email exists if the rows returned are more than 0
		if ( $result->num_rows > 0 ) 
		{
		$_SESSION['message'] = 'User with this email already exists!';
		function_error();
		}
		else
		{
			$result = $mysqli->query("SELECT * FROM users WHERE username='$user_name'") or die($mysqli->error());
			if($result->num_rows > 0)
			{
			$_SESSION['message'] = 'User with this username already exists!';
			function_error();
			}
			else 
			{ // Email and username doesn't already exist in a database, proceed...
			$sql = "INSERT INTO users (userName, email, password, hash) " 
			. "VALUES ('$user_name','$email','$password', '$hash')";
			// Add user to the database
			if ( $mysqli->query($sql) ){
			// $_SESSION['active'] = 0; //0 until user activates their account with verify.php
			$_SESSION['logged_in'] = true; // So we know the user has logged in
			$_SESSION['message'] =
			"Register successfully!";
			function_success();
			// // Send registration confirmation link (verify.php)
			// $to      = $email;
			// $subject = 'Account Verification ( clevertechie.com )';
			// $message_body = '
			// Hello '.$first_name.',
			// Thank you for signing up!
			// Please click this link to activate your account:
			// http://localhost/login-system/verify.php?email='.$email.'&hash='.$hash;  
			// mail( $to, $subject, $message_body );
			
			}
			else {
			$_SESSION['message'] = 'Registration failed!';
			function_error();
			}
			}
	
		}
	}
	function display($array){
        
		echo "<table border=0 width='750'>";
        echo "<tr>";
        echo "<th><h4 style = 'font-weight: bold;'>Donor Name</h4></th>";
		echo "<th><h4 style = 'font-weight: bold;'>Phone</h4></th>";
        echo "<th><h4 style = 'font-weight: bold;'>Email</h4></th>";
		echo "<th><h4 style = 'font-weight: bold;'>Blood</h4></th>";
        echo "</tr>";
        
	   foreach($array as $value){
		   
		   $name  = $value['Name'];
		   $phone = $value['Phone'];
		   $email = $value['Email'];
		   $blood_id  = $value['Blood_ID'];
           $bloodType = getBlood_Type($blood_id);   
	    		
		   echo "<tr>";
		   echo "<td style='width:30%' ><h4>".$name."</h4></td>";
           echo "<td style='width:25%' ><h4>".$phone."</h4></td>";
           echo "<td style='width:35%' ><h4>".$email."</h4></td>";
           echo "<td style='width:10%' ><h4><font color=#CC0000>".$bloodType."</font></h4></td>";
		   echo "</tr>";					
		}
        echo "</table>";
	}
?>