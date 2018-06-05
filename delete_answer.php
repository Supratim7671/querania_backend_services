<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);
$userid=$obj->sessionuserid;
if ($obj->delabtn==1)
	{
		//echo '<script>if (confirm("Press a button!") == true)</script>';
		//{
			$answerid=$obj->answerid;
			$qid=$obj->qid;
		//echo '<script>alert("In the delete reply box"+"'.$q_id.'");</script>';
		$query=mysqli_query($conn,"DELETE FROM `user_question_answer` WHERE `answer_id`='$answerid' and `q_id`='$qid' and `user_id`='$userid';");
		//echo '<script>alert("'.$query.'")</script>';
	}
	
	?>