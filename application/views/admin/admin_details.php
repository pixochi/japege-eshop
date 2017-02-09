
<main>
    <header>
    <h2><?= $name; ?>&nbsp;<?="<span style='color:lightgreen;font-weight:bold;font-size:0.7em;'>".$this->session->message."<span>"; ?></h2>
    </header>
    <section class="product_details">
        <h3>Edit admin details</h3>
        <form action="<?= base_url('admin/admin_details/').$id; ?>" method="post">
            <div class="column_first">
                <div class="form-group">
                    <label for="admin_name">Name</label>
                    <input required type="text" value="<?= $name; ?>" name="name" class="form-control" id="admin_name">
                </div>
                <div class="form-group">
                    <label for="admin_password">Password</label>
                    <input required type="password" class="form-control" name="password" id="admin_password">
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="super_admin" value="1" <?php if($super_admin == "1") echo "checked"; ?>> Super Admin
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="super_admin" <?php if($super_admin == "0"){ echo "checked"; }?> value="0" > Regular Admin
                    </label>
                </div>
                <div class="buttons">
                    <button type="submit" class="btn btn-default">Edit</button>
                      <a  style="display: block;" href="<?= base_url('admin/delete_admin/').$id; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">
                    <button style="width: 100%;" type="button" class="btn btn-default" id="delete">
                        Delete
                    </button>
                </a>
                </div>
            </div>
        </form>

    </section>
</main>










