<h3 class="header smaller lighter">
    Transactions - <span class="text-success bolder ">Pro-Forma Invoice</span>
    <span class="pull-right">
        <a href="<?php echo base_url() ?>admin/transactions/" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<div class="clearfix"></div>
<div class="row">
    <div class="col-lg-12 transactions_details">
        <form method="post" action="" id="frm" class="form-horizontal ">
            <h4>
                Document to <b class="text-info"><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?></b>
                <span class="pull-right">
                 <div class="col-md-12">
                 <label>Pro-Forma Invoice Date</label>
                       <div class="form-group">
                           <input type="text" name="pro_invoice_date" data-date-format="dd/mm/yyyy" class="form-control date-picker input-sm required"/>
                       </div>
                 </div>
            </span>
            </h4>
            <input type="hidden" name="trans" value="<?php echo $_GET['transaction'] ?>"/>
            <?php if ($_GET['transaction'] == 'pro-forma-invoice' && isset($_GET['inward_no'])) {
                ?>
                <input type="hidden" name="inward_no" value="<?php echo $_GET['inward_no'] ?>"/>
                <input type="hidden" name="customer_id" value="<?php echo $inward['customer_pk_id'] ?>"/>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Customer ID</th>
                        <th>Job ID</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th> Amount (INR)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $inward['customer_name'] ?></td>
                        <td><?php echo $inward['customer_id'] ?></td>
                        <td><input type="hidden" value="<?php echo $inward['inward_no'] ?>" name="job_id"/>
                            <?php echo $inward['job_id'] ?></td>
                        <td><?php echo $inward['status'] ?></td>
                        <td><textarea class="form-control" name="remarks"></textarea></td>
                        <td><input type="text" name="amount" placeholder="  Amount " onkeypress="return isNumber(event)" class="form-control q_amount input-sm required"/></td>
                    </tr>
                    </tbody>
                </table>
            <?php } else if (($_GET['transaction'] == 'pro-forma-invoice') && isset($_GET['customer_id'])) { ?>
                <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id'] ?>"/>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Job ID</th>
                        <th style="width: 300px;">Description</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th> Amount (INR)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($inwards)) {
                        $i = 0;
                        foreach ($inwards as $inward) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $inward[0]['job_id'] ?>
                                    <input type="hidden" name="job_id[]" value="<?php echo $inward[0]['pk_id'] ?>"/>
                                </td>
                                <td><?php echo $inward[0]['description'] ?>
                                </td>
                                <td><?php echo $inward[0]['status'] ?></td>
                                <td><textarea class="form-control" name="remarks[]"></textarea></td>
                                <td><input type="text" name="amount[]" onkeypress="return isNumber(event)" placeholder="  Amount " class="form-control q_amount input-sm m-t-10 required"/></td>
                            </tr>
                        <?php }
                    } else {
                    }
                    ?>
                    </tbody>
                </table>
            <?php }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Note :</label>
                                    <textarea name="notes" class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table class="pull-right ">
                                    <tr>
                                        <td><h6>Net Amount&nbsp;&nbsp;&nbsp;&nbsp;: </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="net_amt">0</span></h6>
                                            <input type="hidden" name="total_amount" class="netAmtTxt"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>CGST Amount : </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="cgst_amt">0</span></h6>
                                            <input type="hidden" name="cgst_amount" class="cgstAmtTxt"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>SGST Amount : </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="sgst_amt">0</span></h6>
                                            <input type="hidden" name="sgst_amount" class="sgstAmtTxt"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>IGST Amount : </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="igst_amt">0</span></h6>
                                            <input type="hidden" name="igst_amount" class="igstAmtTxt"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>Shiping & Handling : </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <input type="text" name="ship_handling_amount" value="0" class="shipAmtTxt required"></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="text-danger">Above Field Leave as it is (If not submitted shipping amount)</span></td>
                                    </tr>
                                    <tr>
                                        <td><b><h5>Final Amount : </h5></b></td>
                                        <td><b><h5><i class="fa fa-inr"></i> <span class="final_amt">0</span></h5></b>
                                            <input type="hidden" name="total_tax" class="totalTaxTxt"/>
                                            <input type="hidden" name="final_amount" class="finalAmtTxt"/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="pull-right">
                <button class="btn btn-success btn-sm" type="submit">Submit</button>
            </span>
        </form>
    </div>
</div>
<script>
    $(function () {
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })
        $('#frm').validate();
        $('.q_amount').keyup(function () {
            calc();
        });
    });
    function calc() {
        var sum = 0;
        var totalsum = 0;
        $(".q_amount").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
            totalsum = sum.toFixed(2);
            $('.net_amt').html(totalsum);
            $('.netAmtTxt').val(totalsum);
            <?php
            if(!empty($customer) && $customer['state'] == $branch['state']) {
            ?>
            var igst = 0;
            var cgst = totalsum / 100 * 9;
            $('.cgst_amt').html(cgst.toFixed(2));
            $('.cgstAmtTxt').val(cgst.toFixed(2));
            var sgst = totalsum / 100 * 9;
            $('.sgst_amt').html(sgst.toFixed(2));
            $('.sgstAmtTxt').val(sgst.toFixed(2));
            var shipAmt = parseFloat($('.shipAmtTxt').val());
            $('.totalTaxTxt').val(parseFloat(cgst.toFixed(2)) + parseFloat(sgst.toFixed(2)));
            var _final_c = parseFloat(totalsum) + parseFloat(cgst);
            $('.final_amt').html((_final_c + parseFloat(sgst)).toFixed(2) + parseFloat(shipAmt).toFixed(2));
            $('.finalAmtTxt').val((_final_c + parseFloat(sgst)).toFixed(2) + parseFloat(shipAmt).toFixed(2));
            <?php
            }else{
            ?>
            var igst = totalsum / 100 * 18;
            $('.igst_amt').html(igst.toFixed(2));
            $('.igstAmtTxt').val(igst.toFixed(2));
            var shipAmt = $('.shipAmtTxt').val();
            $('.totalTaxTxt').val(parseFloat(igst).toFixed(2));
            var _final_c = parseFloat(totalsum) + parseFloat(igst) + parseFloat(shipAmt);
            $('.shipAmtTxt').keyup(function () {
                $('.final_amt').html((parseFloat($(this).val()) + parseFloat(_final_c)).toFixed(2));
                $('.finalAmtTxt').val((parseFloat($(this).val()) + parseFloat(_final_c)).toFixed(2));
            });
            $('.final_amt').html((_final_c).toFixed(2));
            $('.finalAmtTxt').val((_final_c).toFixed(2));
            <?php
            }
            ?>
        });
    }
</script>