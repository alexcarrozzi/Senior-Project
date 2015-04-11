<?php     
/*  
 * All code in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 * The University of New Hampshire Computer Science Department owns and
 * is responsible for all functionality contained in the web application
 * ScheduleIt
 *
 * 
 */
    
    //Makeshift router
    if(isset($_REQUEST['action'])){
        switch($_REQUEST['action']){
            case 'cancel':
                require_once 'utilities/cancel.php';
                die;
            default:
                //display 404
        }   
    }
    
    require_once './utilities/load_calendar.php';
    require_once './utilities/google_api_init.php';
    require_once './utilities/signup.php';
?>
<!DOCTYPE HTML>
<html ng-app="ScheduleIt">
<head>
    <title>ScheduleIt Home</title>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/blockui-master/jquery.blockUI.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/date.js"></script>
    <script src="js/spin.min.js"></script>
    <script src="js/app.js"></script>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
    <!---- START BOOTSTRAP CDNS ------------>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!----- END BOOTSTRAP CDNS -------------> 
    <link rel="stylesheet" href="css/additional.css">

<!-- EXTRACT THIS -->
  <style>
      #feedback { font-size: 1.4em; }
      #selectable .ui-selecting { background: #FECA40; }
      #selectable .ui-selected { background: #F39814; color: white; }
      #selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
      #selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
  </style>
</head>
<body>
	<div class="container">
	
        <h1 class="text-center">SCHEDULE IT</h1>
        
        <div class="row">
            
            <div id="nav" class="col-md-12">
                <a href="" id="last" class="pull-left weekButton">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    <span>Previous</span>
                </a>
                <a href="" id="next" class="pull-right weekButton">
                    <span>Next</span>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                </a>
            </div>
        </div>
        </br></br>
        <div id="calController" ng-controller="ScheduleController as schedule">
            <div>Week of: {{controlDate | date : 'MMMM d'}} &ndash; {{endDate | date : 'MMMM d'}}</div>
            <div class="row" id="selectable">
                <div class="day" ng-repeat="all in monday">
                Monday
                    <div ng-repeat="data in all" style="display:block" style="text-align:center;">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in tuesday">
                Tuesday
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in wednesday">
                Wednesday
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in thursday">
                Thursday
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in friday">
                Friday
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <form name="signupForm">
                    <!-- Style this to be very errory -->
                    <div id="errorMsg"></div>
                Name: <input required id="SignUpName" type="text" name="fullname" /><br/>
                Email: <input required id="SignUpEmail" type="text" name="email" /><br/>
                <button ng-disabled="signupForm.$invalid" id="signupButton"/>Sign Up!</button>
                <input id="cal" type="hidden" value="<?=$g_calid?>"/>
                <form>
        </div>
    </div>
</body>
</html>
