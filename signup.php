<?php
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $name=$request->name;
    $fname=$request->fname;
    $gender=$request->gender;
    $email=$request->mail;
    $college=$request->clg;
    $phone=$request->phone;
    $rollno=$request->regno;
    $name=rtrim($name);
    $fname=rtrim($fname);
    $college=rtrim($college);
    $email.="@gmail.com";

    if (empty($name)) {
    	$error = 'name is required ';
    }
    elseif ($name!=clean($name)) {
    	$error="$name is not a valid name";
    }
    elseif (empty($fname)) {
    	$error = 'name is required ';
    }
    elseif ($fname!=clean($fname)) {
    	$error="$name is not a valid name";
    }

    elseif(empty($gender)){
    	$error='gender is required ';
    }
    elseif(($gender!="male")&&($gender!="female")){
    	$error="$gender is not a valid gender";
    }

    elseif(empty($email)){
    	$error="mail is required ";
    }
    elseif(filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) === false){
   		$error="$email is not a valid email address ";
    }
    elseif (empty($phone)) {
    	$error="phone number is required ";
    }
   // elseif (filter_var($phone, FILTER_VALIDATE_INT, array("options" => array("min_range"=>7000000000, "max_range"=>9999999999))) === false){
    //	$error="$phone is not a valid phone number ";
    //}
    elseif(empty($college)) {
    	$error="college name is required ";
    }
    elseif($college!=clean($college)){
    	$error="$college is not a valid college name";
    }
    elseif(empty($rollno)){
    	$error="roll number is required";
    }
    elseif ($rollno!=clean($rollno)) {
    	$error="$rollno is not a valid roll number";
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
      	include("db.php");
        if(!$con){
            $error['db'] = 'There was error in connection to DataBase';        
        }
        else{
            $query=mysql_fetch_array(mysql_query("SELECT * FROM `user` WHERE `email`='$email' OR `mob`='$phone' OR `rollno`='$rollno'"));
            if($query){
            	$error="User already registered";
            }
            else{
            	$uniq=uniqid("knx0std");
            	$pass=md5($phone);
            	$query=mysql_query("INSERT INTO `user`(`uniqid`, `name`, `fname`, `gender`, `college`, `mob`, `email`, `password`, `rollno`, `status`, `login`, `email-verify`) VALUES ('$uniq','$name','$fname','$gender','$college','$phone','$email','$pass','$rollno',0,0,0)");
           		 if($query){
            		$data['success']=true;
					$data['message']="Signup completed successfuly";
                    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";$str=substr($actual_link, 0, strrpos($actual_link, '/'));
                    $message="<h3>Email Confirmation</h3><br>
                    Instruction:<br><br>
                    Username:Your Email Id<br>
                    Password:Your Mobile Number<br><br>
                    Please click the below link to verify your mail address<br>";
                    $email1=urlencode($email);
                    $url="$str"."/verify.php?"."mail="."$email1"."&id=$uniq";
                    $message=$message."<a href='$url'>$url</a>";
                    include 'mail.php';
				}
				else{
					$data['success']=false;
					$error="Error in insert into Database";
				}	
			}
		}
    	if ( ! empty($error)) {
        	$data['success'] = false;
        	$data['err']  = $error;
    	}
	}
echo json_encode($data);

?>