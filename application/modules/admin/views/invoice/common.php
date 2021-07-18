<style>
    .amt-tbl-h6 {
        margin-top: -5px;
    }
    .m-0 {
            margin: 0 0 0 !important;
    }
    .font-20{font-size:20px}
    .w-200{width:200px}
    @media print {
        .print-1half{float:left;width:45%}
            .print-2half{float:left;width:54%}
            table,tr,td{padding:2px !important;font-size:14px}
        .print-third {
            width: 28% !important;
            float: left;
        }
        .print-third3 {
            width: 44% !important;
            float: right;
        }
        .mrn-35 {
            margin-right: -25px !important;
        }
        .text-head {
            text-align: center !important;
        }
        .fs-11 {
            font-size: 11px;
        }
        .amt-tbl-h6.final{
                margin:0;padding:0
            }
        .mb-0{
            margin-bottom:0;
        }
        .p-68{
            padding: 6px 8px;
        }
        .row.inv table{font-size:14px !important}
        .word-wrap{word-break: break-word;}
        .quote{margin:10px}
        b{font-weight:normal}
    }
    .text-head{
        text-align:center ;
    }
</style>
<?php
if (!empty($customer) && (!empty($invoice))) {    
    ?>
    <div class="quote">
        <form method="post" action="">
            <div class="widget-box transparent">
                <div class="row">
                    <div class="col-sm-4  col-md-4  col-xs-4  print-third">
                        <?php $path = '/data/branches/';
                        if (!empty($branch['branch_logo']) && file_exists(FCPATH . $path . $branch['branch_logo'])) { ?>
                            <img class="max-100 f-l preview-pic" alt="Branch Logo"
                                 src="<?php echo base_url() . $path . $branch['branch_logo']; ?>"/>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4  col-md-4  col-xs-4  print-third">
                        <h2 class="text-head mrn-35">Tax Invoice</h2>
                    </div>
                    <div class="col-sm-4  col-md-4  col-xs-4  text-right print-third3">
                        <?php
                        if (!empty($branch)) {
                            ?>
                            <input type="hidden" class="branch_id"
                                   value="<?php echo !empty($branch['pk_id']) ? $branch['pk_id'] : ''; ?>"/>
                            <h4>
                                <?php
                                if (!empty($branch['name'])) {
                                    if (strtolower($branch['name']) == 'hifi technologies') {
                                        echo "<img src='" . base_url() . "assets/h.png' alt='logo'  width='150'/>";
                                    } else {
                                        echo $branch['name'];
                                    }
                                }
                                ?>
                            </h4>
                            <p class="m-0 fs-11">
                                <?php echo !empty($branch['address1']) ? $branch['address1'] . '' : '' ?>
                            </p>
                            <p class="m-0 fs-11"><?php echo !empty($branch['address2']) ? $branch['address2'] . ',' : '' ?> <?php echo !empty($branch['city']) ? $branch['city'] : '' ?>
                                -<?php echo !empty($branch['pincode']) ? $branch['pincode'] . ',' : '' ?> <?php echo !empty($branch['state_name']) ? $branch['state_name'] : '' ?>
                            </p>
                            <p class="m-0 fs-11"><?php echo !empty($branch['email']) ? $branch['email'] : '' ?></p>
                            <p class="m-0 fs-11">
                            <div> <?php echo !empty($branch['phone_1']) ?  $branch['phone_1'] . ', ' : '' ?>
                                <?php echo !empty($branch['phone_2']) ? $branch['phone_2'].', ' : '' ?>
                                <?php echo !empty($branch['mobile_1']) ? $branch['mobile_1'] . ', ' : '' ?>
                                <?php echo !empty($branch['mobile_2']) ? $branch['mobile_2'] : '' ?>
                            </div> 
                        <?php }
                        ?>
                    </div>
                </div>
                <div class="hr hr8 hr-double hr-dotted"></div>
                <div class="widget-body">
                    <div class="row">
                        <div class="col-sm-7 print-2half">
                            <div class="row">
                                <div class="col-xs-11">
                                    <h4 class="gray">Invoice To</h4>
                                </div>
                            </div>
                            <div>
                                <?php
                                if (!empty($customer)) {
                                    ?>
                                    <input type="hidden" name="customer_id"
                                           value="<?php echo !empty($customer['pk_id']) ? $customer['pk_id'] : ''; ?>"/>
                                    <input type="hidden" class="customer_branch_id"
                                           value="<?php echo !empty($customer['branch_id']) ? $customer['branch_id'] : ''; ?>"/>
                                    <ul class="list-unstyled  spaced">
                                        <?php if (!empty($customer['company_name'])) { ?>
                                            <li>
                                                <h4><?php echo $customer['company_name']; ?></h4>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <h4> <?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?></h4>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($customer['gst_no'])) { ?>
                                            <li>
                                                <?php echo "GST No : " . $customer['gst_no']; ?>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <?php echo !empty($customer['address1']) ? $customer['address1'] : '' ?>
                                            <?php echo !empty($customer['address2']) ? ',' . $customer['address2'] : '' ?>
                                            <?php echo !empty($customer['city']) ? $customer['city'] : '' ?>
                                            <?php echo !empty($customer['state']) ? ',' . $customer['state'] : '' ?>
                                            <?php echo !empty($customer['pincode']) ? $customer['pincode'] : '' ?>
                                            India.
                                        </li>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div><!-- /.col -->
                         <div class="col-sm-4 print-1half col-md-offset-1">
                            <!-- <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="grey">Invoice Information</h4>
                                </div>
                            </div> -->
                            <div>
                            <ul class="list-unstyled spaced">
                                <li>
                                    <b><span class="w-150 f-l">Invoice No</span> </b> : <span class="m-l-10"><?php echo !empty($invoice['invoice']) ? $invoice['invoice'] : ''; ?></span>                                    
                                </li>
                                <li>
                                    <b><span class="w-150 f-l">Invoice Date</span></b> : <span class="m-l-10"><?php echo !empty($invoice['invoice_date']) ? dateDB2SHOW($invoice['invoice_date']) : ''; ?></span>                                    
                                </li>
                                <li class="bg-gray">
                                    <div>
                                        <b><span class="w-150 f-l">Invoice Amount </span> </b>: <span class="m-l-10"><b><i class='fa fa-inr'></i> <?php echo !empty($invoice['final_amount']) ? number_format($invoice['final_amount'],2) : ''; ?></b></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="clearfix"></div>
                <div class="space-4"></div>
                    <?php
                    $work = !empty($invoice['work_order']) ? $invoice['work_order'] : '';
                    if (!empty($work)) {
                        $work_order = explode('$', $work)[0];
                        $work_order_date = explode('$', $work)[1];
                    }
                    ?>
                    <div class="clearfix"></div>
                    <p><?php echo !empty($branch['reference']) ? '<b>'.$branch['reference'].'</b>' : '' ?></p>
                    <div class="space-2"></div>
                    <div class="row">
                        <div class="col-md-6 print-half">
                            <span class="pull-left m-0">
                            Kind Attn. :
                            <?php
                                echo (!empty($customer['last_name'])) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'];
                                echo !empty($customer['occupation']) && (!empty($customer['company_name'])) ? ', '.$customer['occupation']: ''; ?>
                            <br/>Customer ID : ( <?php echo $customer['customer_id'] ?> )                        
                            </span>
                        </div>
                        <div class="col-md-6 print-half text-right">
                            <div class="row">
                        <span class="pull-right m-0"> 
                            <?php
                            if (!empty($invoice['invoice_items'])) {
                                foreach ($invoice['invoice_items'] as $invoice1) {
                                    if(!empty($invoice1['gatepass_no'])){
                                        $gatepass = 'Ref : ' . $invoice1['gatepass_no'];
                                    }                                    
                                }
                                echo (!empty($gatepass)) ? $gatepass : '';
                            }
                            ?>
                        <?php echo !empty($invoice['invoice_items'][0]['outward_challan']) ? '&nbsp;<b>DeliveryChallan:</b>' . $invoice['invoice_items'][0]['outward_challan'] : '' ?>
                        <?php echo !empty($work_order) ? '<b>Work Order : </b>' . $work_order : '' ?>
                        <?php echo !empty($work_order_date) ? ' - <b>Date :</b>' . dateDB2SHOW($work_order_date) : '-' ?>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="space-1"></div>
                <div class="row inv">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th width="10">#</th>
                                <th class="w-140">Job ID</th>
                                <th class="w-350">Project Description</th>
                                <th class="w-140">Status</th>
                                <th class="w-100 text-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($invoice['invoice_items'])) {
                                $i = 1;
                                foreach ($invoice['invoice_items'] as $inward) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td>
                                            <b><?php echo !empty($inward['job']) ? $inward['job'] : ''; ?></b>                                                
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
                                        <td>
                                            <?php echo !empty($inward['i_remarks']) ? $inward['i_remarks'] : ''; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo !empty($inward['amount']) ? $inward['amount'] : '0'; ?>
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
                <div class="row" style="margin-bottom: -10px;">
                    <div class="col-sm-8 print-2half pull-left word-wrap">
                        <?php if (!empty($invoice['text_amount'])) { ?>
                            <label>Amount ( In Words) : </label>                            
                            <label><b><?php echo trim($invoice['text_amount']); ?></b></label>
                        <?php } ?>
                        <?php if (!empty($branch['bank_info'])) { ?>
                            <div class="well fs-11 mb-0 p-68">
                                <?php echo !empty($branch['bank_info']) ? "<h6>Bank Name &nbsp;: " . $branch['bank_info'] . "</h6>" : "" ?>
                                <?php echo !empty($branch['account_no']) ? "<h6>Bank Ac No.&nbsp;: " . $branch['account_no'] . "</h6>" : "" ?>
                                <?php echo !empty($branch['ifsc_no']) ? "<h6>IFSC / NEFT  &nbsp;&nbsp;: " . $branch['ifsc_no'] . "</h6>" : "" ?>
                                <?php echo !empty($branch['gst_no']) ? "<h6>GST No.  &nbsp;  &nbsp; &nbsp; &nbsp;: " . $branch['gst_no'] . "</h6>" : "" ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-3 col-md-offset-1 print-1half pull-right">
                    <style>
                        .amt-tbl-h6 {
                            margin-top: 2px;margin-bottom: 2px;
                        }
                    </style>
                        <table>
                            <tr>
                                <td><h6 class="amt-tbl-h6"><b><span class="f-l">Net Amount</span> </b><span style="margin-left:23px;visibility:hidden">( @ 18% ) </span>:</h6></td>
                                <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($invoice['total_amount']) ? number_format($invoice['total_amount'], 2) : '' ?></span></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="amt-tbl-h6"><b><span class=" f-l">CGST Amount </span> </b><span style="margin-left:22px">( @ 9% ) :</span></h6></td>
                                <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($invoice['cgst_amount']) ? number_format($invoice['cgst_amount'], 2) : '' ?></span></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="amt-tbl-h6"><b><span class=" f-l">SGST Amount  </span> </b><span style="margin-left:22px">( @ 9% ) :</span></h6></td>
                                <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($invoice['sgst_amount']) ? number_format($invoice['sgst_amount'], 2) : '' ?></span></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="amt-tbl-h6"><b><span class=" f-l">IGST Amount </span> </b><span style="margin-left:20px">( @ 18% ) : </span></h6></td>
                                <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($invoice['igst_amount']) ? number_format($invoice['igst_amount'], 2) : '' ?></span></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="amt-tbl-h6"><b><span class="f-l">Final Amount </span> </b><span style="margin-left:19px;visibility:hidden">( @ 18% ) </span>:</h6></td>
                                <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($invoice['final_amount']) ? number_format($invoice['final_amount'], 2) : '' ?></span></h6></td>
                            </tr>
                        </table> 
                    </div>
                </div>
                <div class="space-4"></div>
                <?php
                if (!empty($branch['proforma_invoice_tc'])) {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class='red bg-gray fs-11'>Terms and Conditions :</h5>
                            <p class="fs-11">
                                <?php
                                echo $branch['proforma_invoice_tc'];
                                ?>
                            </p>
                            <h6 class="fs-11"><b>Thanks for your Business !</b></h6>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div style="padding: 10px;    border: 1px solid #e3e3e3;">
                    <div class="row">
                        <div class="col-md-6 print-half">
                            <b>Received by : </b>
                            <p>Date<span style="margin-left:44px;"> : </span></p>
                        </div>
                        <div class="col-md-6 print-half text-right">
                            <br/>
                            For <span class="font-20"><?php echo !empty($branch['name']) ? ($branch['name']) : '' ?></span>
                        </div>
                    </div>
                </div>
                <div class="space-4"></div>
            </div>
        </form>
    </div>
    </div>
<?php }
?>
