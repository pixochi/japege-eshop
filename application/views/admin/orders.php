<main>
	<header>
		<h2>Orders</h2>
	</header>
	<section class="orders">
		<table id="orders_table" class="display list_table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="first-row headerSortDown header">ID</th>
					<th class="header">DATE</th>
					<th class="header">COUNTRY</th>
					<th class="header">CITY</th>
					<th class="header">CUSTOMER</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($orders as $order) {?>
				<tr>
					<td><a target="_blank" href="<?= base_url('order_control/order_details/'.$order->id); ?>">
						<?= $order->id; ?>
					</a></td>
					<td><?= $order->order_date; ?></td>
					<td><?= $order->ship_country; ?></td>
					<td><?= $order->ship_city; ?></td>
					<td><a href="<?= base_url('customer_control/customer_details/'.$order->customer_id); ?>"><?= $order->customer_id; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>
</main>









