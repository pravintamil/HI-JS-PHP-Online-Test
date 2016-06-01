<?php 
	include 'db.php';	
	session_start();
	if(!(isset($_SESSION['email']))){
		header('Location: index.php');
	}
	if (isset($_SESSION['admin'])) {
 		header('Location: admin/index.php');
	}
?>
<html ng-app="app1" data-ng-controller="cntrl1" data-ng-init="init()" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>HI-JS ONLINE TEST</title>
		<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 		<link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 		<link rel="stylesheet" href="css/main.css">
 		<link  rel="stylesheet" href="css/font.css">

 		<script type="text/javascript" src="js/js.cookie.js"></script>
 		<script type="text/javascript" src="js/jquery.js"></script>
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
		</script>
		<script type="text/javascript">
		</script>
		<script src="js/jquery.min.js"></script>
    	<script src="js/screenfull.js"></script>
		<script src="js/angular.min.js"></script>
	<!--	<script type="text/javascript">
    		function preventBack(){window.history.forward();}
  			setTimeout("preventBack()", 0);
  			window.onunload=function(){null};
		</script>
		--><script src="js/bootstrap.min.js"  type="text/javascript"></script>
	</head>
	<body id="body">
		
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
      				<a class="navbar-brand" href="#"><b>Knonex</b></a>
    			</div>
    			<!-- Collect the nav links, forms, and other content for toggling -->
    			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      				<ul class="nav navbar-nav">
      					<li class="active" ><a><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
      					<li><a><?php echo $_SESSION['email'];?></a></li>
      					<li><a href="" id="test"> </a></li>
      				</ul>     
      			</div><!-- /.navbar-collapse -->
  			</div><!-- /.container-fluid -->
    	</nav>
    	<div class="container">
    		<div class="row">
				<div class="col-md-12">
					<div class="panel" ><table class="table table-striped title1">
						<tr>
  							<td><b>S.N.</b></td>
  							<td><b>Topic</b></td>
  							<td><b>Total question</b></td>
  							<td><b>Time limit</b></td>
  							<td></td>
  						</tr>
						<?php 
							$result = mysql_query("SELECT * FROM `exam` WHERE `status`='1' ORDER BY `created time` DESC") or die('Error');
							$c=1;
							while($row = mysql_fetch_array($result)) {
								$name = $row['name'];
								$questions = $row['questions'];
    							$duration = $row['duration'];
								$examid = $row['examid'];
								echo '<tr>
									<td>'.$c++.'</td>
									<td>'.$name.'</td>
									<td>'.$questions.'</td>
									<td>'.$duration.'&nbsp;min</td>
									<td><b><a id="request" href="test.php?examid='.$examid.'" class="pull-right btn sub1" style="margin:0px;background:#99cc32"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td>
								</tr>';
		
							}
						$c=0;
					?>
					</table>
					</div>

				</div>
			</div>
    	</div>
    	<div class="ngdialog-content">
		    <script type="text/ng-template" id="modalDialogId">
        		<div class="ngdialog-message">
            		<h3>General instruction</h3>
            		<p>1.Must answer all the questions</p>
            		<p>2.Complete within the allotted time </p>
            		<p>3.Once the time session expires.The test will be closed automatically</p>
            		<p>4.After the completion of test have to fill the Feedback </p>
            		<p>5.Malpractise is strictly prohibited</p>
            		<p align="center"> All the Best!</p>
            		<p>
            		<?php
            			$q=mysql_fetch_row(mysql_query("SELECT `instruction` FROM `exam` WHERE `examid`= '$examid' "));
            			echo $q[0];
            		?>
            		</p>
        		</div>
        		<div class="ngdialog-buttons">
        			<input ng-model="dis" type="checkbox"> I accept term and conditions
            		<button type="button" ng-disabled="!dis" class="btn btn-primary" ng-click="confirm()&&closeThisDialog()">Submit</button>
        		</div>
    		</script>
  		</div>
    	<script type="text/javascript" src="js/ngDialog.js"></script>
    	<link rel="stylesheet" type="text/css" href="css/ngDialog.css">
    	<link rel="stylesheet" href="css/ngDialog-theme-default.css">
    	<style type="text/css">
    		.ngdialog-content {
      			width: 850px!important;
    		}
    	</style>
	</body>
	<script type="text/javascript">
	var app=angular.module("app1",['ngDialog']);
	app.controller("cntrl1",function ($scope,$rootScope,ngDialog){
		$scope.init=function(){
			ngDialog.openConfirm({
                    template: 'modalDialogId',
                    showClose: false,
                	closeByEscape: false,
                    className: 'ngdialog-theme-default'
                }).then(function () {
                    console.log('Modal promise resolved.');
                }, function () {
                    console.log('Modal promise rejected.');$scope.init();
                });
		}
	});
	</script>
