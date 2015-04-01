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
		
		<div class="col-md-12">
			<a href="" id="last" class="pull-left weekButton">
				<span class="glyphicon glyphicon-arrow-left"></span>
				<span>Previous</span>
			</a>
			<a href="" id="next" class="pull-right weekButton">
				<span>Next</span>
				<span class="glyphicon glyphicon-arrow-right weekButton"></span>
			</a>
		</div>
	</div>
	</br></br>
    <div id="calController" ng-controller="ScheduleController as schedule">
        <div id="selectable" style="display:inline-block">
            <div style="text-align:center;">Week of: {{controlDate | date : 'M/d'}} &ndash; {{endDate | date : 'M/d'}}</div>
            <div ng-repeat="day in days.monday" />
                <div ng-attr-id="{{start}}:{{day.id}}" ng-repeat="start in day.segments" style="display:block" style="text-align:center;">
                    {{start*1000 | date : 'h:mm a'}}
                </div>
            </div>
            <hr/>
            <div ng-repeat="day in days.tuesday" />
                <div ng-attr-id="{{start}}:{{day.id}}" ng-repeat="start in day.segments" style="display:block" style="text-align:center;">
                    {{start*1000 | date : 'h:mm a'}}
                </div>
            </div>
            <hr/>
            <div ng-repeat="day in days.wednesday" />
                <div ng-attr-id="{{start}}:{{day.id}}" ng-repeat="start in day.segments" style="display:block" style="text-align:center;">
                    {{start*1000 | date : 'h:mm a'}}
                </div>
            </div>
            <hr/>
            <div ng-repeat="day in days.thursday" />
                <div ng-attr-id="{{start}}:{{day.id}}" ng-repeat="start in day.segments" style="display:block" style="text-align:center;">
                    {{start*1000 | date : 'h:mm a'}}
                </div>
            </div>
            <hr/>
            <div ng-repeat="day in days.friday" />
                <div ng-attr-id="{{start}}:{{day.id}}" ng-repeat="start in day.segments" style="display:block" style="text-align:center;">
                    {{start*1000 | date : 'h:mm a'}}
                </div>
            </div>
        </div>
            <br/>
            Name: <input id="SignUpName" type="text" name="fullname" /><br/>
            Email: <input id="SignUpEmail" type="text" name="email" /><br/>
            <input id="SignUpSubmit" type="submit" value="Sign Up!" />
            <input id="cal" type="hidden" value="<?=$g_calid?>"/>
            <hr/>
    </div>
<!--
    <div id="appController" ng-controller="ScheduleController as schedule">
        <form name="SignUpStudent">
            <input id="cal" type="hidden" value="<?=$g_calid?>"/>
            <div ng-repeat="event in segments">
                 Event ID: <strong>{{event.id}}</strong>
                <div ng-repeat="segment in event.segments" >
                    <input type="radio" name="timeslot_id" ng-attr-value="{{segment.start}}:{{event.id}}" />
                    {{segment.start*1000 | date : 'MMMM d h:mm a'}} &ndash; {{segment.end*1000 | date : 'h:mm a'}}
                </div>
                <br/><br/>
            </div>
            Name: <input id="SignUpName" type="text" name="fullname" /><br/>
            Email: <input id="SignUpEmail" type="text" name="email" /><br/>
            <input id="SignUpSubmit" type="submit" value="Sign Up!" />
        </form>
    </div>
  <input type="button" id="refresh" value="Refresh"/>
    -->
    </div>
</body>
</html>
