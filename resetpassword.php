<!DOCTYPE html>
<?php
include "configuration.php";
?>
<?php
$newemail=$_GET['email'];
$resetkey=$_GET['resetkey'];

if (isset($_POST['change']))
	
{
//echo '<script>alert("'.$resetkey.'.'.$newemail.'");</script>';

$query=mysqli_query($conn,"SELECT * FROM `users` WHERE `email`='$newemail' and `resetkey`='$resetkey';");
$numquery=mysqli_num_rows($query);
//echo '<script>alert("'.$numquery.'");</script>';
if ($numquery  and strcmp($_POST['password'],'')!=0 and strcmp($_POST['cpassword'],'')!=0)
{
	//echo '<script>alert("In the second condition");</script>';
	$fetch=mysqli_fetch_assoc($query);
	$dbpassword=$fetch['password'];
	$dbemail=$fetch['email'];
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
		for ($i = 0; $i < 10; $i++) 
		{
        $randomString .= $characters[rand(0, $charactersLength - 1)];
		}
	
	$password=test_input($_POST['password']);
	$newpassword=hashing($password,$dbemail);
	$cpassword=test_input($_POST['cpassword']);
	$cnewpassword=hashing($cpassword,$dbemail);
	$resetkey=$randomString;
	
	
		
		if (strcmp($newpassword,$cnewpassword)==0)
		{
			//echo '<script>alert("In the third condition");</script>';
			mysqli_query($conn,"UPDATE `users` SET `password`='$newpassword',`resetkey`='$resetkey' WHERE `email`='$newemail';");
			echo '<script>window.onload=function(){$(\'#successful\').show();}</script>';
		}
		
		else if (strcmp($newpassword,$cnewpassword)!=0)
		{
			//echo '<script>alert("In the fourth condition");</script>';
			echo '<script>window.onload=function(){$(\'#passwordnotmatched\').show();}</script>';
		}
	
	
}
else 
{	//echo '<script>alert("In the fifth condition");</script>';
	echo '<script>window.onload=function(){$(\'#resetkeynotvalid\').show();}</script>';
}
}

?>

<html ng-app="myApp">
<title>SCHOLARSGO</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./lib/w3.css">
<link rel="stylesheet" href="./lib/mycss.css">
<link rel="stylesheet" href="./lib/w3-theme-teal.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="lib/bootstrap-horizon.css">
<link href="./lib/agency.min.css" rel="stylesheet">
<link href="./lib/simple-sidebar.css" rel="stylesheet">
<link href="./lib/jquery.mCustomScrollbar.min.css" rel="stylesheet">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="bootstrap_files/bootstrap.min.js"></script>
  <script src="bootstrap_files/angular.js"></script>
  <script src="bootstrap_files/angular-sanitize.js"></script>
   <script src="bootstrap_files/angular-route.js"></script>
 
  <script src="bootstrap_files/angular-cookies.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family:  "Comic Sans MS", sans-serif; font-size:15px;}
.btn-circle {
  width: 80px;
  height: 80px;
  text-align: center;
  padding: 0px 0;
  font-size: 10px;
  line-height: 1.42;
  border-radius: 60px;
  -webkit-transition:opacity 0s;
  transition:opacity 0s
}
.myaccordion-content a:hover{
	background-color:#fff;
}

