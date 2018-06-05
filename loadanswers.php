<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
//echo '<script>alert("'.$obj.'")</script>';
$q_id=$obj->quesid;
$session_user_id=$obj->sessionuid;
//echo $q_id." ".$session_user_id;
$query4=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' ORDER BY `answer_id` desc;");
  if(mysqli_num_rows($query4)!=0)
		  {
  while($fetch4=mysqli_fetch_assoc($query4))
	  {
		  
		  //echo '<script>alert("Blinking is here in second loop")</script>';
		  $q_answer_user_id=$fetch4['user_id'];
		  $q_id=$fetch4['q_id'];
		  $answer_id=$fetch4['answer_id'];
		  $answer=$fetch4['answer'];
		  $decoded_answer=htmlspecialchars_decode($answer);
		  $answer_time=$fetch4['answer_time'];
		  $query5=mysqli_query($conn,"SELECT * from `users` WHERE `user_id`='$q_answer_user_id';");
		  $q_fetch_name=mysqli_fetch_assoc($query5);
		  $q_answer_name=$q_fetch_name['username'];
		  $query_reply_status=mysqli_query($conn,"SELECT * FROM `user_answer_status` where `q_id`='$q_id' and `answer_id`='$answer_id' and `user_id`='$session_user_id';");
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
		  
		   $query_replies=mysqli_query($conn,"SELECT * from `user_question_answer_reply` WHERE `q_id`='$q_id' and `answer_id`='$answer_id' ORDER BY `reply_id` desc;");
		  $no_of_replies=mysqli_num_rows($query_replies);
	//   if (isset($_SESSION['profile_pic']) and $q_answer_user_id==$session_user_id)
   //{
	//   $userpic1=$_SESSION['profile_pic'];
  // }
	//  else
	//  {
	  $query101=mysqli_query($conn,"SELECT * FROM `user_profile_pic` where `user_id`='$q_answer_user_id';");
	  $fetch101=mysqli_fetch_assoc($query101);
	  $profile_path1=$fetch101['pic_path'];
	  if (strcmp($profile_path1,'')==0)
		 $userpic1="Avatar.jpg";
	else
		 $userpic1=$profile_path1;
	//  }
	//$answerlist[] = array(1,2);
	
	$list1[]=array('userpic1' =>$userpic1, 'qid' =>$q_id, 'answerid' =>$answer_id, 'qansweruserid'=> $q_answer_user_id, 'ans' => $decoded_answer, 'answername' => $q_answer_name,'noofanswerlike' =>$no_of_answer_like, 'noofanswerunlike' =>$no_of_answer_unlike, 'noofreplies' =>$no_of_replies,'replystatus'=>$reply_status,'sessionuserid1'=>$session_user_id,'answerstatuslike'=>$answerstatuslike,'answerstatusunlike'=>$answerstatusunlike,'editabtn'=>1,'likeabtn'=>$answerlikebtn,'unlikeabtn'=>$answerunlikebtn,'replyabtn'=>4);

	//$list[] = array('userpic2' =>$userpic,'id' => $q_id, 'quserid' => $q_user_id, 'ques' =>$question, 'questionaskname' =>$q_ask_name, 'nooflike' =>$no_of_like, 'noofunlike' =>$no_of_unlike,'noofanswers' =>$no_of_answers);
		  }
		 
	
			  
	  }
	   else if (mysqli_num_rows($query4)==0)
		  {
			  $userpic1='';
			  $q_id='';
			  $answer_id='';
			  $q_answer_user_id='';
			  $answer='';
			  $decode_answer='';
			  $q_answer_name='';
			  $no_of_answer_like='';
			  $no_of_answer_unlike='';
			  $no_of_replies='';
			  $reply_status='';
			  $answerstatuslike='';
			  $answerstatusunlike='';
			  $answerlikebtn=2;
			  $answerunlikebtn=3;
		  $list1[]=array('userpic1' =>$userpic1, 'qid' =>$q_id, 'answerid' =>$answer_id, 'qansweruserid'=> $q_answer_user_id, 'ans' => $decoded_answer, 'answername' => $q_answer_name,'noofanswerlike' =>$no_of_answer_like, 'noofanswerunlike' =>$no_of_answer_unlike, 'noofreplies' =>$no_of_replies,'replystatus'=>$reply_status,'sessionuserid'=>$session_user_id,'answerstatuslike'=>$answerstatuslike,'answerstatusunlike'=>$answerstatusunlike,'editabtn'=>1,'likeabtn'=>$answerlikebtn,'unlikeabtn'=>$answerunlikebtn,'replyabtn'=>4);
	
		  }
		  
	echo json_encode($list1);
	?>