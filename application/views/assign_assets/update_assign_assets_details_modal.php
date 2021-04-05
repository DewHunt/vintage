<div class="modal-content">

    <?php
    $assign_assets_information;
    $assets_information;

     /*echo '<pre>';
     echo print_r($assign_assets_information);
     echo '</pre>';
     die();*/
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Update Assets</h4>
    </div>

    <div class="modal-body">

        <form id="update_assign_assets_form" name="update_assign_assets_form" method="post" action="<?= base_url('assign_assets/update') ?>">

            <div class="form-group col-xs-12">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= $assign_assets_information->id ?>">

                <input type="hidden" class="form-control" id="assets_info_id" name="assets_info_id" value="<?= $assign_assets_information->assets_info_id ?>">

                <div class="form-group row">
                    <div class="form-group col-xs-12 col-sm-4">
                        <label for="assets_name" class="col-form-label">Asset Name</label>
                        <input readonly="readonly" type="text" class="form-control" id="assets_name" name="assets_name" value="<?= $assets_information->assets_name ?>" placeholder="">
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                        <label for="quantity" class="col-form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="<?= $assign_assets_information->quantity ?>" placeholder="">
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                        <button type="submit" class="btn btn-default add-product-button"
                                id="add-product-button">Update
                        </button>
                    </div>

                </div>

            </div>

        </form>

    </div>

    <div class="clearfix"></div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger modal-close-button" data-dismiss="modal">Close</button>
    </div>
</div>



