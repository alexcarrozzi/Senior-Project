<?php
    require_once 'google_api_init.php';
    require_once 'logger.php';
    
    $url = base64_decode($_REQUEST['s']);
    $base_length = 7;
    $pattern = "/(\w{".$base_length."})9JflMdf3s(\w+)5jk49sDFd(.*)/i";
    preg_match($pattern,$url, $match);
    $cal_id = $match[1].$match[3];
    $event_id = $match[2];
    
    echo $manager->delete_event($cal_id,$event_id);
?>

d62u8j2 9JflMdf3sdgsjdmr3qv4qel4fll4acnihmc 5jk49sDFd ik3dhlu5slu4hka3dfk@group.calendar.google.com