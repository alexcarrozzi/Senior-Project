<?php     
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
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
      #selectable .ui-selecting { background: #3EACE3; }
      #selectable .ui-selected { background: #337ab7; color: white; }
      #selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
      #selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
  </style>
</head>
<body>
	<div class="container">
        <h1 class="text-center">SCHEDULE IT</h1>
        <br/><br/>
        <nav>
            <div id="nav" class="row text-center nav nav-justified">
                <a href="" id="last" class="weekButton">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    <span>Previous Week</span>
                </a>
                <span><a href="" id="datebutton">Go To Date</a></span>
                <span><a href="" id="refresh">Refresh</a></span>
                <span><a href="" id="nextavailable">Find Next Available</a></span>
                <a href="" id="next" class="weekButton">
                    <span>Next Week</span>
                    <span class="glyphicon glyphicon-arrow-right"></span>
                </a>
            </div>
        </nav>
        </br></br>
        <div class="text-center" id="calController" ng-controller="ScheduleController as schedule">
            <div class="row text-center"><strong>Week of: {{controlDate | date : 'MMMM d'}} &ndash; {{endDate | date : 'MMMM d'}}</strong></div>
            <span ng-show="isEmptyWeek" class="day-header">No Appointments Found</span>
            <div ng-hide="isEmptyWeek" class="row" id="selectable">
                <div class="day" ng-repeat="all in monday">
                    <span class="day-header">Monday</span>
                    <div ng-repeat="data in all" style="display:block" style="text-align:center;">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in tuesday">
                    <span class="day-header">Tuesday</span>
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in wednesday">
                <span class="day-header">Wednesday</span>
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in thursday">
                    <span class="day-header">Thursday</span>
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="day"  ng-repeat="all in friday">
                    <span class="day-header">Friday</span>
                    <div ng-repeat="data in all">
                        <div ng-repeat="start in data.segments">
                            <div class="{{data.desc ? 'closed' : 'open'}}" ng-attr-id="{{start}}:{{data.id}}">
                                {{data.desc || start*1000 | date : 'h:mm a' }}
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
    </div>
</body>
</html>
