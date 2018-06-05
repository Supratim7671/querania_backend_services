<?php
include "configuration.php";
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
$q_id=$obj->quesid;
$answer_id=$obj->ansid;
$session_user_id=$obj->sessionuid;
 $query10=mysqli_query($conn,"SELECT * from `user_question_answer_reply` WHERE `q_id`='$q_id' and `answer_id`='$answer_id' ORDER BY `reply_id` desc;");
		  if (mysqli_num_rows($query10)>0)
		  {
		  while($fetch10=mysqli_fetch_assoc($query10))
	  {
		 // echo '<script>alert("Blinking is here in third loop")</script>';
		   $q_answer_reply_user_id=$fetch10['user_id'];
		  $q_id=$fetch10['q_id'];
		  $answer_id=$fetch10['answer_id'];
		  $reply_id=$fetch10['reply_id'];
		  $reply=$fetch10['reply'];
		  $decoded_reply=htmlspecialchars_decode($reply);
		  $reply_time=$fetch10['reply_date'];
		  $query5=mysqli_query($conn,"SELECT * from `users` WHERE `user_id`='$q_answer_reply_user_id';");
		  $q_fetch_name=mysqli_fetch_assoc($query5);
		  $q_reply_name=$q_fetch_name['username'];
//	if (isset($_SESSION['profile_pic']) and $q_answer_reply_user_id==$session_user_id)
	//		$userpic2=$_SESSION['profile_pic'];
	//	else
	//	{
		  $query100=mysqli_query($conn,"SELECT * FROM `user_profile_pic` where `user_id`='$q_answer_reply_user_id';");
			$fetch100=mysqli_fetch_assoc($query100);
			$profile_path=$fetch100['pic_path'];
	if (strcmp($profile_path,'')==0)
		$userpic2="Avatar.jpg";
	else
		$userpic2=$profile_path;
	//	}	
	$list2[]=array('userpic'=>$userpic2,'answerquestionid'=>$q_id,'answerreplyid'=>$answer_id, 'replyid'=>$reply_id, 'answerreplyuserid' =>$q_answer_reply_user_id, 'answerreply'=>$decoded_reply, 'answerreplyname' =>$q_reply_name,'sessionuserid2'=>$session_user_id,'editreplybtn'=>1);
		  
	  
	  }
	  }
	else{
		$q_id='';
		$userpic='';
		$reply_id='';
		$q_answer_reply_user_id='';
		$reply='';
		$decoded_reply='';
		$q_reply_name='';
		$answer_id='';
		$list2[]=array('userpic'=>$userpic,'answerquestionid'=>$q_id,'answerreplyid'=>$answer_id,'replyid'=>$reply_id, 'answerreplyuserid' =>$q_answer_reply_user_id, 'answerreply'=>$decoded_reply, 'answerreplyname' =>$q_reply_name,'sessionuserid2'=>$session_user_id,'editreplybtn'=>1);
	}
	//  $list1[]=array('a'=>1,'b'=>2);
	  echo json_encode($list2);
	  
	 ?>