<div id="page-wrapper">
    <?php
        $client_list;
        $user_info = $this->session->userdata('user_session');
        $user_type = $user_info['user_type'];
        $settings_access = $user_info['settings_access'];
        $product_access = $user_info['product_access'];
        $client_access = $user_info['client_access'];
    ?>
    <?php if (!empty($this->session->flashdata('successMessage'))) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?= $this->session->flashdata('successMessage') ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->session->flashdata('errorMessage'))) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Opps!</strong> <?= $this->session->flashdata('errorMessage') ?>
        </div>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
              <div class="col-md-6"><h4 class="">Customer Details</h4></div>
              <div class="col-md-6 text-right">
                    <a href="<?= base_url('client/create_new_client') ?>" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New Client
                    </a>
                    <button type="button" class="btn btn-primary client-list-print-button">
                        <i class="fa fa-print" aria-hidden="true"></i> Print
                    </button>
              </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive table-bordered">
                <table class="table table-striped" id="details-table">
                    <thead>
                        <tr>
                            <th width="20px">SL</th>
                            <th width="150px">Name</th>
                            <th width="60px">Code</th>
                            <th width="60px">For</th>
                            <th width="100px">Mobile</th>
                            <th>Address</th>
                            <th width="150px">Email</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1 ?>
                        <?php foreach ($client_list as $client): ?>                            
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= ucfirst($client->client_name) ?></td>
                                <td><?= $client->client_code ?></td>
                                <td><?= $client->client_type ?></td>
                                <td><?= $client->cell_number ?></td>
                                <td><?= ucfirst($client->address) ?></td>
                                <td><?= $client->email ?></td>
                                <td>
                                    <a href="<?= base_url("client/update_client/$client->id") ?>" class="btn btn-primary">
                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>

                                    <a onclick="return delete_confirm();" href="<?= base_url("client/delete/$client->id") ?>" class="btn btn-danger">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->


<!--Display None-->
<!--For Print-->
<div id="client-print-information" style="width: 100%; display: none;">
    <style type="text/css">
        table {
          border-collapse: collapse;
          width: 100%;
        }

        table, td, th {  
          border: 1px solid #ddd;
          text-align: left;
        }

        th, td {
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
          /*background-color: #4CAF50;*/
          background-color: #999;
          color: white;
          text-align: center;
        }
    </style>

    <div style="width: 100%">
        <h2 style="text-align: center; font-size: 20px;">CLIENT LIST<hr></h2>
    </div>

    <table border="2px" cellspacing="0">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Code</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Email</th>
                <!-- <?php if ((string) (strtolower($user_type) != 'marketing') && (int) $settings_access > 0) { ?>
                    <th style="text-align: center; font-weight: bold; background-color: black; color: white; font-size: 18px">
                        Assigned Employee
                    </th>
                <?php } ?> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($client_list)) {
                foreach ($client_list as $client):
                    ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= ucfirst($client->client_name) ?></td>
                        <td><?= $client->client_code ?></td>
                        <td><?= $client->cell_number ?></td>
                        <td><?= ucfirst($client->address) ?></td>
                        <td><?= $client->email ?></td>
                        <!-- <?php if ((string) (strtolower($user_type) != 'marketing') && (int) $settings_access > 0) { ?>
                            <td><?= !empty($client->employee_name) ? ucfirst($client->employee_name) : '' ?></td>
                        <?php } ?> -->
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

</div>


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

        $(".client-list-print-button").on("click", function () {

            var divContents = $('#client-print-information').html();

            var printWindow = window.open();
            printWindow.document.write(divContents);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                    "<html><head><title></title></head><body>" +
                    divElements + "</body>";

            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
    });
</script>

<script>
    function delete_confirm() {
        var delete_confirmation_message = confirm("Are you sure to delete permanently?");
        if (delete_confirmation_message != true) {
            return false;
        }
    }
</script>
