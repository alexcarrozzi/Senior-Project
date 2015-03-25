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
            $(this_ref.events).each(function(i){
                var this_event = [];
                var my_id = this_ref.events[i].id;
                $http.get('./utilities/get.php?type=segments&id='+encodeURIComponent(my_id)+'&calendar='+encodeURIComponent(this_ref.calendarId)).success(function(data){
                    this_event.segments = data.segments;
                    this_event.id = data.id;
                    this_ref.segments.push(this_event);
                    console.log(this_ref.segments);
                });
            });
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




//

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