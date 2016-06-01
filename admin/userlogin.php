<?php
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $email=$request->mail;
    $password=$request->pass;
    
    if(empty($email)){
    	$error="mail is required ";
    }
    elseif(filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) === false){
   		$error="email address is invalid ";
    }
    elseif (empty($password)) {
    	$error="password is required ";
    }
    elseif ($password!=clean($password)){
    	$error="password is invalid ";
    }
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
      	include("../db.php");
        if(!$con){
            $error = 'There was error in connection to DataBase';        
        }
        else{
            $pass=$password;
            $email=strtolower($email);
            $qr=mysql_fetch_array( mysql_query("SELECT * FROM `admin` WHERE `mail` LIKE '$email';"));
            if($qr['s.no']){
                    $query=mysql_query("SELECT * FROM `admin` WHERE `mail` LIKE '$email' AND binary `pass`  LIKE '$pass'");
                    if(mysql_fetch_array($query)){
                        $data['success']=true;
                        $data['message']="you logged in success fully ";
                        session_start();
                        $_SESSION["email"]=$email;
                        $_SESSION["admin"]="admin";
                    }
                    else{
                        $error="please check username or password";
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