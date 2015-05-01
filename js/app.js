/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 *
 * 
 */
(function(){
    var app = angular.module('ScheduleIt', []);
    
    app.controller('ScheduleController', ['$scope','$http', function($scope,$http){
    
        //Initialize Globals
        $scope.isEmptyWeek = true;
        $scope.maxWeeksCheck = 10;
        $scope.attempts = 0;
        $scope.calendarId = $('#cal').val();
        
        //Check if today is monday and if not, set it to the monday of this week
        $scope.controlDate = Date.today().is().monday() ? Date.today() : Date.now().last().monday();
        $scope.endDate = Date.today().is().monday() ? Date.today() : Date.now().last().monday();
        $scope.endDate.setDate($scope.controlDate.getDate()+4);
        
        //Do initial week get
        init().then(function(msg){
            $.blockUI({ message: '<h1>Finding Closest Times...</h1>' });
            getWeek($scope.controlDate, true);
            console.log(msg);          
        });

        //Refresh every minute
        setInterval( function(){
            init().then(function(msg){
                $.blockUI({ message: '<h1>Refreshing...</h1>' });
                getWeek($scope.controlDate, false);
                console.log(msg);
            });
        }, 60000 );
        
        function getWeek(today,traverse){   
            //All ensures that navigation buttons are not activated until all data 
            //has been received. 
            //Timeouts and retrys should be applied to each call
            Promise.all( [true,
                getDay(1,today).success(function(data1){
                    $scope.monday.push(data1);
                    console.log($scope.monday);
                }),
                
                getDay(2,today).success(function(data2){
                    $scope.tuesday.push(data2);
                    console.log($scope.tuesday);
                }),  
                
                getDay(3,today).success(function(data3){
                    $scope.wednesday.push(data3);   
                    console.log($scope.wednesday);
                }),      
                       
                getDay(4,today).success(function(data4){
                    $scope.thursday.push(data4);     
                    console.log($scope.thursday);
                }), 
                
                getDay(5,today).success(function(data5){
                    $scope.friday.push(data5);         
                    console.log($scope.friday); 
                })]
            ).then(function(){
                $("#traverseError").remove();
                
                var empty = $scope.monday[0].length==0&&
                    $scope.tuesday[0].length==0&&
                    $scope.wednesday[0].length==0&&
                    $scope.thursday[0].length==0&&
                    $scope.friday[0].length==0;
                    
                if(empty&&traverse&&$scope.attempts < $scope.maxWeeksCheck){ //Emtpy week while traversing
                        $scope.attempts += 1;
                        weekButtonCallback(1,'next',traverse);
                }else if($scope.attempts == $scope.maxWeeksCheck){ //We've hit the number of max traversals, quit and alert user
                    $scope.isEmptyWeek = empty;
                    $('#nav').css('visibility','visible');
                    $.unblockUI();
                    $scope.attempts = 0;
                    $scope.$apply();
                }else{ //All set, week with appointments found
                    $scope.isEmptyWeek = empty;
                    $('#nav *').css('visibility','visible');
                    $.unblockUI();
                    $scope.attempts = 0;
                    $scope.$apply();
                }   
            });  
        }
        
        // 1 = Monday
        // 2 = Tuesday etc..
        function getDay(ind,today){
            var temp_date = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay()+ind);
            temp_date = temp_date.toISOString();
            $scope.days.push(temp_date);
            console.log(encodeURI('./utilities/get.php?type=segments&calendar='+$scope.calendarId+'&date='+temp_date));
            return $http.get(encodeURI('./utilities/get.php?type=segments&calendar='+$scope.calendarId+'&date='+temp_date)); //RESTful call to get.php and return the promise
        }
        
        function init(){
            return new Promise(function(resolve,reject){
                //Disable the navigation buttons
                $('#nav').css('visibility','hidden');
                $scope.isEmptyWeek = true;
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
        
        //------------------Event Handlers---------------------------------------------
        //Signup button clicked
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
                            getWeek($scope.controlDate, true);
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
        
        //Week Naviagtion buttons clicked
        $(document).on('click','.weekButton', function(){
            weekButtonCallback( 1, $(this).attr('id'), false);
        });        
         
        //Refresh button clicked
        //TODO: update view, not refresh entire page
        $(document).on('click','#refresh',function(){
           location.reload();
        });
        
        //Next week available clicked (traversal)
        $(document).on('click','#nextavailable',function(){
            $.blockUI({ message: '<h1>Finding Closest Times...</h1>' });
            weekButtonCallback( 1, 'next', true);
        });
        
        
        //------------Callbacks----------------------------------------------------------
        function weekButtonCallback(num_weeks,id,traverse){
            init().then(function(){
                if(id=='next'){
                    $scope.controlDate.setDate($scope.controlDate.getDate() + (num_weeks*7)); 
                    $scope.endDate.setDate($scope.endDate.getDate() + (num_weeks*7));
                }else if(id=='last'){
                    $scope.controlDate.setDate($scope.controlDate.getDate() - (num_weeks*7)); 
                    $scope.endDate.setDate($scope.endDate.getDate() - (num_weeks*7));
                }else{
                
                }
                getWeek($scope.controlDate, traverse);
            });
        };
        
        
        //--------------Various Utility Initializations--------------------------------------
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
        
        //Author gnarf@stackoverflow.com
        //Question: http://stackoverflow.com/questions/2198741/jquery-ui-datepicker-making-a-link-trigger-datepicker
        var $dp = $("<input type='text' />").hide().datepicker({
            onSelect: function(dateText, inst) {
                init().then(function(){
                    $scope.controlDate = Date.parse(dateText).last().monday();
                    $scope.endDate = Date.parse(dateText).last().monday();
                    $scope.endDate.setDate($scope.controlDate.getDate()+4);
                    getWeek($scope.controlDate, false);
                });
            }
        }).appendTo('#nav');

        $("#datebutton").button().click(function(e) {
            if ($dp.datepicker('widget').is(':hidden')) {
                $dp.show().datepicker('show').hide();
                $dp.datepicker("widget").position({
                    my: "left bottom",
                    at: "right top",
                    of: this
                });
            } else {
                $dp.hide();
            }

            e.preventDefault();
        });
    } ]);
})();