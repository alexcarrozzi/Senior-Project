/*  
 * All code in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 * The University of New Hampshire Computer Science Department owns and
 * is responsible for all functionality contained in the web application
 * ScheduleIt
 *
 * 
 */
    (function(){
    var app = angular.module('ScheduleIt', []);
    
    app.controller('ScheduleController', ['$scope','$http', function($scope,$http){
        $scope.events = [];
        $scope.segments = [];
        $scope.calendarId = $('#cal').val();
        
        getTimes();
        
        function getTimes(){
            $scope.segments = [];
            $http.get('./utilities/get.php?type=events&calendar='+encodeURIComponent($scope.calendarId)).success(function(data){
                $scope.events = data.events;
                $scope.calendarId = data.calId; 
                $($scope.events).each(function(i){
                    var this_event = [];
                    var my_id = $scope.events[i].id;
                    if($scope.events[i].description == null){
                        $http.get('./utilities/get.php?type=segments&id='+encodeURIComponent(my_id)+'&calendar='+encodeURIComponent($scope.calendarId)).success(function(data){
                            this_event.segments = data.segments;
                            this_event.id = data.id;
                            $scope.segments.push(this_event);
                        });
                    }
                });
            });
        }
        
        $("form[name='SignUpStudent']").submit(function(f){
            f.preventDefault();
            $.ajax({
                type:"POST",
                url:'utilities/signup.php',
                data:{
                    fullname: $("#SignUpName").val(),
                    email: $("#SignUpEmail").val(),
                    timeslot_id : $("input:radio[name=timeslot_id]:checked").val(),
                    cal_id : $('#cal').val()
                },
                success: function(data){
                    console.log("SUCCESS:"+data);
                    getTimes();
                    //$("#SignUpSubmit").attr('disabled','disabled');
                },
                fail: function(data){
                    console.log("FAIL:"+data);
                }
            });
        });
        
        
    } ]);
    
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
})();



//Various Functions

function ObjectDump(obj, name) {
  this.result = "[ " + name + " ]\n";
  this.indent = 0;
 
  this.dumpLayer = function(obj) {
    this.indent += 2;
 
    for (var i in obj) {
      if(typeof(obj[i]) == "object") {
        this.result += "\n" + 
          "              ".substring(0,this.indent) + i + 
          ": " + "\n";
        this.dumpLayer(obj[i]);
      } else {
        this.result += 
          "              ".substring(0,this.indent) + i + 
          ": " + obj[i] + "\n";
      }
    }
 
    this.indent -= 2;
  }
 
  this.showResult = function() {
    var pre = document.createElement('pre');
    pre.innerHTML = this.result;
    document.body.appendChild(pre);
  }
 
  this.dumpLayer(obj);
  this.showResult();
}