.w3-accordion-content a:hover{
	background-color:#fff;
}
.btn-primary {
    background: #607d8b ;
    color: #ffffff;
	padding:2px;
	border-color:#ffffff;
}
.btn-circle:active{
	opacity:0.5;
}
.btn-circle:hover{
	box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19)
}
.my-ppt
{
	content:url('my-ppt1.png');
	
}
img[title]:hover:after {
  content: attr(title);
  padding: 4px 8px;
  color: #333;
  position: absolute;
  left: 0;
  top: 100%;
  z-index: 20;
  white-space: nowrap;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  -moz-box-shadow: 0px 0px 4px #222;
  -webkit-box-shadow: 0px 0px 4px #222;
  box-shadow: 0px 0px 4px #222;
  background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #eeeeee),color-stop(1, #cccccc));
  background-image: -webkit-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -ms-linear-gradient(top, #eeeeee, #cccccc);
  background-image: -o-linear-gradient(top, #eeeeee, #cccccc);
}
.myshow{display:block!important}
.myshow1{display:block!important}
.myshow2{display:block!important}
.myshow3{display:block!important}

.mydisplay{display:block}
.mydisplay1{display:none}
.mydisplay2{display:block}
.mydisplay3{display:none}
.mydisplay4{display:block}
.mydisplay5{display:none}
</style>
<body class="w3-theme-l5" ng-controller="myCtrl">

<!-- Navbar -->
<div class="w3-top">
<div class="w3-container" style="padding:0px;">

 <ul class="w3-navbar w3-theme-d4  w3-large">
 
  
  <li><a href="#" class="w3-padding-large w3-theme-d4 w3-medium"></i><img src="images/logo.jpg" class="w3-responsive w3-image" width="35px;height:35px;"/></a></li>
   <li><a href="#" class="w3-padding-large w3-theme-d4 w3-medium">SCHOLARSGO</a></li>
 
 <li class="w3-hide-large w3-right">
   <a href="login_signup.html"  title="My Account" class="w3-medium w3-hover-white w3-theme-d4"><img src="Avatar.jpg" class="w3-circle" style="height:25px;width:25px" alt="Avatar">Login/SignUp</a>
    
   </li>
   <li class="w3-hide-small w3-hide-medium w3-right">
   <a href="login_signup.html"  title="My Account" class="w3-medium w3-hover-white w3-theme-d4"><img src="Avatar.jpg" class="w3-circle" style="height:25px;width:25px" alt="Avatar">Login/SignUp</a>
    
   </li>


 </ul>
</div>


<br>

</div>
<br>

</br>
<!-- Navbar on small screens -->


</br>
</br>
</br>
</br>

<!-- Page Container -->
<div class="w3-container" >    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
   
    
    <!-- Middle Column -->
	<!--Medium and Small Screen-->
	<div class="w3-col m4 s4 l4" style="margin-left:32.33333%;margin-right:32.333333%">
	<div class="w3-card-4 w3-center">
	 <header class="w3-container w3-teal"> 
       
        <center><h2>Change Password</h2></center>
      </header>
      <div class="w3-container">
<form method="POST" action="" class="w3-container  w3-light-grey w3-text-blue w3-margin">

 




<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border"  type="password" placeholder="New Password" name="password">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border"  type="password" placeholder="Confirm New Password" name="cpassword">
    </div>
</div>




<p class="w3-section" style="">

<button class="w3-button w3-section w3-blue w3-ripple w3-round-large w3-card-2" type="submit" name="change"> Change </button>
</p>
</form>
      </div>
      
	
	
	</div>
	
	</div>
	   
	<!--Larger screen-->

    
    <!-- Right Column -->

  
<!-- End Page Container -->
</div>
<br>
</br>
</br>

<br>
</div>
<!-- Footer -->
</br>
</br>


<div class="w3-modal" id="successful" role="dialog">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:500px;max-height:400px;">
      <div class="modal-content">
        <header class="w3-center w3-container w3-teal"> 
        <span onclick="document.getElementById('successful').style.display='none'" 
      class="w3-closebtn">&times;</span>
        <h2 class="w3-center">&nbsp;SUCCESS</h2>
      </header>
        <div class="w3-container">
          <p style="color:#A9A9A9;">You have been successfully changed your password. Please login now.</p>
        </div>
				</div>
			</div>
			</div>
			
			<div class="w3-modal" id="passwordnotmatched" role="dialog">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:500px;max-height:400px;">
      <div class="modal-content">
        <header class="w3-center w3-container w3-teal"> 
        <span onclick="document.getElementById('passwordnotmatched').style.display='none'" 
      class="w3-closebtn">&times;</span>
        <h2 class="w3-center">&nbsp;FAILURE</h2>
      </header>
        <div class="w3-container">
          <p style="color:#A9A9A9;">Your passwords didnt matched.Please enter correct passwords</p>
        </div>
				</div>
			</div>
			</div>
			
			<div class="w3-modal" id="resetkeynotvalid" role="dialog">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:500px;max-height:400px;">
      <div class="modal-content">
        <header class="w3-center w3-container w3-teal"> 
        <span onclick="document.getElementById('resetkeynotvalid').style.display='none'" 
      class="w3-closebtn">&times;</span>
        <h2 class="w3-center">&nbsp;FAILURE</h2>
      </header>
        <div class="w3-container">
          <p style="color:#A9A9A9;">The reset key you entered is invalid.Please visit your email and open the link.</p>
        </div>
				</div>
			</div>
			</div>
<footer class="w3-container w3-theme-d5">
  <p>Powered by <a href=#" target="_blank">scholarsgo.com</a></p>
</footer>
 <script src="lib/jquery.nicescroll.min.js"></script>
<script>
// Accordion

 

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
function openNav1() {
    var x = document.getElementById("navDemo1");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
function bigImg(x) {
    x.style.height = "128px";
    x.style.width = "128px";
}

function normalImg(x) {
    x.style.height = "45px";
    x.style.width = "45px";
}
</script>


</body>
</html> 
