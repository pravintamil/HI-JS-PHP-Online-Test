<?php
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    include '../db.php';
    $mode=$request->mode;
    if (isset($mode)) {
    	if($mode=="active_inactive"){
    		$data['success'] = false;
    		$examids=$request->examid;
				foreach ($examids as $examid) {
					$q=mysql_query("SELECT * FROM `exam` WHERE `examid` = '$examid'");
					$row=mysql_fetch_array($q);
					if($row['status']){
						$status=0;
					}
					else{
						$status=1;
					}
    				$q1=mysql_query("UPDATE `exam` SET `status`='$status' WHERE `examid`='$examid'");
    				if($q1)
    					$data['success']=true;
				}
				
				$data['err']  ="Error";
    	}
    	elseif ($mode=="delete_user") {
    		$data['success'] = false;
    		$email=$request->email;
    		$q=mysql_query("INSERT INTO `z_user`(`uniqid`, `name`, `gender`, `college`, `mob`, `email`, `password`, `rollno`, `status`, `eid`, `email-verify`, `fname`) 
                SELECT `uniqid` , `name` , `gender` , `college` , `mob` , `email` , `password` , `rollno` , `status` , `eid` , `email-verify` , `fname` FROM `user` WHERE `email` LIKE '$email';");
    		$q1=mysql_query("DELETE FROM `user` WHERE `email` LIKE '$email';");
    		$q2=mysql_query("INSERT INTO `z_rank`(`email`, `score`, `time`)SELECT `email`, `score`, `time` FROM `rank` WHERE `email` LIKE '$email';");
    		$q3=mysql_query("DELETE FROM `rank` WHERE `email` LIKE '$email';");
    		$q4=mysql_query("INSERT INTO `z_history`(`email`, `examid`, `score`, `date`) SELECT `email`, `examid`, `score`, `date` FROM `history` WHERE `email` LIKE '$email'");
    		$q5=mysql_query("DELETE FROM `history` WHERE `email` LIKE '$email'");
    		$data['success'] = true;
    	}

        elseif ($mode=="delete_exam") {
            $data['success'] = false;
            $examid=$request->examid;
            $q_e=mysql_query("INSERT INTO `z_exam`(`examid`, `name`, `questions`, `duration`, `created time`, `instruction`, `status`)
                SELECT `examid`, `name`, `questions`, `duration`, `created time`, `instruction`, `status` FROM `exam` WHERE `examid` LIKE '$examid'");
            $q1=mysql_query("SELECT * FROM `question` WHERE `examid` LIKE '$examid'");
            while ($row=mysql_fetch_array($q1)) {
                $qid=$row['ques-id'];
                $q_q=mysql_query("INSERT INTO `z_question`(`examid`, `ques-id`, `question`, `choice`)
                    SELECT `examid`, `ques-id`, `question`, `choice` FROM `question` WHERE `ques-id` LIKE '$qid'");
                $q2=mysql_query("SELECT * FROM `options` WHERE `ques-id` LIKE '$qid'");
                while ($row1=mysql_fetch_array($q2)) {
                    $q_o=mysql_query("INSERT INTO `z_options`(`ques-id`, `option`, `option-id`)
                        SELECT `ques-id`, `option`, `option-id` FROM `options` WHERE `ques-id` LIKE '$qid'");
                    $q3=mysql_query("SELECT * FROM `answer` WHERE `ques-id` LIKE '$qid'");
                    while ($row2=mysql_fetch_array($q3)) {
                        $q_a=mysql_query("INSERT INTO `z_answer`(`ques-id`, `ans-id`) 
                            SELECT `ques-id`, `ans-id` FROM `answer` WHERE `ques-id` LIKE '$qid'");
                        $q_a_d=mysql_query("DELETE FROM `answer` WHERE `ques-id` LIKE '$qid'");
                    }
                    $q_o_d=mysql_query("DELETE FROM `options` WHERE `ques-id` LIKE '$qid'");
                }
                $q_q_d=mysql_query("DELETE FROM `question` WHERE `ques-id` LIKE '$qid'");
            }
            $q_e_d=mysql_query("DELETE FROM `exam` WHERE `examid` LIKE '$examid'");
            $data['success'] = true;
        }
        elseif ($mode=="delete_feedback") {
            $data['success'] = false;
            $feedids=$request->feedid;
            $data['err']  ="Error";
            foreach ($feedids as $feedid) {
                $q1=mysql_query("INSERT INTO `z_feedback`(`id`, `name`, `email`, `subject`, `feedback`, `date`, `time`) SELECT `id`, `name`, `email`, `subject`, `feedback`, `date`, `time` FROM `feedback` WHERE `id` LIKE '$feedid'");
                $q2=mysql_query("DELETE FROM `feedback` WHERE `id` LIKE '$feedid'");
                if($q2){
                    $data['success']=true;
                }
            }
        }
        elseif ($mode=="delete_single_feedback") {
            $data['success'] = false;
            $feedid=$request->feedid;
            $data['err']  ="Error";
            $q1=mysql_query("INSERT INTO `z_feedback`(`id`, `name`, `email`, `subject`, `feedback`, `date`, `time`) SELECT `id`, `name`, `email`, `subject`, `feedback`, `date`, `time` FROM `feedback` WHERE `id` LIKE '$feedid'");
            $q2=mysql_query("DELETE FROM `feedback` WHERE `id` LIKE '$feedid'");
            if($q2){
                $data['success']=true;
            }
        }
        elseif ($mode=='get_feedback') {
            $data['success'] = false;
            $feedid=$request->feedid;
            if($row=mysql_fetch_array(mysql_query("SELECT * FROM `feedback` WHERE `id` LIKE '$feedid'"))){
                $data['feed']=$row['feedback'];
                $data['sub']=$row['subject'];
                $data['email']=$row['email'];
                $data['feedid']=$feedid;
                $data['success']=true;    
            }
            else{
                $data['err']="error";
            }
            
        }
        elseif ($mode=="get_all_feed") {
            $data['success'] = false;
            $result = mysql_query("SELECT * FROM `feedback` ORDER BY `feedback`.`date` DESC") or die('Error');
            while($row = mysql_fetch_assoc($result)) {
                $feedback[]=$row;
                $data['success']=true;
            }
            $data['feedback']=$feedback;
        }
        elseif ($mode=="set_user_active"){
            $data['success'] = false;
            $email=$request->email;
            $q=mysql_query("UPDATE `user` SET `status`='1' WHERE `email` LIKE '$email'");
            if($q)
                $data['success']=true;
        }
        elseif ($mode=="select_student_to_next_test"){
            $data['success'] = false;
            $emails=$request->email;
            foreach ($emails as $email) {
                $q=mysql_query("UPDATE `user` SET `status`='1' WHERE `email` LIKE '$email'");
                if($q)
                    $data['success']=true;
            }
        }
        elseif ($mode=="deselect_student_to_next_test"){
            $data['success'] = false;
            $emails=$request->email;
            foreach ($emails as $email) {
                $q=mysql_query("UPDATE `user` SET `status`='0' WHERE `email` LIKE '$email'");
                if($q)
                    $data['success']=true;
            }
        }
    }
    echo json_encode($data);
?>