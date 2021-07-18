<style>
    .spaced > li {
        margin-top: 2px;
        margin-bottom: 2px;
    }
</style>
<h3 class="header smaller lighter">
    Edit Proforma
    <span class="pull-right">
        <a href="/admin/proforma" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<div class="clearfix"></div>
<div class="space-6"></div>
<?php
if (!empty($customer) && (!empty($proforma))) {
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
                            <h4><?php echo $branch['name'] ?></h4>
                            <p><?php echo !empty($branch['address1']) ? $branch['address1'] : '' ?><?php echo !empty($branch['address2']) ?  '<br/>' .$branch['address2'] . ',' : '' ?> </p>
                            <p><?php echo !empty($branch['city']) ? $branch['city'] : '' ?>-<?php echo !empty($branch['pincode']) ? $branch['pincode'] . ',' : '' ?> <?php echo !empty($branch['state_name']) ? $branch['state_name'] : '' ?></p>
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
                                    <ul class="list-unstyled  spaced">
                                        <?php if (!empty($customer['company_name'])) { ?>
                                            <li>
                                                <h4><?php echo $customer['company_name']; ?></h4>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?>
                                            </li>
                                        <?php } ?>
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
                                            <?php echo !empty($customer['pincode']) ? $customer['pincode'] : '' ?>
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
                                    <input type="hidden" name="proforma_id" value="<?php echo !empty($proforma['pk_id']) ? $proforma['pk_id'] : ''; ?>"/>
                                    <input type="hidden" name="proforma" value="<?php echo !empty($proforma['proforma']) ? $proforma['proforma'] : ''; ?>"/>
                                    <input type="hidden" name="proforma_no" value="<?php echo !empty($proforma['proforma_no']) ? $proforma['proforma_no'] : ''; ?>"/>
                                </li>
                                <li>
                                    <b><span class="w-150 f-l">Proforma No</span> </b> : <span class="m-l-10"><?php echo !empty($proforma['proforma']) ? $proforma['proforma'] : '' ?></span>
                                </li>
                                <li>
                                    <div class="">
                                        <label class="w-150 f-l">Proforma Date</label> :
                                        <input type="text" class="from-control date-picker input-sm" name="proforma_date" value="<?php echo !empty($proforma['proforma_date']) ? dateRangeDB2SHOW($proforma['proforma_date']) : date('Y-m-d'); ?>"/>
                                    </div>
                                </li>
                                <li class="bg-gray p-10">
                                    <div>
                                        <b><span class="w-150 f-l">Proforma Amount </span> </b>: <i class='fa fa-inr'></i> <span class="f_amEdt"><?php echo !empty($proforma['final_amount']) ? $proforma['final_amount'] : ''; ?></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                    <p>
                        <textarea name="notes" class="form-control input-sm" rows="3"><?php echo !empty($proforma['notes']) ? $proforma['notes'] : '' ?></textarea>
                    </p>
                    <div class="space"></div>
                    <div>
                        Kind Attn.
                        <span><b><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?></b></span>,
                        <span><b>Gatepass No.:</b><?php echo !empty($proforma['proforma_items'][0]['gatepass_no']) ? $proforma['proforma_items'][0]['gatepass_no'] : ''; ?></span>
                        <?php echo !empty($proforma['proforma_items'][0]['outward_challan']) ? "<span><b>Delivery Challan:</b>" . $proforma['proforma_items'][0]['outward_challan'] . "</span>" : ""; ?>
                    </div>
                    <div class="space-1"></div>
                    <div class="row inv">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-100">#</th>
                                    <th class="w-140">Job ID</th>
                                    <th class="w-140">Gatepass No</th>
                                    <!-- <th class="w-140">Delivery Challan</th> -->
                                    <th class="w-350">Project Description</th>
                                    <th class="w-100">Amount</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($proforma['proforma_items'])) {
                                    $count = count($proforma['proforma_items']);
                                    $i = 1;
                                    foreach ($proforma['proforma_items'] as $inward) {                                                                                
                                        ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td>
                                                <input type="hidden" name="proforma_job_id[]" value="<?php echo !empty($inward['proforma_job_id']) ? $inward['proforma_job_id'] : ''; ?>"/>
                                                <input type="hidden" name="quotation_job_id[]" value="<?php echo !empty($inward['quotation_job_id']) ? $inward['quotation_job_id'] : ''; ?>"/>
                                                <input type="hidden" name="job_id[]" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>"/>
                                                <input type="hidden" name="job[]" value="<?php echo !empty($inward['job']) ? $inward['job'] : ''; ?>"/>
                                                <b><?php echo $inward['job'] ?><br></b>
                                            </td>
                                            <td><?php echo $inward['gatepass_no'] ?></td>                                            
                                            <td>
                                                <div>
                                                    <span class="small"><b><?php echo !empty($inward['product']) ? $inward['product'] . ',' : '' ?></b></span>
                                                    <span class="small"><b><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] . ',' : '' ?></b></span>                                               
                                                    <span class="small"><b><?php echo !empty($inward['model_no']) ? $inward['model_no'] . ',' : '' ?></b></span>
                                                    <span class="small"><b><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] . ',' : '' ?></b></span>
                                                    <span class="small"><b><?php echo !empty($inward['description']) ? $inward['description'] : '' ?></b></span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" readonly name="amount[]" class="form-control input-sm q_amount" value="<?php echo !empty($inward['amount']) ? $inward['amount'] : '0'; ?>"/>
                                                <input type="hidden" name="tax_amount[]" class="form-control input-sm tax_amount" value="<?php echo !empty($inward['tax_amount']) ? $inward['tax_amount'] : '0'; ?>"/>
                                                <input type="hidden" name="net_amount[]" class="form-control input-sm net_amount" value="<?php echo !empty($inward['net_amount']) ? $inward['net_amount'] : '0'; ?>"/>
                                            </td>
                                            <td>
                                                <?php if ($count > 1) { ?>
                                                    <span class="btn btn-xs btn-danger del delete_job" data-proforma="<?php echo $proforma['pk_id']; ?>" data-job="<?php echo $inward['pk_id']; ?>"><i class="fa fa-trash"></i></span>
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
                                        <h6><i class="fa fa-inr"></i> <span class="net_amt"><?php echo !empty($proforma['total_amount']) ? $proforma['total_amount'] : ''; ?></span></h6>
                                        <input type="hidden" name="total_amount" class="totalAmtTxt" value="<?php echo !empty($proforma['total_amount']) ? $proforma['total_amount'] : ''; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h6>CGST Amount : </h6></td>
                                    <td>
                                        <h6><i class="fa fa-inr"></i> <span class="cgst_amt"><?php echo !empty($proforma['cgst_amount']) ? $proforma['cgst_amount'] : ''; ?></span></h6>
                                        <input type="hidden" name="cgst_amount" class="cgstAmtTxt" value="<?php echo !empty($proforma['cgst_amount']) ? $proforma['cgst_amount'] : ''; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h6>SGST Amount : </h6></td>
                                    <td>
                                        <h6><i class="fa fa-inr"></i> <span class="sgst_amt"><?php echo !empty($proforma['sgst_amount']) ? $proforma['sgst_amount'] : ''; ?></span></h6>
                                        <input type="hidden" name="sgst_amount" class="sgstAmtTxt" value="<?php echo !empty($proforma['sgst_amount']) ? $proforma['sgst_amount'] : ''; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h6>IGST Amount : </h6></td>
                                    <td>
                                        <h6><i class="fa fa-inr"></i> <span class="igst_amt"><?php echo !empty($proforma['igst_amount']) ? $proforma['igst_amount'] : ''; ?></span></h6>
                                        <input type="hidden" name="igst_amount" class="igstAmtTxt" value="<?php echo !empty($proforma['igst_amount']) ? $proforma['igst_amount'] : ''; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b><h5>Final Amount : </h5></b></td>
                                    <td><b><h5><i class="fa fa-inr"></i> <span class="final_amt"><?php echo !empty($proforma['final_amount']) ? $proforma['final_amount'] : ''; ?></span></h5></b>
                                        <input type="hidden" name="total_tax" class="totalTaxTxt" value="<?php echo !empty($proforma['total_tax']) ? $proforma['total_tax'] : ''; ?>"/>
                                        <input type="hidden" name="final_amount" class="finalAmtTxt" value="<?php echo !empty($proforma['final_amount']) ? $proforma['final_amount'] : ''; ?>"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-7 pull-left">
                            <?php
                            $work = !empty($proforma['work_order']) ? $proforma['work_order'] : '';
                            if (!empty($work)) {
                                $work_order = explode('$', $work)[0];
                                $work_order_date = explode('$', $work)[1];
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="">Work Order : </label>
                                        <input name="work_order" class="form-control" placeholder="Work Order" value="<?php echo !empty($work_order) ? $work_order : '' ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="">Work Order Date : </label>
                                        <input name="work_order_date" class="form-control date-picker" placeholder="Work Order Date" value="<?php echo !empty($work_order_date) ? dateRangeDB2SHOW($work_order_date) : '' ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Amount (In words) : </label>
                                <input name="text_amount" readonly class="form-control txt_amount" placeholder="Amount in Words" value="<?php echo !empty($proforma['text_amount']) ? $proforma['text_amount'] : ''; ?>"/>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success btn-sm"><i class=" fa fa-save"></i> Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
<?php } else {
    //echo "<h5 class='text-center text-danger'>No Inward found with these Number for the Quotation</h5>";
}
?>
<script>
    $(document).ready(function () {
        $("#frm").validate();
        $(".date-picker").datepicker({
            format: 'dd-mm-yyyy',
        });
        $("body").on("click", ".delete_job", function (e) {
            var pi = $(this).data('proforma');
            var pij = $(this).data('job');
            e.preventDefault();
            var len = $(document).find('.delete_job').length;
            var th = $(this);
            var url = '<?php echo base_url();?>';
            console.log(pi + ',' + pij);
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
                            $(this).dialog("close");
                            var len = $(document).find('.delete_job').length;
                            if (len == 1) {
                                $(document).find('.delete_job').remove();
                                $.ajax({
                                    type: 'POST',
                                    url: url + 'admin/proforma/proforma-edit-item/',
                                    data: {pi: pi, pij: pij},
                                    success: function (data) {
                                        console.log(data);
                                    }
                                });
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
        /*function discountAmountValues() {
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
         }*/
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
            var $finalAmount = 0;
            var $totalAmount = $('.totalAmtTxt').val();
            var $taxAmount = $('.totalTaxTxt').val();
            $finalAmount = parseFloat($totalAmount) + parseFloat($taxAmount);
            $finalAmount = toDecimal($finalAmount, 2);
            $('.finalAmtTxt').val($finalAmount);
            $('.final_amt').text($finalAmount);
            $('.f_amEdt').text($finalAmount);
            $('.txt_amount').val(convertNumberToWords($finalAmount) + 'Rupees Only');
            console.log(convertNumberToWords($finalAmount) + 'Rupees Only');
        }
    })
</script>