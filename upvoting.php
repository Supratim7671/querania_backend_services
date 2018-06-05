<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

	if ($obj->likeqbtn==3)
		{
			$q_id=$obj->id;
			$user_id=$obj->sessionuserid;
			$query100=mysqli_query($conn,"SELECT * FROM `user_question_status` WHERE `q_id`='$q_id' and `user_id`='$user_id';");
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
			if (mysqli_num_rows($query100)==0)
			{
			mysqli_query($conn,"INSERT INTO `user_question_status` (`q_id`,`user_id`,`status`) VALUES('$q_id','$user_id','LIKE');");
			if ($userid1!=$user_id)
			{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has upvoted a question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
			//echo '<script>alert("'.$query1.'")</script>';
		}
			}
			else
			{		
	
	mysqli_query($conn,"UPDATE `user_question_status` set `status`='LIKE' WHERE `q_id`='$q_id' and `user_id`='$user_id';");
		
			if ($userid1!=$user_id)
			{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has upvoted a question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
			
		}
		}
		}
		else if ($obj->likeqbtn==2)
		{
			$q_id=$obj->id;
			$user_id=$obj->sessionuserid;
			$query102=mysqli_query($conn,"SELECT * FROM `user_question_status` WHERE `q_id`='$q_id' and `user_id`='$user_id' and `status`='UNLIKE';");
			if (mysqli_num_rows($query102)==0)
			mysqli_query($conn,"DELETE FROM `user_question_status` where `user_id`='$user_id' and `q_id`='$q_id' and status='LIKE';");
			else
			mysqli_query($conn,"UPDATE `user_question_status` set `status`='UNLIKE' WHERE `q_id`='$q_id' and `user_id`='$user_id';");
		}
		
		$query_status=mysqli_query($conn,"SELECT * FROM `user_question_status` where `q_id`='$q_id' and `user_id`='$user_id';");
		  $fetch_status=mysqli_fetch_assoc($query_status);
		  $answer_status=$fetch_status['status'];
		  if (strcmp($answer_status,"LIKE")==0)
		  {
			  $statuslike="LIKE";
			  $likebtn=2;
		  }
		  else 
		  {
			$statuslike="";
			$likebtn=3;
		  }
		  if (strcmp($answer_status,"UNLIKE")==0)
		  {
			$statusunlike="UNLIKE";
			$unlikebtn=2;
		  }
		  else
		  {  
			$statusunlike="";
			$unlikebtn=3;
		  }
		  $query_like=mysqli_query($conn,"SELECT * from `user_question_status` WHERE `q_id`='$q_id' and `status`='LIKE';");
		  $no_of_like=mysqli_num_rows($query_like);
		  $query_unlike=mysqli_query($conn,"SELECT * from `user_question_status` WHERE `q_id`='$q_id' and `status`='UNLIKE';");
		  $no_of_unlike=mysqli_num_rows($query_unlike);
		  
		  $list5[]=array('likeqbtn'=>$likebtn,'unlikeqbtn'=>$unlikebtn,'statuslike'=>$statuslike,'statusunlike'=>$statusunlike,'noof_likes'=>$no_of_like,'noof_unlikes'=>$no_of_unlike);
		  echo json_encode($list5);



















?>