 <main>
        <section class="frame">
        <section id="review">
        <h2>Checkout</h2>      
                <article>
                <div class="checkout_row">
                    <p class="p_name_heading">Product Name</p>
                    <p class="p_quantity_heading">Quantity</p>
                    <p class="p_price_heading">Price per 1 quantity</p>
                </div>
                <?php if(!empty($products_in_cart)){ $price_total =0; foreach ($products_in_cart as $product) { 
                        if($new_price = $this->product->with_discount($product)){$product->price = $new_price;}
                    ?>
                <div class="checkout_row">
                     <p class="p_name"><?= $product->name; ?></p>
                    <p class="p_quantity"><?=$quantity_in_cart[$product->id]; ?></p>
                    <p class="p_price"><?php echo number_format($product->price,2); ?>$</p>
                </div>
                <?php $price_total += $quantity_in_cart[$product->id] * $product->price;}} ?>

                 <p class="p_total">Total</p>     
                <p class="p_total"><?= number_format($price_total,2); ?>$</p>
                </article>
            </section>
            <form action="<?= base_url('checkout'); ?>" method="post">
                <h3>Review your info before proceeding to payment</h3>
                 <?php if(!$this->session->customer_id) echo '<a href="'.base_url('login').'" class="login_redirect">Log in if you have an account</a>';?>
                <div id="japege_form">
                    <div class="info">
                        <h3>Recipient info</h3>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input required type="text" name="ship_first_name" class="form-control" id="first_name" value="<?= $this->session->first_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input required type="text" name="ship_last_name"  class="form-control" id="last_name" value="<?= $this->session->last_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="e-mail">E-mail</label>
                            <input required type="email" class="form-control" id="e-mail" value="<?= $this->session->email_address; ?>">
                        </div>
                    </div>
                    <div class="address">
                        <h3>Delivery Address</h3>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input required type="text" name="ship_address" class="form-control" id="street" value="<?= $address['street']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="zip">ZIP</label>
                            <input required type="number" name="ship_zip_code" class="form-control" id="zip" value="<?= $address['zip_code']; ?>"
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input required type="text" name="ship_city" class="form-control" id="city" value="<?= $address['city']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select name="ship_country" class="form-control" id="country">
                            </select>
                             <script>
                    $(function(){
                        $.getJSON( "../../../assets/scripts/public/countries.json", function( data ) {  
                            $.each( data, function(index,country) {
                             $("#country").append("<option value='"+country.code+"'>"+country.name+"</option>");
                            });

                          locale = Cookies.get("locale") ? Cookies.get("locale") : "";
                          country_code = locale.substr(locale.length -2, locale.length).toUpperCase();
                          has_locale = false, has_country = false;

                          country_customer = "<?= ucfirst($address['country']); ?>";
                        if(country_customer.length > 0){
                            has_country = true;
                            $("#country").find("option:selected").attr("selected",false);
                             $("#country").find("option[value="+country_customer+"]").attr("selected",true);
                        } 
                         if(!has_country && country_code.length > 0){
                            $("#country").find("option:selected").attr("selected",false);
                            $("#country").find("option[value="+country_code+"]").attr("selected",true);
                            has_locale = true;
                        } 

                        if(!has_country && !has_locale) {
                            $("#country").find("option:selected").attr("selected",false);
                            $("#country").find("option[value=DK]").attr("selected",true);
                        }
                        });
                    });
                </script>
                        </div>
                        <button type="submit" name="payment" class="btn btn-default">Proceed to payment</button>
                    </div>
                </div>
            </form>
            
        </section>
    </main>