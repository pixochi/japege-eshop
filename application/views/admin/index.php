<?php $this->login->is_admin_logged(); ?>
<main>
	<header>
		<h2>Products <?="<span style='color:lightgreen;font-weight:bold;font-size:0.7em;'>".$this->session->message."<span>"; ?></h2>
		<a href="<?= base_url('product_control/add_product'); ?>"><button type="button" id="add_product_button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add a product</button></a>
	</header>
	<section class="products">
		<table id="products_table" class="display list_table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="first-row headerSortDown header">ID</th>
					<th class="header">NAME</th>
					<th class="header">CATEGORY</th>
					<th class="header">QUANTITY</th>
					<th class="header">PRICE</th>
					<th class="header">RATING</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $product) { ?>
				<tr>
					<td>
						<a target="_blank" href="<?php echo base_url('product_control/product_details/'.$product->id); ?>">
						<?= $product->id; ?>
						</a>
					</td>
					<td><?= $product->name; ?></td>
					<td><?= $product->category; ?></td>
					<td><?= $product->quantity; ?></td>
					<td><?= $product->price; ?></td>
					<td><?= $product->avg_rating; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>
</main>