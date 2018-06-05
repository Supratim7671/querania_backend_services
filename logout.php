<?php
include 'configuration.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
$sessionuserid=$obj->sessionuserid;
mysqli_query($conn,"UPDATE `users` set `online`='no' where `user_id`='$sessionuserid';");
//session_start();
//session_destroy();
//header("Location: admin_login.php");
?>