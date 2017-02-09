
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
