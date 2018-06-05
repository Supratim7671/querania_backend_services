<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

	if (strcmp($obj->newanswer,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			
			$answer=mysqli_real_escape_string($conn,htmlspecialchars($obj->newanswer));
			//$priority=$_POST['priority'];
			//echo '<script>alert("'.$answer.'")</script>';
			$q_id=$obj->id;
			//echo '<script>alert("'.$q_id.'")</script>';
			$user_id=$obj->sessionuserid;
			//echo '<script>alert("'.$q_user_id.'")</script>';
			//$answer_time=$_POST['answer_post_time'];
			//echo '<script>alert("'.$answer_time.'")</script>';
			$query1=mysqli_query($conn,"INSERT INTO `user_question_answer`(`q_id`,`user_id`,`answer`)VALUES('$q_id','$user_id','$answer');");
			if (!$query1)
			{
				echo("Error description: " . mysqli_error($conn));
			}
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
		  $query_answers=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' ORDER BY `answer_id` desc;");
		  $no_of_answers=mysqli_num_rows($query_answers);
			if ($userid1!=$user_id)
			{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has answered on a question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
			//echo '<script>alert("'.$query1.'")</script>';
		}
		$query_id=mysqli_query($conn,"SELECT * FROM `user_question_answer` ORDER BY `answer_id` desc limit 1;");
		$fetch_id=mysqli_fetch_assoc($query_id);
		//$qid=$fetch_id['q_id'];
		$answerid=$fetch_id['answer_id'];
		
		$query_name=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
		$fetch_name=mysqli_fetch_assoc($query_name);
		$username=$fetch_name['username'];
		
		$query_pic=mysqli_query($conn,"SELECT * FROM `user_profile_pic` WHERE `user_id`='$user_id';");
		$fetch_pic=mysqli_fetch_assoc($query_pic);
		$profilepic=$fetch_pic['pic_path'];
		
		if (strcmp($profilepic,'')!=0)
			$userpic=$profilepic;
		else if(strcmp($profilepic,'')==0)
			$userpic="Avatar.jpg";
		
		$answer=htmlspecialchars_decode($obj->newanswer);
		
		$list4[]=array('userid'=>$user_id,'qid'=>$q_id,'noof_answers'=>$no_of_answers,'answerid'=>$answerid,'username'=>$username,'userpic'=>$userpic,'answer'=>$answer);
		echo json_encode($list4);
		}

?>