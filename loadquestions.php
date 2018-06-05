<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
$session_user_id=$obj->sessionid;
//echo $session_user_id;

	  $query2=mysqli_query($conn,"SELECT * FROM `user_question` ORDER BY `q_id` desc;");
	  while($fetch2=mysqli_fetch_assoc($query2))
	  {
					 
		  $q_id=$fetch2['q_id'];
		  $q_user_id=$fetch2['user_id'];
		  $question=$fetch2['question'];
		  $decoded_question=htmlspecialchars_decode($question);
		  $questiondate=$fetch2['question_date'];
		  $query3=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$q_user_id';");
		 
		  
		  $fetch3=mysqli_fetch_assoc($query3);
		  $q_ask_name=$fetch3['username'];
		  $query_status=mysqli_query($conn,"SELECT * FROM `user_question_status` where `q_id`='$q_id' and `user_id`='$session_user_id';");
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
		  $query_answers=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `q_id`='$q_id' ORDER BY `answer_id` desc;");
		  $no_of_answers=mysqli_num_rows($query_answers);
		  $query_follow=mysqli_query($conn,"SELECT * FROM `user_question_follower` WHERE `follow_id`='$session_user_id' and `q_id`='$q_id';");
		  $follow=mysqli_num_rows($query_follow);
		
		if ($follow==0)
			
			$followqbtn=5;
		else
			$followqbtn=7;
			
	//	if (isset($_SESSION['profile_pic']))
	//		$userpic=$_SESSION['profile_pic'];
	//	else
	//	{
		$query100=mysqli_query($conn,"SELECT * FROM `user_profile_pic` where `user_id`='$q_user_id';");
		$fetch100=mysqli_fetch_assoc($query100);
		$profile_path=$fetch100['pic_path'];
		
		if (strcmp($profile_path,'')==0)
			$userpic="Avatar.jpg";
		else
			$userpic=$profile_path;
	// }
		//	mysqli_free_result($list1);
	 //unset ($answerlist);
	 $querydetail=mysqli_query($conn,"SELECT * FROM `user_detail` WHERE `user_id`='$q_user_id';");
	$fetchdetail=mysqli_fetch_assoc($querydetail);
	$country_id=$fetchdetail['country'];
	$querycountry=mysqli_query($conn,"SELECT * FROM `countries` WHERE `id`='$country_id';");
	$fetchcountry=mysqli_fetch_assoc($querycountry);
	$country=$fetchcountry['name'];
	
	$state_id=$fetchdetail['state'];
	$querystate=mysqli_query($conn,"SELECT * FROM `states` WHERE `id`='$state_id';");
	$fetchstate=mysqli_fetch_assoc($querystate);
	$state=$fetchstate['name'];
	
	$district_id=$fetchdetail['district'];
	$querycity=mysqli_query($conn,"SELECT * FROM `cities` WHERE `id`='$district_id';");
	$fetchcity=mysqli_fetch_assoc($querycity);
	$city=$fetchcity['name'];
	$studying=$fetchdetail['studying'];
	$profilebio=$fetchdetail['profile_bio'];
	 $livesin=$city." ,".$state." ,".$country;
	 
	 $query_user_follow=mysqli_query($conn,"SELECT * FROM `user_follower` WHERE `followid`='$q_user_id';");
	 $no_of_user_follower=mysqli_num_rows($query_user_follow);
	 
	 if ($no_of_user_follower)
		{ 
			$status_user_follower="YES";
			$user_follow_btn=1;
		}
	 else 
		{
			$status_user_follower="NO";
			$user_follow_btn=2;
		}
	 
	 
	  $list[] = array('userpic2' =>$userpic,'id' => $q_id, 'quserid' => $q_user_id, 'ques' =>$decoded_question, 'questionaskname' =>$q_ask_name, 'nooflike' =>$no_of_like, 'noofunlike' =>$no_of_unlike,'noofanswers' =>$no_of_answers,'statuslike'=>$statuslike,'statusunlike'=>$statusunlike,'sessionuserid'=>$session_user_id,'follow'=>$follow,'editqbtn'=>1,'likeqbtn'=>$likebtn,'unlikeqbtn'=>$unlikebtn,'requestqbtn'=>4,'followqbtn'=>$followqbtn,'answerqbtn'=>6,'studying'=>$studying,'livesin'=>$livesin,'profilebio'=>$profilebio,'statususerfollower'=>$status_user_follower,'userfollowbtn'=>$user_follow_btn,'questiondate'=>$questiondate);
	//  echo $q_id;
	  }
	  
	  //$fetch2->free_result();
	// $fetch2->close();
	  echo json_encode($list);

	//unset ($list);
	  ?>

