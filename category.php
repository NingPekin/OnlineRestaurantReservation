<?php
// Start the session
if (!isset($_SESSION)) session_start();
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (isset($_GET['logout']))
{
 $_SESSION['logged_in']=0;

}
?>
<!DOCTYPE html>
<html>
<head>
	<!-- php -->
	<?php 
	require_once 'includes/functions.php';
	require_once 'includes/classRestaurant.php';
	require_once 'includes/classDatabase.php';
	require_once 'includes/header.php';
	?>
	<title></title>
</head>
<body>
	<section class="appear" id="header"></section>
	<div class="navbar navbar-fixed-top" data-0="line-height:100px; height:100px; background-color:rgba(0,0,0,0.3);" data-300="line-height:60px; height:60px; background-color:rgba(5, 42, 62, 1);" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button"><span class="fa fa-bars color-white"></span></button>
				<div class="navbar-logo">
					<a href="index.php"><img alt="" data-0="width:155px;" data-300=" width:120px;" src=""></a>
				</div>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav" data-0="margin-top:20px;" data-300="margin-top:5px;">
					<li class="active">
						<a href="index.php">Home</a>
					</li>
					<li id="login">
						<a href="login.php">Sign In</a>
					</li>
					<li id="signup">
						<a href="register.php">Sign Up</a>
					</li>
					<li id="logout" style="display:none">
						<a href="%3C?php%20echo%20$url.'&logout=true';%20?%3E">Log Out</a>
					</li>
					<li>
						<a href="#section-contact">en</a>
					</li>
				</ul>
			</div><!--/.navbar-collapse -->
		</div>
	</div>
	<section id="intro" style="height:20vh">
		<div class="intro-content"></div>
	</section>
  <!-- search -->
	<section class="appear" id="search">
		<form action="" method="post">
			<div class="row">
				<div class="col-xs-6 col-sm-4 text-right">
					<select name='searchMethod'>
						<option value="0">
							by name
						</option>
						<option value="1">
							by category
						</option>
					</select>
				</div>
				<div class="col-xs-6 col-sm-4">
					<input class="form-control" id="txtSearch" name="txtSearch" placeholder="Search" type="text">
				</div>
				<div class="col-xs-6 col-sm-4">
					<button class="btn btn-primary" name="search" type="submit"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
		</form>
	</section>
  <?php
	  //is logged in
	  if($_SESSION["logged_in"]==1)
	  {
	    echo("<script>
	    document.getElementById('signup').style.display='none';
	    document.getElementById('login').style.display='none';
	    document.getElementById('logout').style.display='block';
	    </script>");
	  }

	  if(isset($_POST['search']))
	  {
	    $txtSearch=$_POST["txtSearch"];
	    $selected = "0";
	    if(isset($_POST['searchMethod']))
	    {

	      $selected = $_POST['searchMethod'];  
	      switch($selected)
	      {
	        case '0':    
	        $object= Restaurant::GetRestaurantByName($txtSearch); 
	        // echo count($array);
	        if(count($object)>0)
	        {
	          $_SESSION['searchedRestaurant'] = $object;
	          // print_r($_SESSION['searchedRestaurant'] );
	          header("Location:category.php");
	        }
	        else
	        {
	          echo "nothing found!";
	        }
	              break;
	        case '1': 
	        $object= Restaurant::GetRestaurantByCategory($txtSearch);
	        // echo count($array);
	        // foreach($array as $value)
	        // {
	        //   print_r ($value);
	        // }
	        if(count($object)>0)
	        {
	          // print_r ($array);
	          $_SESSION['searchedRestaurant'] = $object;
	          // print_r($_SESSION['searchedRestaurant'] );
	          header("Location:category.php");
	        }
	        else
	        {
	          echo "nothing found!";
	        }
	              break;
	      }
	    }

	  }
	?><!-- restaurant lists -->
	<section class="section appear clearfix" id="section-about" style="margin-top:-20px">
		<div class="container" style="margin:auto; width:50%;padding:10px;background-color:#F9F3F1">
			<?php
			      if(isset($_GET['chosenCategory']))
			      {
			         DisplayAllRestaurants($_GET['chosenCategory']);
			      }
			      else
			      {
			        if(isset($_SESSION['searchedRestaurant']))
			        {
			        $searchedRestaurant=$_SESSION['searchedRestaurant'];
			        // print_r ($searchedRestaurant);
			        DisplayAllSearchedRestaurants($searchedRestaurant);
			        }
			      }
			      ?>
		</div>
	</section><!-- /restaurant lists -->
	<section class="section footer" id="footer">
		<div class="container">
			<div class="row animated opacity mar-bot20" data-andown="fadeIn" data-animation="animation">
				<div class="col-sm-12 align-center">
					<ul class="social-network social-circle">
						<li>
							<a class="icoRss" href="#" title="Rss"><i class="fa fa-rss"></i></a>
						</li>
						<li>
							<a class="icoFacebook" href="#" title="Facebook"><i class="fa fa-facebook"></i></a>
						</li>
						<li>
							<a class="icoTwitter" href="#" title="Twitter"><i class="fa fa-twitter"></i></a>
						</li>
						<li>
							<a class="icoGoogle" href="#" title="Google +"><i class="fa fa-google-plus"></i></a>
						</li>
						<li>
							<a class="icoLinkedin" href="#" title="Linkedin"><i class="fa fa-linkedin"></i></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row align-center mar-bot20">
				<ul class="footer-menu">
					<li>
						<a href="#">Home</a>
					</li>
					<li>
						<a href="#">About us</a>
					</li>
					<li>
						<a href="#">Privacy policy</a>
					</li>
					<li>
						<a href="#">Get in touch</a>
					</li>
				</ul>
			</div>
			<div class="row align-center copyright">
				<div class="col-sm-12">
					<p>Copyright &copy; All rights reserved</p>
				</div>
			</div>
			<div class="credits">
				Designed by <a href="https://bootstrapmade.com/">BootstrapMade.com</a>
			</div>
		</div>
	</section><a class="scrollup" href="#header"><i class="fa fa-chevron-up"></i></a> <!-- Javascript Library Files -->
	 
	<script src="js/modernizr-2.6.2-respond-1.1.0.min.js">
	</script> 
	<script src="js/jquery.js">
	</script> 
	<script src="js/jquery.easing.1.3.js">
	</script> 
	<script src="js/bootstrap.min.js">
	</script> 
	<script src="js/jquery.isotope.min.js">
	</script> 
	<script src="js/jquery.nicescroll.min.js">
	</script> 
	<script src="js/fancybox/jquery.fancybox.pack.js">
	</script> 
	<script src="js/skrollr.min.js">
	</script> 
	<script src="js/jquery.scrollTo.min.js">
	</script> 
	<script src="js/jquery.localScroll.min.js">
	</script> 
	<script src="js/stellar.js">
	</script> 
	<script src="js/jquery.appear.js">
	</script> 
	<script src="js/jquery.flexslider-min.js">
	</script> 
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY">
	</script> <!-- Contact Form JavaScript File -->
	 
	<script src="contactform/contactform.js">
	</script> <!-- Template Main Javascript File -->
	 
	<script src="js/main.js">
	</script>
</body>
</html>