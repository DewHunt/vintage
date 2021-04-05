<div class="modal-content">

    <?php
    $assign_assets_by_employee_id;

    /* echo '<pre>';
      echo print_r($assign_assets_by_employee_id);
      echo '</pre>';
      die(); */
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Assign Assets Details</h4>
    </div>

    <div class="modal-body">

        <div class="form-group col-xs-12">


            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Employee &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; <?= ucfirst($employee_information->employee_name) ?></label>
            </div>
            <div class="col-xs-12">
                <label class="col-form-label left-side-view">Designation &nbsp;: &nbsp; &nbsp; &nbsp;<?= ucfirst($employee_information->designation) ?></label>
            </div>

            <div class="col-xs-12">

            </div>

            <div class="col-xs-12">

                <table class="table table-responsive table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th>SL</th>
                            <th>Asset Name</th>
                            <th>Quantity</th>
                            <th>Assign Date</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $count = 1;
                        foreach ($assign_assets_by_employee_id as $assign_assets):
                            ?>
    <?php $assign_date = date("d-m-Y", strtotime($assign_assets->assign_date)); ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $assign_assets->assets_name ?></td>
                                <td><?= $assign_assets->quantity ?></td>
                                <td><?= $assign_date ?></td>
                            </tr>
<?php endforeach; ?>

                    </tbody>
                </table>



            </div>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>

</div>



