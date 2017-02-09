$(function(){

check_inbox();
setInterval(function(){
  var chat_id = $('.selected_inbox').data('id');
  get_messages(chat_id,false);
  check_inbox();}, 2000);

	$("#send_msg_btn").on('click',function(){

		var message_content = $("#message").val();
		var to_user = $(this).data('to_id');

		if(message_content === "" || to_user.length == 0) return false;
    $("#message").val('');
		$.ajax({
  type: "POST",
  url: "../profile/ajax_add_message",
  data: {to_user: to_user, message_content: message_content},

  success: function(new_message){display_messages(new_message);}
});
    $('.messages').scrollTop($('.messages')[0].scrollHeight);
		return false;
	});

$("figure.inbox_unit").on("click",function(){
  var chat_id = $(this).data('id');
  $(".messages").html('');
  //2nd parameter is true when all messages are required
  get_messages(chat_id,true);
  $('#to_user img').attr('src',$(this).children('img').attr('src'));
  $('figure.inbox_unit').removeClass('selected_inbox');
  $(this).addClass('selected_inbox');

});


function display_messages(messages_data){


	if(messages_data.trim().length > 0){

  	var chat_data = JSON.parse(messages_data);

  	var messages = chat_data.messages;
  	var otherside_user = chat_data.otherside_user;
   
    $('#to_user a').attr('href',config.base_url+'/user/'+otherside_user[0].id);
     $('#to_user #re_name').text(otherside_user[0].first_name +' '+otherside_user[0].last_name);
     $('#send_msg_btn').data('to_id',otherside_user[0].id);

  	var messages_html = [];
  	  $.each(messages, function(i,message){  

          var message_class = message.to_user == my_id ? 'sent_message' : 'received_message';
  	  		$message = $("<figure class = '"+message_class+"''>");
          $message.append($('<p>').text( message.content));
          $message.append($('<figcaption>').text(message.created.split(" ")[1]));

            messages_html.push($message);
  	 
  	   $('.messages').append.apply($('.messages'), messages_html);
        $('.messages').scrollTop($('.messages')[0].scrollHeight); 
});
}}

//GET ALL MESSAGES
	function get_messages(chat_id,all_messages = false){
		$.ajax({
  type: "POST",
  url: "profile/ajax_get_messages",
  data: {chat_id: chat_id, all: all_messages },
  success: function(response){
 	display_messages(response);

  }
});
	}

//CHECK IF A NEW MESSAGE ARRIVED
  function check_inbox(){
    $.ajax({
  type: "POST",
  url: "profile/ajax_check_inbox",
  data: {},
  success: function(unseen_chats){
 var unseen_messages = JSON.parse(unseen_chats);
 $('.inbox_unit .badge').text('');
 $.each(unseen_messages,function(i,unseen_message){
 $('#new_message_'+unseen_message.chat_id).text('NEW');
 });

  }
});
  }
});
