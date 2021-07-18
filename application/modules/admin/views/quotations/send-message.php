<style>
    .modal-dialog{
        width:868px;
    }
</style>
<div id="SmsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-envelope"></span> Send Message </h4>
            </div>
            <div class="modal-body">
                <?php if (!empty($quotation)) { ?>
                    <form id="smsForm" class="form-horizontal" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job-id-edit"><b>Send as</b> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm required type_message" name="type_message">
                                            <option value="">---Select Type---</option>
                                            <option value="SMS">Sms</option>
                                            <option value="EMAIL">Email</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="recipient"><b>Recipient</b> </label>
                                    <div class="col-sm-8">
                                        <div class="radio-inline">
                                            <input type="radio" id="to_customer" name="_smsTo" checked value="1" class="ace"/>
                                            <label class="lbl" for="to_customer"> Customer</label>
                                            <input type="radio" id="to_company" name="_smsTo" value="2" class="ace"/>
                                            <label class="lbl" for="to_company"> Company</label>
                                            <input type="radio" id="to_both" name="_smsTo" value="3" class="ace"/>
                                            <label class="lbl" for="to_both"> Both </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row subject_row hide">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job-id-edit"><b>Subject</b> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="subject" class="form-control input-sm" placeholder="Email Subject"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job-id-edit"><b>Customer Id</b></label>
                                    <div class="col-sm-8">
                                        <p id="job-Id" class="form-control-static"><?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : '' ?></p>
                                        <input type="hidden" class="sms_customer_id" name="sms_customer_id" value="<?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : '' ?>">
                                        <input type="hidden" class="sms_to_customer_mobile" name="sms_to_mobile[]" value="<?php echo !empty($customer['customer_mobile']) ? $customer['customer_mobile'] : '' ?>">
                                        <input type="hidden" class="sms_to_customer_email" name="sms_to_email[]" value="<?php echo !empty($customer['email']) ? $customer['email'] : '' ?>">
                                        <input type="hidden" class="sms_to_customer_company_mobile" name="sms_to_mobile[]" value="<?php echo !empty($inward['company_mobile']) ? $inward['company_mobile'] : '' ?>">
                                        <input type="hidden" class="sms_to_customer_compnay_email" name="sms_to_email[]" value="<?php echo !empty($inward['company_mail']) ? $inward['company_mail'] : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job-id-edit"><b>Name</b> </label>
                                    <div class="col-sm-8">
                                        <p id="job-Id" class="form-control-static"><?php echo !empty($customer['customer_name']) ? $customer['customer_name'] : '';?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job-id-edit"><b>Quotation Id</b> </label>
                                    <div class="col-sm-8">
                                        <p id="job-Id" class="form-control-static"><?php echo !empty($quotation['quotation']) ? $quotation['quotation'] : '' ?></p>
                                        <input type="hidden" class="sms_job_id" name="sms_job_id" value="<?php echo !empty($quotation['pk_id']) ? $quotation['pk_id'] : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><b>Message </b> </label>
                                    <div class="col-sm-9">
                                        <textarea class="autosize-transition form-control required" name="sms_message" rows="7" placeholder="Enter Description...">Hi <?php echo !empty($customer['customer_name']) ? $customer['customer_name'] : '' ?>( <?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : '' ?> ),We are waiting for  your ************************* regarding Quotation:<?php echo !empty($quotation['quotation']) ? $quotation['quotation'] : '' ?>.Thank You, from <?php echo !empty($branch_admin['name']) ? $branch_admin['name']:''; ?>, <?php echo !empty($branch['name']) ? $branch['name']:'';?>,<?php echo !empty($branch['city']) ? $branch['city']:'';?>Phone: <?php echo !empty($branch['mobile_1']) ? $branch['mobile_1']:'';?>.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-offset-9 col-md-4">
                                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                    <button type="submit" id="_sendSMSBtn" class="btn btn-xs btn-success savebtnModl"><i class="fa fa-paper-plane"></i> Send</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <div id="message"></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.type_message').change(function () {
            if ($(this).val() != 'SMS')
                $('.subject_row').removeClass('hide');
            else
                $('.subject_row').addClass('hide');
            $('.subject_row').val('');
        });
        $('#smsForm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {},
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');
                $("#_sendSMSBtn").prop('disabled', false);
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        });
        $("#smsForm").on("submit", function (e) {
            e.preventDefault();
            if ($(this).valid()) {
                $("#_sendSMSBtn").prop('disabled', 'disabled');
                var th = $(this);
                var formData = th.serialize();
                var url = "<?php echo base_url();?>";
                $.ajax({
                    type: 'POST',
                    url: url + 'admin/quotations/send-sms/',
                    data: formData,
                    success: function (data) {
                        if (data == "TRUE") {
                            $("#message").html("<div class='text-success text-center'>Your message has been sent successfully</div>");
                           setInterval(function () {
                                location.reload(true);
                            }, 700);
                        }
                    }
                })
            }
        })
    });
</script>