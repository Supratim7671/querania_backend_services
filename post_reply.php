<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);



if (strcmp($obj->newreply,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			
			$reply=test_input($obj->newreply);
			//$priority=$_POST['priority'];
			//echo '<script>alert("'.$answer.'")</script>';
			$q_id=$obj->qid;
			//echo '<script>alert("'.$q_id.'")</script>';
			$user_id=$obj->sessionuserid1;
			$q_answer_id=$obj->answerid;
			//echo '<script>alert("'.$q_user_id.'")</script>';
			//$reply_time=$_POST['answer_post_time'];
			//echo '<script>alert("'.$answer_time.'")</script>';
			$query1=mysqli_query($conn,"INSERT INTO `user_question_answer_reply`(`user_id`,`q_id`,`answer_id`,`reply`,`reply_date`)VALUES('$user_id','$q_id','$q_answer_id','$reply','NOW()');");
			$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `q_id`='$q_id';");
			$fetch2=mysqli_fetch_assoc($query2);
			$userid1=$fetch2['user_id'];
			$query3=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' and `answer_id`='$q_answer_id';");
			$fetch3=mysqli_fetch_assoc($query3);
			$userid2=$fetch3['user_id'];
			 $query_replies=mysqli_query($conn,"SELECT * from `user_question_answer_reply` WHERE `q_id`='$q_id' and `answer_id`='$q_answer_id' ORDER BY `reply_id` desc;");
			$no_of_replies=mysqli_num_rows($query_replies);
			$query_reply=mysqli_query($conn,"SELECT * FROM `user_question_answer_reply` order by `reply_id` desc limit 1;");
			$fetch_reply=mysqli_fetch_assoc($query_reply);
			$replyid=$fetch_reply['reply_id'];
			$query_name=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name=mysqli_fetch_assoc($query_name);
			$username=$fetch_name['username'];
			$query_pic=mysqli_query($conn,"SELECT * from `user_profile_pic` WHERE `user_id`='$user_id';");
			$fetch_pic=mysqli_fetch_assoc($query_pic);
			$profilepic=$fetch_pic['pic_path'];
			if(strcmp($profilepic,'')!=0)
				$userpic=$profilepic;
			else
				$userpic="Avatar.jpg";
				
		
			if ($userid1!=$user_id)
			{
				if ($userid2!=$user_id)
				{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message1=$name1." has replied on your question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message1', 'NOW()','$q_id');");
			$message2=$name1." has replied on your answer";
			$query5=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid2', '$message2', 'NOW()','$q_id');");
			//echo '<script>alert("'.$query1.'")</script>';
		}
		else
		{
			$query_name1=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name1=mysqli_fetch_assoc($query_name1);
			$name1=$fetch_name1['username'];
			$message1=$name1." has replied on a question";
			$query4=mysqli_query($conn,"INSERT INTO `user_notification` (`user_id`, `notification`, `notification_date`,`q_id`) VALUES ('$userid1', '$message1', 'NOW()','$q_id');");
		}
		
			}
		$list5[]=array('username'=>$username,'userpic'=>$userpic,'sessionuid'=>$user_id,'questionid'=>$q_id,'noof_replies'=>$no_of_replies,'ansid'=>$q_answer_id,'replyid'=>$replyid,'reply'=>$reply);
		echo json_encode($list5);
		}
		
		?>