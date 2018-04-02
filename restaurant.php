<!DOCTYPE html>
<?php
// Start the session
if (!isset($_SESSION)) session_start();
?>
<html>

<head>
  <!-- BASICS -->
  <meta charset="utf-8">
  <title>Online Resturant Reservation</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="js/rs-plugin/css/settings.css" media="screen">
  <link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen">
  <link rel="stylesheet" href="css/flexslider.css" type="text/css">
  <link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Serif:400,400italic,700|Open+Sans:300,400,600,700">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/star.css">

  <!-- skin -->
  <link rel="stylesheet" href="skin/default.css">
<!-- php -->
<?php 
require_once 'includes/functions.php';
require_once 'includes/classCity.php';
require_once 'includes/classRestaurant.php';
require_once 'includes/classCategory.php';
require_once 'includes/classTable.php';
require_once 'includes/classReservation.php';
require_once 'includes/classRestaurantUser.php';

?>




</head>

<body>
  <section id="header" class="appear"></section>
  <div class="navbar navbar-fixed-top" role="navigation" data-0="line-height:100px; height:100px; background-color:rgba(5, 42, 62, 1);" data-300="line-height:60px; height:60px; background-color:rgba(5, 42, 62, 1);">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      	  <span class="fa fa-bars color-white"></span>
        </button>
        <div class="navbar-logo">
          <a href="index.php"><img data-0="width:155px;" data-300=" width:120px;" src="img/logo.png" alt=""></a>
        </div>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav" data-0="margin-top:20px;" data-300="margin-top:5px;">
          <li class="active"><a href="index.php">Home</a></li>
          <li ><a href="login.php">Sign In</a></li>
          <li><a href="register.php">Sign Up</a></li>
          <li><a href="#section-contact">en</a></li>
        </ul>
      </div>
      <!--/.navbar-collapse -->
    </div>
  </div>

  <?php
  // $searchedRestaurant=$_SESSION['searchedRestaurant'];
  $numOfPeople;
  $reserveDate;
  $reserveTime;

  $chosenRestaurant=$_GET['chosenRestaurant'];
  $restaurantDetail=Restaurant::GetRestaurantByName($chosenRestaurant);
  foreach($restaurantDetail as $value)
  { 
  $restaurantDetail=$value;
  }   
  $arrayCategory =Category:: GetCategoryByRestaurant($chosenRestaurant);
  // $arrayCity= GetCityyByRestaurant($chosenRestaurant);
  $arrayCity=City::GetCityByRestaurant($chosenRestaurant);

  ?>
  <section id="intro-restaurant" style="height:auto;background:#e0e0d2;margin-top:110px">
    <div class="row" style="margin:110px;font-size:30px">	
      <div class="col-sm-2" style="margin:auto;">
      <?php     
    // print_r ($restaurantArray);
      echo '<br><img src="'.$restaurantDetail->picture.'" alt="" style="height:120px;align-items:center;">';
      ?>  
      </div>
      <div class="col-sm-8" style="text-align:left;align-items: center;margin:auto">
     <?php
      echo '<br><h3>'.$chosenRestaurant.'</h3>';
      //rate
      $rate=round(doubleval(RestaurantUser::GetRateByRestaurant($restaurantDetail->restaurantId)['AVG(rate)']),2);
      echo "<h4> Rate: ".$rate."</h4>";
      //category 
      echo "<h4>";
     foreach($arrayCategory as $value)
      {
        echo $value->name." ";
      }
      echo "</h4>";
      //city 
      $arrayCity=City::GetCityByRestaurant($chosenRestaurant);
      // print_r ($arrayCity);
      echo "<h4>";
      if($arrayCity)
      {  
      foreach($arrayCity as $value)
      {
        echo $value->name." ";
      }
      echo "</h4>";

      }
      ?>
    </div>
      <div class="col-sm-2" style="text-align:left;margin:auto">
      <form method="post">
      <button name="addToFav" style="border:none;background-color:transparent;outline:none" class="btn btn-default btn-lg">
      <span class="glyphicon glyphicon-heart"></span> Add to favorites 
      </button>
    </form>
      </div>	
    </div>
  </section>
    <!-- //add to favourite -->
    <?php
    if(isset($_POST['addToFav']))
    {
      // echo $_SESSION["user_id"];
      // echo $restaurantDetail->restaurantId;

      USER::AddFavouriteToUser($restaurantDetail->restaurantId,$_SESSION["user_id"]);
    }
    ?>

  <section id="section-reservation" style="margin-top:-80px">
     <div class="row">
        <!-- make reservation area -->
        <form action="" method="post">
           <!-- <div class=" col-sm-8">
              <div class="col-md-offset-3 col-md-6"> -->
                 <div class="section-header">
                    <h4 class="section-heading animated" data-animation="bounceInUp">Make a reservation </h4>
                 </div>
              </div>
              <div id="reservationChoice" class="col-md-offset-3 col-md-6">
              <!-- number of people -->
                 <select name='numOfPeople'>
                 <?php
                 for ($x=0;$x<12;$x++)
                 {
                   $y=$x+1;
                  echo  "<option value='$x'>$y People </option>";
                 }
                  ?>
                 </select>

              <!-- date in 14 days-->
              <select name="reserveDate">
                <?php
                $date = time();
                $num_days = 14;
                for($i=0; $i<=$num_days; ++$i)
                {
                    $date = mktime(0, 0, 0, date("m")  , date("d")+$i, date("Y"));
                    $date = date('Y-m-d', $date);
                    echo "     <option value='{$date}'>{$date}</option>\n";
                }
                ?>
            <!-- time  -->
            </select>
            <select name="reserveTime">
            <?php
            //  the interval for hours is '1'
            for($hours=$restaurantDetail->openingHour; $hours<$restaurantDetail->closingHour; $hours++) 
            {
          // the interval for mins is '30' 
              for($mins=0; $mins<60; $mins+=30)
              { 
                $time=str_pad($hours,2,'0',STR_PAD_LEFT).':'
                .str_pad($mins,2,'0',STR_PAD_LEFT);
        echo '<option value='.$time.'>'.$time.'</option>';
             }
            }
            ?>
            </select>

          <!-- button find a table -->
          <button name="find_table" class="btn btn-primary" type="submit">
        <span class="glyphicon glyphicon-search">  Find a Table </span>
        </button>
              </div>
           </div>
     </div>
  <!-- </div>
  </div> -->
  </form>

  <div class="col-sm-3">
     <?php
        echo $restaurantDetail->style. "<br>Open at: ".$restaurantDetail->openingHour. "<br>Close at: ". $restaurantDetail->closingHour. "<br>Tel: ". $restaurantDetail->phoneNumber;
        
        ?>

  </div>
  </div>
