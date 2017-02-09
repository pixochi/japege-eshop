  <footer>
        <div class="about">
            <a href="<?= base_url('about'); ?>">About</a>
            <a href="<?= base_url('faq'); ?>">FAQ</a>
            <a href="<?= base_url('contact'); ?>">Contact</a>
        </div>
        <div class="email_signup">
            <h2>Stay connected !</h2>
            <form>
                <input type="text" name="emailsignup" class="form-control search_bar" placeholder="your.email@example.com">
            </form>
            <div class="social_media">
                <a href=""><?php $this->loading->pimg('mainpage/facebook.svg'); ?></a>
               <a href=""><?php $this->loading->pimg('mainpage/twitter.svg'); ?></a>
                <a href=""><?php $this->loading->pimg('mainpage/linkedin.svg'); ?></a>
            </div>
        </div>
    </footer>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php script_tag('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'); ?>
<?php script_tag('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.5.1/bootstrap-slider.min.js'); ?>
<?php $this->loading->pjs(['../config','live_search','cookie','cookie_handling']); ?>

<!-- scripts for /register page -->
<?php if( base_url('register') == base_url(uri_string()) ) $this->loading->pjs(['register_validation']); ?>

<!-- scripts for /search page -->
<?php if( base_url('search') == base_url(uri_string()) ) $this->loading->pjs(['sorting_buttons']); ?>

<!-- scripts for the main page -->
<?php if( base_url() == base_url(uri_string()) ) $this->loading->pjs(['../jquery-1.7.min','roundabout.min','carousel','scrolling']); ?>

<!-- scripts for the /edit_profile page -->
<?php if( base_url('edit_profile') == base_url(uri_string()) ) $this->loading->pjs(['profile_validation']); ?>

<!-- scripts for the /my_profile page -->
<?php if( base_url('my_profile') == base_url(uri_string()) ) $this->loading->pjs(['product_owners']); ?>

<!-- scripts for the /messages page -->
<?php if( base_url('messages') == base_url(uri_string()) ) $this->loading->pjs(['messages']); ?>

<!-- scripts for the /user page -->
  <?php if(preg_match("/user/",$this->uri->uri_string())){
        $this->loading->pjs(['new_message']);
        } ?>
<!-- scripts which checks if there are some new messages -->
<?php $this->load->model('login'); if($this->session->customer_id) {
    $this->loading->pjs(['check_inbox']);

    } ?>


<script type="text/javascript">
$('.addReview').on('click', function() {
    $('#create_review').modal('show');
});
    //checks if a review is too short in /product/?
    $('#review_form').submit(function(e){
        $review_text = $.trim($('#user_review').val());

        if($review_text.length < 10){
            $('#message').text('Your review should be longer');
            e.preventDefault();
        }
    });
//open the dropdown for logout/my_account
$('.user_button').on('click',function(){
    $('#user_dropdown').toggleClass('show');
});
</script>