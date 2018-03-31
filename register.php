<?php
// Start the session
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
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
  <?php include 'includes/classUser.php';?>


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

  <section id="section-register" class="section appear clearfix" style="margin-top:50px">

  <form action="" method="POST">         
    <div class="top-row">
    <div class="field-wrap">
        <label> 
        User Name<span class="req">*</span>
        </label>
        <input type="text" required autocomplete="off" name="user_name" />
    </div>
    </div>

    <div class="field-wrap">
    <label>
        Email Address<span class="req">*</span>
    </label>
    <input type="email"required autocomplete="off" name="email"/>
    </div>
    
    <div class="field-wrap">
    <label>
        Password<span class="req">*</span>
    </label>
    <input type="password"required autocomplete="off" name="password"/>
    </div>
    
    <button type="submit" name="register" class="button button-block"/>Register</button> 
    </form>
</section>

<?php 

  // if(isset($_POST['submit'])){
  //   $username = $_POST['username'];
  //   $password = $_POST['password'];
  //   $email = $_POST['email'];
  //   if(! USER::Username_Exists($username)){
  //     $newUser = new USER($username,$password, $email);
  //     $newUser->Create();
  //     echo "Query submitted";
  //   }else{
  //     echo "Error: Username already exists. Try again.";
  //   }
  // }
  
  // if(isset($_POST['delete_submit'])){
  //   $username = $_POST['username'];
  //   $password = $_POST['password'];
    
  //   if( USER::User_Exists($username, $password)){
  //     USER::Delete_User($username);
  //     echo "User Account deleted";
  //   }else{
  //     echo "Error: User does not exist. Try again.";
  //   }
  // }


  if(isset($_POST['register']))
{
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['user_name'] = $_POST['user_name'];
  $_SESSION['password'] = $_POST['password'];

  $username = $_POST['user_name'];
  $password = $_POST['password'];
  $email=$_POST['email'];
  

  if(USER::Username_Exists($username))
  {
    echo "Error: Username  already exists. Try again.";
    exit();
  }
  elseif(USER::Email_Exists($email))
  {
    echo "Error: Email  already exists. Try again.";
    exit();
  }
  else
  {
    $newUser = new USER($username,$password, $email);
    $newUser->Create();
    echo "You are registered successfully!";
    echo "You will be directed to the home page in 3 seconds...";
    echo "<script>
    setTimeout(function(){
      window.location.href='index.php';
    },2000)
    </script>"; 
  }  

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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>

</html>
