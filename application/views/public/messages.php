        <script type="text/javascript"> my_id = <?= $this->session->customer_id; ?>;</script>
        <section class="frame">
            <nav class="msg_nav">
              <header>
                 <h2>My Inbox</h2>
            </header>
            <div id="inbox_units">
             <?php if(!empty($inbox_units)) foreach ($inbox_units as $index => $unit) { ?>
             <figure class="inbox_unit" data-id="<?= $unit['chat_id']; ?>">
                 <img src="<?= user_image($unit); ?>">
                 <figcaption title="<?= $unit['first_name'] .' '.$unit['last_name'] ; ?>"><?= $unit['first_name'] .' '.$unit['last_name'] ; ?></figcaption>
                 <span class="badge" id="new_message_<?= $unit['chat_id']; ?>"><?php if($unseen_chats[$index]->chat_id == $unit['chat_id']) echo 'NEW';?></span>
             </figure>
             <?php } ?>
             </div>
             <script type="text/javascript">$('.msg_nav .inbox_unit:first-child').addClass('selected_inbox');</script>

         </nav>
         <section class="chat">
                <header>
                    <h3 id="to_user">RE : &nbsp;<a target="blank" href="<?= base_url('user/'.$messages->otherside_user[0]->id); ?>"><img src="<?= $user_image; ?>">&nbsp;<span id="re_name"> <?= $messages->otherside_user[0]->first_name . " ". $messages->otherside_user[0]->last_name ; ?></span></a></h3>
                </header>
             </header>
                          <div class="messages">
                          <?php foreach ($messages->messages as $message) { ?>
                    <figure class="<?php echo $message->to_user == $this->session->customer_id ? 'sent_message' : 'received_message' ?>">
                        <p><?= htmlspecialchars($message->content); ?></p>
                        <figcaption><?= explode(" ", $message->created)[1]; ?></figcaption>
                    </figure>
                    <?php } ?>
                </div>
               <script> $('.messages').scrollTop($('.messages')[0].scrollHeight); </script>
                 <div class="send_msg">
                        <textarea id="message" maxlength="300" rows="5"></textarea>
                        <button id="send_msg_btn" data-to_id=<?= $messages->otherside_user[0]->id ?>><span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
                    </div>          
        </section>
    </section>
</main>