<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
$user_id=$obj->sessionuserid;

 if ($obj->notifbtn==1)
	{
		
		$n_id=$obj->nid;
		mysqli_query($conn,"UPDATE `user_notification` set `read_notification`='yes'  WHERE `user_id`='$user_id' and `n_id`='$n_id';");
		
	}
	$query_notification1=mysqli_query($conn,"SELECT * FROM `user_notification` WHERE `user_id`='$user_id' and `read_notification`='no';");
	$no_of_notification=mysqli_num_rows($query_notification1);
	echo $no_of_notification;
?>