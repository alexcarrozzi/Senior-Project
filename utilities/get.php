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
    
     $prod = 1;
     $sp = $prod==0?"Senior-Project/":""; 
        
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/common.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/block.php";
    
    $type=$_REQUEST['type'];
    $eventId=isset($_REQUEST['id'])?$_REQUEST['id']:'';
    $calId=isset($_REQUEST['calendar'])?$_REQUEST['calendar']:'';
    $my_date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
    
    $GLOBALS['g_calid'] = $calId;
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/google_api_init.php";
    
    $list = [];
    $return_array = [];
    
    if($type=='events'){
        
        $events = $service->events->listEvents($g_calid);
        
        
        
        $temp_events = $events->getItems();
       
        $i=-1;
        foreach($temp_events as $event){
            $newEv[++$i]['start'] = $event->getStart()['dateTime'];
            $newEv[$i]['id'] =  $event->getId();
        }
        $myEvents =  array("events"=>$newEv);
        
        usort($myEvents, "custom_sort_by_start");
        
        $return_array = array("events"=>$myEvents[0]);
    }elseif($type=="event"){
        
        $events = $service->events->listEvents($g_calid);
        
        
        
        $myEvent = $service->events->get($calId,$eventId);//make sure the calendarId isnt hard coded
        $return_array = array("id"         => $myEvent->getId(),
                              "start"      => $myEvent->getStart()['dateTime'],
                              "end"        => $myEvent->getEnd()['dateTime'],
                              "calendarId" => $myEvent->getOrganizer()['email'],
                              "desc"       => $myEvent->getDescription()
                              );
                 
    }elseif($type=='segments'){
        
        $events = $service->events->listEvents($g_calid);
        
        
        
        $myEvent = $service->events->get($calId,$eventId);//make sure the calendarId isnt hard coded
        if($myEvent->getDescription() == ''){
            $block = new Block(fmt_gdate($myEvent->getStart()),fmt_gdate($myEvent->getEnd()));
            $list = $block->getList();
        }  
        $return_array = array("id"         => $myEvent->getId(),
                              "segments"   => $list
                              );
    }elseif($type=='newSegments'){
        $return_array = [];
        $params = array(
        'singleEvents' => 'true',
        'timeMin' => date(DATE_ISO8601,strtotime($my_date.' midnight')),
        'timeMax' => date(DATE_ISO8601,strtotime($my_date.' midnight + 86399 seconds')),
        'orderBy' => 'startTime');
        //Execute
        $events = $service->events->listEvents($g_calid,$params);

        
        foreach($events as $myEvent){
            //if(strlen($myEvent->getDescription())==0){
                $block = new Block(fmt_gdate($myEvent->getStart()),fmt_gdate($myEvent->getEnd()));
                $list = $block->getList();
                $temp = array("id"=>$myEvent->getId(),
                              "date" => $myEvent->getStart()['dateTime'],
                              "segments" => $list,
                              "desc" => $myEvent->getDescription()
                              );
                              
                $return_array[]  = $temp;
            //}  
        }
        
    }else{
        $return_array = array("Error"=>'Invalid type');
    }

    header("Content-Type: application/json");
    echo json_encode($return_array);
    
    
    function custom_sort_by_start($a, $b) {
        return ($a['start'] < $b['start']);
    }

?>