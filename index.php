<?php
include_once 'db.php';
session_start();
	if(isset($_SESSION['email'])){
		if (isset($_SESSION['admin'])) {
 			header('Location: admin/index.php');
		}
		header('Location: exam info.php');
	}
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

  		<script type="text/javascript" src="js/js.cookie.js"></script>
 		<script type="text/javascript" src="js/jquery.js"></script>
	  	<script type="text/javascript" src="js/shortcut.js"></script>
		<script type="text/javascript">
			shortcut.add("Shift",function() {
				},{
  				'type':'keydown',
  					'propagate':false,
  				'target':document
				});
			shortcut.add("Ctrl+Shift+a",function() {
				document.getElementById("admin_button").click();
			});
		</script>
		<script src="js/jquery.min.js"></script>
    	<script src="js/screenfull.js"></script>
		<script src="js/angular.min.js"></script>
	<!--	<script type="text/javascript">
    		function preventBack(){window.history.forward();}
  			setTimeout("preventBack()", 0);
  			window.onunload=function(){null};
		</script>
	-->	<script src="js/bootstrap.min.js"  type="text/javascript"></script>
		<script type="text/javascript">
			function isnumber(evt){
  				var charcode = (evt.which) ? evt.which : event.keyCode
  				if ((charcode>32&&charcode<41)||(charcode>47&&charcode<58)||(charcode>95&&charcode<106)||(charcode==8)||(charcode==9)||(charcode==13)){
  				
    				return true;
  				}
  				return false;
			}
			function isalpha(evt){
  				var charcode = (evt.which) ? evt.which : event.keyCode;
  				if ((charcode>31&&charcode<41)||(charcode>64&&charcode<91)||(charcode==8)||(charcode==9)||(charcode==13)){
    				return true;
  				}
  				return false;
			}
			function isalphanum(evt){
	  				var charcode = (evt.which) ? evt.which : event.keyCode;
  				if ((charcode>32&&charcode<41)||(charcode>64&&charcode<91)||(charcode>47&&charcode<58)||(charcode>95&&charcode<106)||(charcode==8)||(charcode==9)||(charcode==13)){
    				return true;
  				}
  				return false;
			}
			function isalphanumdot(evt){
  				var charcode = (evt.which) ? evt.which : event.keyCode;
  				if ((charcode>32&&charcode<41)||(charcode>64&&charcode<91)||(charcode>47&&charcode<58)||(charcode>95&&charcode<106)||(charcode==8)||(charcode==9)||(charcode==13)||(charcode==190)){
    				return true;
  				}
  				return false;
			}
  		</script>
	</head>
	<body ng-app="main">
		<div class="header">
	  		<div class="row">
    			<div class="col-lg-6">
      				<span class="logo">HI-JS Online Test</span>
    			</div>
    			<div class="col-md-4 col-md-offset-2">
	    			<div class="modal fade" id="myModal">
  						<div class="modal-dialog">
    						<div class="modal-content title1">
      							<div class="modal-header">
        							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        								<span aria-hidden="true">&times;</span>
        							</button>
        							<h4 class="modal-title title1">
        								<span style="color:orange">Log In</span>
        							</h4>
      							</div>
      							<div class="modal-body">
        							<form name="userlogin"class="form-horizontal" ng-controller="logincntrlr" method="POST">
										<fieldset>
											<div class="form-group">
  												<label class="col-md-4 control-label" >Gmail username</label>  
  												<div class="col-md-7">
  													<div class="input-group">
  														<input id="mail" ng-model="mail" name="mail" placeholder="username" class="form-control input-md" onkeydown = "return isalphanumdot(event)" minlength="6"  ng-pattern="/^[a-zA-Z0-9\.]{6,30}$/"  maxlength="30" type="text" required>    
  														<span class="input-group-addon" id="basic-addon2">@gmail.com</span>	

  													</div>  												
      												<span ng-show="userlogin.mail.$invalid&&!userlogin.mail.$error.minlength&&!userlogin.mail.$error.maxlength&&userlogin.mail.$error.pattern"style="color:#f44336;">Invalid gmail username</span>
      												<span ng-show="userlogin.mail.$error.minlength"style="color:#f44336;">Username is Too short</span>
      												<span ng-show="userlogin.mail.$error.maxlength"style="color:#f44336;">Username is Too long</span>
      								
  													
												</div>
											</div>
											<div class="form-group">
  												<label class="col-md-4 control-label" for="password">Password</label>
  												<div class="col-md-7">
    												<input id="password" ng-model="password" ng-pattern="/^[7-9]+[0-9]*$/" name="password" placeholder="Enter your password here" class="form-control input-md" type="password" onkeydown="return isnumber(event)"maxlength="10" ng-minlength="10" required>
    												<span ng-show="userlogin.password.$error.minlength"style="color:#f44336;">Type 10 Numbers</span>
   													<span ng-show="userlogin.password.$error.pattern&&!userlogin.password.$error.minlength"style="color:#f44336;">Invalid Mobile No </span>
												</div>
											</div>
      										<div class="modal-footer">
        										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        										<button type="button" class="btn btn-primary" ng-disabled="userlogin.password.$invalid||userlogin.mail.$invalid" ng-click="submit()">Log in</button>
      										</div>
										</fieldset>
									</form>
      							</div>
    						</div><!-- /.modal-content -->
  						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
    			</div>
  			</div>	
		</div>
		<div class="bg1">
			<div class="row">
				<div class="col-md-7"></div>
				<div class="col-md-4 panel">
					<!-- sign in form begins -->  
  					<form class="form-horizontal" ng-controller="signupcntrlr" name="form" method="POST">
						<fieldset>
							<div class="form-group">
  								<label class="col-md-12 control-label"></label>  
  								<div class="col-md-12">
	  								<input id="name" name="name" onkeydown="return isalpha(event)" ng-pattern="/^[a-zA-Z]{3,40}(\s{0,1}[a-zA-Z]{3,40})*$/"  ng-model="name"  ng-minlength="3" placeholder="Enter your Fullname" class="form-control input-md" type="text" required>
  									<span ng-show="form.name.$error.minlength"style="color:#f44336;">Name is too short.</span> 
  									<span ng-show="form.name.$error.pattern"style="color:#f44336;">Enter valid name</span>
  								</div>
							</div>
							<div class="form-group">
  								<label class="col-md-12 control-label"></label>  
  								<div class="col-md-12">
  									<input id="fathername" name="fathername" onkeydown="return isalpha(event)" ng-pattern="/^[a-zA-Z]{3,40}(\s{0,1}[a-zA-Z]{3,40})*$/"  ng-model="fathername"  ng-minlength="3" placeholder="Enter your father name without initial" class="form-control input-md" type="text" required>
  									<span ng-show="form.fathername.$error.minlength"style="color:#f44336;">Fathername is too short.</span>
  									<span ng-show="form.fathername.$error.pattern"style="color:#f44336;">Enter valid father name</span>  
								</div>
							</div>
							<div class="form-group">
  								<label class="col-md-12 control-label"></label>  
  								<div class="col-md-12">
  									<input id="regno" name="regno"onkeydown="return isalphanum(event)" ng-pattern="/^[a-zA-Z0-9]*$/"  ng-model="regno"  ng-minlength="3" maxlength="12" placeholder="Enter register no" class="form-control input-md" type="text" required>
  									<span ng-show="form.regno.$error.minlength"style="color:#f44336;">Reg No is too short.</span>
								</div>
							</div>
							<div class="form-group">
  								<label class="col-md-12 control-label" for="gender"></label>
  								<div class="col-md-12">
    								<select id="gender" name="gender" ng-model="gender"class="form-control input-md"  required>
  										<option value="">choose gender</option>
  										<option value="male">Male</option>
  										<option value="female">Female</option> 
  									</select>
  								</div>
							</div>
							<div class="form-group">
  								<label class="col-md-12 control-label"></label>  
  								<div class="col-md-12">
  									<input id="college" name="college" onkeydown="return isalpha(event)" ng-minlength="3" ng-pattern="/^[a-zA-Z]{3,40}(\s{0,1}[a-zA-Z]{2,40})*$/" ng-model="college"  placeholder="Enter your college name" class="form-control input-md" type="text" required>
  									<span ng-show="form.college.$error.pattern"style="color:#f44336;">Enter valid college name.</span>
  									<span ng-show="form.college.$error.minlength"style="color:#f44336;">College Name is Too Short.</span>
  								</div>
							</div>
							<div class="form-group">
  								<label class="col-md-12 control-label title1"></label>
  								<div class="col-md-12" >
      								<div class="input-group">
      									<input id="email" name="email" ng-model="email" onkeydown = "return isalphanumdot(event)" minlength="6"  ng-pattern="/^[a-zA-Z0-9\.]{6,30}$/"  placeholder="Enter your gmail-username" class="form-control input-md" maxlength="30" type="text" required>
      									<span class="input-group-addon" id="basic-addon2">@gmail.com</span>
      								</div>
      								<span ng-show="form.email.$invalid&&!form.email.$error.minlength&&!form.email.$error.maxlength&&form.email.$error.pattern"style="color:#f44336;">Invalid gmail</span>
      								<span ng-show="form.email.$error.minlength"style="color:#f44336;">Gmail id is Too short</span>
      								<span ng-show="form.email.$error.maxlength"style="color:#f44336;">Gmail id is Too long</span>
      									
  								</div>
							</div>
							<div class="form-group">
  								<label class="col-md-12 control-label" for="mob"></label>  
  								<div class="col-md-12">
  									<input id="mob" name="mob" ng-pattern="/^[7-9]+[0-9]*$/" ng-model="mob" placeholder="Enter your mobile number" class="form-control input-md" type="text" onkeydown="return isnumber(event)"maxlength="10" ng-minlength="10" required>
   									<span ng-show="form.mob.$error.minlength"style="color:#f44336;">Type 10 Numbers</span>
   									<span ng-show="form.mob.$error.pattern&&!form.mob.$error.minlength"style="color:#f44336;">Invalid Mobile No </span>
								</div>
							<div class="form-group">
  								<label class="col-md-12 control-label" for=""></label>
  								<div class="col-md-12"> 
    								<input  type="submit" ng-click="submit()" ng-disabled="form.name.$invalid||form.fathername.$invalid||form.regno.$invalid||form.college.$invalid||form.email.$invalid||form.mob.$invalid||form.gender.$invalid||isDisabled" value="sign up" class="btn btn-primary"/>
    								<input type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal" value="Signin">
  								</div>
							</div>
						</fieldset>
					</form>
				</div><!--col-md-6 end-->
			</div>
		</div>
		<div class="row footer" hidden> 
			<div class="col-md-3 box">
				<a id="admin_button" href="#" data-toggle="modal" data-target="#login">Admin Login</a>
			</div>
		</div>
		<div ng-controller="adlogin" class="modal fade" id="login">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">
        					<span aria-hidden="true">&times;</span>
        					<span class="sr-only">Close</span>
        				</button>
        				<h4 class="modal-title">
        					<span style="color:orange;font-family:'typo' ">LOGIN</span>
        				</h4>
      				</div>
      				<div class="modal-body title1">
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-11">
								<form name="adminlogin"role="form" method="post" >
									<div class="form-group">
										<label class="col-md-4 control-label" >Username</label>  
  										<div class="form-group col-md-7">
										
											<input type="text" name="username" ng-model="adminname" maxlength="20"   class="form-control" type="email" disabled required> 
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" >Password</label>  
  										<div class="form-group col-md-7">
											<input type="password" name="password" ng-model="adminpassword" maxlength="15" placeholder="enter your password here" class="form-control" required>
										</div>
									</div>
									<div class="form-group" align="center">
										<input type="submit" ng-disabled="adminlogin.password.$invalid" ng-click="adsubmit()"name="login" value="Login" class="btn btn-primary" />
									</div>
								</form>
							</div>
							<div class="col-md-3"></div>
						</div>
      				</div>
    			</div>
  			</div>
		</div>
	</body>
	<script type="text/javascript">
	var app=angular.module("main",[]);
	app.controller("signupcntrlr",function($scope,$http){
		$scope.isDisabled=false;
		$scope.submit=function(){
			$scope.isDisabled=true;
			var loc = document.location.pathname;
			pos=loc.lastIndexOf('/');
			loc=loc.substr(0, pos);
			var http=$http({
				method:"post",
				url:"http://" + document.location.hostname + loc + "/signup.php",
				data:{
					name:$scope.name,
					gender:$scope.gender,
					fname:$scope.fathername,
					mail:$scope.email,
					clg:$scope.college,
					phone:$scope.mob,
					regno:$scope.regno
				},
				headers:{'Content-Type':'application/x-www-form-urlencoded'}

			});
			http.success(function(data){
				if ( !data.success) {
          			alert(data.err);
        		} 
        		else {
					alert(data.message);
					$scope.isDisabled=false;
					location.reload();
      			}
			}).error(function(error){
				alert("error in http");
			});
		}

		
	});
	app.controller("adlogin",function($scope,$http){
		$scope.adminname="hire@knonex.com";
		$scope.adsubmit=function(){
			var loc = document.location.pathname;
			pos=loc.lastIndexOf('/');
			loc=loc.substr(0, pos);
			var http=$http({
				method:"post",
				url:"http://" + document.location.hostname + loc + "/admin/userlogin.php",
				data:{
					mail:$scope.adminname,
					pass:$scope.adminpassword
				},
				headers:{'Content-Type':'application/x-www-form-urlencoded'}

			});
			http.success(function(data){
				if ( !data.success) {
          			alert(data.err);
        		} 
        		else {
					window.location="http://" + document.location.hostname + loc + "/admin/index.php";
      			}
			}).error(function(error){
				alert("error in http");
			});
		}
	})
	app.controller("logincntrlr",function($scope,$http){
		$scope.submit=function(){
			var loc = document.location.pathname;
			pos=loc.lastIndexOf('/');
			loc=loc.substr(0, pos);
			var http=$http({
				method:"post",
				url:"http://" + document.location.hostname + loc + "/userlogin.php",
				data:{
					mail:$scope.mail,
					pass:$scope.password
				},
				headers:{'Content-Type':'application/x-www-form-urlencoded'}

			});
			http.success(function(data){
				if ( !data.success) {
          			alert(data.err);
					console.log(data)
        		} 
        		else {
        			window.name = data.email;
					window.location="http://" + document.location.hostname + loc + "/exam info.php";
      			}
			}).error(function(error){
				alert("error in http");
			});
		}
	});
</script>

</html>
