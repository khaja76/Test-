
<?php if (!empty($quotation)) { ?>
    <style>       
        .m-0 {
            margin: 0 0 0 !important;
        }
        .font-20{font-size:20px}
        .w-200{width:200px}
        .fs-11{
            font-size:12px;
        }
        @media print {
            .print-1half{float:left;width:43%}
            .print-2half{float:left;width:56%}
            table,tr,td{padding:2px !important;font-size:14px}
            .print-third {
                width: 27% !important;
                float: left;
            }
            .print-third3 {
                width: 46% !important;
                float: right;
            }
            .mrn-35 {
                margin-right: -25px !important;
            }
            .text-head {
                text-align: center !important;
            }
            .fs-11{
               font-size:10px !important;
            }
            .amt-tbl-h6.final{
                margin:0;padding:0
            }
            .row.inv table{font-size:14px !important}
            .word-wrap{word-break: break-word;}
            .quote{margin:10px}
        }
        .text-head {
            text-align: center;
        }
    </style>
    <div class="quote">
        <div class="widget-box transparent" style="padding-bottom: 0px;">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-4 print-third">
                    <?php $path = '/data/branches/';
                    if (!empty($branch['branch_logo']) && file_exists(FCPATH . $path . $branch['branch_logo'])) { ?>
                        <img class="max-100 f-l preview-pic" alt="Branch Logo" src="<?php echo base_url() . $path . $branch['branch_logo']; ?>"/>
                    <?php } ?>
                </div>
                <div class="col-sm-4 col-md-4  col-xs-4 print-third">
                    <h2 class="text-head mrn-35">Quotation</h2>
                </div>
                <div class="col-sm-4 col-md-4  col-xs-4 text-right print-third3">
                    <?php
                    if (!empty($branch)) {
                        ?>
                        <input type="hidden" class="branch_id" value="<?php echo !empty($branch['pk_id']) ? $branch['pk_id'] : ''; ?>"/>
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
                        <p class="m-0 fs-11"><?php echo !empty($branch['address1']) ? $branch['address1'] . '' : '' ?></p>
                        <p class="m-0 fs-11"><?php echo !empty($branch['address2']) ? $branch['address2'] . ',' : '' ?>
                         <?php echo !empty($branch['city']) ? $branch['city'] : '' ?>-<?php echo !empty($branch['pincode']) ? $branch['pincode'] . ',' : '' ?>
                          <?php echo !empty($branch['state_name']) ? $branch['state_name'] : '' ?> </p>
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
                <div>
                    <div class="row">
                        <div class="col-sm-7 print-2half">
                            <div class="row">
                                <div class="col-xs-11">
                                    <h4 class="gray" style="margin-bottom:0"> To  : <?php if (!empty($customer['company_name'])) { ?>
                                            <?php echo $customer['company_name']; ?>
                                        <?php } else { ?>
                                            <?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?>
                                        <?php } ?></h4>
                                </div>
                            </div>
                            <div>
                                <?php
                                if (!empty($customer)) {
                                    ?>
                                    <ul class="list-unstyled  spaced ">
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
                                            <?php echo !empty($customer['pincode']) ? $customer['pincode'].'-' : '' ?> India.
                                        </li>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-sm-4 print-1half col-md-offset-1">
                            <!--<div class="row">
                                <div class="col-xs-12">
                                    <h4 class="grey">Quotation Information</h4>
                                </div>
                            </div>-->
                            <div>
                            <ul class="list-unstyled spaced">
                                <li>
                                    <b><span class="w-150 f-l">Quotation No</span> </b> : <span class="m-l-10"><?php echo !empty($quotation['quotation']) ? $quotation['quotation'] : '' ?></span>
                                </li>
                                <li>
                                    <b><span class="w-150 f-l">Quotation Date</span> </b>: <span class="m-l-10"><?php echo !empty($quotation['quotation_date']) ? dateDB2SHOW($quotation['quotation_date']) : '' ?></span>
                                </li>
                                <li class="bg-gray">
                                    <div>
                                        <b><span class="w-150 f-l">Quotation Amount </span> </b>: <span class="m-l-10"><b><i class='fa fa-inr'></i> <?php echo !empty($quotation['final_amount']) ? number_format($quotation['final_amount'], 2) : '' ?></b></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="clearfix"></div>
                <div class="space-4"></div>
                <p><?php echo !empty($quotation['notes']) ? '<b>'.$quotation['notes'].'</b>' : '' ?></p>
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
                            if (!empty($quotation['quotation_items'])) {
                                foreach ($quotation['quotation_items'] as $quotation_job1) {
                                    if(!empty($quotation_job1['gatepass_no'])){
                                        $gatepass = 'Ref : ' . $quotation_job1['gatepass_no'];
                                    }                                    
                                }
                                echo (!empty($gatepass)) ? $gatepass : '';
                            }
                            ?>
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
                                <th>#</th>
                                <th class="w-140">Job ID</th>
                                <!-- <th class="w-100">Gate Pass No</th> -->
                                <th class="w-350">Project Description</th>
                                <th>Remarks</th>
                                <th class="w-100 text-right">Amount</th>
                                <?php if (!empty($quotation['discount_amount']) && ($quotation['discount_amount'] > 0)) { ?>
                                    <th class="w-100 text-right">Discount (%)</th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($quotation['quotation_items'])) {
                                $i = 1;
                                rsort($quotation['quotation_items']);
                                foreach ($quotation['quotation_items'] as $quotation_job) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><b><?php echo $quotation_job['job'] ?></b>                                                                  
                                        </td>
                                        <td>
                                            <div>
                                                <span class="small"><b><?php echo !empty($quotation_job['product']) ? $quotation_job['product'] . ',' : '' ?></b></span>
                                                <span class="small"><b><?php echo !empty($quotation_job['manufacturer_name']) ? $quotation_job['manufacturer_name'] . ',' : '' ?></b></span>                                           
                                                <span class="small"><b><?php echo !empty($quotation_job['model_no']) ? $quotation_job['model_no'] . ',' : '' ?></b></span>
                                                <span class="small"><b><?php echo !empty($quotation_job['serial_no']) ? $quotation_job['serial_no'] . ',' : '' ?></b></span>
                                                <span class="small"><b><?php echo !empty($quotation_job['description']) ? $quotation_job['description'] : '' ?></b></span>
                                            </div>
                                        </td>
                                        <td><?php echo !empty($quotation_job['quotation_remarks']) ? $quotation_job['quotation_remarks'] : 'NA' ?></td>
                                        <td class="text-right"><?php echo !empty($quotation_job['amount']) ? $quotation_job['amount'] : '0'; ?></td>
                                        <?php if (!empty($quotation['discount_amount']) && ($quotation['discount_amount'] > 0)) { ?>
                                            <td class="text-right"><?php echo !empty($quotation_job['discount']) ? $quotation_job['discount'] : '0'; ?></td>
                                        <?php } ?>
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
                        <?php if (!empty($quotation) && !empty($quotation['text_amount'])) { ?>
                            <label>Amount ( In Words) : </label>                            
                            <label><b><?php
                                    echo trim($quotation['text_amount']);
                                    ?></b></label>
                        <?php } ?>
                        <?php if (!empty($branch['bank_info'])) { ?>
                            <div class="well fs-11 mb-0 p-68">
                                <?php echo !empty($branch['bank_info']) ? "<h6>Bank Name &nbsp;: " . $branch['bank_info'] . "</h6>" : "" ?>
                                <?php echo !empty($branch['account_no']) ? "<h6>Bank Ac No.&nbsp;: " . $branch['account_no'] . "</h6>" : "" ?>
                                <?php echo !empty($branch['ifsc_no']) ? "<h6>IFSC / NEFT  &nbsp;: " . $branch['ifsc_no'] . "</h6>" : "" ?>
                                <?php echo !empty($branch['gst_no']) ? "<h6>GST No.  &nbsp;  &nbsp; &nbsp; &nbsp;: " . $branch['gst_no'] . "</h6>" : "" ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-3 col-md-offset-1 print-1half pull-right">
                        <style>
                            .amt-tbl-h6 {
                                /*margin-top: 2px; */margin-bottom: 2px;
                            }
                        </style>
                        <table>
                            <tr>
                                <td><h6 class="amt-tbl-h6"><b><span class="f-l">Net Amount</span> </b><span style="margin-left:23px;visibility:hidden">( @ 18% ) </span>:</h6></td>
                                <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($quotation['total_amount']) ? number_format($quotation['total_amount'], 2) : '' ?></span></h6></td>
                            </tr>
                                <tr>
                                    <td><h6 class="amt-tbl-h6"><b><span class=" f-l">CGST Amount </span> </b><span style="margin-left:22px">( @ 9% ) :</span></h6></td>
                                    <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($quotation['cgst_amount']) ? number_format($quotation['cgst_amount'], 2) : '' ?></span></h6></td>
                                </tr>
                                <tr>
                                    <td><h6 class="amt-tbl-h6"><b><span class=" f-l">SGST Amount  </span> </b><span style="margin-left:22px">( @ 9% ) :</span></h6></td>
                                    <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($quotation['sgst_amount']) ? number_format($quotation['sgst_amount'], 2) : '' ?></span></h6></td>
                                </tr>
                                <tr>
                                    <td><h6 class="amt-tbl-h6"><b><span class=" f-l">IGST Amount </span> </b><span style="margin-left:20px">( @ 18% ) : </span></h6></td>
                                    <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($quotation['igst_amount']) ? number_format($quotation['igst_amount'], 2) : '' ?></span></h6></td>
                                </tr>
                                <?php if (!empty($quotation['discount_amount']) && ($quotation['discount_amount'] > 0)) { ?>
                                <tr>
                                    <td><h6 class="amt-tbl-h6"><b><span class=" f-l">Discount Amount </span> </b><span class="hide" style="margin-left:20px;visibility:hidden">( @ 18% ) </span>: </h6></td>
                                    <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo number_format($quotation['discount_amount'], 2); ?></span></h6></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><h6 class="amt-tbl-h6"><b><span class="f-l">Final Amount </span> </b><span style="margin-left:19px;visibility:hidden">( @ 18% ) </span>:</h6></td>
                                    <td><h6 class="amt-tbl-h6"><span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($quotation['final_amount']) ? number_format($quotation['final_amount'], 2) : '' ?></span></h6></td>
                                </tr>
                        </table>                                                
                    </div>
                    
                </div>
                <div class="space-4"></div>
                <?php
                if (!empty($branch['quotation_tc'])) {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class='red bg-gray Amrutam Gamaya'>Terms and Conditions :</h5>
                            <p class="fs-11">
                                <?php
                                echo $branch['quotation_tc'];
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
        </div>
    </div>
    </div>
<?php } ?>