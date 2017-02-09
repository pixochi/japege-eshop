$(function(){
//SEND A NEW MESSAGE
  $("#send_msg_btn").on('click',function(){

    var message_content = $("#message").val();
    var to_user = $(this).data('to_id');

    if(message_content === "" || to_user.length == 0) return false;
    $("#message").val('');
    $.ajax({
  type: "POST",
  url: "../profile/ajax_add_message",
  data: {to_user: to_user, message_content: message_content},
  success: function(){
    $("#message_confirmation").text('Your message has been sent.');
    setTimeout(function(){$("#message_confirmation").text('');},4000);
}
});
    return false;
  });
});
