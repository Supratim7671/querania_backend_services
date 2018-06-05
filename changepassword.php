<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

if ($obj->cbtn==1 and (strcmp($obj->opassword,'')!=0) and (strcmp($obj->password,'')!=0) and (strcmp($obj->cpassword,'')!=0))
{
	$userid=$obj->sessionuserid;
	$query=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$userid';");
	$fetch=mysqli_fetch_assoc($query);
	$dbpassword=$fetch['password'];
	$dbemail=$fetch['email'];
	
	$opassword=test_input($obj->opassword);
	$oldpassword=hashing($opassword,$dbemail);
	$password=test_input($obj->password);
	$newpassword=hashing($password,$dbemail);
	$cpassword=test_input($obj->cpassword);
	$cnewpassword=hashing($cpassword,$dbemail);
	
	
	if(strcmp($dbpassword,$oldpassword)==0)
	{
		
		if (strcmp($newpassword,$cnewpassword)==0)
		{
			mysqli_query($conn,"UPDATE `users` SET `password`='$newpassword' WHERE `user_id`='$userid';");
			echo '1';
		}
		
		else if (strcmp($newpassword,$cnewpassword)!=0)
		{
			echo '2';
		}
	}
	else if(strcmp($dbpassword,$oldpassword)!=0)
	{
		echo '3';
	}
}

?>