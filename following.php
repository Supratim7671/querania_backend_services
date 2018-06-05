<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

if ($obj->followqbtn==5)
	{
		$q_id=$obj->id;
		$follower_id=$obj->sessionuserid;
		$following_id=$obj->quserid;
		
		$query1=mysqli_query($conn,"SELECT * FROM `users` where `user_id`='$follower_id';");
		$query2=mysqli_query($conn,"SELECT * FROM `users` where `user_id`='$following_id';");
		$query3=mysqli_query($conn,"SELECT * FROM `user_question` where `q_id`='$q_id';");
		$fetch1=mysqli_fetch_assoc($query1);
		$fetch2=mysqli_fetch_assoc($query2);
		$fetch3=mysqli_fetch_assoc($query3);
		$followername=$fetch1['username'];
		$followingname=$fetch2['username'];
		$question=$fetch3['question'];
		
		$message=$followername." has started following you on a particular question";
		$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$following_id', '$message', 'NOW()','$q_id');");
		//echo '<script>alert("'.$query4.'")</script>';
		//$query5=mysqli_query($conn,"SELECT * FROM `user_notification` WHERE `follow_id`='$follower_id' and `following_id`='$following_id' and `q_id`='$q_id';");
		//$fetch5=mysqli_fetch_assoc($query5);
		//$n_id=$fetch5['n_id'];
		mysqli_query($conn,"INSERT INTO `user_question_follower` (`follow_id`, `following_id`, `q_id`) VALUES ('$follower_id', '$following_id', '$q_id');");
	}
	
	if ($obj->followqbtn==7)
	{
		$q_id=$obj->id;
		$follower_id=$obj->sessionuserid;
		$following_id=$obj->quserid;
		mysqli_query($conn,"DELETE FROM `user_question_follower` WHERE `q_id`='$q_id' and `following_id`='$following_id';");
		
	}

		$query_follow=mysqli_query($conn,"SELECT * FROM `user_question_follower` WHERE `follow_id`='$follower_id' and `q_id`='$q_id';");
		$follow=mysqli_num_rows($query_follow);
		
		if ($follow==0)
			
			$followqbtn=5;
			
		else
			$followqbtn=7;
		
		$list8[]=array('followqbtn'=>$followqbtn,'followstatus'=>$follow,'sessionuserid'=>$follower_id,'quserid'=>$following_id);
		echo json_encode($list8);
?>