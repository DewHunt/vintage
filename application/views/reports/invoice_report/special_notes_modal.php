<style>
    .styled-checkbox {
        position: absolute;
        opacity: 0;
    }
    .styled-checkbox + label {
        position: relative;
        cursor: pointer;
        padding: 0;
        color: red;
        font-size: 16px;
        font-weight: 700;
    }
    .styled-checkbox + label:before {
        content: '';
        margin-right: 2px;
        display: inline-block;
        vertical-align: text-top;
        width: 20px;
        height: 18px;
        background: white;
    }
    .styled-checkbox + label:before {
        background: red;
    }
    .styled-checkbox:hover + label:before {
        background: red;
    }
    .styled-checkbox:focus + label:before {
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
    }
    .styled-checkbox:checked + label:before {
        background: red;
    }
    .styled-checkbox:disabled + label {
        color: #b8b8b8;
        cursor: auto;
    }
    .styled-checkbox:disabled + label:before {
        box-shadow: none;
        background: #ddd;
    }
    .styled-checkbox:checked + label:after {
        content: '';
        position: absolute;
        left: 5px;
        top: 9px;
        background: white;
        width: 2px;
        height: 2px;
        box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .unstyled {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
</style>
<div id="special-notes-modal" class="modal fade special-notes-modal"  tabindex="-1" role="dialog" aria-labelledby="add-narration-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="add-narration-modal-label">Special Notes</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label"></label>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                        <input id="invoice_checkbox" class="styled-checkbox invoice_checkbox" name="invoice_checkbox" type="checkbox" value="1">
                        <label for="invoice_checkbox">&nbsp;Invoice</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="special_notes" class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Notes</label>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                        <textarea id="special_notes" name="special_notes" class="form-control special_notes" placeholder="Special Notes" rows="4" required></textarea>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary send-button-modal" data-id="" href="<?= base_url('reports/invoice_report/send_pdf_as_email'); ?>">Confirm</button>
                <button type="button" class="btn btn-danger special-notes-modal-close-button" data-dismiss="modal">Close</button>
                <div class="col-xs-1 loading-image" style="padding-top: 40px; float: right; display: none;"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.special-notes-modal .special-notes-modal-close-button').unbind('click').click(function (e) {
        e.preventDefault();
        $('body').removeClass('modal-open');
        $('.special-notes-modal .modal-backdrop').remove();
        $('.special-notes-modal').removeClass('in');
//        $('.special-notes-modal').modal('hide');
//        $('.special-notes-modal .modal-content .overlay').fadeOut();
    });

    $('.special-notes-modal .special_notes').unbind('click').click(function () {
        $('.special-notes-modal .special_notes').css('border-color', '');
        $('.send-button-modal').prop("disabled", false);
    });

    $('.send-button-modal').click(function (e) {
        e.preventDefault();
        var invoiceDetailsId = $(this).attr('data-id');
        invoiceDetailsId = isNaN(invoiceDetailsId) ? 0 : invoiceDetailsId;
        var isInvoice = 0;
        if ($('input.invoice_checkbox').is(':checked')) {
            isInvoice = $('.invoice_checkbox').val();
        }
        var specialNotes = '';
        specialNotes = $('.special_notes').val();
        if (specialNotes !== '') {
            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                data: {'invoice_details_id': invoiceDetailsId, 'is_invoice': isInvoice, 'special_notes': specialNotes},
                success: function (data) {
                    if (data['isSent']) {
                        alert(data['message']);
                        $('.special-notes-modal .modal-content .overlay').fadeOut();
                        $('.special-notes-modal').modal('hide');
                    } else {
                        alert(data['message']);
                        return false;
                    }
                },
                beforeSend: function () {
                    $(".send-button-modal").hide();
                    $(".special-notes-modal-close-button").hide();
                    $('.special-notes-modal .loading-image').show();
                },
                complete: function () {
                    $(".send-button-modal").show();
                    $(".special-notes-modal-close-button").show();
                    $('.special-notes-modal .loading-image').hide();
                },
                error: function () {
                    console.log('Error Occured.');
                }
            });
        } else {
            $('.special-notes-modal .special_notes').css('border-color', 'red');
            return false;
        }
    });
</script>