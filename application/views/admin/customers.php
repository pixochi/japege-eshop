<main>
	<header>
		<h2>Customers</h2>
	</header>
	<section class="customers">
		<table id="customers_table" class="display list_table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="first-row headerSortDown header">ID</th>
					<th class="header">NAME</th>
					<th class="header">EMAIL</th>
				</tr>
			</thead>
			<tbody>
						<?php foreach($customers as $customer) {?>
				<tr>
					<td>
						<a href="<?= base_url('customer_control/customer_details/').$customer->id; ?>">
							<?= $customer->id; ?>
						</a>
					</td>
					<td><?= $customer->first_name ." ". $customer->last_name; ?></td>
					<td><?= $customer->email_address; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>
</main>









