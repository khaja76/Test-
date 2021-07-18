<style>
    .w-12 {
        width: 12%;
    }
</style>
<h3 class="header smaller lighter">
    Payments
    <span class="pull-right">
    </span>
</h3>
<form class="form-inline text-center" action="" enctype="multipart/form-data" method="get">
    <div class="form-group">
        <label for="payment-sel">Payment Status :</label>
    </div>
    <div class="form-group">
        <?php $statusList = ['all' => 'All', 'success' => 'Payment Done', 'due' => 'Payment Dues']; ?>
        <select class="form-control input-sm" name="payment-status" id="payment-sel">
            <?php
            foreach ($statusList as $key => $value) {
                ?>
                <option value="<?php echo $key ?>" <?php echo (isset($_GET['payment-status']) && ($_GET['payment-status'] == $key)) ? 'selected' : '' ?>><?php echo $value; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <?php $statusList = ['job_id' => 'Job Ids', 'invoice' => 'Invoice Nos']; ?>
        <select class="form-control input-sm" required name="payment-type" id="payment-type">
            <?php
            foreach ($statusList as $key => $value) {
                ?>
                <option value="<?php echo $key ?>" <?php echo (isset($_GET['payment-type']) && ($_GET['payment-type'] == $key)) ? 'selected' : '' ?>><?php echo $value; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Get Records</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="space"></div>
<?php
if (!empty($_GET['payment-status']) && !empty($_GET['payment-type']) && ($_GET['payment-type']=='job_id') && !empty($inwards)) {
    ?>
    <table class="table table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
        <thead>
        <tr>
            <th>S. No</th>
            <th width="200">Job Id</th>
            <th>Amount ( <i class="fa fa-inr"></i> )</th>
            <th>Amount Paid ( <i class="fa fa-inr"></i> )</th>
            <th>Amount Dues ( <i class="fa fa-inr"></i> )</th>
            <th> History</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($inwards as $inward) {
            $estimation = !empty($inward['estimation_amt']) ? $inward['estimation_amt'] : 0;
            $paid = !empty($inward['paid_amt']) ? $inward['paid_amt'] : 0;
            $balance = $estimation - $paid;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td>
                    <input type="hidden" class="tbl_inward_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>
                    <?php include currentModuleView('admin') . 'common_pages/inward-view-url.php'; ?>
                </td>
                <td><?php echo !empty($inward['estimation_amt']) ? $inward['estimation_amt'] : '-'; ?></td>
                <td><?php echo !empty($inward['paid_amt']) ? $inward['paid_amt'] : '-'; ?></td>
                <td><?php echo number_format($balance, 2); ?></td>
                <td><a href="<?php echo get_role_based_link(); ?>/payments/history/?inward=<?php echo $inward['inward_no'] ?><?php echo (!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == 'SUPER_ADMIN')) ? '&branch_id=' . $inward['branch_id'] : '' ?>" data-toggle="tooltip" title="Click to View Payment History" class="label label-info btn-xs">Show </a></td>
                <td>
                    <?php
                    if ($balance == 0) {
                        if ($inward['estimation_amt'] > 0) { ?>
                            <label class="label label-success"> <i class="fa fa-check"></i>&nbsp;&nbsp; Debited &nbsp; </label>
                        <?php } else {
                            if ($_SESSION['ROLE'] == 'ADMIN') {
                                if(empty($inward['invoice_id'])){ ?>
                                <a href="<?php echo get_role_based_link(); ?>/quotations/add/?type=inward_no&amp;value=<?php echo $inward['inward_no'] ?>" class="label label-primary"> <i class="fa fa-plus"></i> Make Quote </a>
                                <?php }
                                ?>
                                
                                <?php
                            } else {
                                ?>
                                <label class="label label-danger"> <i class="fa fa-times"></i>&nbsp;&nbsp; Access Denied &nbsp; </label>
                            <?php }
                        }
                        ?>
                        <?php
                    } else {
                        ?>
                        <a class="label label-warning add-payment-dialog " data-toggle="modal" data-target="#myModal"><span data-toggle="tooltip" data-placement="top" title="Click to Add Payment"> <i class="fa fa-hourglass-o"></i> &nbsp; &nbsp;Pending &nbsp;&nbsp;&nbsp;</span></a>
                        <?php
                    } ?>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
<?php } 
if (!empty($_GET['payment-status']) && !empty($_GET['payment-type']) && ($_GET['payment-type']=='invoice') && !empty($inwards)) {
    ?>
    <table class="table table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
        <thead>
        <tr>
            <th>S. No</th>
            <th width="200">Invoice Id</th>
            <th>Amount ( <i class="fa fa-inr"></i> )</th>
            <th>Amount Paid ( <i class="fa fa-inr"></i> )</th>
            <th>Amount Dues ( <i class="fa fa-inr"></i> )</th>
            <th>View</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($inwards as $inward) {
            $estimation = !empty($inward['final_amount']) ? $inward['final_amount'] : 0;
            $paid = !empty($inward['paid_amt']) ? $inward['paid_amt'] : 0;
            $balance = $estimation - $paid;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td>
                    <input type="hidden" class="tbl_invoice_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>
                    <?php echo !empty($inward['invoice']) ? $inward['invoice'] : '-'; ?>
                </td>
                <td><?php echo !empty($inward['final_amount']) ? $inward['final_amount'] : '-'; ?></td>
                <td><?php echo !empty($inward['paid_amt']) ? $inward['paid_amt'] : '-'; ?></td>
                <td><?php echo number_format($balance, 2); ?></td>
                <td><a href="<?php echo get_role_based_link(); ?>/payments/history/?invoice=<?php echo $inward['pk_id']; ?><?php echo (!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == 'SUPER_ADMIN')) ? '&branch_id=' . $inward['branch_id'] : '' ?>" data-toggle="tooltip" title="Click to View Payment History" class="label label-info btn-xs">Show </a></td>
                <td>
                    <?php
                    if ($balance == 0) {
                        if (!empty($inward['final_amount']) && ($inward['final_amount'] > 0)) { ?>
                            <label class="label label-success"> <i class="fa fa-check"></i>&nbsp;&nbsp; Debited &nbsp; </label>
                        <?php }
                        ?>
                        <?php
                    } else {
                        ?>
                        <a class="label label-warning add-invoice-payment" data-toggle="modal" data-target="#myModal"><span data-toggle="tooltip" data-placement="top" title="Click to Add Payment"> <i class="fa fa-hourglass-o"></i> &nbsp; &nbsp;Pending &nbsp;&nbsp;&nbsp;</span></a>
                        <?php
                    } ?>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
<?php }
else if(empty($_GET['payment-type']) || empty($inwards)){
    ?>
    <div class="text-center text-danger">No Data found !</div>
    <?php
} ?>
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
                                    <p id="jobId" class="form-control-static"></p>
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
                                    <select class="form-control input-sm" id="paymentModeID" onchange="disableJobFormSubmit()" name="payment_mode">
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
                                    <input class="form-control input-sm amount" type="number" onkeyup="disableJobFormSubmit()" autofocus="autofocus" id="amt" name="amount" placeholder="Enter Amount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hide" id="transDiv">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="job-id-edit"><span class="class_trans"></span> <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="cheque_no" onkeyup="disableJobFormSubmit()" id="jobCheque" class="form-control input-sm cheque_no" placeholder="Enter Cheque No."/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group hide" id="bankDiv">
                                <label class="control-label col-sm-3" for="job-id-edit">Bank Details </label>
                                <div class="col-sm-9">
                                    <textarea name="bank_details" class="form-control bank_details" rows="3" placeholder="Enter Cheque Bank Details"></textarea>
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
                                <button type="submit" id="submitButton" class="btn btn-xs btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="invoiceForm" class="form-horizontal" style="display: none;" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-6" for="job-id-edit">Total Amount</label>
                                <div class="col-sm-6">
                                    <input type="hidden" class="hidden_invoice_id" name="invoice_id">
                                    <p id="totalAmt" class="form-control-static"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Paid Amount </label>
                                <div class="col-sm-6">
                                    <p id="invoice_paidAmt" class="form-control-static"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Due Amount </label>
                                <div class="col-sm-6">
                                    <p id="invoice_dueAmt" class="form-control-static"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="paymentMode">Make payment via </label>
                                <div class="col-sm-6">
                                    <select class="form-control input-sm" onchange="disableInvoiceSubmit()" id="invoice_paymentMode" name="payment_mode">
                                        <option value="CASH">Cash</option>
                                        <option value="CHEQUE">Through Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-6 control-label" for="invoice_amt"> Amount <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control input-sm amount" onkeyup="disableInvoiceSubmit()" autofocus="autofocus" type="number" id="invoice_amt" name="amount" placeholder="Enter Amount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 hide" id="invoice_ChequeDiv">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="invoice_cheque"><span class="class_trans">Cheque No.</span> <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="cheque_no" id="invoice_cheque" onkeyup="disableInvoiceSubmit()" class="form-control input-sm cheque_no" placeholder="Enter Cheque No."/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group hide" id="invoice_bankDiv">
                                <label class="control-label col-sm-3" for="invoice_bank_details">Bank Details </label>
                                <div class="col-sm-9">
                                    <textarea name="bank_details" class="form-control bank_details" id="invoice_bank_details" rows="3" placeholder="Enter Cheque Bank Details"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="invoice_remarks">Remarks </label>
                                <div class="col-sm-9">
                                    <textarea class="autosize-transition form-control" id="invoice_remarks" name="remarks" rows="3" placeholder="Enter Description..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-offset-9 col-md-4">
                                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                <button type="submit" id="invoiceSubmit" class="btn btn-xs btn-success"><i class="fa fa-save"></i> Save</button>
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
        $('.amount').focusout(function () {
            var dAmt = $('#dueAmt').html();
            dAmt = parseFloat(dAmt);
            var a = $(this).val();
            a = parseFloat(a);
            if (a != ' ' && a != 'NaN') {
                elem = $(this).parent().parent().parent();
                if (a > dAmt) {
                    $(this).attr('required', true);
                    elem.addClass('has-error');
                    $('#submitButton').addClass('disabled').attr({type: 'button'});
                    $("#message").html("<div class='text-danger text-center'>Amount  should be equal to  or less than due amount !</div>");
                } else {
                    $(this).attr('required', false);
                    elem.removeClass('has-error');
                    $('#submitButton').removeClass('disabled').attr({type: 'submit'});
                    $("#message").html("");
                }
            }
        });
        $(".add-payment-dialog").on('click', function (e) {
            e.preventDefault();
            disableJobFormSubmit();
            var inward_id;
            inward_id = $(this).closest('tr').find('.tbl_inward_id').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>' + 'admin/inwards/getInwardById/',
                data: {inward_id: inward_id},
                dataType: 'json',
                cache: false,
                success: function (data) {
                    // console.log(data);
                    if (data.length !== 0) {
                        $('.cheque_no,.amount').val('');
                        $('#jobId').html(data.job_id);
                        $('#estimationAmt').html(data.estimation_amt);
                        $('#paidAmt').html(data.paid_amt);
                        $('.class_inward_pk_id').val(data.pk_id);
                        var dueS = (parseFloat(data.estimation_amt) - parseFloat(data.paid_amt)).toFixed(2);
                        $('#dueAmt').html(dueS);
                    } else {
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
                $('.cheque_no').attr('required', true);
            }
            $('.class_trans').html(lblTxt);
        });
        $("#invoice_paymentMode").on("change",function () {
            if ($(this).val() === 'CASH') {
                $('#invoice_ChequeDiv').addClass('hide');
                $('#invoice_bankDiv').addClass('hide');
            } else {
                $('#invoice_ChequeDiv').removeClass('hide');
                $('#invoice_bankDiv').removeClass('hide');
                $('#invoice_cheque').attr('required', true);
            }
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
        $('#invoiceForm').validate({
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
                $("#invoiceSubmit").prop('disabled', false);
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
                type: 'POST',
                url: '<?php echo base_url() ?>' + 'admin/payments/paymentToInward/',
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
<script>
    function disableInvoiceSubmit(){
        let amountStatus = $("#invoice_amt").val(),chequeNumber = $("#invoice_cheque").val(),paymentMode = $("#invoice_paymentMode").val();
        if(paymentMode === "CASH"){
            $("#invoiceSubmit").prop("disabled",(amountStatus.length < 1))
        }else{
            console.log(!(amountStatus.length > 0 && chequeNumber.length > 0));
            $("#invoiceSubmit").prop("disabled",!(amountStatus.length > 0 && chequeNumber.length > 0))
        }
    }
    function disableJobFormSubmit(){
        let amountStatus = $("#amt").val(),chequeNumber = $("#jobCheque").val(),paymentMode = $("#paymentModeID").val();
        if(paymentMode === "CASH"){
            $("#submitButton").prop("disabled",(amountStatus.length < 1))
        }else{
            console.log(!(amountStatus.length > 0 && chequeNumber.length > 0));
            $("#submitButton").prop("disabled",!(amountStatus.length > 0 && chequeNumber.length > 0))
        }
    }
    $(document).ready(function () {
        $(".add-invoice-payment").on('click', function (e) {
            e.preventDefault();
            disableInvoiceSubmit();
            var invoice_id = $(this).closest('tr').find('.tbl_invoice_id').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>' + 'admin/payments/getInvoiceById/',
                data: {invoice_id: invoice_id},
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data.length !== 0) {
                        $('.cheque_no,.amount').val('');
                        $("#paymentsForm").hide();
                        $("#invoiceForm").show();
                        $('#totalAmt').html(data.final_amount);
                        $('#invoice_paidAmt').html(data.paid_amt);
                        $('.hidden_invoice_id').val(data.pk_id);
                        var dueS = (parseFloat(data.final_amount) - parseFloat(data.paid_amt)).toFixed(2);
                        $('#invoice_dueAmt').html(dueS);
                    } else {
                        console.log('No Data');
                    }
                }
            })
        });
        $("#invoiceForm").on("submit", function (e) {
            e.preventDefault();
            $("#invoiceSubmit").prop('disabled', 'disabled');
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>' + 'admin/payments/invoicePayment/',
                data: formData,
                success: function (data) {
                    if (data == "TRUE") {
                        $("#message").html("<div class='text-success text-center'>Payment successfully paid to the Invoice...!</div>");
                        $("#paymentsForm").show();
                        $("#invoiceForm").hide();
                        setInterval(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            })
        })
    });
</script>