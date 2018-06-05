<?php
include 'configuration.php';
$json = file_get_contents('php://input');
//echo '<script>alert("hello");</script>';
//echo '<script>alert("'.$json.'")</script>';
$obj = json_decode($json);

//$btnno=$obj->btnno;
//$btnno1=$obj->btnno1;




if ($obj->editqbtn==1 and strcmp($obj->ques,'')!=0)
		{
			$questiontxt=$obj->ques;
			$txt=mysqli_real_escape_string($conn,htmlspecialchars($questiontxt));
			$qid=$obj->id;
			$sessionuserid=$obj->sessionuserid;
			
			//$user_id=intval($_POST['user_id']);
			//$priority=$_POST['priority'];
			//$post_time=$_POST['question_post_time'];
			$query1=mysqli_query($conn,"UPDATE `user_question` set `question`='$txt' where `user_id`='$sessionuserid' and `q_id`='$qid';");
			//$query2=mysqli_query($conn,"SELECT * FROM `user_question` WHERE `user_id`='$sessionuserid' and `q_id`='$qid';");
			//$fetch2=mysqli_fetch_assoc($query2);
			//$posttime=$fetch2['question_date'];
			
		//	$list4[]=array('q_id'=>$qid,'user_id'=>$sessionuserid,'question'=>$txt,'question_date'=>$posttime);
		
		}


?>