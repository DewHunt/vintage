<?php
	$order_summary = 
	"
    CREATE OR REPLACE VIEW view_order_summary AS
    SELECT `invoice_details`.`id`,`invoice_details`.`order_date`, COUNT(`invoice_details`.`branch_id`) AS `totalOrder`, `invoice_details`.`branch_id`, `invoice_details`.`user_id`, `branch_info`.`branch_name` AS `branchName`, SUM(`invoice_details`.`gross_payable`) AS subTotal, SUM(`invoice_details`.`total_vat`) AS vatTotal, SUM(`invoice_details`.`deduction`) AS discountAmount, SUM(`amount_to_paid`) AS payableAmount, SUM(`invoice_details`.`cash_payment`) AS `cashPayment`,sum(`invoice_details`.`card_payment`) AS `cardPayment`
    FROM `invoice_details` LEFT JOIN `branch_info` ON `branch_info`.`id` = `invoice_details`.`branch_id`
    WHERE `invoice_details`.`mode_of_payment` <> 'pending'
    GROUP BY DATE_FORMAT(`invoice_details`.`order_date`,'%Y-%M-%d'),`invoice_details`.`branch_id`
	"

    $order_summary_by_product = 
    "
    CREATE OR REPLACE VIEW view_order_summary_product AS
    SELECT `sale_product`.`id` AS `id`, `invoice_details`.`order_date` AS `order_date`,`sale_product`.`product_id` AS `product_id`, `product`.`product_name` AS `productName`,`invoice_details`.`branch_id` AS `branchId`, `branch_info`.`branch_name` AS `branchName`, SUM(`sale_product`.`quantity`) AS `quantity`, `sale_product`.`unit_price` AS `unit_price`, SUM(`sale_product`.`discount_amount`) AS `discount_amount`, SUM(`sale_product`.`sales_price_excluding_vat`) AS `sales_price_excluding_vat`, SUM(`sale_product`.`vat`) AS `vat`, SUM((`sale_product`.`sales_price_excluding_vat` + `sale_product`.`vat`)) AS `sales_price_including_vat`
    FROM `sale_product` 
    LEFT JOIN `invoice_details` ON `invoice_details`.`id` = `sale_product`.`invoice_id`
    LEFT JOIN `product` ON `product`.`id` = `sale_product`.`product_id`
    LEFT JOIN `branch_info` ON `branch_info`.`id` = `invoice_details`.`branch_id`
    GROUP BY DATE_FORMAT(`invoice_details`.`order_date`,'%Y-%M-%d'),`invoice_details`.`branch_id`,`sale_product`.`product_id`
    "

    $assignedBranchs = 
    "
    SELECT `branch_one`.*
    FROM `branch_info` AS `branch_one`
    LEFT JOIN `branch_info` AS `branch_two` ON FIND_IN_SET (`branch_one`.`id`,`branch_two`.`assign_outlet`) 
    WHERE `branch_two`.`assign_outlet` IS NULL
    "

    "SELECT `tbl_lifting_products`.`product_id`,`tbl_lifting_products`.`serial_no`
FROM `tbl_lifting_products`
LEFT JOIN `tbl_product_issue_lists` ON `tbl_product_issue_lists`.`serial_no` = `tbl_lifting_products`.`serial_no`
WHERE `tbl_product_issue_lists`.`serial_no` IS NULL"
?>