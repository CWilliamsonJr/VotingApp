$(document).ready(function(){
    $('.form-group').on('click','.delete_btn',function(){

        // $.ajax({
        //   type: "POST",
        //   url: './dashboard.php',
        //   data: {'form':$(this).siblings('.choice').val(),'Task':'Delete_something'},
        //   success: console.log('it worked')
        // });
        $.post( "./dashboard.php", {Task:'Delete_something'},function(){console.log('working')} );
    });


});
