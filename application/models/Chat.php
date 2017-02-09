<?php
require_once('Dbobject.php');
class Chat extends Dbobject{

	public $customer_id;
	public $street;
	public $zip_code;
	public $city;
	public $country;
	protected $db_table = 'messages';
	public $editable_fields = ['customer_id','street','zip_code','city','country'];

  public function __construct()
  {
    parent::__construct();
  }

  public function add_message($to_user, $content){
    //get id of a logged in user
    $my_id = $this->session->customer_id;
    //check if a conversation between 2 users started
    $this->db->select('chat_id')->where(['from_user'=>$my_id, 'to_user'=>$to_user])
    ->or_where('(from_user = '.$this->db->escape($to_user).' AND to_user = '.$this->db->escape($my_id).')');
    $chat_id = $this->db->get('messages',0,1)->row()->chat_id;
    //start a new conversation if a conversation did not start yet
    if(count($chat_id) == 0) {$chat_id = ($this->db->select_max('chat_id')->get('messages')->row()->chat_id+1); }
    //send a message data
    $message = new stdClass();
    $message->chat_id = $chat_id;
    $message->from_user = $my_id;
    $message->to_user = $to_user;
    $message->content = $content;
    //save a message to DB
    $this->db->insert('messages',$message);
  }

    //load messages for a selected chat
  public function get_messages($chat_id, $last_message_id){

   $this->db->select(['id','to_user','from_user','content','created'])
   ->where('chat_id',$chat_id)
   ->where('id>',$last_message_id)
   ->order_by('created','DESC');
     //offset for loading of messages will be added soon
   $messages = $this->db->get('messages',15)->result();
   $messages = array_reverse($messages);
   //find id of a user on the otherside
   $otherside_user = new stdClass();
   $otherside_user->chat_id = $chat_id;
   foreach ($messages as $field => $value) {
    if($value->to_user == $this->session->customer_id){
     $otherside_user->id = $value->from_user;
     break;
   } else {
    $otherside_user->id = $value->to_user;
    break;
  }
}
//get information about a user on the other side
if(!empty($otherside_user->id)){
  $this->db->select(['id','first_name','last_name','image'])
  ->from('customers')
  ->where('id',$otherside_user->id);
  $otherside_user = $this->db->get()->result();
}
//send messages and otherside user info to a view
$chat_data['messages'] = $messages;
$chat_data['otherside_user'] = $otherside_user ? $otherside_user : '';

return $chat_data;
}

//get inbox data
public function get_inbox(){

  $my_id = $this->session->customer_id;
//get all chats of a logged in user
  $query = " select chat_id, from_user, to_user, created from
  (SELECT chat_id, from_user, to_user, created 
  FROM messages 
  WHERE from_user = '".$my_id."' OR to_user = '".$my_id."'
  ORDER BY created DESC
  )t group by chat_id";

  $inbox_info['chats'] = $this->db->query($query)->result();

//check if there exists any conversation
  if(!empty($inbox_info)){

   $this->db->select(['id','first_name','last_name','image']);
   foreach ($inbox_info['chats'] as $index => $chat_info) {
    if($chat_info->from_user == $my_id){
      $chat_overview[$index]['otherside_id'] = $chat_info->to_user;      
    } else {
      $chat_overview[$index]['otherside_id'] = $chat_info->from_user;
    }
    $chat_overview[$index]['chat_id'] = $chat_info->chat_id;
    $this->db->or_where('id',$chat_overview[$index]['otherside_id']);
  }
//get info about users on the other side
  $inbox_info['users'] = $this->db->get('customers')->result();

  foreach ($inbox_info['chats'] as $index => $chat_info) { 
   foreach ($inbox_info['users'] as $user_info) { 
    if($chat_info->from_user == $user_info->id || $chat_info->to_user == $user_info->id){
      $inbox_units[$index]['chat_id'] = $chat_info->chat_id;
      $inbox_units[$index]['created'] = $chat_info->created;
      $inbox_units[$index]['id'] = $user_info->id;
      $inbox_units[$index]['first_name'] = $user_info->first_name;
      $inbox_units[$index]['last_name'] = $user_info->last_name;
      $inbox_units[$index]['image'] = $user_info->image;
      continue(2);
    }
  }
}
return $inbox_units;

}
}
//check if there are any unseen messages
public function has_new_messages(){

  $unseen_chats = $this->db->select('chat_id')
  ->where('seen',NULL)
  ->where('to_user',$this->session->customer_id)
  ->group_by('chat_id')
  ->get('messages')->result();

  return $unseen_chats;
}

}
?>