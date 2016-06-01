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
	$name=$_SESSION['name'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>HI-JS ONLINE TEST</title>
		<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 		<link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 		<link rel="stylesheet" href="css/main.css">
 		<link  rel="stylesheet" href="css/font.css">

 		<script type="text/javascript" src="js/jquery.js"></script>
	  	<script type="text/javascript" src="js/shortcut.js"></script>
		<script type="text/javascript">
			shortcut.add("Esc",function() {
  				alert("The bookmarks of your browser will show up after this alert...");
				},{
  				'type':'keydown',
  				'propagate':true,
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
	<body ng-app="app-feed" ng-controller="feed-cntr">
		<!--
		<div class="header">
	  		<div class="row">
    			<div class="col-lg-6">
      				<span class="logo">HI-JS Online Test</span>
    			</div>
    			<div style="float: right;" class="col-md-6 ">
	    		</div>
  			</div>	
		</div>
		<nav class="navbar navbar-default title1" style="margin-bottom: 0px;">
	  		<div class="container-fluid">
    			<div class="navbar-header">
      				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	      				<span class="sr-only">Toggle navigation</span>
    	  				<span class="icon-bar"></span>
      					<span class="icon-bar"></span>
      					<span class="icon-bar"></span>
      				</button>
      				<a class="navbar-brand" href="#"><b>Knonex</b></a>
    			</div>
    			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      				<ul class="nav navbar-nav">
      					<li><a><?php echo $_SESSION['email'];?></a></li>
      				</ul>     
      			</div>
  			</div>
    	</nav>
    	-->
		<div class="bg1">
			<div class="row">
				<div class="col-md-3">
					
				</div>
				<div class="col-md-6 panel" style="background-image:url(image/bg1.jpg); min-height:430px;">
					<h2 align="center" style="font-family:'typo'; color:#000066">FEEDBACK/REPORT A PROBLEM</h2>
					<div style="font-size:14px">
						<span style="font-size:18px;">
							<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							&nbsp;
						</span>
						You can send us your feedback through e-mail on the following e-mail id:<br />
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<a href="mailto:chiraggoel.53784@gmail.com" style="color:#000000">work@knonex.com</a><br /><br />
							</div>
							<div class="col-md-1"></div>
						</div>
						<p>Or you can directly submit your feedback by filling the enteries below:-</p>
						<form name="form">
							<div class="row">
								<div class="col-md-3"><b>Name:</b><br /><br /><br /><b>Subject:</b></div>
								<div class="col-md-9">
									<div class="form-group">
  										<input ng-model="name" name="name" ng-value="name" ng-pattern="/^[a-zA-Z]{3,40}(\s{0,1}[a-zA-Z]{3,40})*$/" placeholder="Enter your name" class="form-control input-md" type="text" disabled required><br />    
   										<select ng-model="subject" name="subject" class="form-control input-md" required>
   											<option value="" disabledselected>Choose Subject</option>
											<option value="About Recruitemrnt">About Recruitemrnt</option> 
											<option value="About Company">About Company</option>
											<option value="About Technology">About Technology</option>
											<option value="Suggestion & Others">Suggestion & Others</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3"><b>E-Mail address:</b></div>
								<div class="col-md-9">
									<div class="form-group">
  										<input ng-value="email" name="email" placeholder="Enter your email-id" class="form-control input-md" type="email" disabled required>    
 									</div>
								</div>
							</div>
							<div class="form-group"> 
								<textarea rows="5" cols="8" ng-model="feedtext" ng-pattern="/^[0-9a-zA-Z-,.\/\s]*$/" name="feedtext" class="form-control" placeholder="Write feedback here..." minlength="6"required></textarea>
							   	<span ng-show="form.feedtext.$error.minlength"style="color:#f44336;">Minimum length is 6</span>
							</div>
						</form>

							<div class="form-group" align="center">
								<input type="button" ng-click="submit()" ng-disabled="form.name.$invalid||form.subject.$invalid||form.email.$invalid||form.feedtext.$invalid"value="Submit" class="btn btn-primary" />
							</div>
					</div>
					<div class="col-md-3"></div>
				</div>
			</div>
		</div>

	</body>
<script type="text/javascript">
	var app=angular.module("app-feed",[]);
	app.controller("feed-cntr",function($scope,$http){
		$scope.email=<?php echo "'$email';";?>
		$scope.name=<?php echo "'$name';";?>
		$scope.submit=function(){
			var loc = document.location.pathname;
			pos=loc.lastIndexOf('/');
			loc=loc.substr(0, pos);
			var http=$http({
				method:"post",
				url:"http://" + document.location.hostname + loc + "/submit feed.php",
				data:{
					name:$scope.name,
					email:$scope.email,
					sub:$scope.subject,
					feed:$scope.feedtext
				},
				headers:{'Content-Type':'application/x-www-form-urlencoded'}

			});
			http.success(function(data){
				if ( !data.success) {
          			alert(data.err);
        		} 
        		else {
					window.location="http://" + document.location.hostname + loc + "/userlogout.php";
      			}
			}).error(function(error){
				alert("error in http");
			});
		}
	})
</script>
