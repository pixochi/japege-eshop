<main>
	<header>
		<h2>Order Details</h2>
	</header>
	<section class="order_details">
		<table id="orders_table" class="display list_table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="first-row headerSortDown header">ID</th>
					<th class="header">PRODUCT</th>
					<th class="header">PRICE/ITEM</th>
					<th class="header">QUANTITY</th>
					<th class="header">PRICE TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<?php for( $i=0 ;$i < count($order_details); $i++) { ?>
				<tr>
					<td>
						<a target="_blank" href="<?= base_url('product_control/product_details/'.$order_details[$i]->product_id); ?>">
							<?= $order_details[$i]->product_id; ?>
						</a>
					</td>
					<td><?= $products_info[$i]['name']; ?></td>
					<td><?= number_format($products_info[$i]['price'],2); ?></td>
					<td><?= $order_details[$i]->quantity; ?></td>
					<td><?= number_format($order_details[$i]->quantity * $products_info[$i]['price'],2); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>
</main>









