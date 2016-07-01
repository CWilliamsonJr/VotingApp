'use strict';
$(document).ready(function(){
    /*
     *
     * Javascript used for the edit page
     *
     */

    $('.delete_btn').on('click',function(){ // deletes the option from the poll
       if(confirm('Are you sure you want to delete this?')){
           $(this).siblings('.choice').val(''); //find the correct option to delete
           $('#update_btn').trigger('click'); //clicks the update button to trigger the delete
       }
    });
    $('#new_option').focus(); // sets the focus to the add option box on the edit page

    /*
    *
    * Javascript for the make poll page.
    *
    */

    $("#add_option").click(function(){
        let newChoice = '<div class="form-group"><input class="input-width" type="text" name="poll_option[]" placeholder="Put your option here"></div>';
        $('#poll_options').append(newChoice);
    });
    $('#poll_topic').focus();

    
});
