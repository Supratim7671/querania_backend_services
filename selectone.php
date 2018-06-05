<?php
include "configuration.php";
$json = file_get_contents('php://input');
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
//echo '<script>alert("'.$obj.'")</script>';
$userid=$obj->sessionuserid;
//echo '<script>alert("'.$userid.'")</script>';
$query=mysqli_query($conn,"SELECT * FROM `user_detail` where `user_id`='$userid';");
$query_name=mysqli_query($conn,"SELECT * FROM `users` 	where 	`user_id`='$userid';");
$fetch_name=mysqli_fetch_assoc($query_name);
$username=$fetch_name['username'];
$email=$fetch_name['email'];
$query_pic=mysqli_query($conn,"SELECT * FROM `user_profile_pic` WHERE `user_id`='$userid';");
$fetch_pic=mysqli_fetch_assoc($query_pic);
$profilepic=$fetch_pic['pic_path'];
if (strcmp($profilepic,'')==0)
	$userpic="Avatar.jpg";
else if(strcmp($profilepic,'')!=0)
	$userpic=$profilepic;


	  $fetchdetail=mysqli_fetch_assoc($query);
$profilebio=$fetchdetail['profile_bio'];
$mobile=$fetchdetail['mobile_no'];
$gender=$fetchdetail['gender'];
$aboutme=$fetchdetail['about_me'];
$query_question_asked=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `user_id`='$userid';");
$noofquestionasked=mysqli_num_rows($query_question_asked);

$query_answer_given=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `user_id`='$userid';");
$noofanswergiven=mysqli_num_rows($query_answer_given);

$query_reply_given=mysqli_query($conn,"SELECT * FROM `user_question_answer_reply` WHERE `user_id`='$userid';");
$noofreplygiven=mysqli_num_rows($query_reply_given);

$list1=[];
$list1=array('username'=>$username,'email'=>$email,'profilebio'=>$profilebio,'mobile'=>$mobile,'gender'=>$gender,'aboutme'=>$aboutme,'userpic'=>$userpic,'noofquestionasked'=>$noofquestionasked,'noofanswergiven'=>$noofanswergiven,'noofreplygiven'=>$noofreplygiven);
echo json_encode($list1);		
		
		//echo json_encode($fetchdetail);
	?>