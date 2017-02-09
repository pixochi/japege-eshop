    <section class="content">
        <div class="headings_row">
            <div class="image">
            </div>
            <div class="name">
                <p>Name</p>
            </div>
            <div class="quantity">
                <p>Quantity</p>
            </div>
            <div class="price">
                <p>Price</p>
            </div>
        </div>
<?php if(!empty($products_in_cart)){ foreach ($products_in_cart as $product) { ?>
        <div class="cart_row">
            <div class="image">
                <button class="remove-from-cart"><span class="glyphicon glyphicon-remove"></span></button>
                <?php $this->loading->pimg('../uploads/products/'.$product->id."/".$product->image); ?>
            </div>
            <div class="name">
                <p><?= $product->name; ?></p>
            </div>
            <div class="quantity">
                <input type="number" name="quantity"  min="1" max="100"
                 value="<?= $quantity_in_cart[$product->id]; ?>">
            </div>
            <div class="price">
                <p><?php 
                if($new_price = $this->product->with_discount($product)){
                    $product->price = $new_price;
                }
                echo number_format(($quantity_in_cart[$product->id] * $product->price),2);
                 ?></p>
            </div>
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">
        </div>
        <?php }} ?>
        <div id="checkout">
            <p id="price_total">Total 0$</p>
            <form>
                <input type="hidden" name="checkout_products">
                <input type="hidden" name="checkout_quantities">
                <input type="hidden" name="checkout_prices">
                <a href="<?= base_url('checkout'); ?>" class="btn btn-primary.btn-block">Checkout</a>
            </form>
        </div>
    </section>
