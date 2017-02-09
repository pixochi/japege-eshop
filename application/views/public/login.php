 <?php if($this->login->customer_logged) redirect(base_url());?>
 <main>
    <form class="login" method="post" action="<?= base_url('login'); ?>">
        <h2>Log in</h2>
        <div class="error">
            <?php echo $this->session->login_message; ?>
        </div>
        <div class="form-group">
            <label for="InputEmail">Email address</label>
            <input name="email_address" type="email" class="form-control" id="InputEmail" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="InputPassword">Password</label>
            <input name="password" type="password" class="form-control" id="InputPassword" placeholder="Password">
        </div>
        <div class="form-group">
            <input name="submit" type="submit" class="form-control" id="InputSubmit" value="Log in">
        </div>
        <aside>
            <div class="social">
                <a class="loginBtn loginBtn--facebook" href="<?= base_url('login/fb'); ?>">
                      Login with Facebook
              </a>
              <a class="loginBtn loginBtn--google" href="<?= base_url('login/google'); ?>">
                  Login with Google
          </a>
      </div>
      <a href="<?= base_url('register'); ?>">Don't have an account ? Register here</a>
  </aside>
</form>
</main>
