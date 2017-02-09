   <?php if($this->session->payment_success) $this->load->view('public/partials/payment_success');?>
<section class="content">
    <div class="filters">
        <div id="filter-panel" class="collapse-in collapse in filter-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="search_form" class="form-inline" role="form" method="post" action="<?php echo base_url('search'); ?>">
                        <div class="form-group">
                            <input type="text" name="query" class="form-control search_bar" placeholder="Search" value="<?php if(!empty($this->session->query)) echo $this->session->query; ?>" aria-label="...">
                            <h3>Category</h3>
                            <div class="toggle-button toggle-button--tuli category">
                                <input <?php if(!empty($this->session->sport) || empty($this->input->post('filter_products'))) echo 'checked'; ?> id="sport_category" type="checkbox" name="sport">
                                <label for="sport_category">Sport</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <div class="toggle-button toggle-button--tuli category">
                                <input <?php if(!empty($this->session->artistic)  || empty($this->input->post('filter_products'))) echo 'checked'; ?> id="artistic_category" type="checkbox" name="artistic">
                                <label for="artistic_category">Artistic</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <div class="toggle-button toggle-button--tuli category">
                                <input <?php if(!empty($this->session->creative) || empty($this->input->post('filter_products'))) echo 'checked'; ?> id="creative_category" type="checkbox" name="creative">
                                <label for="creative_category">Creative</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <div class="toggle-button toggle-button--tuli category">
                                <input <?php if(!empty($this->session->practical) || empty($this->input->post('filter_products'))) echo 'checked'; ?> id="practical_category" type="checkbox" name="practical">
                                <label for="practical_category">Practical</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <div class="toggle-button toggle-button--tuli category">
                                <input <?php if(!empty($this->session->technology) || empty($this->input->post('filter_products'))) echo 'checked'; ?> id="technology_category" type="checkbox" name="technology">
                                <label for="technology_category">Technology</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                        </div>
                        <h3>Popular among</h3>
                        <div class="form-group">
                            <div class="toggle-button toggle-button--tuli age-group">
                                <input id="kids_category" type="checkbox" name="kids" <?php if(!empty($this->session->kids) || empty($this->input->post('filter_products'))) echo 'checked'; ?>>
                                <label for="kids_category">Kids</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <div class="toggle-button toggle-button--tuli age-group">
                                <input id="teens_category" type="checkbox" name="teens" <?php if(!empty($this->session->teens) || empty($this->input->post('filter_products'))) echo 'checked'; ?>>
                                <label for="teens_category">Teens</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <div class="toggle-button toggle-button--tuli age-group">
                                <input id="adult_category" type="checkbox" name="adults" <?php if(!empty($this->session->adults) || empty($this->input->post('filter_products'))) echo 'checked'; ?>>
                                <label for="adult_category">Adults</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <div class="toggle-button toggle-button--tuli age-group">
                                <input id="elderly_category" type="checkbox" name="elderly" <?php if(!empty($this->session->elderly) || empty($this->input->post('filter_products'))) echo 'checked'; ?>>
                                <label for="elderly_category">Elderly</label>
                                <div class="toggle-button__icon"></div>
                            </div>
                            <h3>Price</h3>
                            <div class="form-group">
                                <b>€ 0</b> <input id="ex2" type="text" name="price" class="span2" value="<?php if($this->session->price_bottom != null || $this->session->price_top != null ){ echo $this->session->price_bottom.",".$this->session->price_top;} else {echo "0,500"; }?>" data-slider-min="0" data-slider-max="500" data-slider-step="5" data-slider-value="[<?php if($this->session->price_bottom != null || $this->session->price_top != null ){ echo $this->session->price_bottom.",".$this->session->price_top;} else { echo "0,500"; }?>]"/> <b>€ 500</b>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#filter-panel">
            <span class="glyphicon glyphicon-cog"></span> Advanced Search
        </button>
    </div>
    <div class="sorting">
        <div class="sorting_button">
           <a id="rating_order" class="desc" href="javascript:void(0)">Average Rating &nbsp;</a>
           <a id="price_order" href="javascript:void(0)">Price &nbsp;</a>
       </div>
   </div>
   <section class="product_list">
    <?php if(count($products) == 0) {echo "No products found";} else{ foreach ($products as $product) { ?>
    <a href="<?= base_url('product/'.$product->id); ?>">
        <article class="card">
            <figure>
                <?= $this->loading->pimg('../uploads/products/'.$product->id."/".$product->image); ?>
                <figcaption ><?= $product->name; ?></figcaption>
                <figcaption class="prod_category" ><?= $product->category; ?></figcaption>
                <?php
                 if($this->product->with_discount($product)) {
                { echo '<span id="discount">-'.$product->discount_percentage.'%</span>' ; }
           }
               ?>
           </figure>
           <?php
           if($new_price = $this->product->with_discount($product)) {
              echo '<span id="oldprice">'.number_format($product->price,2).'$</span><span id="newprice">'.number_format($new_price,2).'$</span>' ; 
          } else {echo '<span id="price">'.number_format($product->price,2).'$</span>';}
          ?>
      </article>
  </a>
  <?php } }?>
  <?= $this->ajax_pagination->create_links(); ?>
</section>

</section>


