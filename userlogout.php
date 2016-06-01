<?php
	include("db.php");
	session_start();
	$email=$_SESSION['email'];
	session_unset();
	session_destroy();
	mysql_query("UPDATE `user` SET `login`=0 WHERE `email` LIKE '$email'");
	header('Location: index.php');
?>