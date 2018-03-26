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

  <link rel="stylesheet" href="css/style.css">
  <!-- skin -->
  <link rel="stylesheet" href="skin/default.css">
<!-- php -->
<?php include 'includes/functions.php';?>
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
          <li><a href="#section-about">search</a></li>
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
  $chosenRestaurant=$_GET['chosenRestaurant'];
  $restaurantDetail=GetRestaurantByName($chosenRestaurant);
  foreach($restaurantDetail as $value)
  { 
  $restaurantDetail=$value;
  }   
  $arrayCategory = GetCategoryByRestaurant($chosenRestaurant);
  $arrayCity= GetCityyByRestaurant($chosenRestaurant);

  ?>
  <section id="intro" style="height:150px;background:#e0e0d2" >
    <div class="row" style="margin:100px;font-size:30px">	
      <div class="col-sm-2" style="margin:auto;">
      <?php     
    // print_r ($restaurantArray);
      echo '<img src="'.$restaurantDetail['picture'].'" alt="" style="height:100px">';
      ?>  
      </div>
      <div class="col-sm-8" style="text-align:left;align-items: center;margin:auto">
     <?php
      echo $chosenRestaurant.'<br>';
      //rate
      echo "rate".'<br>';
      //category 
     foreach($arrayCategory as $value)
      {
        echo $value["name"]." ";
      }
      echo "|";
      //city 
      foreach($arrayCity as $value)
      {
        echo $value["name"]." ";
      }
      ?>
      </div>
      <div class="col-sm-2" style="text-align:left;margin:auto">
      Add to favorites
      </div>	
    </div>
  </section>

  <!-- about -->
  <section id="section-about" class="section appear clearfix">

    <div class="container">
    <div class="row">
    <div class=" col-sm-8">
        <div class="col-md-offset-3 col-md-6">
          <div class="section-header">
            <h4 class="section-heading animated" data-animation="bounceInUp">Make a reservation </h4>
          </div>
        </div>
        <div class="col-md-offset-3 col-md-6">
          how many people |
          date |
          time |
          button find a table |
       
        <h3>function return if has table</h3>
        <h3>other avaibility time on the other day(in 5 days)</h3> 
        </div>
        
      </div>
    <div class="col-sm-3">
      <?php
      echo $restaurantDetail['style']. "<br>Opening: ".$restaurantDetail['openingHour']. "<br>Closing: ". $restaurantDetail['closingHour']. "<br>". $restaurantDetail['phoneNumber'];
      
      ?>
  
      price
    </div>
    
    </div>
    </div>
  </section>
  <!-- /about -->




  <section id="footer" class="section footer">
    <div class="container">
      <div class="row animated opacity mar-bot20" data-andown="fadeIn" data-animation="animation">
        <div class="col-sm-12 align-center">
          <ul class="social-network social-circle">
            <li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
            <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="row align-center mar-bot20">
        <ul class="footer-menu">
          <li><a href="#">Home</a></li>
          <li><a href="#">About us</a></li>
          <li><a href="#">Privacy policy</a></li>
          <li><a href="#">Get in touch</a></li>
        </ul>
      </div>
      <div class="row align-center copyright">
        <div class="col-sm-12">
          <p>Copyright &copy; All rights reserved</p>
        </div>
      </div>
      <div class="credits">
        <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Vlava
        -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade.com</a>
      </div>
    </div>

  </section>
  <a href="#header" class="scrollup"><i class="fa fa-chevron-up"></i></a>

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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>

</html>
