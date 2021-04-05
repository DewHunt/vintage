<select id="allCustomer" name="customerId" class="form-control select2">
    <option value="">Please Select Customer</option>
    <option value="add new customer">Add New Customer</option>
    <?php foreach ($allCustomer as $customer): ?>
	    <?php
	    	if ($customer->id == $lastInsertedCustomerId) {
	    		$select = "selected";
	    	} else {
	    		$select = "";
	    	}
	    ?>
	    <option value="<?= $customer->id ?>" <?= $select ?>><?= $customer->client_name ?></option>
	<?php endforeach ?>
</select>