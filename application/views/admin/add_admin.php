<main>
    <header>
    <h2>Add a new admin&nbsp;<?="<span style='color:lightgreen;font-weight:bold;font-size:0.7em;'>".$this->session->message."<span>"; ?></h2>
    </header>
    <section class="product_details">
        <h3>Fill out the form</h3>
        <form action="<?= base_url('admin/add_admin'); ?>" method="post">
            <div class="column_first">
                <div class="form-group">
                    <label for="admin_name">Name</label>
                    <input required type="text" name="name" class="form-control" id="admin_name">
                </div>
                <div class="form-group">
                    <label for="admin_password">Password</label>
                    <input required type="password" class="form-control" name="password" id="admin_password">
                </div>
                <div class="radio">
                    <label>
                        <input required type="radio" name="super_admin" value="1" > Super Admin
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input required type="radio" name="super_admin" value="0" > Regular Admin
                    </label>
                </div>
                <div class="buttons">
                    <button type="submit" class="btn btn-default">Add</button>

                </div>
            </div>
        </form>
    </section>
</main>





















