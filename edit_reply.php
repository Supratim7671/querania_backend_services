<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

//$btnno=$obj->btnno;
//$btnno1=$obj->btnno1;





		
/*if ($obj->editabtn==1 and strcmp($obj->ans,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			$txt=htmlspecialchars($obj->ans);
			$q_id=$obj->qid;
			$user_id=$obj->sessionuserid1;
			$answer_id=$obj->answerid;
			//$priority=$_POST['priority'];
			//$post_time=$_POST['question_post_time'];
			$query1=mysqli_query($conn,"UPDATE `user_question_answer` set `answer`='$txt' where `user_id`='$user_id' and `q_id`='$q_id' and `answer_id`='$answer_id';");
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
			if ($userid1!=$user_id)
			{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has edited his answer";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
		
			//echo '<script>alert("'.$query1.'")</script>';
		}
		}
		*/
		
if ($obj->editreplybtn==1 and strcmp($obj->answerreply,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			$txt=htmlspecialchars($obj->answerreply);
			$q_id=$obj->answerquestionid;
			$user_id=$obj->sessionuserid2;
			$answer_id=$obj->answerreplyid;
			$reply_id=$obj->replyid;
			
			//$post_time=$_POST['question_post_time'];
			$query1=mysqli_query($conn,"UPDATE `user_question_answer_reply` set `reply`='$txt' where `user_id`='$user_id' and `q_id`='$q_id' and `answer_id`='$answer_id' and `reply_id`='$reply_id';");
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
			$query3=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' and `answer_id`='$answer_id';");
			$fetch3=mysqli_fetch_assoc($query3);
			$userid2=$fetch3['user_id'];
			if ($userid1!=$user_id)
			{
				if ($userid2!=$user_id)
				{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has edited his reply";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
				$query5=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid2', '$message', 'NOW()','$q_id');");
			
			}
				else
				{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has edited his reply";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
				}
					
			//echo '<script>alert("'.$query1.'")</script>';
		}	
		}
		
/*		if ($obj->answerqbtn==6 and strcmp($obj->newanswer,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			
			$answer=test_input($obj->newanswer);
			//$priority=$_POST['priority'];
			//echo '<script>alert("'.$answer.'")</script>';
			$q_id=$obj->id;
			//echo '<script>alert("'.$q_id.'")</script>';
			$q_user_id=$obj->sessionuserid;
			//echo '<script>alert("'.$q_user_id.'")</script>';
			//$answer_time=$_POST['answer_post_time'];
			//echo '<script>alert("'.$answer_time.'")</script>';
			$query1=mysqli_query($conn,"INSERT INTO `user_question_answer`(`q_id`,`user_id`,`answer`,`answer_time`)VALUES('$q_id','$q_user_id','$answer','NOW()');");
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
		  $query_answers=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' ORDER BY `answer_id` desc;");
		  $no_of_answers=mysqli_num_rows($query_answers);
			if ($userid1!=$q_user_id)
			{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$q_user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message=$name1." has answered on a question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message', 'NOW()','$q_id');");
			//echo '<script>alert("'.$query1.'")</script>';
		}
		$list4[]=array('sessionuid'=>$q_user_id,'questionid'=>$q_id,'noof_answers'=>$no_of_answers);
		echo json_encode($list4);
		//echo $no_of_answers
		}
		
		if ($obj->replyabtn==4 and strcmp($obj->newreply,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			
			$reply=test_input($obj->newreply);
			//$priority=$_POST['priority'];
			//echo '<script>alert("'.$answer.'")</script>';
			$q_id=$obj->qid;
			//echo '<script>alert("'.$q_id.'")</script>';
			$q_user_id=$obj->sessionuserid1;
			$q_answer_id=$obj->answerid;
			//echo '<script>alert("'.$q_user_id.'")</script>';
			//$reply_time=$_POST['answer_post_time'];
			//echo '<script>alert("'.$answer_time.'")</script>';
			$query1=mysqli_query($conn,"INSERT INTO `user_question_answer_reply`(`user_id`,`q_id`,`answer_id`,`reply`,`reply_date`)VALUES('$q_user_id','$q_id','$q_answer_id','$reply','NOW()');");
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
			$query3=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' and `answer_id`='$q_answer_id';");
			$fetch3=mysqli_fetch_assoc($query3);
			$userid2=$fetch3['user_id'];
			 $query_replies=mysqli_query($conn,"SELECT * from `user_question_answer_reply` WHERE `q_id`='$q_id' and `answer_id`='$q_answer_id' ORDER BY `reply_id` desc;");
			$no_of_replies=mysqli_num_rows($query_replies);
			if ($userid1!=$q_user_id)
			{
				if ($userid2!=$q_user_id)
				{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$q_user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message1=$name1." has replied on a question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message1', 'NOW()','$q_id');");
			$message2=$name1." has replied on a answer";
			$query5=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid2', '$message2', 'NOW()','$q_id');");
			//echo '<script>alert("'.$query1.'")</script>';
		}
		else
		{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$q_user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message1=$name1." has replied on a question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message1', 'NOW()','$q_id');");
		}
		
			}
		$list5[]=array('sessionuid'=>$q_user_id,'questionid'=>$q_id,'noof_replies'=>$no_of_replies,'ansid'=>$q_answer_id);
		echo json_encode($list5);
		}
		
	
	*/	
//echo json_encode($list4);

?>