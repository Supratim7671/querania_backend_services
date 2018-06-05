<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
//$qid=$obj->quesid;
$qid=$obj;
$query=mysqli_query($conn,"SELECT * FROM `user_question_follower` WHERE `q_id`='$qid';");
while($fetch=mysqli_fetch_assoc($query))
{
	$followingid=$fetch['follow_id'];
	$queryfollow=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$followingid';");
	$fetchfollow=mysqli_fetch_assoc($queryfollow);
	$username=$fetchfollow['username'];
	$querypic=mysqli_query($conn,"SELECT * FROM `user_profile_pic` WHERE `user_id`='$followingid';");
	$fetchpic=mysqli_fetch_assoc($querypic);
	$followerpic=$fetchpic['pic_path'];
	if (strcmp($followerpic,'')!=0)
	{
		$userpic=$followerpic;
	}
	else if(strcmp($followerpic,'')==0)
	{
		$userpic="Avatar.jpg";
	}
	
	$querydetail=mysqli_query($conn,"SELECT * FROM `user_detail` WHERE `user_id`='$followingid';");
	$fetchdetail=mysqli_fetch_assoc($querydetail);
	$country=$fetchdetail['country'];
	$state=$fetchdetail['state'];
	$district=$fetchdetail['district'];
	$studying=$fetchdetail['studying'];
	$profilebio=$fetchdetail['profile_bio'];
	
	$livesin=$country." ".$state." ".$district;
	$query_no_of_followers=mysqli_query($conn,"SELECT * FROM `user_question_follower` where `following_id`='$followingid';");
	$no_of_followers=mysqli_num_rows($query_no_of_followers);
	$list2[]=array('username'=>$username,'followerpic'=>$userpic,'studying'=>$studying,'livesin'=>$livesin,'nooffollowers'=>$no_of_followers,'profilebio'=>$profilebio);
	}
 echo json_encode($list2);
 
?>