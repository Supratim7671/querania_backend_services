<?php
include "configuration.php";
$json = file_get_contents('php://input');
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
//echo '<script>alert("'.$obj.'")</script>';
	$userid=$obj->user_id;
	//echo '<script>alert("'.$userid.'")</script>';
	if (strcmp(($obj->profile_bio),'')!=0)
	{
		$profile_bio=test_input($obj->profile_bio);
		//echo'<script>alert("'.$profile_bio.'")</script>';
		//echo'<script>alert("'.$userid.'")</script>';
		mysqli_query($conn,"UPDATE `user_detail` SET `profile_bio`='$profile_bio' where `user_id`='$userid';");
		
	}
/*	
	if (strcmp(($obj->gender),'')!=0)
		{
		$gender=test_input($obj->gender);
		//echo'<script>alert("'.$gender.'")</script>';
		mysqli_query($conn,"UPDATE `user_detail` SET `gender`='$gender' where `user_id`='$userid';");
		}
		
	if (strcmp(($obj->country),'')!=0)
	{
		$country=test_input($obj->country);
		//echo'<script>alert("'.$country.'")</script>';
		mysqli_query($conn,"UPDATE `user_detail` SET `country`='$country' where `user_id`='$userid';");
	}
	if (strcmp(($obj->state),'')!=0)
	{
		$state=test_input($obj->state);
		mysqli_query($conn,"UPDATE `user_detail` SET `state`='$state' where `user_id`='$userid';");
	}
	if (strcmp(($obj->district),'')!=0)
	{
		$city=test_input($obj->district);
		mysqli_query($conn,"UPDATE `user_detail` SET `district`='$city' where `user_id`='$userid';");
	}
	*/
	if (strcmp(($obj->mobile_no),'')!=0)
	{
		$mobile=test_input($obj->mobile_no);
		mysqli_query($conn,"UPDATE `user_detail` SET `mobile_no`='$mobile' where `user_id`='$userid';");
	}
/*
	if (strcmp(($obj->studying),'')!=0)
	{
		$study=test_input($obj->studying);
		mysqli_query($conn,"UPDATE `user_detail` SET `studying`='$study' where `user_id`='$userid';");
	}
	if (strcmp(($obj->status),'')!=0)
	{
		$status=test_input($obj->status);
		mysqli_query($conn,"UPDATE `user_detail` SET `status`='$status' where `user_id`='$userid';");
	}
*/
	if (strcmp(($obj->about_me),'')!=0)
	{
		$aboutme=test_input($obj->about_me);
		mysqli_query($conn,"UPDATE `user_detail` SET `about_me`='$aboutme' where `user_id`='$userid';");
	}
	//if (strcmp(($obj->dob),'')!=0)
	//{
	//	$dob=test_input($obj->dob);
	//	mysqli_query($conn,"UPDATE `user_detail` SET `dob`='$dob' where `user_id`='$userid';");
	//}
	
	/*function GetImageExtension($imagetype)
     {
		if(empty($imagetype)) return false;
		switch($imagetype)
{
			case 'image/bmp': return '.bmp';
			case 'image/gif': return '.gif';
			case 'image/jpeg': return '.jpg';
			case 'image/png': return '.png';
			default: return false;
	}
}

	if (isset($_POST['img']))
{
	if (!empty($_FILES["uploadedimage"]["name"])) 
 {
	$file_name=$_FILES["uploadedimage"]["name"];
	$temp_name=$_FILES["uploadedimage"]["tmp_name"];
	$imgtype=$_FILES["uploadedimage"]["type"];
	$ext= GetImageExtension($imgtype);
	$imagename=date("d-m-Y")."-".time().$ext;
	$target_path = "./images/".$imagename;
	
if(move_uploaded_file($temp_name, $target_path)) 
{	
           $query1= mysqli_query($conn,"SELECT * FROM `users` where `user_id`='$userid';");
     $fetch1=mysqli_fetch_array($query1,MYSQLI_NUM);
     $username=$fetch1[1];
	$uid=$_SESSION['uid'];
	$query=mysqli_query($conn,"SELECT * FROM  `users` WHERE `user_id`='$uid';");
	$result=mysqli_fetch_array($query,MYSQLI_NUM);
	$userid=$result[0];
	$query2=mysqli_query($conn,"SELECT * FROM `user_profile_pic` WHERE `user_id`='$userid';");
	$fetch2=mysqli_fetch_assoc($query2);
	$profile_id=$fetch2['pic_id'];
	$image_path=$fetch2['pic_path'];
	if (strcmp($image_path,'')==0)
	mysqli_query($conn,"INSERT INTO `user_profile_pic` (`user_id`,`pic_name`,`pic_path`) VALUES('$userid','$imagename','$target_path');");
	
	else
	
	mysqli_query($conn,"UPDATE `user_profile_pic` set `pic_name`='$imagename',`pic_path`='$target_path' WHERE `user_id`='$userid' and `pic_id`='$profile_id';");
//$message=$username.' has changed his profile pic';
        //        mysqli_query($conn,"INSERT INTO `admin_notification` (`notification`) VALUES ('$message');");    
	echo "<meta content=\"2;user_profile.php\" http-equiv=\"refresh\">";  

}
else
{
	exit("Error While uploading image on the server");
}
}
}
*/
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
$query_question_asked=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `user_id`='$userid';");
$noofquestionasked=mysqli_num_rows($query_question_asked);

$query_answer_given=mysqli_query($conn,"SELECT * FROM `user_question_answer` WHERE `user_id`='$userid';");
$noofanswergiven=mysqli_num_rows($query_answer_given);

$query_reply_given=mysqli_query($conn,"SELECT * FROM `user_question_answer_reply` WHERE `user_id`='$userid';");
$noofreplygiven=mysqli_num_rows($query_reply_given);

$list1=[];
$list1=array('username'=>$username,'email'=>$email,'profilebio'=>$profilebio,'mobile'=>$mobile,'gender'=>$gender,'aboutme'=>$aboutme,'userpic'=>$userpic,'noofquestionasked'=>$noofquestionasked,'noofanswergiven'=>$noofanswergiven,'noofreplygiven'=>$noofreplygiven);
echo json_encode($list1);		
		  
	




?>