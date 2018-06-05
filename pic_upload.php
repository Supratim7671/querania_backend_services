<?php
include 'configuration.php';
//$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo 'json value is'.$json;
//$obj = json_decode($json);
//echo 'json value is'.$obj;

//$userid=$obj->sessionuserid;
//$imgbtn=$obj->imgbtn;
//$file=$obj->file;
//echo $_FILES["file"]["name"];
//var_dump($_POST['file']);
//var_dump($_FILES['sessionuserid']);
//var_dump($_POST['sessionuserid']);
//echo "hello";
$userid=$_POST['sessionuserid'];
//$imgbtn=$_POST['imgbtn'];
echo $userid;
function GetImageExtension($imagetype)
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


	if (!empty($_FILES) ) 
 {
	$file_name=$_FILES["file"]["name"];
	$temp_name=$_FILES["file"]["tmp_name"];
	$imgtype=$_FILES["file"]["type"];
	$ext= GetImageExtension($imgtype);
	$imagename=date("d-m-Y")."-".time().$ext;
	$target_path = "./images/".$imagename;
	//echo $file_name." ".$target_path;
	echo file_get_contents($_FILES["file"]["tmp_name"]);
	
if(move_uploaded_file($temp_name, $target_path)) 
{	
         //  $query1= mysqli_query($conn,"SELECT * FROM `users` where `user_id`='$userid';");
    // $fetch1=mysqli_fetch_array($query1,MYSQLI_NUM);
    // $username=$fetch1[1];
	//$uid=$_SESSION['uid'];
	//$query=mysqli_query($conn,"SELECT * FROM  `users` WHERE `user_id`='$userid';");
	//$result=mysqli_fetch_array($query,MYSQLI_NUM);
	//$userid=$result[0];
	$query2=mysqli_query($conn,"SELECT * FROM `user_profile_pic` WHERE `user_id`='$userid';");
	$fetch2=mysqli_fetch_assoc($query2);
	$profile_id=$fetch2['pic_id'];
	$image_path=$fetch2['pic_path'];
	if (strcmp($image_path,'')==0)
	mysqli_query($conn,"INSERT INTO `user_profile_pic` (`user_id`,`pic_name`,`pic_path`) VALUES('$userid','$imagename','$target_path');");
	
	else
	
	{
		mysqli_query($conn,"UPDATE `user_profile_pic` set `pic_name`='$imagename',`pic_path`='$target_path' WHERE `user_id`='$userid' and `pic_id`='$profile_id';");
		unlink($image_path);
	}

}
else
{
	exit("Error While uploading image on the server");
}
}



//$query3=mysqli_query($conn,"SELECT * FROM `user_profile_pic` where `user_id`='$userid';");
//$fetch3=mysqli_fetch_assoc($query3);
//$user_pic=$fetch3['pic_path'];
//echo $user_pic;


?>