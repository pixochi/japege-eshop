  <main>
        <nav class="profile_nav">
            <figure class="profile_pic">
                <img height="300" width="300" src="<?= $image; ?>">
                <figcaption><?= $this->session->first_name ." ".$this->session->last_name; ?></figcaption>
            </figure>
            <div class="profile_info">
                <h3>Bio</h3>
            <p><?php if($bio = $this->session->bio){ echo preg_replace('/\v+/','<br>', $bio); } else {echo "Write something about yourself and let other people know what you like to do, what are your hobbies and what you would like to learn.";} ?></p>
            <a href="<?= base_url('my_profile'); ?>">My starter packs</a>
            <a href="<?= base_url('edit_profile'); ?>">Edit Profile</a>
            <a href="<?= base_url('messages'); ?>" id="messages_btn">Messages</a>
            </div>
            
        </nav>