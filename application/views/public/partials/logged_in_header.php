				<?php $this->load->helper('image'); $image = profile_image(); ?>
				<div id="user_info" class="user_info_in">
                     <div class="user_button"><span class="login_text" id="logged_name"><img class="user_icon" src="<?= $image; ?>"><span class="user_name"><?php echo $this->session->first_name." ".$this->session->last_name;?></span></span></div>
                     <div id="user_dropdown">
                         <a href="<?= base_url('my_profile'); ?>" id="profile">My Profile</a>
                         <a href="<?= base_url('index/logout'); ?>">Logout</a>
                     </div>
                </div>