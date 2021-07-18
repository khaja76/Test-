<h3 class="header smaller lighter">
    Edit Quotation
    <span class="pull-right">
        <a href="/admin/quotations" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<div class="clearfix"></div>
<div class="space-6"></div>
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
                    <h2 class="text-center">Quotation</h2>
                </div>
                <div class="col-sm-4 text-right print-third">
                    <?php
                    if (!empty($branch)) {
                        ?>
                        <input type="hidden" class="branch_id" value="<?php echo !empty($branch['pk_id']) ? $branch['pk_id'] : ''; ?>"/>
                        <h4><?php echo $branch['name'] ?></h4>
                        <p><?php echo !empty($branch['address1']) ? $branch['address1'] : '' ?><?php echo !empty($branch['address2']) ? '<br/> '.$branch['address2'] . ',' : '' ?> </p>
                        <p><?php echo !empty($branch['city']) ? $branch['city'] : '' ?>-<?php echo !empty($branch['pincode']) ? $branch['pincode'] . ',' : '' ?> <?php echo !empty($branch['state']) ? $branch['state'] : '' ?>, India</p>
                        <p><?php echo !empty($branch['email']) ? $branch['email'] : '' ?></p>
                        <p><?php echo !empty($branch['mobile_1']) ? $branch['mobile_1'] : '' ?></p>
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
                                <h4 class="gray">Quotation To</h4>
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
                                            <?php echo $customer['company_name']; ?>
                                        </li>
                                    <?php }
                                    ?>
                                    <li>
                                        <b><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?></b>
                                    </li>
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
                                    <!--   <li>
                                        Contact :<?php // echo !empty($customer['mobile']) ? $customer['mobile'] : '' ?>
                                    </li> -->
                                </ul>
                            <?php } ?>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-sm-4 print-half col-md-offset-2">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 class="grey">Quotation Information</h4>
                            </div>
                        </div>
                        <div>
                        <ul class="list-unstyled spaced">
                            <li>
                                <input type="hidden" name="quotation_id" value="<?php echo !empty($quotation['pk_id']) ? $quotation['pk_id'] : ''; ?>"/>
                                <input type="hidden" name="quotation" value="<?php echo !empty($quotation['quotation']) ? $quotation['quotation'] : ''; ?>"/>
                                <input type="hidden" name="quotation_no" value="<?php echo !empty($quotation['quotation_no']) ? $quotation['quotation_no'] : ''; ?>"/>
                                <b><span class="w-150 f-l">Quotation No</span> </b> : <span class="m-l-10"><?php echo !empty($quotation['quotation']) ? $quotation['quotation'] : ''; ?></span>
                            </li>
                            <li>
                                <div class="">
                                    <label class="w-150 f-l">Quotation Date</label> :
                                    <input type="text" class="from-control date-picker input-sm" name="quotation_date" value="<?php echo !empty($quotation['quotation_date']) ? dateRangeDB2SHOW($quotation['quotation_date']) : '' ?>"/>
                                </div>
                            </li>
                            <li class="bg-gray p-10">
                                <div>
                                    <b><span class="w-150 f-l">Quotation Amount </span> </b>:<i class='fa fa-inr'></i> <span class="m-l-10 final_amt"><?php echo !empty($quotation['final_amount']) ? number_format($quotation['final_amount'], 2) : '' ?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="space"></div>
                <div class="clearfix">
                </div>
                <p><textarea name="notes" rows="3" class="form-control input-sm"><?php echo !empty($quotation['notes']) ? $quotation['notes'] : '' ?></textarea></p>
                <div class="space"></div>
                Kind Attn.
                <span><b><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?></b></span>,
                <span><?php echo !empty($inwards[0]['gatepass_no']) ? "<b>Gatepass No.:</b>" . $inwards[0]['gatepass_no'] : ''; ?></span>
                <?php echo !empty($inwards[0]['outward_challan']) ? "<span><b>Delivery Challan:</b>" . $inwards[0]['outward_challan'] . "</span>" : ""; ?>
                <div class="row inv">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="w-140">Job ID</th>
                                <th class="w-350">Project Description</th>
                                <th>Remarks</th>
                                <th class="w-100">Amount</th>
                                <th class="w-100">Discount (%)</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($quotation['quotation_items'])) {
                                $i = 1;
                                $count = count($quotation['quotation_items']);
                                foreach ($quotation['quotation_items'] as $quotation_job) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td>
                                            <input type="hidden" name="quotation_job_id[]" value="<?php echo !empty($quotation_job['pk_id']) ? $quotation_job['pk_id'] : ''; ?>"/>
                                            <input type="hidden" name="job_id[]" value="<?php echo !empty($quotation_job['job_id']) ? $quotation_job['job_id'] : ''; ?>"/>
                                            <b><?php echo $quotation_job['job'] ?><br></b>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="small"><b><?php echo !empty($quotation_job['product']) ? $quotation_job['product'] . ',' : '' ?></b></span>
                                                <span class="small"><b><?php echo !empty($quotation_job['manufacturer_name']) ? $quotation_job['manufacturer_name'] . ',' : '' ?></b></span>
                                            </div>
                                            <div>
                                                <span class="small"><b><?php echo !empty($quotation_job['model_no']) ? $quotation_job['model_no'] . ',' : '' ?></b></span>
                                                <span class="small"><b><?php echo !empty($quotation_job['serial_no']) ? $quotation_job['serial_no'] . ',' : '' ?></b></span>
                                                <span class="small"><b><?php echo !empty($quotation_job['description']) ? $quotation_job['description'] : '' ?></b></span>
                                            </div>
                                        </td>
                                        <td><textarea name="remarks[]" rows="2" cols="40"><?php echo !empty($quotation_job['quotation_remarks']) ? $quotation_job['quotation_remarks'] : ''; ?></textarea></td>
                                        <td>
                                            <input type="text" name="amount[]" class="form-control input-sm q_amount" onkeypress="return isNumber(event);" value="<?php echo !empty($quotation_job['amount']) ? $quotation_job['amount'] : '0'; ?>"/>
                                            <input type="hidden" name="tax_amount[]" class="form-control input-sm tax_amount" value="<?php echo !empty($quotation_job['tax_amount']) ? $quotation_job['tax_amount'] : '0'; ?>"/>
                                            <input type="hidden" name="net_amount[]" class="form-control input-sm net_amount" value="<?php echo !empty($quotation_job['net_amount']) ? $quotation_job['net_amount'] : '0'; ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="discount[]" class="form-control input-sm discount" onkeypress="return isNumber(event);" value="<?php echo !empty($quotation_job['discount']) ? $quotation_job['discount'] : '0'; ?>"/>
                                            <input type="hidden" name="dis_amt[]" class="dis_amt" value="<?php echo !empty($quotation_job['disc_amount']) ? $quotation_job['disc_amount'] : '0'; ?>"/>
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
                                    <h6><i class="fa fa-inr"></i> <span class="net_amt"><?php echo !empty($quotation['total_amount']) ? $quotation['total_amount'] : ''; ?></span></h6>
                                    <input type="hidden" name="total_amount" class="totalAmtTxt" value="<?php echo !empty($quotation['total_amount']) ? $quotation['total_amount'] : ''; ?>"/>
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
                                <td><h6>Discount Amount : </h6></td>
                                <td>
                                    <h6><i class="fa fa-inr"></i> <span class="discount_amt"><?php echo !empty($quotation['discount_amount']) ? $quotation['discount_amount'] : ''; ?></span></h6>
                                    <input type="hidden" name="discount_amount" class="discountAmtTxt" value="<?php echo !empty($quotation['discount_amount']) ? $quotation['discount_amount'] : ''; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td><b><h5>Final Amount : </h5></b></td>
                                <td><b><h5><i class="fa fa-inr"></i> <span class="final_amt"><?php echo !empty($quotation['final_amount']) ? $quotation['final_amount'] : ''; ?></span></h5></b>
                                    <input type="hidden" name="total_tax" class="totalTaxTxt" value="<?php echo !empty($quotation['total_tax']) ? $quotation['total_tax'] : ''; ?>"/>
                                    <input type="hidden" name="final_amount" class="finalAmtTxt" value="<?php echo !empty($quotation['final_amount']) ? $quotation['final_amount'] : ''; ?>"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-7 pull-left">
                        <div class="form-group">
                            <label class="">Round off Amount (In words) : </label>
                            <input name="text_amount" readonly class="form-control text_amount" placeholder="Amount in Words" value="<?php echo !empty($quotation['text_amount']) ? $quotation['text_amount'] : '' ?>"/>
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
<script>
    $(document).ready(function () {
        $("#frm").validate();
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
                            discountAmountValues();
                            totalAmount();
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
            $disAmount = 0;
            $qAmount = th.closest('tr').find('.q_amount').val();
            $dis = th.closest('tr').find('.discount').val();
            if ((($dis != '') || (!isNaN($dis))) && ($qAmount.length !== 0)) {
                $disAmount = parseFloat(($qAmount * $dis) / 100);
                th.closest('tr').find('.dis_amt').val($disAmount);
            }
            $tax = 18;
            if ($qAmount !== 0) {
                $taxAmount = parseFloat($qAmount) + parseFloat((($qAmount-$disAmount) * $tax) / 100);
                th.closest('tr').find('.tax_amount').val($taxAmount);
            }
            $net_amount = parseFloat($taxAmount) - parseFloat($disAmount);
            th.closest('tr').find('.net_amount').val($net_amount);
            discountAmountValues();
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
            //var $finalAmount = parseFloat($totalAmount) + parseFloat($taxAmount) - parseFloat($discountAmount);
            var $finalAmount = parseFloat($totalAmount) + parseFloat($taxAmount);
            $finalAmount = Math.floor($finalAmount);
            $('.finalAmtTxt').val($finalAmount);
            $('.final_amt').text($finalAmount);
            $('.text_amount').val(convertNumberToWords($finalAmount) + 'Rupees Only');
        }
    })
</script>