$(function(){

  if(Cookies.getJSON('unseen_message')){show_notification();};

  setInterval(function(){
    check_inbox();}, 2000);

  function check_inbox(){
    $.ajax({
      type: "POST",
      url: config.base_url+"/profile/ajax_check_inbox",
      data: {},
      success: function(unseen_chats){

       var unseen_messages = JSON.parse(unseen_chats);

       if(unseen_messages[0] != undefined){
        Cookies.set('unseen_message', 'true', { expires: 7, path: '/' });

        show_notification();
      } else {
        Cookies.set('unseen_message',null);
        $('.new_unseen_msg').remove();
      }
    }
  });
  }
});

function show_notification(){
  if(!$('.new_unseen_msg').length){
    $('<a>').attr('href',config.base_url+'/messages').addClass("new_unseen_msg glyphicon glyphicon-envelope").css({"color":"darkorange","font-size":"1.5em"}).appendTo('.user_button');
    $('<span>').addClass("new_unseen_msg glyphicon glyphicon-envelope").css({"color":"white","font-size":"1.5em"}).appendTo('#messages_btn');
  } 

}
