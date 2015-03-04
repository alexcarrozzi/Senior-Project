$(document).ready(function(){
    $("form[name='SignUpStudent']").submit(function(f){
        //f.preventDefault();
        $("#SignUpSubmit").attr('disabled','disabled');
      /*  $.ajax({
            type:"POST",
            url:'.',
            data:{
                fullname: $("#SignUpName").val(),
                email: $("#SignUpEmail").val()
            },
            success: function(data){
                alert(data);
            },
            fail: function(data){
                alert(data);
            }
        });
    });*/
});