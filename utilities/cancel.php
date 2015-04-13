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
    require_once 'google_api_init.php';
    require_once 'logger.php';
    
    $url = base64_decode($_REQUEST['s']);
    $base_length = 7;
    $pattern = "/(\w{".$base_length."})9JflMdf3s(\w+)5jk49sDFd(.*)/i";
    preg_match($pattern,$url, $match);
    $cal_id = $match[1].$match[3];
    $event_id = $match[2];
    
    $canceled_time = $manager->delete_event($cal_id,$event_id);
    
    include_once 'after_cancel.php';
?>