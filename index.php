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
    <script src="js/angular.min.js"></script>
    <script src="js/app.js"></script>
</head>
<body>
    <form name="SignUpStudent">
        <input id="cal" type="hidden" value="<?=$g_calid?>"/>
        <div id="appController" ng-controller="ScheduleController as schedule">
            <div ng-repeat="event in segments">
                 Event ID: <strong>{{event.id}}</strong>
                <div ng-repeat="segment in event.segments | orderBy : '-start'" >
                    <input type="radio" name="timeslot_id" ng-attr-value="{{segment.start}}:{{event.id}}" />
                    {{segment.start*1000 | date : 'MMMM d h:mm a'}} &ndash; {{segment.end*1000 | date : 'h:mm a'}}
                </div>
                <br/><br/>
            </div>
        </div>
   
    Name: <input id="SignUpName" type="text" name="fullname" /><br/>
    Email: <input id="SignUpEmail" type="text" name="email" /><br/>
    <input id="SignUpSubmit" type="submit" value="Sign Up!" />
  </form>
</body>
</html>
