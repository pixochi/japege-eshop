        
  <main>

        <div class="modal fade" id="new_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_title">Send a message !</h4>
                    </div>
                    <div class="modal-body">
                       <textarea id="message"></textarea>
<a href="#" id="send_msg_btn"  data-to_id="<?= $user['id']; ?>">SEND</a>
                      <!-- <a href="#" id="submit_message">send</a> -->
                    </div>
                    <div class="modal-footer">
                    <span id="message_confirmation" style="color:green; font-size: 2em;"></span>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>
       
        </div>

        <nav class="profile_nav">
            <figure class="profile_pic">
             <img height="300" width="300" src="<?= $user['image']; ?>">
                <figcaption><?= $user['first_name'] ." ".$user['last_name']; ?></figcaption>
            </figure>
            <div class="profile_info">
                <h3>Bio</h3>
            <p><?php if(!empty($user['bio'])){ echo preg_replace('/\v+/','<br>', $user['bio']); } else {echo $user['first_name'] ." likes to keep secrets.";} ?></p>
          <a href="#" data-toggle="modal" data-target="#new_message">Send a message</a>
            </div>
            
            
        </nav>

        <section class="frame">



        <h2 style="color:black; width: 100%; margin:0; display: block-inline !important; height: 100px;"><?= $user['first_name']; ?>'s Starter Packs</h2>
            <?php if(!empty($owned_products)){ foreach ($owned_products as $product) { ?>
            <a href="#" class="owned_product">
            <input class="product_id" type="hidden" value="<?= $product->id; ?>">
                <article>
                    <figure>
                        <img src="<?php echo base_url('assets/images/uploads/products/'.$product->id.'/'.$product->image); ?>">
                        <figcaption><?php echo $product->name; ?></figcaption>
                    </figure>
                </article>
            </a>
            <?php }} ?>
        </section>
    </main>
     <!-- <script type="text/javascript">$(function(){$("#new_message").modal();});</script> -->

