<?php
    //Constant for 30 minute segments
    define('DEFAULT_TIME',1800);
    
    class segment_list{
        
        //The main list of segments
        private $_list = array();
        
        private $_start;
        private $_end;
        private $_seg_duration;
        
        public function __construct($start_time, $end_time, $seg_duration = DEFAULT_TIME){
            $this->_start = $start_time;
            $this->_end = $end_time;
            $this->_seg_duration = $seg_duration;
            
            $this->_list = $this->segment_block(array($start_time,$end_time));
        }
        
        public function getList(){
            return $this->_list;
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
        
        //A block is an array('start_time', 'end_time')
        private function segment_block($block){
            $segments = array();
            $unix_block = array($block[0],$block[1]);
            
            $i=0;
            $beginning = $unix_block[0];
            $end = $beginning;
            while($end < $unix_block[1]){
                $end+=$this->_seg_duration;
                $segments[$i++] = array($beginning,$end);
                $beginning = $end;
            }
      
            return $segments;
        }
    }
?>