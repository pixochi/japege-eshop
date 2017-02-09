<?php if(!empty($reviews)) {foreach ($reviews as $review) { ?>
            <div class="review">
                <article>
                  <h2>&nbsp;<img src="<?= $review->customer_image; ?>" >
                    <?= $review->customer_name; ?> </h2>
                    <figure>
                    <?php  
                        for ($i=0; $i < $review->rating; $i++) { 
                            $this->loading->pimg('star.svg',["id"=>"star"]);
                        }
                    ?>
                    </figure>
                    <p>
                        <?php echo nl2br(preg_replace('/\v+/','<br>', $review->content));?>
                    </p>
                </article>
            </div>
            <?php }} else {  ?>
           <p id="reviews_msg">No reviews here yet </p>
             <?php } ?>
             <?php echo $this->ajax_pagination->create_links(); ?>