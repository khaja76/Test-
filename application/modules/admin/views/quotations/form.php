
<style>
.spaced > li{
    margin-top:2px;
    margin-bottom:2px;
}
</style>
<h3 class="header smaller lighter">
    Make a Quotation
    <span class="pull-right">
        <a href="/admin/quotations" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<form class="form-inline text-center" id="frm" action="" enctype="multipart/form-data">
    <div class="form-group">
        <?php $types = ["customer_id" => "Customer Id", "inward_no" => "Job Id"]; ?>
        <select class="form-control input-sm required" id="search_type" name="type">            
            <?php foreach ($types as $k => $v) { ?>
                <option value="<?php echo $k; ?>" <?php echo !empty($_GET['type']) && ($_GET['type'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
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
<?php
if (!empty($customer) && (!empty($inwards))) {
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
                        <h2 class="text-center">Quotation</h2>
                    </div>
                    <div class="col-sm-4 text-right print-third">
                        <?php
                        if (!empty($branch)) {
                            ?>
                            <input type="hidden" class="branch_id" value="<?php echo !empty($branch['pk_id']) ? $branch['pk_id'] : ''; ?>"/>
                            <input type="hidden" class="b_state" value="<?php echo !empty($branch['state_code']) ? $branch['state_code'] : ''; ?>"/>
                            <h4><?php echo $branch['name'] ?></h4>
                            <p><?php echo !empty($branch['address1']) ? $branch['address1'] : '' ?><?php echo !empty($branch['address2']) ? '<br/>'.$branch['address2'] . ',' : '' ?> </p>
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
                                    <input type="hidden" class="cs_state" value="<?php echo !empty($customer['state_code']) ? $customer['state_code'] : ''; ?>"/>
                                    <ul class="list-unstyled  spaced">
                                    <?php if(!empty($customer['company_name'])){?>
                                        <li>
                                         <h4><?php echo $customer['company_name']; ?></h4>
                                        </li>
                                        <?php }
                                        ?>
                                        <li>
                                            <h4><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?></h4>
                                        </li> 
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
                                    <h4 class="grey">Quotation Information</h4>
                                </div>
                            </div>
                            <div
                            <ul class="list-unstyled spaced">
                                <li>
                                    <b><span class="w-150 f-l">Quotation No</span> </b> : <span class="m-l-10">-</span>
                                </li>
                                <li>
                                    <div class="">
                                        <label class="w-150 f-l">Quotation Date</label> :
                                        <input type="text" class="from-control date-picker input-sm" name="quotation_date" value="<?php echo date('d-m-Y');?>"/>
                                    </div>
                                </li>
                                <li class="bg-gray p-10">
                                    <div>
                                        <b><span class="w-150 f-l">Quotation Amount </span> </b>:<i class='fa fa-inr'></i> <span class="m-l-10 final_amt"></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                    <p><textarea name="notes" rows="3" class="form-control input-sm"><?php echo !empty($branch['reference']) ? $branch['reference']:''?></textarea></p>
                    <div class="space"></div>
                    Kind Attn.
                    <span><b><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name']; ?></b></span>,
                    <span><?php echo !empty($inwards[0]['gatepass_no']) ? "<b>Gatepass No.:</b>".$inwards[0]['gatepass_no'] :'';?></span>
                    <?php echo !empty($inwards[0]['outward_challan']) ? "<span><b>Delivery Challan:</b>".$inwards[0]['outward_challan']."</span>" :"";?>
                    <div class="space-1"></div>
                    <div class="row inv">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="w-140">Job ID</th>
                                    <th class="w-140">Gatepass No.</th>
                                    <th class="w-350">Project Description</th>
                                    <th >Job Status</th>
                                    <th >Remarks</th>
                                    <th class="w-100">Amount</th>
                                    <th class="w-100">Discount (%)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($inwards)) {
                                    $i = 1;
                                    foreach ($inwards as $inward) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td>
                                                <input type="hidden" name="job_id[]" class="form-control input-sm" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>
                                                <b><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></b>
                                                <br>
                                            </td>
                                            <td><?php echo !empty($inward['gatepass_no']) ?$inward['gatepass_no'] : '' ?></td>
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
                                            <td><textarea name="remarks[]" rows="2" cols="40">Repairable</textarea></td>
                                            <td>
                                                <input type="text" name="amount[]" class="form-control input-sm q_amount" onkeypress="return isNumber(event);" value="0"/>
                                                <input type="hidden" name="tax_amount[]" class="form-control input-sm tax_amount" value="0"/>
                                                <input type="hidden" name="net_amount[]" class="form-control input-sm net_amount" value="0"/>
                                            </td>
                                            <td>
                                                <input type="text" name="discount[]" class="form-control input-sm discount" maxlength="2" onkeypress="return isNumber(event);" value="0"/>
                                                <input type="hidden" name="dis_amt[]" class="dis_amt" value="0"/>
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
                                        <h6><i class="fa fa-inr"></i> <span class="net_amt">0</span></h6>
                                        <input type="hidden" name="total_amount" class="totalAmtTxt" value="0"/>
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
                                    <td><h6>Discount Amount : </h6></td>
                                    <td>
                                        <h6><i class="fa fa-inr"></i> <span class="discount_amt">0</span></h6>
                                        <input type="hidden" name="discount_amount" class="discountAmtTxt" value="0"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b><h5>Final Amount : </h5></b></td>
                                    <td><b><h5><i class="fa fa-inr"></i> <span class="final_amt">0</span></h5></b>
                                        <input type="hidden" name="total_tax" class="totalTaxTxt" value="0"/>
                                        <input type="hidden" name="final_amount" class="finalAmtTxt" value="0"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-7 pull-left">
                            <div class="form-group">
                                <label class="">Round off Amount (In words) : </label>
                                <input name="text_amount" readonly class="form-control text_amount" placeholder="Amount in Words"/>
                            </div>
                            <div class="space-12"></div>
                            <button type="submit" class="btn btn-success btn-saveQuote btn-sm"><i class=" fa fa-save"></i> Submit</button>
                        </div>                                                            
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
<?php }
else if(!empty($_GET['type']) && ($_GET['type']=='inward_no') && ((empty($inwards)))){    
    echo "<h5 class='text-center text-danger'>Quotation was already created for this Number</h5>";
}
else if(!empty($_GET['type']) && ($_GET['type']=='customer_id')){      
    echo "<h5 class='text-center text-danger'>No Inward found with these Number for the Quotation</h5>";
}
?>
<script>
    $(document).ready(function () {  
        $('.custSearchBtn').prop('disabled', true);
        var searchLen =  $('#filter').val().length;
        if(parseInt(searchLen)>2){
            $('.custSearchBtn').prop('disabled', false);
        }
        //console.log('Length is '+searchLen);   
        
        $('#filter').on('keyup', function() {
            if($(this).val().length >= 3) {
                $('.custSearchBtn').prop('disabled', false);
            } else {
                $('.custSearchBtn').prop('disabled', true);
            }
        });
        $("#frm").validate();
        $('.btn-saveQuote').click(function(){
//            $(this).attr({
//                'type':'button',
//                'disabled':true
//            });
//            $('#frm').submit();
        });
        $("body").on("change",'.q_amount,.discount',function(){
            var th = $(this);
            var $qAmount,$dis,$disAmount,$tax,$taxAmount,$net_amount;
            $disAmount = 0;
            $qAmount = th.closest('tr').find('.q_amount').val();
            $dis = th.closest('tr').find('.discount').val();
            if ( (($dis != '') || (!isNaN($dis))) && ($qAmount.length !== 0)) {
                $disAmount = parseFloat(($qAmount * $dis) / 100);
                th.closest('tr').find('.dis_amt').val($disAmount);
            }      
            discountAmountValues();
            $tax = 18;
            if ($qAmount !== 0) {
                $taxAmount = parseFloat($qAmount) + parseFloat((($qAmount-$disAmount) * $tax) / 100);
                th.closest('tr').find('.tax_amount').val($taxAmount);
            }
            $net_amount = parseFloat($taxAmount) - parseFloat($disAmount);
            th.closest('tr').find('.net_amount').val($net_amount);
            totalAmount();
        });
        function discountAmountValues(){
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
        function totalAmount(){
            var $totalAmt = 0;
            $("body").find(".q_amount").each(function () {
                var total_amt = $(this).val();
                if (total_amt.length !== 0) {
                    $totalAmt += parseFloat(total_amt);
                }
            });
            $totalAmt = toDecimal($totalAmt,2);
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
            $taxAmt = toDecimal($taxAmt,2);
            $('.totalTaxTxt').val($taxAmt);
            var $customerBranchId = $('.cs_state').val();
            var $branchId = $('.b_state').val();
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
        function toDecimal(number,digits){
            return number.toFixed(digits);
        }
        function finalAmount(){
            var $totalAmount = $('.totalAmtTxt').val();
            var $taxAmount = $('.totalTaxTxt').val();
            var $discountAmount = $('.discountAmtTxt').val();
            //var $finalAmount = parseFloat($totalAmount) + parseFloat($taxAmount) -parseFloat($discountAmount);
            var $finalAmount = parseFloat($totalAmount) + parseFloat($taxAmount);
            $finalAmount = Math.floor($finalAmount);
            $('.finalAmtTxt').val($finalAmount);
            $('.final_amt').text($finalAmount);
            $('.text_amount').val(convertNumberToWords($finalAmount)+'Rupees Only');
        }
    })
</script>