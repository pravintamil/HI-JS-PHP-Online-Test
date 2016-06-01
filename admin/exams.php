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
    <style type="text/css">
          .btn-file {
        position: relative;
        overflow: hidden;

    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        opacity: 0;
        background: white;
        cursor: inherit;
        display: block;
    }
    </style>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/shortcut.js"></script>
    <script type="text/javascript">
      shortcut.add("Esc",function() {
          
        },{
          'type':'keydown',
          'propagate':false,
          'target':document
        });
    </script>
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
      <script src="../js/jquery.min.js"></script>
    <script src="../js/screenfull.js"></script>
    <script src="../js/angular.min.js"></script>
  <!--  <script type="text/javascript">
        function preventBack(){window.history.forward();}
        setTimeout("preventBack()", 0);
        window.onunload=function(){null};
    </script>
    -->
    <script src="../js/bootstrap.min.js"  type="text/javascript"></script>
  </head>
  <body ng-app="myApp" ng-controller="main">
    
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
                <li><a href="feedback.php">Feedback</a></li>
                <li class="active"><a href="exams.php">Exams</a></li>
                <li><a onclick="myFunction()" style="cursor:pointer;">Print page</a></li>
              </ul>
              </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="panel title">
            <form style="float:left" name="pageform" action="#" method="POST">
                <ul class = "pagination" id="pagination">
                <li><a ng-click="page1(1)">1</a></li>
                <input id="pagenumber" type="text" name="limit" hidden >
                <li><a ng-click="page1(2)">2</a></li>
                <li><a ng-click="page1(3)">3</a></li>
                </ul>
              </form>
              <div class="col-md-4 col-md-offset-2">
                <div  ng-controller = "myCtrl" class="modal fade" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content title1">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title title1">
                          <span style="color:orange">Create Test</span>
                        </h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" name="create_test" method="POST" >
                        <fieldset>
                          <div class="form-group">
                            <label class="col-md-4 control-label">Exam name</label>  
                            <div class="col-md-6">
                              <input ng-model="name" name="name" onkeydown="return isalpha(event)" placeholder="Enter test name" class="form-control input-md" type="text" required>    
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 control-label">Instruction</label>
                            <div class="col-md-6">
                              <textarea ng-model="instruction" name="instruction" ng-pattern="/^[a-zA-Z0-9.,-\s]*$/" placeholder="Enter instruction" class="form-control input-md" type="text" required></textarea> 
                              <span ng-show="create_test.instruction.$error">
                                <span ng-show="create_test.instruction.$error.pattern">Enter only alphanumeric and .,- only</span>
                              </span>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 control-label">Exam Duration in minutes</label>
                            <div class="col-md-6">
                              <input  ng-model="time" ng-pattern="/^[1-9]+[0-9]*$/" maxlength="2" onkeydown="return isnumber(event)" name="time" placeholder="Enter exam duration in minutes" class="form-control input-md" type="text" required>
                              <span ng-show="create_test.time.$error.pattern">Enter valid time in minutes</span>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <div style="float:right" class="btn-group">
                              <span class="file-input btn btn-info btn-file">
                                Select Text Document&hellip; 
                                <input type="file" onchange="angular.element(this).scope().uploadImage()" name="file" file-model = "myFile" class="form-control" required >
                              </span> 
                              <span style="margin-left:10px" class="btn-file">
                                <button ng-click = "uploadFile()" ng-disabled="create_test.name.$invalid||create_test.instruction.$invalid||create_test.time.$invalid||isdisabled" class="glyphicon glyphicon-upload btn btn-warning">Upload</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </span>
                            </div>

                          </div>
                        </fieldset>
                        </form>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
              </div>
              <button style="float:right" class="btn btn-success"  data-toggle="modal" data-target="#myModal">CreateTest</button>
             
              <table class="table table-striped title1">
                  <tr>
                    <td><b>S.N.</b></td>
                    <td><b>Name</b></td>
                    <td><b>Questions</b></td>
                    <td><b>Duration</b></td>
                    <td><b>Created on</b></td>
                    <td><b>Status</b></td>
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
                  $c=1;
                  while($row = mysql_fetch_array($result)) {
                    $examid = $row['examid'];
                    $title = $row['name'];
                    $total = $row['questions'];
                    $duration = $row['duration'];
                    $date = $row['created time'];
                    $status=$row['status'];
                    if ($status) {
                      $status="active";
                      $dis="disabled";
                    }
                    else{
                      $status="inactive";
                      $dis="";
                    }
                    echo '<tr>
                    <td>'.$c++.'</td>
                    <td>'.$title.'</td>
                    <td>'.$total.'</td>
                    <td>'.$duration.'min</td>
                    <td>'.$date.'</td>
                    <td>'.$status.'</td>
                    <td>
                      <button class="btn btn-danger btn-sm" title="Delete Exam" ng-click="submit('."'".$examid."'".')" '.$dis.'>delete
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                      </button>
                    </td>
                    </tr>';
                  }
                  $c=0;
                ?>
                </table>
            </div>
          </div>
        </div>
      </div>

  </body>
      <script>
         var myApp = angular.module('myApp', []);
         
         myApp.directive('fileModel', ['$parse', function ($parse) {
            return {
               restrict: 'A',
               link: function(scope, element, attrs) {
                  var model = $parse(attrs.fileModel);
                  var modelSetter = model.assign;
                  
                  element.bind('change', function(){
                     scope.$apply(function(){
                        modelSetter(scope, element[0].files[0]);
                     });
                  });
               }
            };
         }]);
      
         myApp.service('fileUpload', ['$http', function ($http) {
            this.uploadFileToUrl = function(file, uploadUrl, name, instruction, time){
               var fd = new FormData();
               fd.append('fileToUpload', file);
               fd.append('name', name);
               fd.append('instruction', instruction);
               fd.append('time', time);
            
               $http.post(uploadUrl, fd, {
                  transformRequest: angular.identity,
                  headers: {'Content-Type': undefined}
               })
            
               .success(function(msg){
                   alert(msg);
                   location.reload();
               })
            
               .error(function(da){
                   alert(da)
               });
            }
         }]);
      
         myApp.controller('myCtrl', ['$scope', 'fileUpload', function($scope, fileUpload){
            $scope.isdisabled=true;
            $scope.uploadImage = function () {
              $scope.isdisabled=false;
            }
            $scope.uploadFile = function(){
               var file = $scope.myFile;
               var name = $scope.name;
               var instruction = $scope.instruction;
               var time = $scope.time;
               console.log('file is ' );
               console.dir(file);
               
               var uploadUrl = "upload.php";
               fileUpload.uploadFileToUrl(file, uploadUrl, name, instruction, time);
            };
         }]);
         myApp.controller('main',function ($scope,$http) {
    $scope.page1=function(num){
      
      document.getElementById("pagenumber").value=(num-1)*20;
      var k=(num-1)*20;
      document.pageform.submit();

    }
           
            $scope.submit=function(examid){
              var loc = document.location.pathname;
              pos=loc.lastIndexOf('/');
              loc=loc.substr(0, pos);
              var http=$http({
                method:"post",
                url:"http://" + document.location.hostname + loc + "/control.php",
                data:{
                  examid:examid,
                  mode:"delete_exam"
                },
                headers:{'Content-Type':'application/x-www-form-urlencoded'}
              });
              http.success(function(data){
              if ( !data.success) {
                alert(data.err);
              } 
              else {
                alert("Exam deleted successfully");
                location.reload();
              }
            })
            .error(function(error){
              alert("error in http");
            });
          }
         })
      function myFunction(){
        window.print();
      }
      </script>
      