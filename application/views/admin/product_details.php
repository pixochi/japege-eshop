  <main>
  	<header>
  		<h2><?= $name; ?>&nbsp;<?="<span style='color:lightgreen;font-weight:bold;font-size:0.7em;'>".$this->session->message."<span>"; ?></h2>
  	</header>
  	<section class="product_details">
  		<h3>Edit product details</h3>
  		<?= form_open_multipart(base_url('product_control/product_details/').$id,['id'=>'product_form','role'=>'form']);?>
  		<div class="column_first">
  			<div class="form-group">
  				<label for="product_name">Name</label>
  				<input required type="text" class="form-control" id="product_name" value="<?= $name; ?>" name="name">
  			</div>
  			<div class="form-group">
  				<label for="product_category">Category</label>
  				<input required type="text" class="form-control" id="product_category" value="<?= $category; ?>" name="category" >
  			</div>
  			<div class="form-group">
  				<label for="product_description">Description</label>
  				<textarea required id="product_description" class="form-control" rows="10" name="description"><?= $description; ?></textarea>
  			</div>
  		</div>
  		<div class="column_second">
  			<div class="form-group">
  				<label for="product_price">Price</label>
  				<input required type="number" min="0" step="0.01" class="form-control" id="product_price" value="<?= $price ?>" name="price">
  			</div>
  			<div class="form-group">
  				<label for="product_quantity">Quantity</label>
  				<input required type="number" min="1" class="form-control" id="product_quantity" value="<?= $quantity; ?>" name="quantity">
  			</div>
  		</div>
  		<div class="column_third">
  			<div class="form-group">
  				<label for="discount_percentage">Discount (%)</label>
  				<input type="number" min="1" max="99" class="form-control" id="discount_percentage" value="<?= $discount_percentage; ?>" name="discount_percentage">
  			</div>
  			<div class="form-group">
  				<label for="discount_finish">Discount until </label>
  				<input type="datetime-local" step="1" class="form-control" id="discount_finish" value="<?= $discount_finish; ?>" name="discount_finish">
  			</div>
  			<div class="form-group">
  				<img src="<?= base_url('assets/images/uploads/products/'.$id."/".$image); ?>" id="image">
  				<label for="product_image">Image</label>
  				<input type="file" id="product_image" name="image">
  				<p class="help-block">Higher resolution images in a 1:1 ratio prefered</p>
  			</div>
  			<div class="buttons">
  				<button type="submit" name="edit" class="btn btn-default">Edit</button>
  				<a  style="display: block;" href="<?= base_url('product_control/delete_product/').$id; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
  					<button style="width: 100%;" type="button" class="btn btn-default" id="delete">
  						Delete
  					</button>
  				</a>

  			</div>

  		</div>
  	</form>
  </section>
</main>










