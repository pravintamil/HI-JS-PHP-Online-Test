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
    <script src="../js/bootstrap.min.js"  type="text/javascript"></script>
	</head>
	<body ng-app="adminapp5" ng-controller="admincntrl5">
		
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
        				<li><a href="select user.php">Selected candidates</a></li>
                <li class="active"><a href="feedback.php">Feedback</a></li>
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
                <form name="pageform" action="./feedback.php" method="POST">
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
                  <td><b>Subject</b></td>
                  <td><b>Email</b></td>
                  <td><b>Date</b></td>
                  <td><b>Time</b></td>
                  <td><b>By</b></td>
                  <td>Select</td>
                  <td></td>
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
echo "$limit<br>";
echo $_POST['limit'];
                  $result = mysql_query("SELECT * FROM `feedback` ORDER BY `feedback`.`date` DESC $limit") or die('Error');
                  $c=1;
                  while($row = mysql_fetch_array($result)) {

                    $date = $row['date'];
                    $date= date("d-m-Y",strtotime($date));
                    $time = $row['time'];
                    $subject = $row['subject'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $id = $row['id'];
                    echo '<tr>
                      <td>'.$c.'</td>';
                    echo '<td><a href="" ng-click="submit2('."'".$id."'".')" >'.$subject.'</a></td>
                          <td>'.$email.'</td>
                          <td>'.$date.'</td>
                          <td>'.$time.'</td>
                          <td>'.$name.'</td>
                          <td><input type="checkbox" ng-model="feedid['.$c++.']" ng-true-value="'."'".$id."'".'" > </td>
                    
                          ';
/*                          echo '<td>
                    
                        */
                    echo '</tr>';
                  }
                ?>
                </table>
                <button class="btn btn-success" ng-click="submit()">Remove feedback</button>
            </div>
          </div>
				</div>
    	</div>

	</body>
  <div class="ngdialog-content">
    <script type="text/ng-template" id="modalDialogId">
        <div class="ngdialog-message">
            <h3 ng-bind="modal_sub"></h3>
            <h6 ng-bind="modal_mail"></h6>
            <p ng-bind="modal_feed"></p>
        </div>
        <div class="ngdialog-buttons">
            <button type="button" class="ngdialog-button ngdialog-button-primary" ng-click="confirm()&&closeThisDialog()">Delete feedback</button>
            <button type="button" class="ngdialog-button ngdialog-button-secondary" ng-click="closeThisDialog()">Cancel</button>
        </div>
    
    </script>
  </div>
    <script type="text/javascript" src="../js/ngDialog.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/ngDialog.css">
    <link rel="stylesheet" href="../css/ngDialog-theme-default.css">
    <style type="text/css">
    .ngdialog-content {
      width: 150px;
    }
    </style>
  <script type="text/javascript">
  var app = angular.module('adminapp5', ['ngDialog']);

  app.controller("admincntrl5",function ($scope,$rootScope,$http,ngDialog){
    $scope.feedid=[];
    $scope.modalid="";
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
          feedid:$scope.feedid,
          mode:"delete_feedback"
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
    $scope.submit1=function(id){
      var loc = document.location.pathname;
      pos=loc.lastIndexOf('/');
      loc=loc.substr(0, pos);
      var http=$http({
        method:"post",
        url:"http://" + document.location.hostname + loc + "/control.php",
        data:{
          feedid:id,
          mode:"delete_single_feedback"
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
    $scope.submit2=function(feedid1){
      var loc = document.location.pathname;
      pos=loc.lastIndexOf('/');
      loc=loc.substr(0, pos);
      $scope.modalid=feedid1;
      var http=$http({
        method:"post",
        url:"http://" + document.location.hostname + loc + "/control.php",
        data:{
          feedid:feedid1,
          mode:"get_feedback"
        },
        headers:{'Content-Type':'application/x-www-form-urlencoded'}

      });
      http.success(function(data){
        if ( !data.success) {
              alert(data.err);
            } 
            else {
              $rootScope.modal_mail=data.email;
              $rootScope.modal_sub=data.sub;
              $rootScope.modal_feed=data.feed;
              $rootScope.modal_feedid=data.feedid;

              $scope.openConfirm();
            }
      }).error(function(error){
        alert("error in http");
      });
    }
    $scope.openConfirm = function () {
                ngDialog.openConfirm({
                    template: 'modalDialogId',
                    showClose: true,
                    className: 'ngdialog-theme-default'
                }).then(function () {
                    console.log('Modal promise resolved.');

                    $scope.submit1($rootScope.modal_feedid);
                }, function () {
                    console.log('Modal promise rejected.');
                });
            };




  });

  
</script>
