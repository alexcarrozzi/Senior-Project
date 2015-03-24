<?php
    //Constant for 30 minute segments
    define('DEFAULT_TIME',1800);
    
    class Block{
        
        //The main list of segments
	//Not used currently
        private $_list = array();
        
        private $_start;
        private $_end;
        private $_seg_duration;
        
        public function __construct($start_time, $end_time, $seg_duration = DEFAULT_TIME){
            $this->_start = $start_time;
            $this->_end = $end_time;
            $this->_seg_duration = $seg_duration;
        }
        
        public function getList(){
            return $this->evenly_segment_block(array($this->_start,$this->_end));
        }
        
        public function setStartTime($start){
            $this->_start = $start;
        }
        
        public function getStartTime(){
            return $this->_start;
        }
        
        public function setEndTime($end){
            $this->_end = $end;
        }
        
        public function getEndTime(){
            return $this->_end;
        }
        
        public function setSegmentDuration($seg){
            $this->_seg_duration = $seg;
        }
	
        //Evenly segments <empty> block for display
        //A block is an array('start_time', 'end_time')
	//TODO:
	//Handle Case: Block doesn't evenly divide by _seg_duration
		//eg: Block(11:00AM  - 12:15PM)
		//	Segment: 30 minutes
        private function evenly_segment_block($block){
            $segments = array();
            
            //Why???
            $unix_block = array($block[0],$block[1]);
            
            $i=1;
            $beginning = $unix_block[0];
            $end = $beginning;
            while($end < $unix_block[1]){
                $end+=$this->_seg_duration;
                $segments[$i++] = array("start"=>$beginning,"end"=>$end);
                $beginning = $end;
            }
      
            return $segments;
        }
    }
?>