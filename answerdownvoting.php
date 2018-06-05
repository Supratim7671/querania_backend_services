<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

if ($obj->unlikeabtn==3)
		{	
			//echo '<script>alert("Posting in database")</script>';
			$q_id=$obj->qid;
			$user_id=$obj->sessionuserid1;
			$answer_id=$obj->answerid;
			$query105=mysqli_query($conn,"SELECT * FROM `user_answer_status` WHERE `q_id`='$q_id' and `answer_id`='$answer_id' and `user_id`='$user_id' and `status`='LIKE';");
			if (mysqli_num_rows($query105)==0)
			mysqli_query($conn,"INSERT INTO `user_answer_status` (`user_id`, `answer_id`, `status`, `q_id`) VALUES('$user_id','$answer_id','UNLIKE','$q_id');");
			else
			mysqli_query($conn,"UPDATE `user_answer_status` set `status`='UNLIKE' WHERE `q_id`='$q_id' and `answer_id`='$answer_id' and `user_id`='$user_id';");
		}
else if ($obj->unlikeabtn==2)
		{
			$q_id=$obj->qid;
			$user_id=$obj->sessionuserid1;
			$answer_id=$obj->answerid;
			$query107=mysqli_query($conn,"SELECT * FROM `user_answer_status` WHERE `q_id`='$q_id' and `user_id`='$user_id' and `answer_id`='$answer_id'  and  `status`='LIKE';");
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
			$query3=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' and `answer_id`='$answer_id';");
			$fetch3=mysqli_fetch_assoc($query3);
			$userid2=$fetch3['user_id'];
			if (mysqli_num_rows($query107)==0)
			mysqli_query($conn,"DELETE FROM `user_answer_status` where `user_id`='$user_id' and `q_id`='$q_id' and `answer_id`='$answer_id' and status='UNLIKE';");
			else
			{
			mysqli_query($conn,"UPDATE `user_answer_status` set `status`='LIKE' WHERE `q_id`='$q_id' and `answer_id`='$answer_id'  and `user_id`='$user_id';");
				
			if ($userid1!=$user_id)
			{
				if ($userid2!=$user_id)
				{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has upvoted a reply";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
			$query5=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid2', '$message', 'NOW()','$q_id');");
		
			}
			else
			{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has upvoted a reply";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
				
			}
			}
		}
		}

	
	$query_reply_status=mysqli_query($conn,"SELECT * FROM `user_answer_status` where `q_id`='$q_id' and `answer_id`='$answer_id' and `user_id`='$user_id';");
		  $fetch_status=mysqli_fetch_assoc($query_reply_status);
		  $reply_status=$fetch_status['status'];
		  if (strcmp($reply_status,"LIKE")==0)
		  {
			  $answerstatuslike="LIKE";
				$answerlikebtn=2;
		  }
		  else
		  {	
				$answerstatuslike="";
				$answerlikebtn=3;
		  }
		  if (strcmp($reply_status,"UNLIKE")==0)
		  {
			  $answerstatusunlike="UNLIKE";
				$answerunlikebtn=2;
		  }
		  else
		  {		$answerstatusunlike="";
				$answerunlikebtn=3;
		  }
		  $query_answer_like=mysqli_query($conn,"SELECT * from `user_answer_status` WHERE `q_id`='$q_id' and `answer_id`='$answer_id' and `status`='LIKE';");
		  $no_of_answer_like=mysqli_num_rows($query_answer_like);
		  $query_answer_unlike=mysqli_query($conn,"SELECT * from `user_answer_status` WHERE `q_id`='$q_id' and `answer_id`='$answer_id' and `status`='UNLIKE';");
		  $no_of_answer_unlike=mysqli_num_rows($query_answer_unlike);
		  
	$list7[]=array('likeabtn'=>$answerlikebtn,'unlikeabtn'=>$answerunlikebtn,'answerstatuslike'=>$answerstatuslike,'answerstatusunlike'=>$answerstatusunlike,'noofanswer_like'=>$no_of_answer_like,'noofanswer_unlike'=>$no_of_answer_unlike);
	echo json_encode($list7);
?>