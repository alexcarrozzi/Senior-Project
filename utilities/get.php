<?php 
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 *
 * 
 */

        
    require_once $_SERVER['DOCUMENT_ROOT']."/utilities/common.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/utilities/block.php";
    
    $type=$_REQUEST['type'];
    $eventId=isset($_REQUEST['id'])?$_REQUEST['id']:'';
    $calId=isset($_REQUEST['calendar'])?$_REQUEST['calendar']:'';
    $my_date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
    
    $GLOBALS['g_calid'] = $calId;
    require_once $_SERVER['DOCUMENT_ROOT']."/utilities/google_api_init.php";
    
    $list = [];
    $return_array = [];
    
    if($type=='segments'){
        $return_array = [];
        $params = array(
        'singleEvents' => 'true',
        'timeMin' => date(DATE_ISO8601,strtotime($my_date.' midnight')),
        'timeMax' => date(DATE_ISO8601,strtotime($my_date.' midnight + 86399 seconds')),
        'orderBy' => 'startTime');
        //Execute
        $events = $service->events->listEvents($g_calid,$params);

        
        foreach($events as $myEvent){
            $block = new Block(fmt_gdate($myEvent->getStart()),fmt_gdate($myEvent->getEnd()));
            $list = $block->getList();
            $temp = array("id"=>$myEvent->getId(),
                          "date" => $myEvent->getStart()['dateTime'],
                          "segments" => $list,
                          "desc" => $myEvent->getDescription()
                          );
                          
            $return_array[]  = $temp;
        }
        
    }else{
        $return_array = array("Error"=>'Invalid type');
    }

    header("Content-Type: application/json");
    echo json_encode($return_array);

?>