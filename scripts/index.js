'use strict';
$(document).ready(function(){
    $('.delete_btn').on('click',function(){
        $(this).siblings('.choice').val('');
        $('#update_btn').trigger('click');
    });
    $('#new_option').focus();
});
