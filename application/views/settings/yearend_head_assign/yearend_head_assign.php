<div id="page-wrapper">
    <div class="row card-margin-top">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="">Yearend Head Assign</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 yearend_head_assign_form_block">
                            <form id="yearend_head_assign_form" name="yearend_head_assign_form" action="<?= base_url('settings/yearend_head_assign/save_yearend_head_assign') ?>" method="post">

                                <div class="form-group row">
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label class="form-control-label" for="closing_head_id">Closing Head</label>
                                        <select name="closing_head_id" id="closing_head_id" class="form-control">
                                            <option value="" name="closing_head_id">Please Select</option>
                                            <?php
                                            if (!empty($head_details_list)) {
                                                foreach ($head_details_list as $head) {
                                                    ?>
                                                    <option class="" value="<?= $head->id ?>" name="closing_head_id"><?= $head->head_name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4">
                                        <label class="form-control-label" for="opening_head_id">Opening Head</label>
                                        <select name="opening_head_id" id="opening_head_id" class="form-control">
                                            <option value="" name="opening_head_id">Please Select</option>
                                            <?php
                                            if (!empty($head_details_list)) {
                                                foreach ($head_details_list as $head) {
                                                    ?>
                                                    <option class="" value="<?= $head->id ?>" name="opening_head_id"><?= $head->head_name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3" style="padding-top: 40px">
                                        <button type="submit" class="btn btn-primary stock-transfer-challan-report-button" id="show-button">Save</button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-xs-12 yearend_head_assign_table_section">
                                <?php $this->load->view('settings/yearend_head_assign/yearend_head_assign_table_section', $this->data); ?>
                            </div>
                        </div>                
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.yearend_head_assign_form_block form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $(".yearend_head_assign_table_section").html(data);
                },
                error: function () {

                }
            });
        });
    });
</script>

