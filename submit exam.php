<?php 
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata,true);
    $email=$request['mail'];
    $answers=$request['ans'];
    $examid=$request['examid'];
    $score_tot=0;
    echo "<br>";
    $i=0;
    $score=0;
    $temp;
    include 'db.php';
    foreach ($answers as $value) {
    	$quesid=$value['ques-id'];
    	$ansid=$value['ans-id'];
    	$q="SELECT * FROM  `answer` WHERE  `ques-id` LIKE  '$quesid'AND  `ans-id` LIKE  '$ansid'";
    	$exec=mysql_query($q);
    	$row=mysql_num_rows($exec);
    	if($row)
    		$score++;		
	}
$data="Score $score<br/> Email $email <br/> Examid : $examid <br/>";

//insert score into history table
	//$q1 = mysql_query("SELECT * FROM `history` WHERE `email` LIKE '$email' AND `eid` LIKE '$eid'");
	//if( mysql_num_rows($q1) > 0) {
    //	mysql_query("DELETE FROM `history` WHERE `email` LIKE '$email' AND `eid` LIKE '$eid' ");
	//}
	mysql_query("INSERT INTO `history`(`email`, `examid`, `score`) VALUES ('$email','$examid','$score')");
$data.="Score :$score<br/>";
//insert total score into  rank table
	$q2 = mysql_query("SELECT * FROM `rank` WHERE `email` LIKE '$email' ");
	if( mysql_num_rows($q2) > 0) {
		mysql_query("DELETE FROM `rank` WHERE `email` LIKE '$email' ");
	}
	$q3 = mysql_query("SELECT * FROM ( SELECT * FROM history WHERE `email` LIKE '$email' ORDER BY date DESC ) history GROUP BY examid");
	while ($r1=mysql_fetch_array($q3)) {
		$score_tot=$score_tot+$r1['score'];
        $eeeeid=$r1['examid'];
        $data.="Tot score:$score_tot<br/>eid:$eeeeid<br/>";
	}
	mysql_query("INSERT INTO `rank`(`email`, `score`) VALUES ('$email','$score_tot')");
//set user inactive
	$q4 = mysql_query("UPDATE `user` SET `status`='0' WHERE `email`='$email' ");
echo "$data";

?>