<h3 class="header smaller lighter">
    Outwards
    <span class="pull-right">
        <a class="btn btn-xs btn-warning" href="javascript:void(0)" onclick="goBack()">
                    <i class="white ace-icon fa fa-arrow-left bigger-120"></i>
                  Back
     </a>
</h3>
<form class="form-inline text-center" id="frm" action="" enctype="multipart/form-data">
    <div class="form-group">
        <?php $types = ["customer_id" => "Customer Id", "inward_no" => "Job Id"]; ?>
        <select class="form-control input-sm required" id="search_type" name="type">
            <option value="">----- Select Search Type -----</option>
            <?php foreach ($types as $k => $v) { ?>
                <option value="<?php echo $k; ?>" <?php echo !empty($_GET['type']) && ($_GET['type'] == $k) ? "selected='selected'" : (($k=='inward_no') ? 'selected':'')  ; ?>><?php echo $v; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <input class="form-control input-sm required" id="filter" name="value" type="text" placeholder="Enter Your Input" value="<?php echo !empty($_GET['value']) ? $_GET['value'] : "" ?>"/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary custSearchBtn"><i class="fa fa-sign-in"></i> Search</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="space-6"></div>
<?php if (!empty($inwards)) {
    $customer_data = !empty($customer[0]) ? $customer[0] : $customer;
    ?>
    <div class="col-md-12">
        <div class="col-md-4">
            <h4>Customer Information</h4>
            <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                    <div class="profile-info-name"> Id</div>
                    <div class="profile-info-value">
                        <span><?php echo !empty($customer_data['customer_id']) ? $customer_data['customer_id'] : ''; ?></span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Name</div>
                    <div class="profile-info-value">
                        <span><?php echo !empty($customer_data['customer_name']) ? $customer_data['customer_name'] : ''; ?></span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Photo</div>
                    <div class="profile-info-value">
                        <?php
                        if (!empty($customer_data['img']) && file_exists(FCPATH . $customer_data['img_path'] . $customer_data['img'])) {
                            $img = base_url() . $customer_data['img_path'] . $customer_data['img'];
                            $thumb_img = base_url() . $customer_data['img_path'] . "thumb_" . $customer_data['img'];
                            ?>
                            <div class="gallery">
                                <a href="<?php echo $img; ?>">
                                    <img src="<?php echo $thumb_img; ?>" class="max-150" alt="customer name"/>
                                </a>
                            </div>
                        <?php } else { ?>
                            <img src="<?php echo dummyLogo(); ?>" class="max-150" alt="customer name"/>
                        <?php }
                        ?>
                    </div>
                </div>
                <?php
                if (!empty($customer_data['company_name'])) {
                    ?>
                    <div class="profile-info-row">
                        <div class="profile-info-name">Company Name :</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($customer_data['company_name']) ? $customer_data['company_name'] : '-'; ?></span>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-md-8">
            <span class="pull-right">
                
                <form class="form-inline" method="POST" id="frm">
                    <?php if (!empty($_GET['outward'])) { ?>
                        <a href="<?php echo base_url(); ?>reception/outwards/challan/?customer_id=<?php echo !empty($customer_data) ? $customer_data['pk_id'] : '' ?>" class="btn btn-primary btn-xs"><i class='fa fa-print'></i> Get Challan</a>
                    <?php } ?>
                    <button type="button" id="submitBtn" class="btn btn-success btn-xs"><?php echo !empty($_GET['outward']) ? "<i class='fa fa-plus'></i> Add more " : 'Submit' ?></button>
                    <input type="hidden" id="inward_no" name="inward_no" value=""/>
                    <input type="hidden" id="outward_ids" name="outward_ids[]" value=""/>
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo !empty($inwards) ? $inwards[0]['customer_pk_id'] : '' ?>"/>
                    <input type="hidden" id="customer_no" name="customer_no" value="<?php echo !empty($customer_data) ? $customer_data['customer_no'] : '' ?>"/>
                </form>
            </span>
            <div class="clearfix"></div>
            <div class="space-2"></div>
            <div class="table-header">
                Please select Job to outward
            </div>
            <table class="table table-bordered" id="">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Job Id</th>
                    <th>Inward Date</th>
                    <th>Status</th>
                    <th>Gatepass</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($inwards)) {
                    $i = 1;
                    foreach ($inwards as $inward) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <?php echo $inward['job_id'] ?>
                                <?php if (!empty($inward['job_id'])) {
                                    if (($inward['estimation_amt'] != '0.00') && ($inward['paid_amt'] < $inward['estimation_amt'])) {
                                        $status = true;
                                        $btn = "warning";
                                        $msg = "Pending";
                                    } else if ($inward['estimation_amt'] == '0.00') {
                                        $status = false;
                                        $btn = "danger";
                                        $msg = "Not Quoted";
                                    } else if (($inward['estimation_amt'] != '0.00') && ($inward['paid_amt'] == $inward['estimation_amt'])) {
                                        $status = false;
                                        $btn = "success";
                                        $msg = "Payment Completed";
                                    }
                                    ?>
                                    <span class="info">
                                    <a href="<?php echo get_role_based_link() ?>/inwards/history/?inward=<?php echo $inward['inward_no']; ?>" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
                                    <a href="<?php echo get_role_based_link() ?>/inwards/view/?inward=<?php echo $inward['inward_no']; ?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
                                    <a href="#" data-inward-id="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>" class="badge badge-<?php echo $btn ?>  add-payment-dialog" title="<?php echo $msg; ?>" data-toggle="<?php echo ($status) ? "modal" : "tooltip" ?>" data-target="#myModal"><i class="fa fa-inr"></i></a>
                                    
                                </span>
                                <?php } ?>
                            </td>
                            <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : ''; ?></td>
                            <td><?php echo !empty($inward['status']) ? $inward['status'] : ''; ?></td>
                            <td><?php echo !empty($inward['gatepass_no']) ? $inward['gatepass_no'] : ''; ?></td>
                            <td>
                                <?php if (($inward['estimation_amt'] != '0.00') || (!empty($inward['status']) && $inward['status']=='NOT REPAIRABLE')) { ?>
                                    <input type="radio" class="ace makeRadio" name="pk_id" value="<?php echo $inward['inward_no'] ?>"/>
                                    <label class="lbl"></label>
                                    <?php
                                } else {
                                    if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'ADMIN') {
                                            ?>
                                            <a href="<?php echo get_role_based_link(); ?>/quotations/add/?type=inward_no&value=<?php echo $inward['inward_no']; ?>" class="label label-info quoteLink" title="Please make Quoation before outward !" data-toggle="tooltip">Make Quote</a>
                                        <input type="checkbox" id="removeMakeQuote" data-inw="<?php echo $inward['inward_no'] ?>" class="ace removeMakeQuote"/>
                                        <label class="lbl" for="removeMakeQuote"></label>
                                            <?php
                                    } else {
                                        ?>
                                        <p  class="label label-danger" data-toggle="tooltip" title="Please contact admin to make quotation">Access denied</p>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else {
    echo "<h5 class='text-center text-danger'>No Data found </h5>";
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
                                    <select class="form-control input-sm" id="paymentModeID" name="payment_mode">
                                        <option value="CASH">Cash</option>
                                        <option value="CHEQUE">Through Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group er">
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
                <div class="clearfix"></div>
                <div id="message"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.removeMakeQuote').on('click',function (e) {
            if($(this).prop('checked')===true){
                $(this).siblings().closest('a').addClass('hide');
                var inw=$(this).data('inw');
                $(this).parent().closest('td').append("<input type='radio' class='ace makeRadio' name='pk_id' value='"+inw+"'/><label class='lbl'></label>");
                $('#submitBtn').attr('type', 'submit');
                $('#submitBtn').removeClass('disabled');
                $checks = $(":radio");
                $checks.on('change', function () {
                    if ($checks.filter(":checked").length > 0) {
                        $('#inward_no').val(inw);
                    }
                });
            }else{
                var inw=$(this).data('inw');
                $(this).siblings().closest('a').removeClass('hide');
                $(this).parent().closest('td').empty().append('<a href="<?php echo get_role_based_link(); ?>/quotations/add/?type=inward_no&value='+inw+'" class="label label-info quoteLink" title="Please make Quoation before outward !" data-toggle="tooltip">Make Quote</a><input type="checkbox" id="removeMakeQuote" data-inw="'+inw+'" class="ace removeMakeQuote"/>\n'+
'                                        <label class="lbl" for="removeMakeQuote"></label>');
                $('#submitBtn').attr('type', 'button');
                $('#inward_no').val('');
                $('#submitBtn').addClass('disabled');
                window.location.reload();
            }
        });
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
                    $("#message").html("<div class='text-danger text-center'>Amount is Should be equal or lessthan Due amount !</div>");
                } else {
                    $(this).attr('required', false);
                    elem.removeClass('has-error');
                    $('#submitButton').removeClass('disabled').attr({type: 'submit'});
                    $("#message").html("");
                }
            }
        });
       /* $('#submitBtn').click(function(){
            $('#submitBtn').attr({'type':'button','disabled':true});
            $('#frm').submit();
        });*/
        $('#submitBtn').attr('type', 'button').addClass('disabled');
        var disableButton = (e) =>
        {
            $('#submitBtn').attr('type', 'button').addClass('disabled');
        }
        $checks = $(":radio");
        $checks.on('change', function () {
            if ($checks.filter(":checked").length > 0) {
                $('#submitBtn').attr('type', 'submit');
                $('#submitBtn').removeClass('disabled');
            } else {
                disableButton();
            }
            var string = $checks.filter(":checked").map(function (i, v) {
                return this.value;
            }).get();
            $('#inward_no').val(string);
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".add-payment-dialog").on('click', function (e) {
            e.preventDefault();
            var inward_id;
            inward_id = $(this).data('inward-id');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>admin/inwards/getInwardById/',
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
                type: 'POST',
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
