<?php
$mail= $_GET["mail"];
$mail=urldecode($mail);
$uniq= $_GET["id"];
include('db.php');
$q="SELECT * FROM `user` WHERE `email` LIKE '$mail' AND `uniqid` LIKE '$uniq'";
$row=mysql_fetch_array(mysql_query($q));
if($row){
	$q1=mysql_query("UPDATE `user` SET `email-verify` = '1' WHERE `email` LIKE '$mail'");header('Location: index.php');
}


?>