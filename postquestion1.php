<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
//echo "hello".$json;
$json= stripslashes ( $json );
$decodedText = html_entity_decode($json);
//echo $decodedText;
$obj = json_decode($json);
$error = json_last_error();
//echo $obj->newquestion . $error;

if (strcmp($obj->newquestion,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			$txt=mysqli_real_escape_string($conn,htmlspecialchars($obj->newquestion));
			
			//$lower_txt=strtolower($txt);
			$user_id=$obj->sessionuserid;
			//$postdate=$obj->postdate;
			//$fetch_tag=mysqli_fetch_assoc['tag_name'];
			//$post_time=$_POST['question_post_time'];
			$query1=mysqli_query($conn,"INSERT INTO `user_question`(`user_id`,`question`)VALUES('$user_id','$txt');");
			if (!$query1)
			{
				
				echo("Error description: " . mysqli_error($conn));
			}
			//echo $query1;
			$query_id=mysqli_query($conn,"SELECT * FROM `user_question` order by `q_id` desc limit 1;");
			$fetch_id=mysqli_fetch_assoc($query_id);
			$qid=$fetch_id['q_id'];
			$query_name=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='$user_id';");
			$fetch_name=mysqli_fetch_assoc($query_name);
			$username=$fetch_name['username'];
			$query_pic=mysqli_query($conn,"SELECT * from `user_profile_pic` WHERE `user_id`='$userid';");
			$fetch_pic=mysqli_fetch_assoc($query_pic);
			$profilepic=$fetch_pic['pic_path'];
			if (strcmp($profilepic,'')!=0)
				$userpic=$profilepic;
			else
				$userpic="Avatar.jpg";
			 $txt=htmlspecialchars_decode($obj->newquestion);
			$list[]=array('qid'=>$qid,'userid'=>$user_id,'username'=>$username,'userpic'=>$userpic,'question'=>$txt);
			/*$query_tag=mysqli_query($conn,"SELECT * FROM `user_question_tag`;");
			while ($fetch_tag=mysqli_fetch_assoc($query_tag))
			{
					$tag_name=$fetch_tag['tag_name'];
					if (stripos($txt,$tag_name)!==false)
					{
						$query_question_id=mysqli_query($conn,"SELECT * FROM `user_question` where `question`='$txt';");
						$fetch_question_id=mysqli_fetch_assoc($query_question_id);
						$question_id=$fetch_question_id['q_id'];
						$tag_id=$fetch_tag['tag_id'];
						$query_multilink=mysqli_query($conn,"INSERT INTO `user_multilink`(`q_id`,`tag_id`) VALUES ('$question_id','$tag_id');");
						
						
					}
			}*/	
		//$priority=$_POST['priority'];
			
			//echo '<script>alert("'.$query1.'")</script>';
			
		}
		
echo json_encode($list);		

?>