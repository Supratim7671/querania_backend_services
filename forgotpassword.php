 
<?php

include "configuration.php";
//include "smtpwork.php";
include "PHPMailerAutoload.php";
include "class.phpmailer.php";

$json = file_get_contents('php://input');
$obj = json_decode($json);
 
 if(($obj->forgotbtn==1) and strcmp($obj->femail,'')!=0)
	{
		$result=mysqli_query($conn,"SELECT * FROM `users` WHERE `email`='".$obj->femail."';");
		if($result and mysqli_num_rows($result)==1)
		{
			//$acode='';
			//for($i = 0; $i < 10; $i++) {
			//	$acode .= mt_rand(0, 9);
		//	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		//	$charactersLength = strlen($characters);
		//	$randomString = '';
		//for ($i = 0; $i < 10; $i++) 
		//{
       // $randomString .= $characters[rand(0, $charactersLength - 1)];
		//}
		$fetch=mysqli_fetch_assoc($result);
		$resetkey=$fetch['resetkey'];
		}
			$email=test_input($obj->femail);
			//$pass=$randomString;
			//$password=hashing($pass,$email);
			$to=$email;
			$from="donotreplyFrom: <www.scholarsgo.com>";
			$subject="DO NOT REPLY TO THIS MESSAGE";
            $message="Your password reset link is https://www.scholarsgo.com/resetpassword.php?resetkey";
			$message.="=$resetkey";
			$message.="&amp;email=$email";
		
	// response if there are errors
	if ( ! empty($errors)) {
		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
		
	} else {
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
        $mail->AddAddress($to, 'Supratim');
        $mail->SetFrom($from, 'donotreplyFrom: <www.scholarsgo.com>');
		$mail->FromName ='Scholarsgo';
		$mail->Subject = $subject;
		$mail->Body =$message;
		$mail->AddAddress("visitscholarsgo@gmail.com"); //Pass the e-mail that you setup
		
	//echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
		 if(!$mail->Send())
		    {
		    		echo "Mailer Error: " . $mail->ErrorInfo;
		    }
		    else if($mail->send())
		    {
		    	echo "1";
				//$data['success'] = true;
	    		//$data['message'] = 'Thank you for sending e-mail.';
		    }
		
	}
	//echo json_encode($data);
	}
	

			
			
			
		
		
		
		?>