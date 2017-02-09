 <?php if($this->login->customer_logged) redirect(base_url());?>
<main>
        <form id="registration" class="register" method="post" action="<?= base_url(uri_string()); ?>">
        <h2>Register</h2>
         <div class="errors">
            <ul
            </ul>
        </div>
            <div class="form-group has-feedback">
                <label for="first_name">First name</label>
                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                 <span class="error" id="first_name_err"></span>
            </div>
            <div class="form-group has-feedback">
                <label for="last_name">Last name</label>
                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <span class="error" id="last_name_err"></span>
            </div>
            <div class="form-group has-feedback">
                <label for="email">Email address</label>
                <input type="email" name="email_address" class="form-control" id="email" placeholder="Email">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                 <span class="error" id="email_err"></span>
            </div>
            <div class="form-group has-feedback">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <span class="error" id="password_err"></span>
            </div>
            <div class="form-group has-feedback">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                 <span class="error" id="confirm_err"></span>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="form-control" id="submit" value="Register">
            </div>
              <a href="<?= base_url('login'); ?>">Already have an account ? Sign in here</a>
            
        </form>
    </main>
