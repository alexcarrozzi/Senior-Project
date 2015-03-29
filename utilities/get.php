<?php 
     $prod = 0;
     $sp = $prod==0?"Senior-Project/":""; 
        
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/common.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/block.php";
    
    $type=$_REQUEST['type'];
    $eventId=isset($_REQUEST['id'])?$_REQUEST['id']:'';
    $calId=isset($_REQUEST['calendar'])?$_REQUEST['calendar']:'';
    
    $GLOBALS['g_calid'] = $calId;
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/google_api_init.php";
    
    $list = [];
    $return_array = [];
    
    if($type=='events'){
        $temp_events = $events->getItems();
        $myEvents =  array("events"     =>$temp_events,
                           "calId"      =>$calId
                           );
         $return_array = $myEvents;
    }elseif($type=="event"){
        $myEvent = $service->events->get($calId,$eventId);//make sure the calendarId isnt hard coded
        $return_array = array("id"         => $myEvent->getId(),
                              "start"      => $myEvent->getStart()['dateTime'],
                              "end"        => $myEvent->getEnd()['dateTime'],
                              "calendarId" => $myEvent->getOrganizer()['email'],
                              "desc"       => $myEvent->getDescription()
                              );
    }elseif($type=='segments'){
        $myEvent = $service->events->get($calId,$eventId);//make sure the calendarId isnt hard coded
        if($myEvent->getDescription() == ''){
            $block = new Block(fmt_gdate($myEvent->getStart()),fmt_gdate($myEvent->getEnd()));
            $list = $block->getList();
        }  
        $return_array = array("id"         => $myEvent->getId(),
                              "segments"   => $list
                              );
    }else{
        $return_array = array("Error"=>'Invalid type');
    }

    echo json_encode($return_array);


?>