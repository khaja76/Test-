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
        <select class="form-control input-sm" name="payment-status" id="payment-sel">
            <option value="">----- Select Status -----</option>
            <option value="all">All</option>
            <option value="success">Payment Done</option>
            <option value="due">Payment Dues</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Get Records</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="space"></div>
<?php
if (!empty($_GET['payment-status']) && !empty($inwards)) {
    ?>
    <span class="pull-right p-10 red">* Amt = Amount , <i class="fa fa-inr"></i> = Indian Rupee </span>
    <table class="table table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
        <thead>
        <tr>
            <th>S. No</th>
            <th width="200">Job Id</th>
            <!-- <th>Item Name</th> -->
            <th>Payment Mode</th>
            <th>Cheque No.</th>
            <th>Payment Date</th>
            <th>Amt ( <i class="fa fa-inr"></i> )</th>
            <th>Amt Paid ( <i class="fa fa-inr"></i> )</th>
            <th>Amt Dues ( <i class="fa fa-inr"></i> )</th>
            <th></th>
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
                    <span class="hide tbl_inward_pk_id"><?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?></span>
                    <span class="hide tbl_job_id"><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></span>
                    <span class="hide tbl_estimation_amt"><?php echo !empty($inward['estimation_amt']) ? $inward['estimation_amt'] : ''; ?></span>
                    <span class="hide tbl_paid_amt"><?php echo !empty($inward['paid_amt']) ? $inward['paid_amt'] : ''; ?></span>
                    <?php include currentModuleView('admin') . 'common_pages/inward-view-url.php'; ?>
                </td>
                <td><?php echo !empty($inward['payment_mode']) ? $inward['payment_mode'] : 'NA' ?></td>
                <td><?php echo !empty($inward['cheque_no']) ? $inward['cheque_no'] : 'NA' ?></td>
                <td><?php echo !empty($inward['payment_done_on']) ? $inward['payment_done_on'] : 'NA' ?></td>
                <td><?php echo !empty($inward['estimation_amt']) ? $inward['estimation_amt'] : '-'; ?></td>
                <td><?php echo !empty($inward['paid_amt']) ? $inward['paid_amt'] : '-'; ?></td>
                <td><?php echo number_format($balance, 2); ?></td>
                <td>
                    <?php
                    if ($balance < 1) {
                        ?>
                        <label class="label label-success"> <i class="fa fa-check"></i> Paid </label>
                        <?php
                    } else { ?>
                        <a class="label label-warning add-payment-dialog " data-toggle="modal" data-target="#myModal"> <i class="fa fa-hourglass-o"></i> Add Payment </a>
                    <?php }
                    ?>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
<?php } else {
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
                <form id="frm" class="form-horizontal" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Job Id </label>
                                <div class="col-sm-6">
                                    <input readonly class="form-control input-sm" id="jobId">
                                    <input type="hidden" class="class_inward_pk_id" name="inwardPkTxt">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-6" for="job-id-edit">Estimated Amount</label>
                                <div class="col-sm-6">
                                    <input readonly class="form-control input-sm" id="estimationAmt">
                                    <input type="hidden" class="class_estimation_amount" name="estimationAmtTxt">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Paid Amount </label>
                                <div class="col-sm-6">
                                    <input readonly class="form-control input-sm" id="paidAmt">
                                    <input type="hidden" class="class_paid_amount" name="paidAmountTxt">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit">Due Amount </label>
                                <div class="col-sm-6">
                                    <input readonly class="form-control input-sm" id="dueAmt">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="paymentMode">Make payment via </label>
                                <div class="col-sm-6">
                                    <input type="hidden" class="class_payment_mode" name="paymentModeTxt">
                                    <select class="form-control input-sm" id="paymentModeID" name="paymentMode">
                                        <option value="CASH">Cash</option>
                                        <option value="CHEQUE">Through Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 hide" id="transDiv">
                            <div class="form-group">
                                <label class="control-label col-sm-6" for="job-id-edit"><span class="class_trans"></span> </label>
                                <div class="col-sm-6">
                                    <input type="text" name="transaction_id" class="form-control input-sm"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" col-sm-6 control-label" for="job-id-edit"> Amount </label>
                                <div class="col-sm-6">
                                    <input class="form-control input-sm" id="amt">
                                    <input type="hidden" class="class_amount input-sm" name="amountTxt">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Remarks </label>
                        <div class="col-sm-9">
                            <textarea class="autosize-transition form-control" name="remarks" rows="3" placeholder="Enter Description..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-9 col-md-4">
                            <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                            <button type="submit" id="submitButton" class="btn btn-xs btn-success"><i class="fa fa-save"></i> Save</button>
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
            var inward_pk_id, job_id;
            inward_pk_id = $(this).closest('tr').find('.tbl_inward_pk_id').text();
            //job_id = $(this).closest('tr').find('.tbl_job_id').text();
            //estimation = $(this).closest('tr').find('.tbl_estimation_amt').text();
            //paid = $(this).closest('tr').find('.tbl_paid_amt').text();
            //var due = parseFloat(estimation) - parseFloat(paid);
            //Assign to Text Box
            $("#jobId").val(job_id);
            //$("#estimationAmt").val(estimation);
            //$("#paidAmt").val(paid);
            //$("#dueAmt").val(parseFloat(due).toFixed(2));
            //Assign to Hidden
            //$(".class_inward_pk_id").val(inward_pk_id);
            //$(".class_estimation_amount").val(estimation);
            //$(".class_paid_amount").val(paid);
            //console.log(trans_type());
            // console.log({jobid: job_id, inward_pk_id: inward_pk_id, estimation: estimation, paid: paid, due: due});
        });
        //var trans_type = () =>{
        var ttype = $('#paymentModeID');
        ttype.change(function () {
            var lblTxt;
            $('#transDiv').removeClass('hide');
            if (ttype.val() == 'CASH') {
                $('#transDiv').addClass('hide');
            } else {
                lblTxt = 'Cheque No';
            }
            $('.class_trans').html(lblTxt);
        });
        //return $(this).val();
        //}
        /*$('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                inwardPkId: {required: true},
                engineerId: {required: true}
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
        });*/
        /*$("#frm").on("submit", function (e) {
            e.preventDefault();
            $("#submitButton").prop('disabled', 'disabled');
            var jobId = $("#jobId").val();
            var th = $(this);
            var formData = th.serialize();
            $.ajax({
                type : 'POST',
                url: '/admin/payments/paymentToInward/',
                data: formData,
                success: function (data) {
                console.log(data);
                    if (data == "TRUE") {
                        $("#message").html("<div class='text-success text-center'>Payment for this Job Id successfully Added</div>");
                        setInterval(function () {
                            location.reload(true);
                        }, 2000);
                    }
                }
            })
        })*/
    });
</script>