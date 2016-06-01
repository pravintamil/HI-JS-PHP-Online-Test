<?php 
  include("../db.php");
  session_start();
if(!(isset($_SESSION['email']))){
  header('Location: ../index.php');
}
elseif (!(isset($_SESSION['admin']))) {
  header('Location: ../exam info.php');
}
  $email=$_SESSION['email'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>HI-JS ONLINE TEST</title>
		<link  rel="stylesheet" href="../css/bootstrap.min.css"/>
 		<link  rel="stylesheet" href="../css/bootstrap-theme.min.css"/>    
 		<link rel="stylesheet" href="../css/main.css">
 		<link  rel="stylesheet" href="../css/font.css">

 		<script type="text/javascript" src="../js/jquery.js"></script>
	  	<script type="text/javascript" src="../js/shortcut.js"></script>
		<script type="text/javascript">
			shortcut.add("Esc",function() {
				},{
  				'type':'keydown',
  				'propagate':true,
  				'target':document
				});
		</script>
		<script type="text/javascript">
    
      function myFunction(){
        window.print();
      }
		</script>
		<script src="../js/jquery.min.js"></script>
    	<script src="../js/screenfull.js"></script>
		<script src="../js/angular.min.js"></script>
	<!--	<script type="text/javascript">
    		function preventBack(){window.history.forward();}
  			setTimeout("preventBack()", 0);
  			window.onunload=function(){null};
		</script>
		--><script src="../js/bootstrap.min.js"  type="text/javascript"></script>
	</head>
	<body ng-app="adminapp3" ng-controller="admincntrl3">
		
		<div class="header">
	  		<div class="row">
    			<div class="col-lg-6">
      				<span class="logo">HI-JS Online Test</span>
    			</div>
    			<div style="float: right;" class="col-md-6 ">
            <?php
                session_start();
                if(!(isset($_SESSION['email']))){
                // header("location:index.php");
                }
                else
                {
                  $name = $_SESSION['name'];
                  $email=$_SESSION['email'];
              echo '<span class="pull-right top title1" >
                  <span class="log1">
                    <span class="glyphicon glyphicon-user" aria-hidden="true">
                    </span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                  </span> 
                  <a class="log log1">'.$email.'</a>
                  &nbsp;|&nbsp;
                  <a href="userlogout.php" class="log">
                  <span class="glyphicon glyphicon-log-out" aria-hidden="true">
                  </span>
                  &nbsp;Signout</a></span>';
            }
          ?>
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
      				<a class="navbar-brand"><b>Dashboard</b></a>
    			</div>
    			<!-- Collect the nav links, forms, and other content for toggling -->
    			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      				<ul class="nav navbar-nav">
        				<li><a href="index.php">Home</a></li>
        				<li><a href="user_list.php">User</a></li>
		    		    <li><a href="rank.php">Ranking</a></li>
        				<li class="active"><a href="select user.php">Selected candidates</a></li>
                <li><a href="feedback.php">Feedback</a></li>
        				<li><a href="exams.php">Exams</a></li>
       					<li><a onclick="myFunction()" style="cursor:pointer;">Print page</a></li>
      				</ul>
          		</div><!-- /.navbar-collapse -->
  			</div><!-- /.container-fluid -->
		</nav>
    	<div class="container">
    		<div class="row">
			   	<div class="col-md-12">
            <div class="panel title">
            <form name="pageform" action="#" method="POST">
                <ul class = "pagination" id="pagination">
                <li><a ng-click="page1(1)">1</a></li>
                <input id="pagenumber" type="text" name="limit" hidden>
                <li><a ng-click="page1(2)">2</a></li>
                <li><a ng-click="page1(3)">3</a></li>
                </ul>
                </form>
              <table class="table table-striped title1" >
                  <tr style="color:red">
                    <td><b>Rank</b></td>
                    <td><b>Name</b></td>
                    <td><b>Gender</b></td>
                    <td><b>Email</b></td>
                    <td><b>Mobile</b></td>
                    <td><b>College</b></td>
                    <td>
                      <table style="width:100%">
                        <td><b>Exam type</b></td>
                        <td style="text-align:right;"><b>Score</b></td>
                        <td style="text-align:right;"><b>First</b></td>
                      </table>
                    </td>
                    <td><b>Total Score</b></td>
                    <td><b>Select</b></td>
                  </tr>
                  <?php
                  $limit="LIMIT ";
                  $a=0;
                  $b=20;
                  if(isset($_POST['limit']));{
                    $a+=$_POST['limit'];
                    $b+=$_POST['limit'];
                  }
                  $limit.=$a." , ".$b;
                    $q=mysql_query("SELECT * FROM rank  ORDER BY score DESC $limit " )or die('Error223');
                    $c=0;
                    while($row=mysql_fetch_array($q) )
                    {
                      $email=$row['email'];
                      $score=$row['score'];
                      $q12=mysql_query("SELECT * FROM user WHERE email='$email' and `status` = '1' " )or die('Error231');
                      $row=mysql_fetch_array($q12);
                      if($row['s.no']){
                        $name=$row['name'];
                        $gender=$row['gender'];
                        $college=$row['college'];
                        $mob=$row['mob']; 
                        $c++;
                        echo '<tr>
                          <td>'.$c.'</td>
                          <td>'.$name.'</td>
                          <td>'.$gender.'</td>
                          <td>'.$email.'</td>
                          <td>'.$mob.'</td>
                          <td>'.$college.'</td>';
                        $q1=mysql_query("SELECT * FROM ( SELECT * FROM history ORDER BY date DESC ) history WHERE email LIKE '$email'GROUP BY examid ");
                        echo '<td>
                               <table style="width:100%">';
                        while ($row=mysql_fetch_array($q1)) {
                        $examid=$row['examid'];
                        $q2=mysql_query("SELECT * FROM `exam` WHERE examid='$examid'");
                        $q2r=mysql_fetch_array($q2);
                        if($q2r['name']){
                          $exam=$q2r['name'];
                          $score2=$row['score'];
                          echo '<tr>';
                        }
                        else{
                          $q3=mysql_query("SELECT * FROM `z_exam` WHERE examid='$examid'");
                          $q3r=mysql_fetch_array($q3);
                          $exam=$q3r['name'];
                          $score2=$row['score'];
                          echo '<tr class="bg-danger">';
                        }
                         $q4=mysql_query("SELECT * FROM `history` WHERE `email` = '$email' AND `examid` = '$examid' ORDER BY `date` DESC ");
                          $q4r=mysql_num_rows($q4)-1;
                          echo '<td>'.$exam ." [$q4r]".'</td>
                                  <td style="">'.$score2.'</td>';
                          $q4a=mysql_fetch_array($q4);
                          echo "<td>".$q4a['score']."</td>
                          </tr>";
                      }
                        echo "</table>
                          </td>";
                        echo '<td style="text-align:center;">'.$score.'</td>
                            <td><input type="checkbox" ng-model="email['.$c.']" ng-true-value="'."'".$email."'".'" > </td>
                          </tr>';
                      }
                    }
                  ?>
                
              </table>
              <button class="btn btn-success" ng-click="submit()">Remove from selected candidates</button>
            </div>
            <script>
              function myFunction() {
                window.print();
              }
            </script>
            </div>
				  </div>
		    </div>
    	</div>

	</body>
  <script type="text/javascript">
  var app=angular.module("adminapp3",[]);
  app.controller("admincntrl3",function($scope,$http){
    $scope.email=[];
    $scope.page1=function(num){
      
      document.getElementById("pagenumber").value=(num-1)*20;
      var k=(num-1)*20;
      document.pageform.submit();

    }
    $scope.submit=function(){
      var loc = document.location.pathname;
      pos=loc.lastIndexOf('/');
      loc=loc.substr(0, pos);
      var http=$http({
        method:"post",
        url:"http://" + document.location.hostname + loc + "/control.php",
        data:{
          email:$scope.email,
          mode:"deselect_student_to_next_test"
        },
        headers:{'Content-Type':'application/x-www-form-urlencoded'}

      });
      http.success(function(data){
        if ( !data.success) {
              alert(data.err);
            } 
            else {
              location.reload();
            }
      }).error(function(error){
        alert("error in http");
      });
    }
  });
</script>