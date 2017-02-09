 <script
  src="https://code.jquery.com/jquery-3.0.0.min.js"
  integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="
  crossorigin="anonymous"></script>
 <main>
            <header>
                <h2><?= $first_name." ".$last_name; ?>&nbsp;<?="<span style='color:lightgreen;font-weight:bold;font-size:0.7em;'>".$this->session->message."<span>"; ?></h2>
            </header>
            <section class="product_details">
                <h3>Edit customer details</h3>
                	<?php echo form_open_multipart(base_url('customer_control/customer_details/').$id,['id'=>'product_form','role'=>'form']);?>
                    <div class="column_first">
                        <div class="form-group">
                            <label for="customer_first_name">First Name</label>
                            <input required type="text" class="form-control" id="customer_first_name" value="<?= $first_name; ?>" name="first_name">
                        </div>
                        <div class="form-group">
                            <label for="customer_last_name">Last Name</label>
                            <input required type="text" class="form-control" id="customer_last_name" value="<?= $last_name; ?>" name="last_name">
                        </div>
                        <div class="form-group">
                            <label for="customer_email">Email</label>
                            <input required type="email" id="customer_email" class="form-control" value="<?= $email_address; ?>" name="email_address">
                        </div>
                    </div>
                    <div class="column_second"><div class="form-group">
                            <label for="address_street">Street</label>
                            <input type="text" class="form-control" id="address_street" value="<?= $street; ?>" name="street">
                        </div>
                        <div class="form-group">
                            <label for="address_city">City</label>
                            <input type="text" class="form-control" id="address_city" value="<?= $city; ?>" name="city">
                            <input type="hidden" name="customer_id" value="<?= $customer_id; ?>">
                        </div>
                        <div class="form-group">
                            <label for="address_zip">ZIP</label>
                            <input type="number" class="form-control" id="address_zip" value="<?= $zip_code; ?>" name="zip_code">
                        </div>
                        <div class="form-group">
                            <label for="address_Country">Country</label>
                             <select class="form-control" name="country" id="country"></select>
                    <script>
                    $(function(){
                        $.getJSON( "../../../assets/scripts/public/countries.json", function( data ) {  
                            $.each( data, function(index,country) {
                             $("#country").append("<option value='"+country.code+"'>"+country.name+"</option>");
                            });

                         country_customer = "<?= ucfirst($country); ?>";
                        if(country_customer.length > 0){
                            $("#country").find("option:selected").attr("selected",false);
                             $("#country").find("option[value="+country_customer+"]").attr("selected",true);
                        } 
                        });
                    });
                </script>
                        </div>
                        
                        <div class="buttons">
                            <button type="submit" class="btn btn-default">Edit</button>
                        </div>
                    </div>
                </form>
            </section>
        </main>










