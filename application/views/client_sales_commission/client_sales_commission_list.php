<div id="page-wrapper">
    <div class="col-xs-12 row card-margin-top">
        <div class="create-new-button">
            <?php echo anchor(base_url('client_sales_commission/create_client_sales_commission'), '<i class=" fa fa-plus" aria-hidden="true"></i> Add New Client Sales Commission', 'class="btn btn-primary create-new-button"') ?>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class=""><?= !empty($page_title) ? $page_title : ''; ?></h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table table-striped" id="details-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Claim Date</th>
                                        <th>Insert Date</th>
                                        <th>Invoice</th>
                                        <th class="text-right"><?= 'Total Amount ' . '(' . get_currency() . ')' ?></th>
                                        <th class="action-fixed-width">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($client_sales_commission_list)) {
                                        $m_invoice_details = new Invoice_details_Model();
                                        $count = 1;
                                        $grand_total_amount = 0;
                                        foreach ($client_sales_commission_list as $client_sales_commission) {
                                            $id = intval($client_sales_commission->id);
                                            $cost_date = date("d-m-Y", strtotime($client_sales_commission->claim_date));
                                            $cost_date = (is_valid_date($cost_date)) ? $cost_date : '';
                                            $current_date = date("d-m-Y", strtotime($client_sales_commission->current_date_time));
                                            $current_date = (is_valid_date($current_date)) ? $current_date : '';
                                            $total_amount = !empty($client_sales_commission->commission_amount) ? get_floating_point_number($client_sales_commission->commission_amount) : 0;
                                            $grand_total_amount += $total_amount;
                                            $invoice_details = $m_invoice_details->get_invoice_details(intval($client_sales_commission->invoice_details_id));
                                            ?>
                                            <tr>
                                                <td><?= $count++; ?></td>
                                                <td><?= $cost_date; ?></td>
                                                <td><?= $current_date; ?></td>
                                                <td><?= (!empty($invoice_details->invoice_number)) ? $invoice_details->invoice_number : ''; ?></td>
                                                <td class="text-right"><?= get_floating_point_number($total_amount, TRUE); ?></td>
                                                <td class="action-fixed-width">
                                                    <a href="<?= base_url("client_sales_commission/update_client_sales_commission/$id") ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Update"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Grand Total</strong></td>
                                            <td class="text-right"><strong><?= get_floating_point_number($grand_total_amount, TRUE); ?></strong></td>
                                            <td class="action-fixed-width"></td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

</div>
<!-- /#page-wrapper -->

<!--Jquery Data Table-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#details-table').dataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
            "scrollY": "400px",
            "scrollX": true,
            "ordering": false,
        });
    });
</script>

