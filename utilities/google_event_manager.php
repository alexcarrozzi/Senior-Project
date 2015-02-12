<?php
    class Google_Event_Manager{
        //Google API Service
        private $_service;
        
        public function __construct($service){
            $this->_service = $service;
        }
        
        //Block is an array(start_time, end_time)
        //Segment is an array(start_time, end_time)
            //A segment is a minimum length block
        //Destroy block, create 3 new (open,reserved,open)
            //Unless block length == segment length
        //Divides into block array(  array($block[0],$target_segment[0]),
        //                           array($target_segment[0],$target_segment[1]),
        //                           array($target_segment[1],$block[1])
        //                        )
        
        //Ask about inserting student as attendee and email as attendeeEmail
        public function insert_segment($calendar_id, $block_id, $target_segment, $name, $email){
            $block_event = $this->_service->events->get($calendar_id, $block_id);
            $block = array(fmt_gdate($block_event->getStart()),fmt_gdate($block_event->getEnd()));
        
            //Divide segments
            $open_event1 = array($block[0],$target_segment[0]);
            $reserved_event = array($target_segment[0],$target_segment[1]);
            $open_event2 = array($target_segment[1],$block[1]);
            
            //Insert Open Events
            $event = new Google_Service_Calendar_Event();
            $event->setSummary('Advising Meeting');
            $event->setLocation('My Office');
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime(date(\DateTime::ATOM, $open_event1[0]));
            $event->setStart($start);
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime(date(\DateTime::ATOM, $open_event1[1]));
            $event->setEnd($end);
            $event->setDescription('open');
            $createdEvent1 = $this->_service->events->insert($calendar_id, $event);
            
            $event = new Google_Service_Calendar_Event();
            $event->setSummary('Advising Meeting');
            $event->setLocation('My Office');
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime(date(\DateTime::ATOM, $open_event2[0]));
            $event->setStart($start);
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime(date(\DateTime::ATOM, $open_event2[1]));
            $event->setEnd($end);
            $event->setDescription('open');
            $createdEvent3 = $this->_service->events->insert($calendar_id, $event);
          
            //Insert Actual Event
            $event = new Google_Service_Calendar_Event();
            $event->setSummary($name);
            $event->setLocation('My Office');
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime(date(\DateTime::ATOM, $reserved_event[0]));
            $event->setStart($start);
            $end = new Google_Service_Calendar_EventDateTime();
            $event->setDescription("Name: $name\nEmail:$email");
            $end->setDateTime(date(\DateTime::ATOM, $reserved_event[1]));
            $event->setEnd($end);
            //$attendee1 = new Google_Service_Calendar_EventAttendee();
            //$attendee1->setEmail('attendeeEmail');
            // ...
           // $attendees = array($attendee1,
                               // ...
            //                  );
            //$event->attendees = $attendees;
            $createdEvent2 = $this->_service->events->insert($calendar_id, $event);
            
            //Delete old Google event and add these 3
            $this->_service->events->delete($calendar_id, $block_id);
            
            return array($createdEvent1,$createdEvent2,$createdEvent3);
        }
        
        //$id is a colon delimeted string that seperates block index, segment index, and target block to delete
        //eg: '1:2' would be the third segment of the second block
        public function getSegmentById($id){
            $split = explode(':',$id);
            $i = $split[0];
            $j = $split[1];

            $segment = $_SESSION['segments'][$i][$j];
            $delete_event = $split[2];
            return array("segment" => $segment,"delete_event" => $delete_event);
        }
    }
?>