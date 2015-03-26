<?php
    if(isset($_REQUEST['cid'])){
        $cal_id = $_REQUEST['cid'];
        $GLOBALS['g_calid'] = $cal_id;
    }else{
        die("no calendar specified!");
    }
    //Get calendar ID from url
    //Load proper display proper calendar
?>