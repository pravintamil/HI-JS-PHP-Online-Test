<?php
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $email=$request->mail;
    $password=$request->pass;
    $email.="@gmail.com";
    if($email=="@gmail.com"){
    	$error="mail is required ";
    }
    elseif(filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) === false){
   		$error="$email is not a valid email address ";
    }
    elseif (empty($password)) {
    	$error="password is required ";
    }
 /*   elseif (filter_var($password, FILTER_VALIDATE_INT, array("options" => array("min_range"=>7000000000, "max_range"=>9999999999))) === false){
    	$error="$phone is not a valid password ";
    }*/
    function clean($str) {
   		$str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
   		$str = preg_replace('/[^A-Za-z0-9\ ]/', '', $str);
   		return $str;
	}
	if (!empty($error)) {
    	$data['success']=false;
    	$data['err']=$error;
    }
    else{
    	$data['success']=false;
      	include("db.php");
        if(!$con){
            $error = 'There was error in connection to DataBase';        
        }
        else{
            $email=strtolower($email);
            $pass=md5($password);
            $qr=mysql_fetch_array( mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$email';"));
            if($qr['s.no']){
                if($qr['email-verify']==0){
                    $error="Please verify your mail";
                }
                elseif($qr['status']==0||$qr['login']==1){
                    $error="Access denied";
                }
                    
                else{
                    $query=mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$email' AND binary `password` LIKE '$pass'");
                    $row=mysql_fetch_array($query);
                    if($row){
                        $data['success']=true;
                        $data['message']="you logged in success fully ";
                        $data['email']="$email";
                        mysql_query("UPDATE `user` SET `login`=0 WHERE `email` LIKE '$email'");
                        session_start();
                        $_SESSION["email"]=$email;
                        $_SESSION['name']=$row['name'];
                    }
                    else{
                        $error="please check username or password";
                    }
                }
                    
            }
            else{
                $error="mail not in database";
            }
        }
    	if ( ! empty($error)) {
        	$data['success'] = false;
        	$data['err']  = $error;
    	}
	}
echo json_encode($data);

?>