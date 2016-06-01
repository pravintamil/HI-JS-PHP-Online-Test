<?php 
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata,true);
    $email = $request['email'];
    $name = $request['name'];
	$subject=$request['sub'];
	$feed=$request['feed'];
	$date=date("Y-m-d");
	$time=date("h:i:sa");
	if(empty($email)){
    	$error="email is required";
    }
    elseif(filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) === false){
   		$error="email address is invalid";
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
            $id=uniqid("feed");
        	mysql_query("INSERT INTO `feedback`(`id`,`name`, `email`, `subject`, `feedback`, `date`, `time`) VALUES ('$id','$name','$email','$subject','$feed','$date','$time')");
        	$data['success']=true;
        }

    	if ( ! empty($error)) {
        	$data['success'] = false;
        	$data['err']  = $error;
    	}    
	}
	echo json_encode($data);
?>