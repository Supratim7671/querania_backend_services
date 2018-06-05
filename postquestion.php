<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

if (strcmp($obj->newquestion,'')!=0)
		{
			//echo '<script>alert("Posting in database")</script>';
			$txt=mysqli_real_escape_string($conn,htmlspecialchars($obj->newquestion));
			//$lower_txt=strtolower($txt);
			$user_id=$obj->sessionuserid;
			$postdate=$obj->postdate;
			//$fetch_tag=mysqli_fetch_assoc['tag_name'];
			//$post_time=$_POST['question_post_time'];
			$query1=mysqli_query($conn,"INSERT INTO `user_question`(`user_id`,`question`,`question_date`)VALUES('$user_id','$txt','$postdate');");
			
			$query_tag=mysqli_query($conn,"SELECT * FROM `user_question_tag`;");
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
			}	
		//$priority=$_POST['priority'];
			
			//echo '<script>alert("'.$query1.'")</script>';
		}
		
		echo $user_id;

?>