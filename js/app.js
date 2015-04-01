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
       // $scope.events = [];
       // $scope.oldSegments = [];
        /*
        var temp_date = today.toISOString();
        var myDataPromise = myService.serviceTimes($scope.calendarId,temp_date);
        myDataPromise.then(function(result) {  // this is only run after $http completes
           $scope.data = result;
           console.log("data.name"+$scope.data.name);
        });*/
        
        $scope.calendarId = $('#cal').val();
        $scope.controlDate = Date.now().last().monday();
        $scope.endDate = Date.now().last().monday();
        $scope.endDate.setDate($scope.controlDate.getDate()+4);
        init().then(function(msg){
            getTimes($scope.controlDate);
            console.log(msg);
        });
        
        //Construct a week calendar based on current day
        //Make a function to retrieve different weeks
        
        //setInterval( getTimes, 10000 );
         
        $(document).on('click','#refresh',function(){
            init().then(function(msg){
                getTimes($scope.controlDate);
                console.log(msg);
            });
        });
        
        function getTimes(today){          
            getDay(1,today).success(function(data1){
                $scope.monday.push(data1);
                console.log($scope.monday);
            }); 
            
            getDay(2,today).success(function(data2){
                $scope.tuesday.push(data2);
                console.log($scope.tuesday);
            });   
            
            getDay(3,today).success(function(data3){
                $scope.wednesday.push(data3);   
                console.log($scope.wednesday);
            });       
                   
            getDay(4,today).success(function(data4){
                $scope.thursday.push(data4);     
                console.log($scope.thursday);
            });   
            
            getDay(5,today).success(function(data5){
                $scope.friday.push(data5);         
                console.log($scope.friday); 
            });              
            
        }
        
        // 1 = Monday
        // 2 = Tuesday etc..
        function getDay(ind,today){
            var temp_date = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay()+ind);
            temp_date = temp_date.toISOString();
            $scope.days.push(temp_date);
            console.log(encodeURI('./utilities/get.php?type=newSegments&calendar='+$scope.calendarId+'&date='+temp_date));
            return $http.get(encodeURI('./utilities/get.php?type=newSegments&calendar='+$scope.calendarId+'&date='+temp_date));
        }
        
        function init(){
            return new Promise(function(resolve,reject){
                $scope.segments = [];
                $scope.days = [];
                $scope.monday = [];
                $scope.tuesday = [];
                $scope.wednesday = [];
                $scope.thursday = [];
                $scope.friday = [];
                resolve("Promise Complete");
            });
        }
        
        
        $(document).on('click','#signupButton',function(){
            console.log($(".ui-selected")[0].id);
            $.blockUI();
            $.ajax({
                type:"POST",
                url:'utilities/signup.php',
                data:{
                    fullname: $("#SignUpName").val(),
                    email: $("#SignUpEmail").val(),
                    timeslot_id : $(".ui-selected")[0].id,
                    cal_id : $('#cal').val()
                },
                success: function(data){
                    if(data.status == 'success'){
                        console.log("SUCCESS: "+data.msg);
                        init().then(function(msg){
                            getTimes($scope.controlDate);
                            console.log("DONE LOADING");
                            console.log(msg);
                        });
                    }else if(data.status == 'error'){
                        $('#errorMsg').html(data.msg);
                        console.log("FAIL: "+data.msg);
                    }else{
                        console.log(data);
                    }
                },
                error: function(data){
                    console.log(data);
                },
                complete: function(){
                    $.unblockUI();
                }
            });
        });
        
        $(document).on('click','.weekButton',function(){
            var ref_this = this;
            init().then(function(){
                if($(ref_this).attr('id')=='next'){
                    $scope.controlDate.setDate($scope.controlDate.getDate() + 7); 
                    $scope.endDate.setDate($scope.endDate.getDate() + 7);
                }else if($(ref_this).attr('id')=='last'){
                    $scope.controlDate.setDate($scope.controlDate.getDate() - 7); 
                    $scope.endDate.setDate($scope.endDate.getDate() - 7);
                }else{
                
                }
                getTimes($scope.controlDate);
            });
        });
        
      $(function() {
        $( "#selectable" ).selectable({
            filter: 'div div div div:not(.closed)',
            selecting: function(event, ui){
            if( $(".ui-selected, .ui-selecting").length > 1){
                  $(ui.selecting).removeClass("ui-selecting");
            }
        }
        });
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

