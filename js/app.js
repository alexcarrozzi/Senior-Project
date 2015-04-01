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
    
    //I need to add a model for segments
    
    /*
    app.factory('myService',function($http,calId,date){
        var serviceTimes = function(){
            return $http.get(encodeURI('./utilities/get.php?type=newSegments&calendar='+calId+'&date='+date)).then(function(result){
                return result.data;
            });
        };
        return { serviceTimes: serviceTimes };
    });*/
    
    app.controller('ScheduleController', ['$scope','$http', function($scope,$http){
        $scope.events = [];
        $scope.segments = [];
        $scope.oldSegments = [];
        /*
        var temp_date = today.toISOString();
        var myDataPromise = myService.serviceTimes($scope.calendarId,temp_date);
        myDataPromise.then(function(result) {  // this is only run after $http completes
           $scope.data = result;
           console.log("data.name"+$scope.data.name);
        });*/
        
        $scope.days = [];
        $scope.days.monday = [];
        $scope.days.tuesday = [];
        $scope.days.wednesday = [];
        $scope.days.thursday = [];
        $scope.days.friday = [];
        
        
        $scope.firstLoad = true;
        $scope.calendarId = $('#cal').val();
        
        
        //Construct a week calendar based on current day
        //Make a function to retrieve different weeks
        
        //setInterval( getTimes, 10000 );
        getTimes();
        
        $(document).on('click','#refresh',function(){
            getTimes();
        });
        function getTimes(){
            //$scope.oldSegments = $scope.segments;
            //$scope.segments = [];  
            //////GET BY DAY/////////            
            getDay(1).success(function(data1){
                $scope.days.monday.push(data1);
            }); 
            
            getDay(2).success(function(data2){
                $scope.days.tuesday.push(data2);
            });   
            
            getDay(3).success(function(data3){
                $scope.days.wednesday.push(data3);  
            });       
                   
            getDay(4).success(function(data4){
                $scope.days.thursday.push(data4);     
            });   
            
            getDay(5).success(function(data5){
                $scope.days.friday.push(data5);          
            });              
            ///////END GET BY DAY/////
            
            
            /*
            $http.get('./utilities/get.php?type=events&calendar='+encodeURIComponent($scope.calendarId)).success(function(data){          
                $scope.events = data.events;
                $($scope.events).each(function(i){
                    var this_event = [];
                    var my_id = $scope.events[i].id;
                    if($scope.events[i].description == null){
                        $http.get('./utilities/get.php?type=segments&id='+encodeURIComponent(my_id)+'&calendar='+encodeURIComponent($scope.calendarId)).success(function(data1){
                            var len1 = 0;
                            var len2 = 0;
                            
                            if(typeof $scope.oldSegments[i] !== 'undefined'){
                                len1 = Object.keys($($scope.oldSegments[i].segments)[0]).length;
                                len2 = Object.keys($(data1.segments)[0]).length;   

                                //console.log($scope.oldSegments + "\n\n" + data1.segments);
                            }
                                //console.log(data);
                            console.log("len1: "+len1+" len2: "+len2+"\n");
                            
                            if((len1 != len2) && (!$scope.firstLoad)){
                                console.log("You may be out of sync! "+ len1 +" != "+ len2);
                                this_event.segments = data1.segments;
                                this_event.id = data1.id;
                                $scope.segments.push(this_event);
                                
                                $scope.days.dates.segments.push(this_event);
                                //$scope.firstLoad = false;
                            }else if($scope.firstLoad){
                                this_event.segments = data1.segments;
                                this_event.id = data1.id;
                                $scope.segments.push(this_event);
                               
                                $scope.days.dates.segments.push(this_event);
                            }else{
                                $scope.segments = $scope.oldSegments;
                                console.log("All Good");
                            }
                            console.log($scope.days);
                        });
                    }
                });
            });*/
        }
        
        // 1 = Monday
        // 2 = Tuesday etc..
        function getDay(ind){
            var today = Date.now();
            var temp_date = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay()+ind);
            temp_date = temp_date.toISOString();
            $scope.days.push(temp_date);
            console.log(encodeURI('./utilities/get.php?type=newSegments&calendar='+$scope.calendarId+'&date='+temp_date));
            return $http.get(encodeURI('./utilities/get.php?type=newSegments&calendar='+$scope.calendarId+'&date='+temp_date));
        }
        
        $("form[name='SignUpStudent']").submit(function(f){
            f.preventDefault();
            $.blockUI();
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
                },
                complete: function(){
                    $.unblockUI();
                }
            });
        });
        
        $(document).on('click','.weekButton',function(){
            if($(this).attr('id')=='next'){
                window.location.href = window.location.href + "?next";
                console.log("next");
            }else{
                window.location.href = window.location.href + "?last";
                console.log("last");
            }
        });
    } ]);
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

