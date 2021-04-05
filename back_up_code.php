<?php
	$stockBranchId = $this->input->post('outlet');

	$isHotKitchenProduct = $this->Product_Model->getProductById($this->input->post('productId')[$i]);
	if ($isHotKitchenProduct->hot_kitchen_status == 1) {
		$isHotKitchenBranch = $this->Branch_Model->check_hot_kitchen($stockBranchId);
		$stockBranchId = $isHotKitchenBranch->id;
	}

	// --------------------------- ********** ---------------------------
	
    $branchStock = $this->Branch_stock_Model->is_branch_stock_exists($from_branch_id,$this->input->post('productId')[$i]);
    $branchStockData['stock'] = $branchStock->stock - $this->input->post('qty')[$i];
    $this->db->where('id',$branchStock->id);
    $this->db->update('branch_stock', $branchStockData);

	// --------------------------- ********** ---------------------------
?>
