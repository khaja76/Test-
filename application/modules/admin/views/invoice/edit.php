
<style>
.spaced > li{
    margin-top:2px;
    margin-bottom:2px;
}
</style>
<h3 class="header smaller lighter">
    Edit  Invoice
    <span class="pull-right">
        <a href="/admin/invoice" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<div class="clearfix"></div>
<div class="space-6"></div>
<?php
if (!empty($customer) && (!empty($invoice))) {
    ?>
    <div class="quote">
        <form method="post" action="">
            <div class="widget-box transparent">
                <div class="row">
                    <div class="col-sm-4 print-third">
                    <?php  $path = '/data/branches/';
                            if (!empty($branch['branch_logo']) && file_exists(FCPATH . $path . $branch['branch_logo'])) { ?>                               
                                <img class="max-100 f-l preview-pic" alt="Branch Logo" src="<?php echo base_url() .$path . $branch['branch_logo']; ?>"/>                              
                    <?php }?>
                     
                    </div>
                    <div class="col-sm-4 print-third">
                        <h2 class="text-center">Tax Invoice</h2>
                    </div>
                    <div class="col-sm-4 text-right print-third">
                        <?php
                        if (!empty($branch)) {
                            ?>
                            <input type="hidden" class="branch_id" value="<?php echo !empty($branch['pk_id']) ? $branch['pk_id'] : ''; ?>"/>
                            <h4><?php echo $branch['name'] ?></h4>
                            <p><?php echo !empty($branch['address1']) ? $branch['address1'] : '' ?><?php echo !empty($branch['address2']) ?  '<br/>'.$branch['address2'] . ',' : '' ?> </p>
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
                                    <h4 class="gray">Invoice To</h4>
                                </div>
                            </div>
                            <div>
                                <?php
                                if (!empty($customer)) {
                                    ?>                                    
                                    <input type="hidden" class="customer_branch_id" value="<?php echo !empty($customer['branch_id']) ? $customer['branch_id'] : ''; ?>"/>
                                    <ul class="list-unstyled  spaced">
                                    <?php if(!empty($customer['company_name'])){?>
                                        <li>
                                            <h4><?php echo $customer['company_name'];?></h4>
                                        </li>
                                        <?php }else{?>
                                        
                                        <li>
                                            <?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?>
                                        </li>
                                        <?php }?>
                                        <?php if(!empty($customer['gst_no'])){?>
                                        <li>
                                            <b><?php echo  "GST No : ".$customer['gst_no'];?></b>
                                        </li>
                                        <?php }?>
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
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="grey">Invoice Information</h4>
                                </div>
                            </div>
                            <div>
                            <ul class="list-unstyled spaced">
                            <li>
                                <input type="hidden" name="invoice_id" value="<?php echo !empty($invoice['pk_id']) ? $invoice['pk_id'] : ''; ?>"/>                               
                            </li>
                            <li>
                            <b><span class="w-150 f-l">Invoice No</span> </b> : <span class="m-l-10"><?php echo !empty($invoice['invoice']) ? $invoice['invoice']:''?></span>
                            </li>
                        <li>
                            <div class="">
                                <label class="w-150 f-l">Invoice Date</label> :
                                <input type="text" class="from-control date-picker input-sm" name="invoice_date" value="<?php echo !empty($invoice['invoice_date']) ? dateDB2SHOW($invoice['invoice_date']): date('Y-m-d');?>"/>
                            </div>
                        </li>
                        <li class="bg-gray p-10">
                            <div>
                                <b><span class="w-150 f-l">Invoice Amount </span> </b>: <i class='fa fa-inr'></i> <?php echo !empty($invoice['final_amount']) ? $invoice['final_amount'] : ''; ?>
                            </div>
                        </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                    <p>
                        <textarea name="notes" class="form-control"  rows="3"><?php echo !empty($invoice['notes']) ? $invoice['notes']: $branch['reference']?></textarea>
                    </p>
                    <div class="space"></div>
                    <div class="row">
                        <div class="col-md-6">
                            Kind Attn. <span><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?></span>,
                            Customer ID : <span><?php echo !empty($customer['customer_id']) ? $customer['customer_id'] : ''; ?></span>
                        </div>
                        <div class="col-md-6">
                            <span><b>Gatepass No.:</b><?php echo !empty($invoice['invoice_items'][0]['gatepass_no']) ? $invoice['invoice_items'][0]['gatepass_no'] : ''; ?></span>
                            <?php echo !empty($invoice['invoice_items'][0]['outward_challan']) ? "<span><b>DeliveryChallan:</b>" . $invoice['invoice_items'][0]['outward_challan'] . "</span>" : ""; ?>
                        </div>
                    </div>
                    <div class="space-1"></div>
                    <div class="row inv">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                <th class="w-140">#</th>
                                <th class="w-150">Job ID</th>                                
                                <th class="w-350">Project Description</th>
                                <th class="w-140">Status</th>             
                                <th class="w-100">Amount</th>                                                               
                            </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($invoice['invoice_items'])) {
                                    $count=count($invoice['invoice_items']);
                                    $i = 1;
                                    foreach ($invoice['invoice_items'] as $inward) {
                                        ?>
                                         <tr>
                                         <td><?php echo $i ?></td>
                                         <td>
                                             <input type="hidden" name="inward_pk_id[]" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>                                             
                                             <input type="hidden" name="job_id[]" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>"/>                                             
                                             <b><?php echo $inward['job'] ?><br></b>
                                         </td>                                          
                                         <td>
                                             <div>
                                                 <span><b><?php echo !empty($inward['product']) ? $inward['product'] . ',' : '' ?></b></span>
                                                 <span><b><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] . ',' : '' ?></b></span>
                                             </div>
                                             <div>
                                                 <span><b><?php echo !empty($inward['model_no']) ? $inward['model_no'] . ',' : '' ?></b></span>
                                                 <span><b><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] . ',' : '' ?></b></span>
                                                 <span><b><?php echo !empty($inward['description']) ? $inward['description'] : '' ?></b></span>
                                             </div>
                                         </td>
                                         <td>                                         
                                            <input type="text" name="i_remarks[]" value="<?php echo !empty($inward['i_remarks']) ? $inward['i_remarks'] : ''; ?>"/>
                                         </td>
                                         <td>
                                             <input type="text" name="amount[]" class="form-control input-sm q_amount" value="<?php echo !empty($inward['amount']) ? $inward['amount'] : '0'; ?>"/>
                                             <input type="hidden" name="tax_amount[]" class="form-control input-sm tax_amount" value="<?php echo !empty($inward['tax_amount']) ? $inward['tax_amount'] : round($inward['amount']*18/100,2); ?>"/>                                              
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
                                <h6><i class="fa fa-inr"></i> <span class="net_amt"><?php echo !empty($invoice['total_amount']) ? $invoice['total_amount'] : ''; ?></span></h6>
                                <input type="hidden" name="total_amount" class="totalAmtTxt" value="<?php echo !empty($invoice['total_amount']) ? $invoice['total_amount'] : ''; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td><h6>CGST Amount : </h6></td>
                            <td>
                                <h6><i class="fa fa-inr"></i> <span class="cgst_amt"><?php echo !empty($invoice['cgst_amount']) ? $invoice['cgst_amount'] : ''; ?></span></h6>
                                <input type="hidden" name="cgst_amount" class="cgstAmtTxt" value="<?php echo !empty($invoice['cgst_amount']) ? $invoice['cgst_amount'] : ''; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td><h6>SGST Amount : </h6></td>
                            <td>
                                <h6><i class="fa fa-inr"></i> <span class="sgst_amt"><?php echo !empty($invoice['sgst_amount']) ? $invoice['sgst_amount'] : ''; ?></span></h6>
                                <input type="hidden" name="sgst_amount" class="sgstAmtTxt" value="<?php echo !empty($invoice['sgst_amount']) ? $invoice['sgst_amount'] : ''; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td><h6>IGST Amount : </h6></td>
                            <td>
                                <h6><i class="fa fa-inr"></i> <span class="igst_amt"><?php echo !empty($invoice['igst_amount']) ? $invoice['igst_amount'] : ''; ?></span></h6>
                                <input type="hidden" name="igst_amount" class="igstAmtTxt" value="<?php echo !empty($invoice['igst_amount']) ? $invoice['igst_amount'] : ''; ?>"/>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><b><h5>Final Amount : </h5></b></td>
                            <td><b><h5><i class="fa fa-inr"></i> <span class="final_amt"><?php echo !empty($invoice['final_amount']) ? $invoice['final_amount'] : ''; ?></span></h5></b>
                                <input type="hidden" name="total_tax" class="totalTaxTxt" value="<?php echo !empty($invoice['total_tax']) ? $invoice['total_tax'] : ''; ?>"/>
                                <input type="hidden" name="final_amount" class="finalAmtTxt" value="<?php echo !empty($invoice['final_amount']) ? $invoice['final_amount'] : ''; ?>"/>
                            </td>
                        </tr>
                    </table>
                        </div>
                        <div class="col-sm-7 pull-left">
                        <?php
                            $work=  !empty($invoice['work_order']) ? $invoice['work_order']:'';
                            if(!empty($work)){
                            $work_order=explode('$',$work)[0];
                            $work_order_date=explode('$',$work)[1];
                        }
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="">Work Order : </label>
                                        <input name="work_order" class="form-control" placeholder="Work Order" value="<?php echo !empty($work_order) ? $work_order:'' ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="">Work Order Date : </label>
                                        <input name="work_order_date" class="form-control date-picker" placeholder="Work Order Date" value="<?php echo !empty($work_order_date) ? dateDB2SHOW($work_order_date) :'' ?>"/>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Amount (In words) : </label>
                                <input name="text_amount" class="form-control text_amount" placeholder="Amount in Words" value="<?php echo !empty($invoice['text_amount']) ? $invoice['text_amount'] :''; ?>"/>
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
<?php }
?>
<script>
    $(document).ready(function () {
        $("#frm").validate();
        
        $("body").on("change", '.q_amount', function () {
            var th = $(this);
            var $qAmount, $dis, $disAmount, $tax, $taxAmount, $net_amount;
            $finalAmount = 0;
            $qAmount = th.closest('tr').find('.q_amount').val();          
            $tax = 18;
            if ($qAmount !== 0) {
                $taxAmount = parseFloat(($qAmount * $tax) / 100);
                th.closest('tr').find('.tax_amount').val($taxAmount);                
            }            
            totalAmount();
        });
        
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
            var $taxAmt = parseFloat($totalNetAmt);
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
            var $finalAmount = parseFloat($totalAmount) + parseFloat($taxAmount);
            $finalAmount = toDecimal($finalAmount, 2);
            $('.finalAmtTxt').val($finalAmount);
            $('.final_amt').text($finalAmount);
            $('.text_amount').val(convertNumberToWords($('.final_amt').text()) + 'Rupees Only');
        }
       
    })
</script>