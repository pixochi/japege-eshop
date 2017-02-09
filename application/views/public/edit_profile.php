 <section class="frame">
     <?php echo form_open_multipart(base_url('edit_profile/'),["id"=>"profile_form"]);?>
        <div id="japege_form">
            <div class="info">
                <h3>Profile info</h3>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $this->session->first_name; ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="<?= $this->session->last_name; ?>">
                </div>
                <div class="form-group">
                    <label for="e-mail">E-mail</label>
                    <input type="email" class="form-control" name="email_address" id="e-mail" value="<?= $this->session->email_address; ?>">
                </div>
                 <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?= $this->session->birthdate ?>">
                </div>
                <?php if(!$this->session->oauth_provider) $this->load->view('public/partials/edit_password'); ?>
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea type="text" class="form-control" name="bio" id="bio" placeholder="Write your bio" maxlength="301" rows="8"><?php if($bio = $this->session->bio) echo $bio; ?></textarea>
                    <span><span id="characters"></span>/300</span>
                    <script type="text/javascript">
                    $(function(){
                        $("#characters").text($("#bio").val().length);
                        $("#bio").on("input",function(){
                            $bio_length = $(this).val().length;
                            $("#characters").text($bio_length);
                        });
                    });
                    </script>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Change your profile picture (less than 2MB)</label>
                    <input name="image" type="file" id="exampleInputFile">
                </div>
            </div>
            <div class="address">
                <h3>Address</h3>
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" name="street" id="street" value="<?= $address['street'] ; ?>">
                </div>
                <div class="form-group">
                    <label for="zip">ZIP</label>
                    <input type="text" class="form-control" name="zip_code" id="zip" value="<?= $address['zip_code']; ?>">
                    <span class="error" id="zip_err"></span>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" id="city" value="<?= $address['city']; ?>">
                    <input type="hidden" name="customer_id" value="<?= $this->session->customer_id; ?>">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select class="form-control" name="country" id="country"></select>
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
            <button type="submit" name="submit" class="btn btn-default">EDIT</button>
            <span><?= $this->session->message; ?></span>
            <span><?= $this->session->message_img; ?></span>
        </div>
    </div>
</form>
</section>
</main>