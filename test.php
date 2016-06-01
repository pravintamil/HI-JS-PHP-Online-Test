<?php 
  include 'db.php'; 
  session_start();
  if(!(isset($_SESSION['email']))){
    header('Location: index.php');
  }
  if (isset($_SESSION['admin'])) {
    header('Location: admin/index.php');
  }
  $email=$_SESSION['email'];
  $examid=$_GET["examid"];
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
      $ques_id_array[]=$qid;
	    $q2="SELECT * FROM `options` WHERE `ques-id`='$qid'";
	    $r2 = mysql_query($q2);
	    while ($row2 = mysql_fetch_assoc($r2)) {
        foreach ($row2 as $key2 => $value2) {
          $row2["$key2"]=urldecode($value2);
        }
	    	$options_array[] = $row2;
	    }
	}
	shuffle($questions_array);
  shuffle($options_array);
  shuffle($ques_id_array);
	$detail_array['email']="pravindotin@gmail.com";
	$detail_array['eid']=$examid;
	$js_d= json_encode($detail_array);
	$js_q= json_encode($questions_array);
  $js_o= json_encode($options_array);
  $js_q_id= json_encode($ques_id_array);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>KNONEX || HIRING TEST 2016</title>
		<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 		<link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 		<link rel="stylesheet" href="css/main.css">
 		<link  rel="stylesheet" href="css/font.css">
    <style type="text/css">
    #choice{
      width: 60%;
      }
    </style>

 		<script type="text/javascript" src="js/jquery.js"></script>

  <script type="text/javascript" src="js/js.cookie.js"></script>
	  <script type="text/javascript" src="js/shortcut.js"></script>
		<script type="text/javascript">
      shortcut.add("Esc",function() {
          
        },{
          'type':'keydown',
          'propagate':false,
          'target':document
        });
      var mail=<?php echo "'".$_SESSION['email']."';";?>
      if(mail!=window.name){
        var loc = document.location.pathname;
        pos=loc.lastIndexOf('/');
        loc=loc.substr(0, pos);
        window.location="http://" + document.location.hostname + loc + "/error.php";
      }
      // shortcut.add("ctrl",function() {
          
      //   },{
      //     'type':'keydown',
      //     'propagate':false,
      //     'target':document
      //   });
		</script>
  
		<script type="text/javascript">
      var questions= <?php echo $js_q;?>;
      var questions_id= <?php echo $js_q_id;?>;
			var options= <?php echo $js_o;?>;
			var detail= <?php echo $js_d;?>;
			var answers=[];
			var skipped_ques=[];
      var answered_ques=[];
			var skip_act=0;
			var index;
			var answered,skipped;
		</script>
		<script src="js/jquery.min.js"></script>
    	<script src="js/screenfull.js"></script>
		<script src="js/angular.min.js"></script>
		<script src="js/bootstrap.min.js"  type="text/javascript"></script>

    <script type="text/javascript">
      window.history.forward();
      function prevent()
      {
        window.history.forward(); 
      }
    </script>
	</head>

	<body id="testpage" onkeydown="return (event.keyCode == 154)" onload="prevent;" oncontextmenu="return false;">
		<div class="header">
	  		<div class="row">
    			<div class="col-lg-6">
      				<span class="logo">Knonex Hiring Test 2016</span>
    			</div>
    			<div class="col-md-4 col-md-offset-2">
	    			
    			</div>
  			</div>	
		</div>
		<nav class="navbar navbar-default title1">
  		<div class="container-fluid">
    	<!-- Brand and toggle get grouped for better mobile display -->
    		<div class="navbar-header">
      		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
      			<span class="sr-only">Toggle navigation</span>
      			<span class="icon-bar"></span>
      			<span class="icon-bar"></span>
      			<span class="icon-bar"></span>
      		</button>
      		<a class="navbar-brand" href="#"><b>Knonex</b></a>
    		</div>

    		<!-- Collect the nav links, forms, and other content for toggling -->
    		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      		<ul  ng-app="app" ng-controller="pravCtrl" class="nav navbar-nav">
            <li><a>Email : <?php echo "$email";?></a></li>
            <li><a><span id="answered"></span></a></li>
            <li><a><span id="skipped"></span></a></li>
            <li><a href="" id="check"></a></li>
            <li ng-show='countDown_text >= 300'><a>Time left : {{countDown_min}}min {{countDown_sec}}sec</a></li>
            <li ng-show='countDown_text < 300'><a>Please complete test. Only <span style="color:#ff3333">{{countDown_min}}min {{countDown_sec}}sec</span> left</a></li>
            </div>
      		</ul>     
      	</div><!-- /.navbar-collapse -->
  		</div><!-- /.container-fluid -->
    </nav>
   	  <div class="container"><!--container start-->
		    <div class="row">
        		<div class="col-md-12">
        		<?php
        			$q5=mysql_query("SELECT `duration` FROM `exam` WHERE `examid` LIKE '$examid'");
        			$q5= mysql_fetch_array($q5);
        			$time=$q5['duration']*60;

        		?>
        			<div  class="panel" style="margin:5%">
        				<div style="width:30%;float:right;text-align: right; " ng-show='countDown_text > 0' style='float:right'>
        					
        					<br>
        					<ul class = "pagination" id="pagination">
   						   </ul>

        				</div>
        				<div style="font-weight: 600;" id="question.no"></div><br>
						    <div>
            <label  id="question"></label>      
                </div>
    						<div style="width=60%"id="choice"></div>
	    		  		<div id="button"></div>
	 	     				<div id="ans"></div>
	   	   				<div id="status"></div>
				     		<br />
					   </div>
        		</div>
        	</div>
		</div>
	</body>
	<script>
    var app=angular.module("app",[]);
    app.controller("pravCtrl",function($scope, $timeout,$window) {
      var countDowner, countDown;
      <?php
        echo "countDown=$time;";
      ?>
      var time=Cookies.get('time')
          if(time){
            countDown=time;
          }
      countDowner = function() {
        if (countDown < 1) {
          countDown = 0;
          $scope.countDown_text = countDown;
          $timeout(ajax_post(), 500);
          return; // quit
        } else {// update scope
          var test=(countDown/60);
          $scope.countDown_text = countDown;
          $scope.countDown_min=Math.floor(test);
          $scope.countDown_sec=countDown%60;
          countDown--; // -1
          Cookies.set("time",countDown);
          $timeout(countDowner, 1000); // loop it again
        }
      };
      $scope.countDown_text = countDown;
      countDowner()
    })
    function ajax_post(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "submit exam.php";
    var email=<?php echo "'$email'";?>;
    var examid=<?php echo "'$examid'";?>;
    var vars=JSON.stringify({ 'ans': answers, 'mail': email, 'examid':examid })
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
      if(hr.readyState == 4 && hr.status == 200) {
        var return_data = hr.responseText;
        Cookies.remove('questions');
        Cookies.remove('detail');
        Cookies.remove('answered_ques');
        Cookies.remove('answers');
        Cookies.remove('answered');
        Cookies.remove('skipped');
        Cookies.remove('skipped_ques');
        Cookies.remove('time');
        Cookies.remove('current');
      window.location="feedback.php";
      }
    }
    console.log(vars);
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status").innerHTML = "processing...";
}
  /*function ajax_post1(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "submit exam.php";
    var email=<?php echo "'$email'";?>;
    var examid=<?php echo "'$examid'";?>;
    var vars=JSON.stringify({ 'ans': answers, 'mail': email, 'examid':examid,'reload':1 })
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
      if(hr.readyState == 4 && hr.status == 200) {
        var return_data = hr.responseText;
      //document.getElementById("status").innerHTML = return_data;
      window.location="feedback.php";
      }
    }
    console.log(vars);
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status").innerHTML = "processing...";
}
*/
  </script>
  <script type="text/javascript" src="test.js"></script>
  <script type="text/javascript">

  </script>
  <style type="text/css">
 		label{
 			font-weight: normal;
 			text-decoration: none;
 		}
 		button{
 			margin-right: 5px;
 		}

 		</style>

</html>




