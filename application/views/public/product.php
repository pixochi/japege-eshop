    <section class="content">
        <div class="info_box">
            <div class="product_image">
               <?php $this->loading->pimg('../uploads/products/'.$product['id'].'/'.$product['image']); 

               if($this->product->with_discount($product)) {
             { echo '<span id="discount">-'.$product['discount_percentage'].'%</span>' ; }
            }
               ?>
            </div>
            <div class="product_information">
                <div class="product_header">
                    <h2><?= $product['name'] ?></h2>
                    <p><?= $product['category'] ?></p>
                    <p><?= round($product['avg_rating'],2) ?>/5</p>
                </div>
                <div class="description_area">
                    <p>Description</p>
                    <p><?= nl2br($product['description']); ?></p>
                </div>
            </div>
        </div>
        <div class="order_box">
            <div class="row_share">
                <div class="quantity">
                    <p>Quantity</p>
                    <input type="number" class="form-control" name="quantity" max="100" min="1" value="1">
                </div>
                <div class="share">
                   <a href=""><?php $this->loading->pimg('mainpage/facebook.svg'); ?></a>
                   <a href=""><?php $this->loading->pimg('mainpage/twitter.svg'); ?></a>
                   <a href=""><?php $this->loading->pimg('mainpage/linkedin.svg'); ?></a>
               </div>
           </div>
           <div class="row_buy">
            <div class="price">
                <p>
                <?php

               if($new_price = $this->product->with_discount($product)) {

              echo '<span id="oldprice">'.number_format($product['price'],2).'$</span><span id="newprice">'.number_format($new_price,2).'$</span>' ; 
            } else {echo '<span id="price">'.number_format($product['price'],2).'$</span>';}
                ?> 
                </p>
            </div>

            <div class="buy">
                <button class="to_cart">+ Add to cart <input type="hidden" name="id" value="<?= $product['id']; ?>"></button>
            </div>

        </div>
    </div>
    <div class="reviews">
          <nav>
                <ul class="nav nav-tabs">
                   <a class="review_btn" href="javascript:void(0);" onclick="getData(0,'all')"> <li role="presentation" class="active">All reviews</li></a>
                   <script>$(function(){$(".reviews ul").children()[0].focus();});</script>
                 <a class="review_btn" href="javascript:void(0);" onclick="getData(0,'positive')">  <li role="presentation">Positive Reviews &nbsp;
<span class="glyphicon glyphicon-plus"></span></li></a>

                     <a class="review_btn" href="javascript:void(0);" onclick="getData(0,'negative')"> <li role="presentation">Negative Reviews&nbsp;<span class="glyphicon glyphicon-minus"></span></li></a>

                    <!--  ALLOWS TO ADD A REVIEW ONLY FOR LOGGED IN CUSTOMERS -->
                      <?php if($this->session->customer_id){
                                if($this->db->from('comments')->where('customer_id',$this->session->customer_id)->where('product_id',$this->uri->segment($this->uri->total_segments()))->count_all_results()){
                                    echo "<p id='login_addreview'>You already added a review for this product. </p>";

                                }else{
                                     $this->load->view('public/partials/logged_in_addreview');
                                }
                    } else {
                        $this->load->view('public/partials/logged_out_addreview');
                        } ?>
                </ul>
            </nav>

        <div id="reviews">
                <script>
        function getData(page,filter){  
                        var segments = $(location).attr('href').split( '/' );
            var product_id = segments[segments.length - 1];

            $.ajax({
                method: "POST",
                url: "<?php echo '../index/ajaxreviews/'; ?>"+product_id+"/"+page,
                data: { page: page, filter: filter },
                success: function(data){
                    $('#reviews').html(data);
                }
            });
        }
        </script>
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
                        <?php echo nl2br(preg_replace('/\v+/','<br>', $review->content)); ?>
                    </p>
                </article>
            </div>
            <?php }} else {  ?>
             <p id="reviews_msg">No reviews here yet </p>
             <?php } ?>
             <?php echo $this->ajax_pagination->create_links(); ?>
        </div>
    </section>
