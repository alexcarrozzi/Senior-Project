(function(){
    var app = angular.module('ScheduleIt', []);
    
    app.controller('ScheduleController', ['$http', function($http){
        var this_ref = this;
        this_ref.events = [];
        this_ref.segments = [];
        this_ref.calendarId = '';
        
        $http.get('./utilities/get.php?type=events').success(function(data){
            this_ref.events = data.events;
            this_ref.calendarId = data.calId;
            
            for(var i=0;i<this_ref.events.length;i++){
                var tempsegs = [];
                $http.get('./utilities/get.php?type=segments&id='+this_ref.events[i].id+'&calendar='+this_ref.calendarId).success(function(data){
                    this_ref.segments[data.segments.id] = data.segments.list;
                });
                //alert(JSON.stringify(this_ref.segments));
            }
        });
    } ]);
})();

$(document).ready(function(){
    

    $("form[name='SignUpStudent']").submit(function(f){
        f.preventDefault();
        $.ajax({
            type:"POST",
            url:'utilities/signup.php',
            data:{
                fullname: $("#SignUpName").val(),
                email: $("#SignUpEmail").val()//,
                //timeslot_id : $("#timeslot_id").val()
            },
            success: function(data){
                console.log("SUCCESS:"+data);
                //$("#SignUpSubmit").attr('disabled','disabled');
            },
            fail: function(data){
                console.log("FAIL:"+data);
            }
        });
    });
});