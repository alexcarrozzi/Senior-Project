<?php
    $prod = 1;
    $sp = $prod==0?"Senior-Project/":"";    
        
        
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/common.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/utilities/block.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/google_api_init.php";
    
    $type=$_REQUEST['type'];
    $eventId=isset($_REQUEST['id'])?$_REQUEST['id']:'';
    $calId=isset($_REQUEST['calendar'])?$_REQUEST['calendar']:'';
    
    $list = [];
    $return_array = [];
    
    if($type=='events'){
        $myEvents =  array("events"=>$events->getItems(),
                           "calId"=>CALID);
         $return_array = $myEvents;
    }elseif($type=="event"){
        $myEvent = $service->events->get($calId,$eventId);//make sure the calendarId isnt hard coded
        $return_array = array("id"         => $myEvent->getId(),
                              "start"      => $myEvent->getStart()['dateTime'],
                              "end"        => $myEvent->getEnd()['dateTime'],
                              "calendarId" => $myEvent->getOrganizer()['email']
                              );
        //print_r($myEvent);
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