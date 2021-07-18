
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add payment </h4>
            </div>
            <div class="modal-body">
                <form id="paymentsForm" class="form-horizontal" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Job Id </label>
                                <div class="col-sm-6">
                                    <p id="job-Id" class="form-control-static"></p>
                                    <input type="hidden" class="class_inward_pk_id" name="inward_id">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-6" for="job-id-edit">Estimated Amount</label>
                                <div class="col-sm-6">
                                    <p id="estimationAmt" class="form-control-static"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Paid Amount </label>
                                <div class="col-sm-6">
                                    <p id="paidAmt" class="form-control-static"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Due Amount </label>
                                <div class="col-sm-6">
                                    <p id="dueAmt" class="form-control-static"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="paymentMode">Make payment via </label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm" id="paymentModeID" name="payment_mode">
                                        <option value="CASH">Cash</option>
                                        <option value="CHEQUE">Through Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" col-sm-6 control-label"> Amount <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control input-sm amount" autofocus="autofocus" id="amt" name="amount" onkeypress="return isNumber(event);" placeholder="Enter Amount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hide" id="transDiv">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="job-id-edit"><span class="class_trans"></span> <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="cheque_no" class="form-control input-sm cheque_no" placeholder="Enter Cheque No."/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group hide" id="bankDiv">
                                <label class="control-label col-sm-3" for="job-id-edit">Bank Details </label>
                                <div class="col-sm-9">
                                    <textarea  name="bank_details" class="form-control bank_details" rows="3" placeholder="Enter Cheque Bank Details"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Remarks </label>
                                <div class="col-sm-9">
                                    <textarea class="autosize-transition form-control" name="remarks" rows="3" placeholder="Enter Description..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-offset-9 col-md-4">
                                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                <button type="submit" id="submitButton" class="btn btn-xs btn-success savebtnModl"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div id="message"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".add-payment-dialog").on('click', function (e) {
            e.preventDefault();
            var inward_id;
            inward_id = $(this).data('inward');
            $.ajax({
                type : 'POST',
                url : '<?php echo base_url();?>admin/inwards/getInwardById/',
                data : {inward_id: inward_id},
                dataType : 'json',
                cache : false,
                success : function(data){
                   if(data.length !== 0){
                        $('.cheque_no,.amount').val('');
                        $('#job-Id').text(data.job_id);
                        $('#estimationAmt').html(data.estimation_amt);
                        $('#paidAmt').html(data.paid_amt);
                        $('.class_inward_pk_id').val(data.pk_id);
                        var dueS=(parseFloat(data.estimation_amt)-parseFloat(data.paid_amt)).toFixed(2);
                        if(data.estimation_amt=='0.00'){
                            $('.savebtnModl').attr('disabled',true);
                        }
                        $('#dueAmt').html(dueS);
                        
                       
                    }else{
                        console.log('No Data');
                    }
                }
            })
        });
        var ttype = $('#paymentModeID');
        ttype.change(function () {
            var lblTxt;
            $('#transDiv').removeClass('hide');
            if (ttype.val() == 'CASH') {
                $('#transDiv').addClass('hide');
                $('#bankDiv').addClass('hide');
            } else {
                lblTxt = 'Cheque No';
                $('#bankDiv').removeClass('hide');
                $('.cheque_no').attr('required',true);
            }
            $('.class_trans').html(lblTxt);
        });
        $('#paymentsForm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                amount: {required: true},
                payment_mode: {required: true},
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $("#submitButton").prop('disabled', false);
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        });
        $("#paymentsForm").on("submit", function (e) {
            e.preventDefault();
            $("#submitButton").prop('disabled', 'disabled');
            var th = $(this);
            var formData = th.serialize();
            $.ajax({
                type : 'POST',
                url: '<?php echo base_url();?>admin/payments/paymentToInward/',
                data: formData,
                success: function (data) {
                    console.log(data);
                    if (data == "TRUE") {
                        $("#message").html("<div class='text-success text-center'>Payment for this Job Id successfully Added</div>");
                        setInterval(function () {
                            location.reload(true);
                        }, 1000);
                    }
                }
            })
        })
    });
</script>