<?php
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 * The University of New Hampshire Computer Science Department owns and
 * is responsible for all functionality contained in the web application
 * ScheduleIt
 *
 * google_event_manager.php
 * This class is used to define a service object that interfaces with the
 * Google calendar itself. This is responsible for managing time blocking,
 * insertions, deletions, and updates to Google Calendar Events. Additionally,
 * This file will utilize email.php to send confirmation emails after the sign-up
 * process has completed.
 */
    //require_once 'logger.php';
    define('OPEN_MESSAGE','Open Time');

    class Google_Event_Manager{
        //Google API Service
        private $_service, $_email;
        
        public function __construct($service){
            $this->_service = $service;
            //$this->_email = new Email('professor.jones567@gmail.com');
        }
        
        //Block is an array(start_time, end_time)
        //Segment is an array(start_time, end_time)
            //A segment is a minimum length block
        //Destroy block, create 3 new blocks (open,reserved,open)
            //Unless block length == segment length
        //Divides into block array(  array($block[0],$target_segment[0]),
        //                           array($target_segment[0],$target_segment[1]),
        //                           array($target_segment[1],$block[1])
        //                        )
        
        //TODO:
        //Test Cases:
            //First segment sign up
                //Doesn't delete open time
            //Last segment sign up
                //Adds new open time slot after
            //block length = segment length (only a 30 minute slot available)
                //Doesn't delete open time
                //AND
                //Adds new open time slot after
        
        public function insert_segment($calendar_id, $block_id, $target_segment, $name, $email){
            $block_event = $this->_service->events->get($calendar_id, $block_id);
            $block = array(fmt_gdate($block_event->getStart()),fmt_gdate($block_event->getEnd()));
            //Divide segments
            $open_event1 = array($block[0],$target_segment[0]);
            $reserved_event = array($target_segment[0],$target_segment[1]);
            $open_event2 = array($target_segment[1],$block[1]);

            
            $case = 'middle';
            
            if($reserved_event[0] == $block[0]){
                $case = 'first';
            }
            if($reserved_event[1] == $block[1]){
                $case = 'last';
            }
            if($reserved_event[0] == $block[0] && $reserved_event[1] == $block[1]){
                $case = 'both';
            }
            
            $createdEvent1 = '';
            $createdEvent2 = '';
            $createdEvent3 = '';
            
            if($case != 'first' && $case !='both'){
                //Insert Open Events
                $event = new Google_Service_Calendar_Event();
                $event->setSummary(OPEN_MESSAGE);
                $event->setLocation('My Office');
                $start = new Google_Service_Calendar_EventDateTime();
                $start->setDateTime(date(\DateTime::ATOM, $open_event1[0]));
                $event->setStart($start);
                $end = new Google_Service_Calendar_EventDateTime();
                $end->setDateTime(date(\DateTime::ATOM, $open_event1[1]));
                $event->setEnd($end);
                $event->setDescription('');
                try{
                    $createdEvent1 = $this->_service->events->insert($calendar_id, $event);
                }catch(Exception $e){
                   //Logger::write("Error Inserting Google Event - Google_Event_Manager::insert_segment()");                
                }
            }
            
            if($case != 'last' && $case !='both'){
                $event = new Google_Service_Calendar_Event();
                $event->setSummary(OPEN_MESSAGE);
                $event->setLocation('My Office');
                $start = new Google_Service_Calendar_EventDateTime();
                $start->setDateTime(date(\DateTime::ATOM, $open_event2[0]));
                $event->setStart($start);
                $end = new Google_Service_Calendar_EventDateTime();
                $end->setDateTime(date(\DateTime::ATOM, $open_event2[1]));
                $event->setEnd($end);
                $event->setDescription('');
                
                try{
                    $createdEvent3 = $this->_service->events->insert($calendar_id, $event);
                }catch(Exception $e){
                    //Logger::write("Error Inserting Google Event - Google_Event_Manager::insert_segment()");                
                }
            }
            //Insert Actual Event
            $event = new Google_Service_Calendar_Event();
            $event->setSummary($name);
            $event->setLocation('My Office');
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime(date(\DateTime::ATOM, $reserved_event[0]));
            $event->setStart($start);
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime(date(\DateTime::ATOM, $reserved_event[1]));
            $event->setEnd($end);
            $event->setDescription($name);
            $attendee1 = new Google_Service_Calendar_EventAttendee();
            $attendee1->setEmail($email);
            //new attendee for instructor
            $attendees = array($attendee1);//add instructor attendee
            $event->attendees = $attendees;
            try{
                $createdEvent2 = $this->_service->events->insert($calendar_id, $event);
            }catch(Exception $e){
                //Logger::write("Error Inserting Google Event - Google_Event_Manager::insert_segment()");                
            }
            
            //Delete old Google event and add these 3
            try{
                $this->_service->events->delete($calendar_id, $block_id);
             //Nail down this exception type
            }catch(Exception $e){
                //Logger::write("Google Event Already Deleted - Google_Event_Manager::insert_segment() $e->message()");
            }
            return array($createdEvent2->getId(),$reserved_event[0]);
        }
        
        //This function will simply change the title and description of the event to appear open
        public function delete_event($cal_id,$event_id){
            $event = $this->_service->events->get($cal_id, $event_id);
            $event->setSummary('Open Time');
            $event->setDescription('');
            $event->attendees = array();

            $updatedEvent = $this->_service->events->update($cal_id, $event->getId(), $event);

            return $event->getStart()['dateTime'];
        }
        
        //$id is a colon delimeted string that seperates block index, segment index, and target block to delete
        //eg: '1:2' would be the third segment of the second block
        public function getSegmentById($id){
            $split = explode(':',$id);
            $segment = array($split[0], $split[0]+1800);
            $delete_event = $split[1];
            return array("segment" => $segment,"delete_event" => $delete_event);
        }
    }
?>