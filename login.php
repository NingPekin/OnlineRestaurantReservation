<!DOCTYPE html>
<html>
<?php
if (!isset($_SESSION)) session_start();
?>
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
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>

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
          <a href="index.php"><img data-0="width:155px;" data-300=" width:120px;" src="" alt=""></a>
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

  <section id="section-login" style="margin-top:150px">

  <form action="" method="post">
     <div class="field-wrap">
        <label>
        <select name='loginMethod'>
						<option value = "0"> User Name </option>
            <option value = "1" > Email </option>
        </select>
        <span class="req">*</span>
        </label>
        <input type="text" required autocomplete="off" name="user_email"/>
     </div>
     <div class="field-wrap">
        <label>
        Password<span class="req">*</span>
        </label>
        <input type="password" required autocomplete="off" name="password"/>
     </div>
     <p class="forgot"><a href="#">Forgot Password?</a></p>
     <button class="button button-block" name="login"/>Log In</button>
  </form>
</section>


<?php 

      $selected=0;
      if(isset($_POST['login']))
      {
        if(isset($_POST['loginMethod']))
        {
          $selected = $_POST['loginMethod'];
          //login in with username
          if($selected==0)
          {
            $username = $_POST['user_email'];
            $password = $_POST['password'];
            //check username match password
            if(User::User_Exists_UserName($username,$password))
            {
              echo "You are successfully logged in"."<br>";
              echo "You will be directed to the home page in 3 seconds...";
              $obj=USER::Get_Users_By_Username($username);
              // print_r($obj);
              $_SESSION['user_id']=$obj->userId;
              $_SESSION['email']=$obj->email;
              $_SESSION['user_name']=$username;
              $_SESSION['password']=$password;
              // $_SESSION['favList']=USER::
              $_SESSION['logged_in']=1;

              echo "<script>
              setTimeout(function(){
                window.location.href='index.php';
              },2000)
              </script>"; 
              // header( "Location: index.php" );
            }         
            else
            {
              echo "Error: Mismatch of Username and Password";
            }
            }

          //login in with email
          if($selected==1)
          {
            $email = $_POST['user_email'];
            $password = $_POST['password'];
            //check email match password
            if(User::User_Exists_Email($email,$password))
            {
              echo "You are successfully logged in";
              echo "You will be directed to the home page in 3 seconds...";
              $obj=USER::Get_Users_By_Email($email);
              $_SESSION['user_id']=$obj->userId;
              $_SESSION['user_name']=$username;
              $_SESSION['email']=$email;
              $_SESSION['logged_in']=1;
              echo "<script>
              setTimeout(function(){
                window.location.href='index.php';
              },2000)
              </script>";           
            }
            else
            {
              echo "Error: Mismatch of Email and Password";
            }
          }
        }
      }
      
?>



  <!-- Javascript Library Files -->
  <script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