</section>
  
  <!-- function for find a table -->
<?php
  // if(isset($_POST['numOfPeople'])&&isset($_POST['date'])&&isset($_POST['time']))
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) 
  {
  if(isset($_POST['find_table']))
  
  {
    $numOfPeople=$_POST['numOfPeople']+1;
    $reserveDate=$_POST['reserveDate'];
    $reserveTime=$_POST['reserveTime'];
 
    // check in chosen date and time, there is any reservation.
    // if has, check if there is any other table match criteria, and select one, if has valid table,return 
   if( Table::Exist_Reservation($reserveDate,$reserveTime))
   {
    //  echo"exist rev";
      $obj=Table::ValidTableCompare($restaurantDetail->restaurantId,$numOfPeople,$reserveDate,$reserveTime);
     if($obj)
     {
      // print_r($obj1);
      // echo "valid1";
      $makeReservation=
      "<script>var r=confirm('$restaurantDetail->name,$numOfPeople People at $reserveTime, $reserveDate.\\nClick OK to confirm your reservation');
      if(r)
      {
        ".Reservation::Create($_SESSION["user_id"],$reserveDate,$reserveTime,$numOfPeople,$obj->tableId)."
      }
      else
      {
      alert('cancle');
      }
      </script>";
      echo $makeReservation;
    }
    else
    {
      echo "No table available!";
    }
   }

  //  don't have any rdv, chose one of table match creteria
   else
   {
    // echo "valid2";
    // echo "numpeope".$numOfPeople;
    $obj=Table::ValidTable($restaurantDetail->restaurantId,$numOfPeople);
    // print_r($obj->tableId);
    echo "<script>var r=confirm('$restaurantDetail->name,$numOfPeople People at $reserveTime, $reserveDate.\\nClick OK to confirm your reservation');
    if(r)
      {
        ".Reservation::Create($_SESSION["user_id"],$reserveDate,$reserveTime,$numOfPeople,$obj->tableId)."

    }
    else
    {
    alert('cancle');
    }
    </script>";


   }

  }
}
else
{
  echo "<script>alert('You have to log in at first!')</script>";
}
?>

<div class="container">
<div class="row" style="margin-top:40px;">
<div class="col-md-6">

<?php
$arrayReview=RestaurantUser::GetReviewByRestaurant($restaurantDetail->restaurantId);
if($arrayReview)
{
display($arrayReview);
}
else
{
  echo "no comment for now";
}

?>
</div>
</div>
</div>


<div class="container">
	<div class="row" style="margin-top:40px;">
		<div class="col-md-6">
    	<div class="well well-sm">        
            <div class="row" id="post-review-box" style="">
                <div class="col-md-12">
                    <form accept-charset="UTF-8" action="" method="post">
                        <textarea class="form-control animated" cols="50" id="new-review" name="comment_area" placeholder="Enter your review here..." rows="5"></textarea>
                        <div class="text-right stars">
                          <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
                          <label class="star star-5" for="star-5"></label>
                          <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
                          <label class="star star-4" for="star-4"></label>
                          <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
                          <label class="star star-3" for="star-3"></label>
                          <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
                          <label class="star star-2" for="star-2"></label>
                          <input class="star star-1" id="star-1" type="radio" name="star" value="1"/>
                          <label class="star star-1" for="star-1"></label>
                        </div>
                            <button class="btn btn-success btn-lg" type="submit" name="save_review">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
		</div>
	</div>
</div>

<?php

if(isset($_POST["save_review"])&&isset($_POST["star"])&&isset($_POST["comment_area"]))
{
  $comment=$_POST["comment_area"];
  $rate=$_POST["star"];
  // echo $_POST["star"];
  // echo $_POST["comment_area"];
  RestaurantUser::Create($restaurantDetail->restaurantId,$_SESSION["user_id"],date('Y-m-d H:i:s'),$comment,$rate);
}



?>


  <!-- Javascript Library Files -->
  <script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/jquery.nicescroll.min.js"></script>
  <script src="js/fancybox/jquery.fancybox.pack.js"></script>
  <script src="js/skrollr.min.js"></script>
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.localScroll.min.js"></script>
  <script src="js/stellar.js"></script>
  <script src="js/jquery.appear.js"></script>
  <script src="js/jquery.flexslider-min.js"></script>


  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>

</html>
