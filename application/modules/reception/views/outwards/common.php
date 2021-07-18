<!-- <span class="msg"></span> -->
<style>
    /*page styles will be same in mail template also*/
    @media screen, print {  
        .max-100{
            margin:10px;
        }     
        .font-20{font-size:20px} 
        .col-xs-9 {
            float: left;
            width: 75%;
        }
        .challan-box {
            max-width: 900px;
            margin: 0 auto;
        }
        .border {
            border: 1px solid #ada7a7 !important;
        }
        .border-right {
            border-right: 1px solid #ada7a7 !important;
        }
        .border-left {
            border-left: 1px solid #ada7a7 !important;
        }
        .border-top {
            border-top: 1px solid #ada7a7 !important;
        }
        .p-5 {
            padding: 5px;
        }
        .mb-0 {
            margin-bottom: 0;
        }
        .w-15 {
            width: 15px;
        }
        .w-140 {
            width: 140px;
        }       
        .m-15 {
            margin: 15px 5px !important;
        }
        .p-10 {
            padding: 10px;
        }
        .ml-15 {
            margin-left: 15px;
        }
        .border-t-none{
            border-top:none !important;
        }
        .border-b-none{
            border-bottom:none !important;
        }        
    }
    @media print {
        /* .clp {
            padding-left: 15px;
            padding-right: 15px;
        } */        
        .mw-127{
            max-width: 127px;
        }
        table,tr,td{padding:2px !important;font-size:14px}
        .challan-box{margin:13px}
        .mb-0{font-size:14px}        
        .font-10{font-size:10px}
        .font-20{font-size:20px}
        .left-print:{float:left;width:90%}
        .right-print:{float:right;width:10%}        
        body{  margin: 0mm 5mm 5mm 5mm;}
    }    
    
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 ">
        <!-- <div class="space-12"></div> -->
        <div class="challan-box">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 no-padding border border-b-none">
                    <div class="col-md-9 col-sm-9 leeft-print  col-xs-8 text-center no-padding border-right">
                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                $path = '/data/branches/';
                                if (!empty($branch_data['branch_logo']) && file_exists(FCPATH . $path . $branch_data['branch_logo'])) { ?>
                                    <div class="">
                                        <img style="max-width: 127px" class="max-100 m-10 mw-127 f-l preview-pic" alt="Branch Logo" src="<?php echo base_url() . $path . $branch_data['branch_logo']; ?>"/>
                                    </div>
                                <?php } ?>
                                <h4>
                                    <?php
                                    if (!empty($branch_data['name'])) {
                                        if (strtolower($branch_data['name']) == 'hifi technologies') {
                                            echo "<img src='" . base_url() . "assets/h.png' alt='logo' width='150'/>";
                                        } else {
                                            echo $branch_data['name'];
                                        }
                                    }
                                    ?>
                                </h4>
                                <div class="mb-0"><?php echo !empty($branch_data['address1']) ? $branch_data['address1'] . ',' : '' ?></div>
                                <div><?php echo !empty($branch_data['address2']) ? $branch_data['address2'].', ' : '' ?>                                                                    
                                    <?php echo !empty($branch_data['city']) ? $branch_data['city'].', ' : '' ?>
                                    <?php echo !empty($branch_data['state_name']) ? $branch_data['state_name'].' - ' : '' ?>
                                    <?php echo !empty($branch_data['pincode']) ? $branch_data['pincode'] : '' ?>
                                </div>
                                <div> <?php echo !empty($branch_data['phone_1']) ? $branch_data['phone_1'] . ',' : '' ?>
                                    <?php echo !empty($branch_data['phone_2']) ? $branch_data['phone_2'].', ' : '' ?>
                                    <?php echo !empty($branch_data['mobile_1']) ? $branch_data['mobile_1'] . ',' : '' ?>
                                    <?php echo !empty($branch_data['mobile_2']) ? $branch_data['mobile_2'] : '' ?>
                                </div>                      
                            </div>
                        </div>
                        <div class="space-2"></div>
                    </div>
                    <div class="col-md-3 col-sm-4 right-print col-xs-4 clp">
                        <div class="clp">
                            <h4 class="">DELIVERY CHALLAN</h4>
                            <h5 class="mb-0"><?php echo (!empty($challan['challan'])) ? $challan['challan'] : '' ?></h5>
                            <p class="mb-0">Date :<?php echo (!empty($challan['created_on'])) ? dateDB2SHOW($challan['created_on']) : '' ?></p>
                            <p class="" style="font-size: 12px;">Timings 9 A.M. to 7 P.M.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 no-padding border">
                    <div class="text-center">
                        <p style="font-size: 12px;margin:0 0 4px;padding:0 4px;text-align:center"> <?php echo !empty($branch_data['branch_info']) ? $branch_data['branch_info'] : '' ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 border-right border-left">
                <div class="row">
                    <?php
                    if (!empty($customer['company_name'])) { ?>
                        <div class="col-md-6 print-half">
                            <h6><b><?php echo $customer['company_name']; ?></b></h6>
                            <?php echo !empty($customer['address1']) ? $customer['address1'] : ''; ?>
                            <?php echo !empty($customer['address2']) ? $customer['address2'] : ''; ?>
                            <?php echo !empty($customer['city']) ? $customer['city'] : ''; ?>
                        </div>
                    <?php } ?>
                    <div class="col-md-6 print-half <?php echo (!empty($customer['company_name'])) ? 'text-right' : ''; ?>">                            
                    <?php echo (!empty($customer['company_name'])) ? 'Refer ' : ''; ?> To : 
                                <?php
                                echo (!empty($customer['last_name'])) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'];
                                echo !empty($customer['occupation']) && (!empty($customer['company_name'])) ? ', '.$customer['occupation']: ''; ?>
                            <br/>Customer ID : ( <?php echo $customer['customer_id'] ?> )
                            
                    </div> 
                    <div class="col-md-6 print-half text-right">
                        <div class="row">
                        <?php if(!empty($outwards)){
                            foreach($outwards as $outward1){
                                $gatepass = !empty($outward1['gatepass_no']) ? $outward1['gatepass_no'] : '';
                            }
                            echo !empty($gatepass) ? 'Ref : ' .$gatepass : '';
                        } ?>             
                        </div>               
                    </div>
                </div>
            </div>
            <div class="">
                <?php
                if (!empty($outwards)) {
                    $j = 1; ?>
                <div class="border-left border-right">
                    <table class="table table-bordered table-striped mb-0 ">
                        <thead>
                        <tr>
                            <th class="w-15">S.No</th>
                            <th class="w-140">Job Id</th>
                            <th>Description</th>
                            <th class="w-180">Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($outwards as $inward) {
                                ?>
                                <tr>
                                    <td><?php echo $j; ?></td>
                                    <td><span class="small"><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></span></td>
                                    <td>
                                        <div>
                                            <span class="small"><?php echo !empty($inward['product']) ? $inward['product'] . ',' : '-' ?></span>
                                            <span class="small"><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] . ',' : '-' ?></span>                                    
                                            <span class="small"><?php echo !empty($inward['model_no']) ? $inward['model_no'] . ',' : '-' ?></span>
                                            <span class="small"><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] . '' : '-' ?></span>
                                            <span class="small"><?php echo !empty($inward['description']) ? ',' . $inward['description'] : '-' ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-' ?></td>
                                </tr>
                                <?php
                                $j++;                        
                            } ?>
                        </tbody>
                    </table>
                    <div class="m-t-20">
                        <?php if (!empty($branch_data['outwards_tc'])) { ?>
                            <div style="padding:5px 10px" >
                                <h5 style="margin-top:0">Term & Conditions :</h5>                        
                                <div style="font-size: 10px;">
                                    <?php echo !empty($branch_data['outwards_tc']) ? $branch_data['outwards_tc'] : '' ?>
                                </div>
                            </div>
                            <?php
                        } ?>                    
                        <div style="border-top: 1px solid #ada7a7;border-bottom: 1px solid #ada7a7;min-height:80px;">
                            <div style="float:left;width:100%;">
                                <div class="pull-left p-5"><p>Repairs Only</p></div>
                            </div>
                            
                            <div class=" col-md-6 col-sm-6 col-xs-6"><h4>Customer's Signature</h4></div>
                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">For <span class="font-20"><?php echo !empty($branch_data['name']) ? ($branch_data['name']) : '' ?></span></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>