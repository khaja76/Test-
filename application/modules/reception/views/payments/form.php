<h3 class="header smaller lighter">
    Payments
    <span class="pull-right">
        <span class="pull-right">
            <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
            <a href="<?php echo base_url(); ?>reception/payments" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
        </span>
    </span>
</h3>
<form class="form-horizontal text-center" id="frm" action="" method="post" enctype="multipart/form-data">
    <div class="col-md-offset-3 col-md-9">
        <div class="form-group">
            <label class="control-label col-md-2" for="job_id"><sup class="text-danger">*</sup> Job Id :</label>
            <div class="col-md-4">
                <select class="form-control input-sm" name="job_id" id="job_id">
                    <option value="">--Select Job Id--</option>
                    <option value="1">HFT/Job/1205462</option>
                    <option value="2">HFT/Job/1205462</option>
                    <option value="3">HFT/Job/1205462</option>
                </select>
            </div>
        </div>
        <div class="form-group" style='display:none'>
            <label class="control-label col-md-2"><sup class="text-danger">*</sup> Total Due :</label>
            <div class="col-md-4">
                <input type="text" name="due" class="form-control input-sm" value="1000"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2"><sup class="text-danger">*</sup> Payment Mode :</label>
            <div class="col-md-4">
                <select class="form-control input-sm" name="payment_type" id="payment_type">
                    <option value="">--Select Payment Mode--</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque"> Cheque</option>
                </select>
            </div>
        </div>
        <div class="form-group" style='display:none'>
            <label class="control-label col-md-2"><sup class="text-danger">*</sup> Cheque No :</label>
            <div class="col-md-4">
                <input type="text" name="cheque_no" class="form-control cheque_no input-sm" placeholder="Enter Cheque No"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2"><sup class="text-danger">*</sup> Amount :</label>
            <div class="col-md-4">
                <input type="text" name="amount" class="form-control input-sm" placeholder="Enter Amount">
            </div>
        </div>
    </div>
    <div class="col-md-offset-3 col-md-9">
        <div class="form-group">
            <label class="control-label col-md-2">Remarks :</label>
            <div class="col-md-6">
                <textarea name="remarks" class="form-control input-sm" rows="5" placeholder="Enter your remarks here..."></textarea>
            </div>
        </div>
    </div>
</form>
<div class="clearfix"></div>
<script>
    $(document).ready(function () {
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                job_id: {required: true},
                payment_type: {required: true},
                amount: {required: true},
                cheque_no: {required: true}
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            errorPlacement: function (error, element) {
                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },
            invalidHandler: function (form) {
            }
        });
        $('#payment_type').change(function () {
            var val = $(this).val();
            var div = $(this).closest('.form-group');
            if (val == 'Cheque') {
                div.next().show();
                $(".cheque_no").addClass('required');
            } else {
                div.next().hide();
                $(".cheque_no").removeClass('required');
            }
        });
        $('#job_id').change(function () {
            var val = $(this).val();
            var input = $(this).closest('.form-group');
            if (val == '') {
                input.next().hide();
            } else {
                input.next().show();
            }
        })
    })
</script>