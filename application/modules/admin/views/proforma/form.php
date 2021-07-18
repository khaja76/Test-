<style>
.spaced > li{
    margin-top:2px;
    margin-bottom:2px;
}
.w-550 {
    width: 550px;
}
</style>
<h3 class="header smaller lighter">
    Make Proforma
    <span class="pull-right">
        <a href="/admin/proforma" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<form class="form-inline text-center" id="frm" action="" enctype="multipart/form-data">
    <div class="form-group">
        <?php $types = ["customer_id" => "Customer Id", "inward_no" => "Job Id"]; ?>
        <select class="form-control input-sm " id="quotation_no" name="quotation_no">
            <option value="">----- Select Quotation -----</option>
            <?php
            if (!empty($quotations)) {
                foreach ($quotations as $k => $v) { ?>
                    <option value="<?php echo $k; ?>" <?php echo !empty($_GET['quotation_no']) && ($_GET['quotation_no'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                    <?php
                }
            } else {
                echo "<option value=''>No Quotations found</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary custSearchBtn"><i class="fa fa-sign-in"></i> Search</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="space-6"></div>
<?php
if (!empty($customer) && (!empty($quotation))) {    
    if (!empty($quotation['quotation_items'])) {
        ?>
        <div class="quote">
            <form method="post" action="">
                <div class="widget-box transparent">
                    <div class="row">
                        <div class="col-sm-4 print-third">
                            <?php $path = '/data/branches/';
                            if (!empty($branch['branch_logo']) && file_exists(FCPATH . $path . $branch['branch_logo'])) { ?>
                                <img class="max-100 f-l preview-pic" alt="Branch Logo" src="<?php echo base_url() . $path . $branch['branch_logo']; ?>"/>
                            <?php } ?>
                        </div>
                        <div class="col-sm-4 print-third">
                            <h2 class="text-center">Proforma Invoice</h2>
                        </div>
                        <div class="col-sm-4 text-right print-third">
                            <?php
                            if (!empty($branch)) {
                                ?>
                                <input type="hidden" class="branch_id" value="<?php echo !empty($branch['pk_id']) ? $branch['pk_id'] : ''; ?>"/>
                                <input type="hidden" class="b_state" value="<?php echo !empty($branch['state_code']) ? $branch['state_code'] : ''; ?>"/>
                                <h4><?php echo $branch['name'] ?></h4>
                                <p><?php echo !empty($branch['address1']) ? $branch['address1'] : '' ?><?php echo !empty($branch['address2']) ? '<br/>'.$branch['address2'] . ',' : '' ?> </p>
                            <p><?php echo !empty($branch['city']) ? $branch['city'] : '' ?>-<?php echo !empty($branch['pincode']) ? $branch['pincode'] . ',' : '' ?> 
                            <?php echo !empty($branch['state_name']) ? $branch['state_name'] : '' ?></p>
                            <p><?php echo !empty($branch['email']) ? $branch['email'] : '' ?></p>
                            <p><?php echo !empty($branch['mobile_1']) ? $branch['mobile_1'].', ' : '' ?>
                            <?php echo !empty($branch['mobile_2']) ? $branch['mobile_2'].', ' : '' ?>
                            <?php echo !empty($branch['phone_1']) ? $branch['phone_1'].', ' : '' ?>
                            <?php echo !empty($branch['phone_2']) ? $branch['phone_2'].', ' : '' ?>
                            </p>
                            <?php }
                            ?>
                        </div>
                    </div>
                    <div class="hr hr8 hr-double hr-dotted"></div>
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-sm-6 print-half">
                                <div class="row">
                                    <div class="col-xs-11">
                                        <h4 class="gray">To</h4>
                                    </div>
                                </div>
                                <div>
                                    <?php
                                    if (!empty($customer)) {
                                        ?>
                                        <input type="hidden" name="customer_id" value="<?php echo !empty($customer['pk_id']) ? $customer['pk_id'] : ''; ?>"/>
                                        <input type="hidden" class="customer_branch_id" value="<?php echo !empty($customer['branch_id']) ? $customer['branch_id'] : ''; ?>"/>
                                        <input type="hidden" class="cs_state" value="<?php echo !empty($customer['state_code']) ? $customer['state_code'] : ''; ?>"/>
                                        <ul class="list-unstyled  spaced">
                                            <?php if (!empty($customer['company_name'])) { ?>
                                                <li>
                                                    <h4><?php echo $customer['company_name']; ?></h4>
                                                </li>
                                            <?php }
                                            // else { ?>
                                                <li>
                                                    <h4><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?></h4>
                                                </li>
                                            <?php //} ?>
                                            <?php if (!empty($customer['gst_no'])) { ?>
                                                <li>
                                                    <b><?php echo "GST No : " . $customer['gst_no']; ?></b>
                                                </li>
                                            <?php } ?>
                                            <li>
                                                <?php echo !empty($customer['address1']) ? $customer['address1'] : '' ?>
                                                <?php echo !empty($customer['address2']) ? ',' . $customer['address2'] : '' ?>
                                            </li>
                                            <li>
                                                <?php echo !empty($customer['city']) ? $customer['city'] : '' ?>
                                                <?php echo !empty($customer['state']) ? ',' . $customer['state'] : '' ?>
                                            </li>
                                            <li>
                                                <?php echo !empty($customer['pincode']) ? $customer['pincode'] : '' ?>- India.
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div><!-- /.col -->
                            <div class="col-sm-4 print-half col-md-offset-2">
                                <!-- <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="grey">Proforma Information</h4>
                                    </div>
                                </div> -->
                                <div>
                                <ul class="list-unstyled spaced">
                                    <li>
                                        <b><span class="w-150 f-l">Proforma No</span> </b> : <span class="m-l-10">-</span>
                                    </li>
                                    <li>
                                        <div class="">
                                            <label class="w-150 f-l">Proforma Date</label> :
                                            <input type="text" class="from-control date-picker input-sm" name="proforma_date" value="<?php echo date('d-m-Y'); ?>"/>
                                        </div>
                                    </li>
                                    <li class="bg-gray p-10">
                                        <div>
                                            <b><span class="w-150 f-l">Proforma Amount </span> </b>: <i class='fa fa-inr'></i>
                                            <span class="prevAmt">
                                                <?php
                                                //echo !empty($quotation['final_amount']) ? $quotation['final_amount'] : '';
                                                ?>
                                                <?php
                                                if (!empty($quotation['quotation_items'])) {
                                                    $i = 1;
                                                    $count = count($quotation['quotation_items']);
                                                    $amt = 0;
                                                    foreach ($quotation['quotation_items'] as $inward) {
                                                        //$tax=$inward['cgst_amt'];
                                                        $amt += $inward['amount'];
                                                    }
                                                    $qig = !empty($quotation['igst_amount']) ? $quotation['igst_amount'] : 0;
                                                    $qcg = !empty($quotation['cgst_amount']) ? $quotation['cgst_amount'] : 0;
                                                    $qsg = !empty($quotation['sgst_amount']) ? $quotation['sgst_amount'] : 0;
                                                    echo $amt + $qsg + $qcg + $qig;
                                                } ?>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix">
                        </div>
                        <p>
                            <textarea name="notes" class="form-control input-sm" rows="3"><?php echo !empty($branch['proforma_reference']) ? $branch['proforma_reference'] : '' ?></textarea>
                        </p>
                        <div class="space"></div>
                        <div>
                            Kind Attn.
                            <span><b><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?></b></span>,
                            <span><?php echo !empty($quotation['quotation_items'][0]['gatepass_no']) ? "<b>Gatepass No.:</b>" . $quotation['quotation_items'][0]['gatepass_no'] : ''; ?></span>
                            <?php echo !empty($quotation['quotation_items'][0]['outward_challan']) ? "<span><b>Delivery Challan:</b>" . $quotation['quotation_items'][0]['outward_challan'] . "</span>" : ""; ?>
                        </div>
                        <div class="space-1"></div>
                        <div class="row inv">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th class="w-140">Job ID</th>
                                        <th class="w-550">Project Description</th>
                                        <th >Job Status</th>
                                        <th class="w-100">Remarks</th>
                                        <th class="w-100">Amount</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($quotation['quotation_items'])) {
                                        $i = 1;
                                        $count = count($quotation['quotation_items']);
                                        foreach ($quotation['quotation_items'] as $inward) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td>
                                                    <input type="hidden" name="quotation_job_id[]" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>
                                                    <input type="hidden" name="job_pk_id[]" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>"/>
                                                    <input type="hidden" name="job_id[]" value="<?php echo !empty($inward['job']) ? $inward['job'] : ''; ?>"/>
                                                    <b><?php echo !empty($inward['job']) ? $inward['job'] : '' ?><br></b>
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="small"><b><?php echo !empty($inward['product']) ? $inward['product'] . ',' : '' ?></b></span>
                                                        <span class="small"><b><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] . ',' : '' ?></b></span>                                                    
                                                        <span class="small"><b><?php echo !empty($inward['model_no']) ? $inward['model_no'] . ',' : '' ?></b></span>
                                                        <span class="small"><b><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] . ',' : '' ?></b></span>
                                                        <span class="small"><b><?php echo !empty($inward['description']) ? $inward['description'] : '' ?></b></span>
                                                    </div>
                                                </td>
                                                <td><?php echo !empty($inward['status']) ?$inward['status'] : '' ?></td>
                                                <td><input type="text" name="pi_remarks[]" value="Repaired" placeholder="Enter Remarks"/></td>
                                                <td>
                                                    <input type="text" class="q_amount" name="amount[]" value="<?php echo !empty($inward['amount']) ? $inward['amount'] : '0'; ?>"/>
                                                    <input type="hidden" readonly name="amount[]" class="form-control input-sm " value="<?php echo !empty($inward['amount']) ? $inward['amount'] : '0'; ?>"/>
                                                    <input type="hidden" name="tax_amount[]" class="form-control input-sm tax_amount" value="<?php echo !empty($inward['tax_amount']) ? $inward['tax_amount'] : '0'; ?>"/>
                                                    <input type="hidden" name="net_amount[]" class="form-control input-sm net_amount" value="<?php echo !empty($inward['net_amount']) ? $inward['net_amount'] : '0'; ?>"/>
                                                </td>
                                                <td>
                                                    <?php if ($count > 1) { ?>
                                                        <span class="btn btn-xs btn-danger delete_job"><i class="fa fa-trash"></i></span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="hr hr8 hr-double hr-dotted"></div>
                        <div class="row">
                            <div class="col-sm-4 pull-right">
                                <table class="text-left">
                                    <tr>
                                        <td><h6>Net Amount&nbsp;&nbsp;&nbsp;&nbsp;: </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="net_amt">
                                                     <?php
                                                     if (!empty($quotation['quotation_items'])) {
                                                         $i = 1;
                                                         $count = count($quotation['quotation_items']);
                                                         $amt = 0;
                                                         foreach ($quotation['quotation_items'] as $inward) {
                                                             //$tax=$inward['cgst_amt'];
                                                             $amt += $inward['amount'];
                                                         }
                                                         $qig = !empty($quotation['igst_amount']) ? $quotation['igst_amount'] : 0;
                                                         $qcg = !empty($quotation['cgst_amount']) ? $quotation['cgst_amount'] : 0;
                                                         $qsg = !empty($quotation['sgst_amount']) ? $quotation['sgst_amount'] : 0;
                                                         echo $amt;
                                                     } ?>
                                                </span></h6>
                                            <input type="hidden" name="total_amount" class="totalAmtTxt" value=" <?php
                                            if (!empty($quotation['quotation_items'])) {
                                                $i = 1;
                                                $count = count($quotation['quotation_items']);
                                                $amt = 0;
                                                foreach ($quotation['quotation_items'] as $inward) {
                                                    //$tax=$inward['cgst_amt'];
                                                    $amt += $inward['amount'];
                                                }
                                                $qig = !empty($quotation['igst_amount']) ? $quotation['igst_amount'] : 0;
                                                $qcg = !empty($quotation['cgst_amount']) ? $quotation['cgst_amount'] : 0;
                                                $qsg = !empty($quotation['sgst_amount']) ? $quotation['sgst_amount'] : 0;
                                                echo $amt;
                                            } ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>CGST Amount : </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="cgst_amt"><?php echo !empty($quotation['cgst_amount']) ? $quotation['cgst_amount'] : ''; ?></span></h6>
                                            <input type="hidden" name="cgst_amount" class="cgstAmtTxt" value="<?php echo !empty($quotation['cgst_amount']) ? $quotation['cgst_amount'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>SGST Amount : </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="sgst_amt"><?php echo !empty($quotation['sgst_amount']) ? $quotation['sgst_amount'] : ''; ?></span></h6>
                                            <input type="hidden" name="sgst_amount" class="sgstAmtTxt" value="<?php echo !empty($quotation['sgst_amount']) ? $quotation['sgst_amount'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>IGST Amount : </h6></td>
                                        <td>
                                            <h6><i class="fa fa-inr"></i> <span class="igst_amt"><?php echo !empty($quotation['igst_amount']) ? $quotation['igst_amount'] : ''; ?></span></h6>
                                            <input type="hidden" name="igst_amount" class="igstAmtTxt" value="<?php echo !empty($quotation['igst_amount']) ? $quotation['igst_amount'] : ''; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b><h5>Final Amount : </h5></b></td>
                                        <td><b><h5><i class="fa fa-inr"></i> <span class="final_amt">
                                                     <?php
                                                     if (!empty($quotation['quotation_items'])) {
                                                         $i = 1;
                                                         $count = count($quotation['quotation_items']);
                                                         $amt = 0;
                                                         foreach ($quotation['quotation_items'] as $inward) {
                                                             //$tax=$inward['cgst_amt'];
                                                             $amt += $inward['amount'];
                                                         }
                                                         $qig = !empty($quotation['igst_amount']) ? $quotation['igst_amount'] : 0;
                                                         $qcg = !empty($quotation['cgst_amount']) ? $quotation['cgst_amount'] : 0;
                                                         $qsg = !empty($quotation['sgst_amount']) ? $quotation['sgst_amount'] : 0;
                                                         echo $amt + $qig + $qsg + $qcg;
                                                     } ?>
                                                    </span></h5></b>
                                            <input type="hidden" name="total_tax" class="totalTaxTxt" value="<?php echo !empty($quotation['total_tax']) ? $quotation['total_tax'] : ''; ?>"/>
                                            <input type="hidden" name="final_amount" class="finalAmtTxt" value="
                                             <?php
                                            if (!empty($quotation['quotation_items'])) {
                                                $i = 1;
                                                $count = count($quotation['quotation_items']);
                                                $amt = 0;
                                                foreach ($quotation['quotation_items'] as $inward) {
                                                    //$tax=$inward['cgst_amt'];
                                                    $amt += $inward['amount'];
                                                }
                                                $qig = !empty($quotation['igst_amount']) ? $quotation['igst_amount'] : 0;
                                                $qcg = !empty($quotation['cgst_amount']) ? $quotation['cgst_amount'] : 0;
                                                $qsg = !empty($quotation['sgst_amount']) ? $quotation['sgst_amount'] : 0;
                                                echo $amt + $qig + $qsg + $qcg;
                                            } ?>"/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-7 pull-left">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Work Order : </label>
                                            <input name="work_order" class="form-control" placeholder="Work Order"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">Work Order Date : </label>
                                            <input name="work_order_date" class="form-control date-picker" placeholder="Work Order Date"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="">Amount (In words) : </label>
                                    <input readonly name="text_amount" class="form-control text_amount" placeholder="Amount in Words"/>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm"><i class=" fa fa-save"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>  </div>        
    <?php } 
    else{
        echo "<h5 class='text-center text-danger'>Proforma already issued for this Quotation !</h5>";
    }        
} else {
    //echo "<h5 class='text-center text-danger'>No Quotations found with these Number for the Quotation</h5>";
}
?>
<script>
    $(document).ready(function () {
        $("#frm").validate();
        console.log($('.final_amt').text());
        $('.text_amount').val(convertNumberToWords(parseFloat($('.final_amt').text())) + 'Rupees Only');
        $("body").on("click", ".delete_job", function (e) {
            e.preventDefault();
            var len = $(document).find('.delete_job').length;
            var th = $(this);
            $("#dialog-confirm").removeClass('hide').dialog({
                resizable: false,
                width: '320',
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Remove this Item ?</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete Item",
                        "class": "btn btn-danger btn-xs",
                        click: function () {
                            th.closest('tr').remove();
                            //   discountAmountValues();
                            totalAmount();
                            $('.text_amount').val(convertNumberToWords($('.final_amt').text()) + 'Rupees Only');
                            $(this).dialog("close");
                            var len = $(document).find('.delete_job').length;
                            if (len == 1) {
                                $(document).find('.delete_job').remove();
                            }
                        }
                    },
                    {
                        html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                        "class": "btn btn-xs",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                ]
            });
        });
        $("body").on("change", '.q_amount,.discount', function () {
            var th = $(this);
            var $qAmount, $dis, $disAmount, $tax, $taxAmount, $net_amount;
            $qAmount = th.closest('tr').find('.q_amount').val();
            $tax = 18;
            if ($qAmount !== 0) {
                $taxAmount = parseFloat($qAmount) + parseFloat(($qAmount * $tax) / 100);
                th.closest('tr').find('.tax_amount').val($taxAmount);
            }
            $net_amount = parseFloat($taxAmount) - parseFloat($disAmount);
            th.closest('tr').find('.net_amount').val($net_amount);
            totalAmount();
        });
        function discountAmountValues() {
            var $totalDisAmt = 0;
            $("body").find(".dis_amt").each(function () {
                var dis_amt = $(this).val();
                if ((dis_amt.length !== 0)) {
                    $totalDisAmt += parseFloat(dis_amt);
                }
            });
            $totalDisAmt = $totalDisAmt.toFixed(2);
            $('.discountAmtTxt').val($totalDisAmt);
            $('.discount_amt').text($totalDisAmt);
            finalAmount();
        }
        function totalAmount() {
            var $totalAmt = 0;
            $("body").find(".q_amount").each(function () {
                var total_amt = $(this).val();
                if (total_amt.length !== 0) {
                    $totalAmt += parseFloat(total_amt);
                }
            });
            $totalAmt = toDecimal($totalAmt, 2);
            $('.totalAmtTxt').val($totalAmt);
            $('.net_amt').text($totalAmt);
            var $totalNetAmt = 0;
            $("body").find(".tax_amount").each(function () {
                var net_amt = $(this).val();
                if (!isNaN(net_amt)) {
                    $totalNetAmt += parseFloat(net_amt);
                }
            });
            var $taxAmt = parseFloat($totalNetAmt) - parseFloat($totalAmt);
            $taxAmt = toDecimal($taxAmt, 2);
            $('.totalTaxTxt').val($taxAmt);
            var $customerBranchId = $('.customer_branch_id').val();
            var $branchId = $('.branch_id').val();
            if ($customerBranchId == $branchId) {
                // CGST and SGST
                var $halfTax = parseFloat($taxAmt / 2);
                $halfTax = $halfTax.toFixed(2);
                $('.cgst_amt,.sgst_amt').text($halfTax);
                $('.cgstAmtTxt,.sgstAmtTxt').val($halfTax);
                $('.igst_amt').text('0.00');
                $('.igstAmtTxt').val('0.00');
            } else {
                // IGST
                $('.cgst_amt,.sgst_amt').text('0.00');
                $('.cgstAmtTxt,.sgstAmtTxt').val('0.00');
                $('.igst_amt').text($taxAmt);
                $('.igstAmtTxt').val($taxAmt);
            }
            finalAmount();
        }
        function toDecimal(number, digits) {
            return number.toFixed(digits);
        }
        function finalAmount() {
            var $totalAmount = $('.totalAmtTxt').val();
            var $taxAmount = $('.totalTaxTxt').val();
            var $discountAmount = $('.discountAmtTxt').val();
            var $finalAmount = parseFloat($totalAmount) + parseFloat($taxAmount) /* - parseFloat($discountAmount) */;
            $finalAmount = toDecimal($finalAmount, 2);
            $('.finalAmtTxt').val($finalAmount);
            $('.final_amt').text($finalAmount);
            $('.prevAmt').text($finalAmount);
            $('.text_amount').val(convertNumberToWords($('.final_amt').text()) + 'Rupees Only');
        }
    })
</script>