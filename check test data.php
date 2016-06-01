<?php
include 'db.php';
$examid="exam56c41e8ee523a";
$q1 = "SELECT * FROM `question` WHERE `examid`='$examid' ";
	$r1 = mysql_query($q1) or die ("no query");
	$questions_array = array();
	$options_array= array();
	$answers_array = array();
	while($row1 = mysql_fetch_assoc($r1))
	{    

    foreach ($row1 as $key1 => $value1) {
      $row1["$key1"]=urldecode($value1);
    }
    $questions_array[] = $row1;
	    $qid=$row1['ques-id'];
	    echo "q_id : ".$row1['ques-id']."<br>";
	    echo "ques : ".$row1['question']."<br>";
	    $q2="SELECT * FROM `options` WHERE `ques-id`='$qid'";
	    $r2 = mysql_query($q2);
	    while ($row2 = mysql_fetch_assoc($r2)) {
        foreach ($row2 as $key2 => $value2) {
          $row2["$key2"]=urldecode($value2);
        }
	    	$options_array[] = $row2;
	    	echo "\t o_id:".$row2['option-id']." opt : ".$row2['option']."<br>";
	    }
	    $q2="SELECT * FROM `answer` WHERE `ques-id`='$qid'";
	    $r2 = mysql_query($q2);
	    while ($row2 = mysql_fetch_assoc($r2)) {
           	$options_array[] = $row2;
	    	echo "\t ans_id:".$row2['ans-id']."<br>";
	    }

	    echo "<br>\n";
	}



	?>