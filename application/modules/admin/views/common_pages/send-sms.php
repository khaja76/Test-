
<div id="SmsModal" class="modal fade" role="dialog">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-envelope"></span> Send Message  </h4>
            </div>
            <div class="modal-body">
               <?php if(!empty($transaction)){ ?>
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
                                        <input type="radio" id="to_customer" name="_smsTo" checked  value="1" class="ace"/>
                                        <label class="lbl" for="to_customer"> Customer</label>
                                        <input type="radio" id="to_company" name="_smsTo"  value="2" class="ace"/>
                                        <label class="lbl"  for="to_company"> Company</label>
                                        <input type="radio" id="to_both" name="_smsTo"  value="3" class="ace"/>
                                        <label class="lbl"  for="to_both"> Both </label>      
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
                                <label class="control-label col-sm-4" for="job-id-edit"><b>Id</b></label>
                                <div class="col-sm-8">
                                    <p id="job-Id" class="form-control-static"><?php echo  !empty($transaction['customer_id']) ?$transaction['customer_id'] :'' ?></p>
                                    <input type="hidden" class="sms_customer_id" name="sms_customer_id" value="<?php echo  !empty($transaction['customer_id']) ?$transaction['customer_id'] :'' ?>">
                                    <input type="hidden" class="sms_to_customer_mobile" name="sms_to_mobile[]" value="<?php echo  !empty($transaction['customer_mobile']) ?$transaction['customer_mobile'] :'' ?>">
                                    <input type="hidden" class="sms_to_customer_email" name="sms_to_email[]" value="<?php echo  !empty($transaction['customer_email']) ?$transaction['customer_email'] :'' ?>">
                                    <input type="hidden" class="sms_to_customer_company_mobile" name="sms_to_mobile[]" value="<?php echo !empty($inward['company_mobile']) ? $inward['company_mobile']  :'' ?>">
                                    <input type="hidden" class="sms_to_customer_compnay_email" name="sms_to_email[]" value="<?php echo  !empty($inward['company_mail']) ? $inward['company_mail']:'' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="job-id-edit"><b>Name</b> </label>
                                <div class="col-sm-8">
                                    <p id="job-Id" class="form-control-static"><?php echo  !empty($transaction['last_name']) ? $transaction['first_name'].' '.$transaction['last_name'] :$transaction['first_name'] ?></p>
                                   
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="job-id-edit"><b>Job Id</b> </label>
                                <div class="col-sm-8">
                                    <p id="job-Id" class="form-control-static"><?php echo  !empty($transaction['job_id']) ?$transaction['job_id'] :'' ?></p>
                                    <input type="hidden" class="sms_job_id" name="sms_job_id" value="<?php echo  !empty($transaction['job_id']) ?$transaction['job_id'] :'' ?>">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="job-id-edit"><b>DC </b></label>
                                <div class="col-sm-8">
                                    <p><?php echo  !empty($transaction['outward_challan']) ?$transaction['outward_challan'] :'-' ?></p>
                                   
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <?php if(!empty($_SESSION['ROLE']) && $_SESSION['ROLE']!='RECEPTIONIST'){?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="job-id-edit"><b>Quotation</b>  </label>
                                <div class="col-sm-8">
                                    <p><?php echo  !empty($transaction['quotation']) ?$transaction['quotation'] :'-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="job-id-edit"><b>Proforma</b>  </label>
                                <div class="col-sm-8">
                                    <p ><?php echo  !empty($transaction['proforma']) ?$transaction['proforma'] :'-' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="job-id-edit"><b> Status</b>  </label>
                                <div class="col-sm-8">
                                    <p id="job-Id" class="form-control-static"><?php echo  !empty($transaction['status']) ?$transaction['status'] :'-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="job-id-edit"><b>Payment Status </b> </label>
                                <div class="col-sm-8">
                                    <?php
                                    if($transaction['estimation_amt']=='0.00'){
                                        $status="<a href='".get_role_based_link()."/quotations/add/?type=inward_no&amp;value=".$inward['inward_no']."' class='label label-primary'> <i class='fa fa-plus'></i> Make Quote </a>";
                                    }else if(($transaction['estimation_amt']!='0.00') && ($transaction['estimation_amt']>$transaction['paid_amt'])){
                                        $estimation = !empty($transaction['estimation_amt']) ? $transaction['estimation_amt'] : 0;
                                        $paid = !empty($transaction['paid_amt']) ? $transaction['paid_amt'] : 0;
                                        $balance_amt = $estimation - $paid;
                                        $status="<label class='label label-danger'> Pending (".number_format($balance_amt,2).") </label>";
                                    }else if(($transaction['estimation_amt']!='0.00') && ($transaction['estimation_amt']==$transaction['paid_amt'])){
                                        $status="<label class='label label-success'>Completed</label>";
                                    }
                                    echo $status;
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-3"><b>Message </b> </label>
                                <div class="col-sm-9">
                                    <textarea class="autosize-transition form-control required" name="sms_message" rows="7" placeholder="Enter Description...">We are waiting for  your ************************* Thank You, from <?php echo !empty($branch_admin['name']) ? $branch_admin['name']:''; ?>, <?php echo !empty($branch['name']) ? $branch['name']:'';?>.<?php echo !empty($branch['address1']) ? $branch['address1']:'';?>,<?php echo !empty($branch['city']) ? $branch['city']:'';?>,<?php echo !empty($branch['state_name']) ? $branch['state_name']:'';?>,<?php echo !empty($branch['pincode']) ? $branch['pincode']:'';?> Phone: <?php echo !empty($branch['mobile_1']) ? $branch['mobile_1']:'';?>  .</textarea>
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
        $('.type_message').change(function(){
            if($(this).val()!='SMS')
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
            rules: {
                
            },
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
            if($(this).valid()){
                $("#_sendSMSBtn").prop('disabled', 'disabled');
                var th = $(this);
                var formData = th.serialize();
                var url="<?php echo base_url();?>";
                $.ajax({
                    type : 'POST',
                    url: url+'admin/send-sms/',
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