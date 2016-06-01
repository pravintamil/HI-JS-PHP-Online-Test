<?php
session_start();
if(!(isset($_SESSION['email']))){
  header('Location: ../index.php');
}
elseif (!(isset($_SESSION['admin']))) {
  header('Location: ../exam info.php');
}
  $email=$_SESSION['email'];
  include("../db.php");
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
	<body ng-app="adminapp1">
		
		<div class="header">
	  		<div class="row">
    			<div class="col-lg-6">
      				<span class="logo">HI-JS Online Test</span>
    			</div>
    			<div style="float: right;" class="col-md-6 ">
            <?php
                if(!(isset($_SESSION['email']))){
                // header("location:index.php");
                }
                else
                {
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
        				<li class="active"><a href="./">Home<span class="sr-only">(current)</span></a></li>
        				<li><a href="user_list.php">User</a></li>
	               <li><a href="rank.php">Ranking</a></li>
        				<li><a href="select user.php">Selected candidates</a></li>
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
		      <div ng-controller="admincntrl1" class="panel">
          <form name="pageform" action="#" method="POST">
                <ul class = "pagination" id="pagination">
                <li><a ng-click="page1(1)">1</a></li>
                <input id="pagenumber" type="text" name="limit"hidden >
                <li><a ng-click="page1(2)">2</a></li>
                <li><a ng-click="page1(3)">3</a></li>
                </ul>
                </form>
            <table class="table table-striped title1">
                <tr>
                  <td><b>S.N.</b></td>
                  <td><b>Title</b></td>
                  <td class="col-md-1"><b>questions/ marks</b></td>
                  <td><b>Time limit</b></td>
                  <td><b>Created on</b></td>
                  <td><b>Status</b></td>
                  <td><button  class="btn btn-success" ng-click="submit()">Set</button></td>
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
                  $result = mysql_query("SELECT * FROM `exam` ORDER BY `created time` DESC $limit") or die('Error');
                  $c=0;
                  while($row = mysql_fetch_array($result)) {
                    $examid = $row['examid'];
                    $title = $row['name'];
                    $total = $row['questions'];
                    $duration = $row['duration'];
                    $info = $row['instruction'];
                    $date = $row['created time'];
                    $status=$row['status'];
                    if ($status) {
                      $status="active";
                    }
                    else{
                      $status="inactive";
                    }
                    $c++;
                    echo '<tr>
                    <td>'.$c.'</td>
                    <td>'.$title.'</td>
                    <td>'.$total.'</td>
                    <td>'.$duration.'min</td>
                    <td>'.$date.'</td>
                    <td>'.$status.'</td>
                    <td><input type="checkbox" ng-model="examid['.$c.']" ng-true-value="'."'".$examid."'".'" > </td>
                    </tr>';
                  }
                  $c=0;
                ?>
            </table>

          </div>

				</div>
			</div>
    </div>
      <script type="text/javascript">
  var app=angular.module("adminapp1",[]);
  app.controller("admincntrl1",function($scope,$http){
    $scope.examid=[];
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
          examid:$scope.examid,
          mode:"active_inactive"
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
	</body>
