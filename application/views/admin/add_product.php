<main>
    <header>
        <h2>Create a Product <?="<span style='color:lightgreen;font-weight:bold;font-size:0.7em;'>".$this->session->message."<span>"; ?></h2>
    </header>
    <section class="create_product">
        <?php echo form_open_multipart(base_url('product_control/add_product/'),['id'=>'add_product_form','role'=>'form']);?>
        <div class="column_first">
            <div class="form-group">
                <label for="product_name">Name</label>
                <input required type="text" class="form-control" id="product_name" name="name">
            </div>
            <div class="form-group">
                <label for="product_category">Category</label>
                <input required type="text" class="form-control" id="product_category" name="category">
            </div>
            <div class="form-group">
                <label for="product_description">Description</label>
                <textarea required id="product_description" name="description" class="form-control" rows="10"></textarea>
            </div>
        </div>
        <div class="column_second">
           <div class="form-group">
            <label for="product_price">Price</label>
            <input required type="number" min="0" step="0.01" class="form-control" id="product_price" name="price">
        </div>
        <div class="form-group">
            <label for="product_quantity">Quantity</label>
            <input required type="number" min="1" class="form-control" id="product_quantity" value="1" name="quantity">
        </div>
    </div>
    <div class="column_third">
        <div class="form-group">
            <label for="discount_percentage">Discount (%)</label>
            <input type="number" min="1" max="99" class="form-control" id="discount_percentage" name="discount_percentage">
        </div>
        <div class="form-group">
            <label for="discount_finish">Discount until </label>
            <input type="datetime-local" step="1" class="form-control" id="discount_finish" name="discount_finish">
        </div>
        <div class="form-group">
            <img src="http://placehold.it/1000x1000" id="image">
            <label for="product_image">Image</label>
            <input required type="file" id="product_image" name="image">
            <p class="help-block">Higher resolution images in a 1:1 ratio prefered</p>
        </div>
        <div class="buttons">
            <button type="submit" class="btn btn-default">Create</button>
            <button class="btn btn-default" id="cancel"><a style="color:white;" href="<?= base_url('product_control/products'); ?>">Cancel</a></button>
        </div>

    </div>
</form>
</section>
</main>









