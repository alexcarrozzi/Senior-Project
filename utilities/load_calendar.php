<?php
/*  
 * All code in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 * The University of New Hampshire Computer Science Department owns and
 * is responsible for all functionality contained in the web application
 * ScheduleIt
 *
 * load_calendar.php
 * This file is the initial reception point from the browser as it is included
 * at the beginning of index.php. It will check to see if a Google Calendar
 * ID has been provided in the HTTP request. The Calendar ID is necessary
 * to reference events from the advisor's calendar. 
 *
 * NOTE: Future maintainers should look to remove the use of the $GLOBALS
 * array
 */
    
    if(isset($_REQUEST['cid'])){
        $cal_id = $_REQUEST['cid'];
        $GLOBALS['g_calid'] = base64_decode($cal_id);
    }else{
        die("no calendar specified!");
    }
?>