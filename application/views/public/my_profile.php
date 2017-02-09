        
        <?php if($this->session->payment_success) $this->load->view('public/partials/payment_success');?>

        <div class="modal fade" id="user_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Users who also own this product</h4>
                    </div>
                    <div class="modal-body" id="users">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <section class="frame">
        <h2 style="color:black; width: 100%; margin:0; display: block-inline !important; height: 100px;">My Starter Packs</h2>
                <span><?= $this->session->payment_msg; ?></span>
            <?php if(!empty($owned_products)){ foreach ($owned_products as $product) { ?>
            <a href="#" class="owned_product" data-toggle="modal" data-target="#user_list">
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
