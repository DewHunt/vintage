<label for="customer-information">Customer Information</label>

<table class="table table-bordered table-sm">
	<tbody>
		<tr class="customer-info-row"><th>Name</th><td><?= $customerInfo->client_name ?></td></tr>
		<tr class="customer-info-row"><th>Email</th><td><?= $customerInfo->email ?></td></tr>
		<tr class="customer-info-row"><th>Phone</th><td><?= $customerInfo->phone_number ?></td></tr>
		<tr class="customer-info-row"><th>Address</th><td><?= $customerInfo->address ?></td></tr>
	</tbody>
</table>