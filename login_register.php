
<?php

include "configuration.php";
include "PHPMailerAutoload.php";
include "class.phpmailer.php";

$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo '<script>alert("In the php file"+'.$obj.');</script>';
	if ((!empty($obj->email)and !empty($obj->password)) or (!empty($obj->email2)and !empty($obj->password2)))
{
	
	if (!empty($obj->email)and !empty($obj->password))
	{
		$email=test_input($obj->email);
		$password=test_input($obj->password);

		$query_name="SELECT * FROM `users` WHERE `email` = '$email'";
		
		$query_name=mysqli_query($conn,$query_name);
		$fetch_name=mysqli_fetch_assoc($query_name);
		$name=$fetch_name['username'];
		$password=hashing($password,$email);
		$result=mysqli_query($conn,"select * from `users` where `email`='$email' and `password`='$password';");
		
	
		$fetch_result=mysqli_fetch_assoc($result);
		
		$userid=$fetch_result['user_id'];
		$verified=$fetch_result['verified'];
		
		if (mysqli_num_rows($result)==1)
		{
			 
				
				$_SESSION['uid']=$userid;
				$query=mysqli_query($conn,"UPDATE `users` set `online`='yes' where `user_id`=$userid;");
				//echo '<script>window.onload=function(){$(\'#loggedin\').show();}</script>';
				                
			 if (isset($_POST['next']))
			 {
				 
				 $next=$_POST['next'];
				 //echo '<script>alert("'.$next.'");</script>';
				 echo '<meta content="0;'.$next.'" http-equiv="refresh">';
			 }
			 else
			 {
				 $responsedata=1;
				 $list[]=array('response'=>$responsedata,'userid'=>$userid,'verified'=>$verified);  
				 
			echo json_encode($list);	 
			// echo "<meta content=\"0;home_page.php\" http-equiv=\"refresh\">";
			 }
			
		}
		
		else
		{
			$responsedata=2;
			$list[]=array('response'=>$responsedata,'userid'=>0,'verified'=>$verified);   
			
			echo json_encode($list);
			//echo'<script>alert("In the login failed block")</script>';
			//echo '<script>window.onload=function(){$(\'#loginfailed\').show();}</script>';
		}
	
	}
	else if (!empty($obj->email2)and !empty($obj->password2))
	{
	$email=test_input($obj->email2);
		$password=test_input($obj->password2);

		$query_name="SELECT * FROM `users` WHERE `email` = '$email'";
		
		$query_name=mysqli_query($conn,$query_name);
		$fetch_name=mysqli_fetch_assoc($query_name);
		$name=$fetch_name['username'];
		$password=hashing($password,$email);
		$result=mysqli_query($conn,"select * from `users` where `email`='$email' and `password`='$password';");
		
	
		$fetch_result=mysqli_fetch_assoc($result);
		
		$userid=$fetch_result['user_id'];
		$verified=$fetch_result['verified'];
		if (mysqli_num_rows($result)==1)
		{
			 
				
				$_SESSION['uid']=$userid;
				//echo '<script>window.onload=function(){$(\'#loggedin\').show();}</script>';
				$query=mysqli_query($conn,"UPDATE `users` set `online`='yes' where `user_id`=$userid;");
				 $responsedata=1;
				 $list[]=array('response'=>$responsedata,'userid'=>$userid,'verified'=>$verified);                
			 if (isset($_POST['next']))
			 {
				 
				 $next=$_POST['next'];
				 //echo '<script>alert("'.$next.'");</script>';
				 echo '<meta content="0;'.$next.'" http-equiv="refresh">';
			 }
			 else
			echo json_encode($list);	 
			// echo "<meta content=\"0;home_page.php\" http-equiv=\"refresh\">";
			
			
		}
		
		else
		{
			$responsedata=2;
			$list[]=array('response'=>$responsedata,'userid'=>0,'verified'=>$verified);  
			echo json_encode($list);
			//echo'<script>alert("In the login failed block")</script>';
			//echo '<script>window.onload=function(){$(\'#loginfailed\').show();}</script>';
		}	
	}
	else
			echo "Please enter the fields for succesfull login";

}
else if (!empty($obj->username1)and !empty($obj->email1) and !empty($obj->password1) and !empty($obj->cpassword1))
{
	//echo'<script>alert("Button is clicked")</script>';
	if (!empty($obj->username1)and !empty($obj->email1) and !empty($obj->password1) and !empty($obj->cpassword1) )
{
	//echo'<script>alert("fields are not empty")</script>';
	$name=test_input($obj->username1);
$email=test_input($obj->email1);
$password=test_input($obj->password1);
$cpassword=test_input($obj->cpassword1);
$password=hashing($password,$email);

$cpassword=hashing($cpassword,$email);
	//$captcha=$_POST['g-recaptcha-response'];
//if (!$captcha)
//{
//echo '<script>window.onload=function(){$(\'#captchafailed\').modal();}</script>';
//exit;
//}
//$secretkey="6Lc75CUTAAAAAJIhjTCCQHCyVP-nJZzzdW9eSMPp";
//$ip=$_SERVER['REMOTE_ADDR'];
//$response=file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$captcha."&remoteip=".$ip);
//$responsekeys=json_decode($response,true);

//if (intval($responsekeys["success"]!==1))
//echo '<h3 style="color:red;">YOU ARE NOT HUMAN</h3>';
$query="SELECT * FROM `users` WHERE `email`='$email';";
$result=mysqli_query($conn,$query);
if (mysqli_num_rows($result)==0)
{
	//echo'<script>alert("inside 3rd if")</script>';
if (strcmp($password,$cpassword)==0)
{
	//echo'<script>alert("inside 4rth if")</script>';
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
		for ($i = 0; $i < 10; $i++) 
		{
        $randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		$randomkey=$randomString;
		
	//$numquery1=mysqli_num_rows($query1);	
			$to=$email;
			$from="donotreplyFrom: <www.scholarsgo.com>";
			$subject="DO NOT REPLY TO THIS MESSAGE";
            $message="Your verification link is https://www.scholarsgo.com/accountverification.php?verificationkey";
			$message.="=$randomkey";
			$message.="&amp;email=$email";
		
		
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "tls://smtp.gmail.com:587";
		$mail->Port = 587; // or 587 or 465
		$mail->IsHTML(true);
		$mail->Username = "visitscholarsgo@gmail.com"; //Email that you setup
		$mail->Password = "01011994"; // Password
		$mail->AddReplyTo($to, 'First Last');
        $mail->AddAddress($to, 'ScholarsGo');
        $mail->SetFrom($from, 'donotreplyFrom: <www.scholarsgo.com>');
		//$mail->FromName(Scholarsgo.com);
		$mail->FromName   ='Scholarsgo';
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AddAddress("visitscholarsgo@gmail.com"); //Pass the e-mail that you setup
		
	//echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
		 if(!$mail->Send())
		    {
		    	//	echo "Mailer Error: " . $mail->ErrorInfo;
		    }
		    else if($mail->send())
		    {
		    	
				//echo $query1;
				//die();
				
				$query1=mysqli_query($conn,"INSERT INTO `users` (`username`,`password`,`email`,`resetkey`) Values('$name','$password','$email','$randomkey');");
				$query2=mysqli_query($conn,"SELECT * FROM `users` WHERE `email`='$email';");
				$fetch2=mysqli_fetch_assoc($query2);
				$userid=$fetch2['user_id'];
		
			$query2=mysqli_query($conn,"INSERT INTO `user_detail`(`user_id`, `country`, `state`, `district`, `studying`, `gender`, `status`, `about_me`, `mobile_no`, `dob`, `profile_bio`, `user_point`) VALUES ('$userid','','','','','','','','','','','0')");
		
				if($query1>0)
					{
						$responsedata=3;
						$list[]=array('response'=>$responsedata,'userid'=>$userid); 
						echo json_encode($list);
						//echo '3';
						//echo '<script>window.onload=function(){$(\'#suc\').show();}</script>';
	
	 
					}	

				else 
					{
						$responsedata=4;
						$list[]=array('response'=>$responsedata,'userid'=>0); 
						echo json_encode($list);
	
					}
				
		    }
	
	
	

}
else
{
			$responsedata=5;
			$list[]=array('response'=>$responsedata,'userid'=>0); 
			echo json_encode($list);
	//echo '5';
//echo '<script>window.onload=function(){$(\'#alreadyregistered\').show();}</script>';

}

}
else
{ 
			$responsedata=6;
			$list[]=array('response'=>$responsedata,'userid'=>0); 
			echo json_encode($list);

			//echo '6';
	//echo '<script>window.onload=function(){$(\'#unsufficientdetails\').show();}</script>';
}	
}
}
?>