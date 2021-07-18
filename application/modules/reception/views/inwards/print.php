<?php
if (empty($inwards)) {
    redirect(base_url() . 'reception/inwards/add');
}
?>
<style>
    /*page styles will be same in mail template also*/
   @media screen, print
   {
       .col-xs-9{
           float: left;
           width:75%;
       }
    .m-15{
        margin:15px !important;
    }
    .no-margin {
        margin: 0;
    }
    .challan-box {
        width: 700px;
        margin: 0 auto;
    }
    .border {
        border: 1px solid #ada7a7;
    }
    .border-right {
        border-right: 1px solid #ada7a7
    }
    .border-left {
        border-left: 1px solid #ada7a7;
    }
    .border-top {
        border-top: 1px solid #ada7a7;
    }
    .p-5 {
        padding: 5px;
    }
    .mb-0 {
        margin-bottom: 0px;
    }
    .mb-5 {
        margin-bottom: 5px !important;
    }
    .ml-50 {
        margin-left: 50px;
    }
    .ml-10 {
        margin-left: 10px !important;
    }
    .ml-15 {
        margin-left: 15px !important;
    }
    .mh-450 {
        min-height: 300px;
    }
    .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
        border-left:1px solid #ddd;    
        border-top:1px solid #ddd;
        border-right:1px solid #ddd;
    }
    .w-15{
        width:15px;
    }
    .w-140{
        width:140px;
    }
    .ml-15{
        margin-left: 15px;
    }
   }
    @media print {
        .clp {
            padding-left: 15px;
            padding-right: 15px;
        }
        .mw-127{
            max-width: 127px;
        }
    }
</style>
<h3 class="header smaller lighter hidden-print">
    Inwards Challan
    <span class="pull-right">
        <a href="<?php echo base_url() ?>reception/inwards/add" class="btn btn-warning btn-xs"> <i class='fa fa-arrow-left'></i> Back</a>
        <a href="javascript:print(0)" class="btn btn-primary btn-xs"> <i class='fa fa-print'></i> Print</a>
    </span>
</h3>
<div class="row">
    <div class="col-xs-12 col-sm-12 ">
        <div class="space-12"></div>
            <div id="challan-main-div" class="col-sm-8 col-sm-offset-2">
                <div class="challan-box">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 no-padding border">
                            <div class="col-md-9 col-sm-9  col-xs-8 text-center no-padding border-right">
                            <?php 
                                 $path = '/data/branches/';
                                 if (!empty($branch_data['branch_logo']) && file_exists(FCPATH . $path . $branch_data['branch_logo'])) { ?>
                               <img style="max-width: 127px" class="max-100 mw-127 m-15 f-l preview-pic" alt="Branch Logo" src="<?php echo base_url() .$path . $branch_data['branch_logo']; ?>"/>
                             <?php }?>
                                <h4>
                                    <?php
                                    if (!empty($branch_data['name'])) {
                                        if (strtolower($branch_data['name']) == 'hifi technologies') {
                                            echo "<img src='" . base_url() . "assets/h.png' alt='logo'  width='150'/>";
                                        } else {
                                            echo $branch_data['name'];
                                        }
                                    }
                                    ?>
                                </h4>
                                <p class="mb-0"><?php echo !empty($branch_data['address1']) ? $branch_data['address1'] . ',' : '' ?>
                                    <?php echo !empty($branch_data['address2']) ? $branch_data['address2'] : '' ?>,
                                    <?php echo !empty($branch_data['city']) ? $branch_data['city'] : '' ?>,
                                    <?php echo !empty($branch_data['state_name']) ? $branch_data['state_name'] : '' ?>-
                                    <?php echo !empty($branch_data['pincode']) ? $branch_data['pincode'] : '' ?>
                                </p>
                                <p> <?php echo !empty($branch_data['phone_1']) ? 'Ph:' . $branch_data['phone_1'] . ',' : '' ?>
                                    <?php echo !empty($branch_data['phone_2']) ? $branch_data['phone_2'] : '' ?>
                                    <?php echo !empty($branch_data['mobile_1']) ? $branch_data['mobile_1'] . ',' : '' ?>
                                    <?php echo !empty($branch_data['mobile_2']) ? $branch_data['mobile_2'] : '' ?></p>
                                    <p style="font-size: 9px;margin:0 0 4px;"> <?php echo !empty($branch_data['branch_info']) ? $branch_data['branch_info'] : '' ?></p>
                            </div>
                            <div class="col-md-3  col-sm-4  col-xs-4 clp">
                                <h4 class="ml-15">INWARD CHALLAN</h4>
                                <h5 class="ml-15"><b> <?php echo !empty($inwards[0]['inward_challan']) ? $inwards[0]['inward_challan']  : 'NA'; ?> </b></h5>
                                <p class="mb-0 ml-15">Date :<?php echo date('d-m-Y') ?></p>
                                <p style="font-size: 12px;" class="ml-15">Timings 9 A.M. to 7 P.M.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 border-right border-left">
                        
                            <?php 
                            if (!empty($customer['company_name'])) { ?>
                                <div class="col-md-6 print-half">
                                    <h6><b><?php echo $customer['company_name']; ?></b></h6>
                                    <?php echo !empty($customer['address1']) ? $customer['address1']: '' ; ?>
                                    <?php echo !empty($customer['address2']) ? $customer['address2']: '' ; ?>
                                    <?php echo !empty($customer['city']) ? $customer['city']: '' ; ?>
                                    
                                </div>
                            <?php } ?>
                            <div class="col-md-6 print-half">
                                <h6>Refer To : <b>
                                    <?php
                                        if (!empty($customer['last_name'])) { 
                                            echo $customer['first_name'].' '.$customer['last_name']; 
                                    }else{
                                        echo $customer['first_name'];
                                    }
                                    ?>
                                    </b>                             
                                        ( <?php echo $customer['customer_id'] ?> )                                    
                                </h6>
                                 <?php
                                            echo !empty($inwards[0]['gatepass_no']) ? 'Gatepass No. - '.$inwards[0]['gatepass_no']: '' ;
                                    ?>
                            </div>
        
                         </div>
                    </div>
                    <div class="row">
                        <?php
                        if (!empty($inwards)) {
                            $i = 1; ?>
                            <div class="mh-450 border-left border-right">
                                <table class="table table-bordered table-striped mb-0 ">
                                    <thead>
                                    <tr>
                                    <th class="w-15">S.No</th>
                                    <th class="w-140">Job Id</th>
                                    <th>Description</th>
                                    <th  class="w-180">Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($inwards as $inward) {
                                        ?>
                                        <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><b><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></b></td>
                                        <td>
                                        <div>
                                        <span class="small"><b><?php echo !empty($inward['product']) ? $inward['product'].',' : '-' ?></b></span>
                                        <span class="small"><b><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'].',' : '-' ?></b></span>
                                    </div>
                                    <div>
                                        <span class="small"><b><?php echo !empty($inward['model_no']) ? $inward['model_no'].',' : '-' ?></b></span>
                                        <span class="small"><b><?php echo !empty($inward['serial_no']) ? $inward['serial_no'].'' : '-' ?></b></span>
                                        <span class="small"><b><?php echo !empty($inward['description']) ? ','.$inward['description'] : '-' ?></b></span>
                                    </div>
                                        </td>
                                        <td><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-' ?></td>
                                    </tr>
                                        <?php
                                        $i++;
                                    } ?>
                                    </tbody>
                                </table>
                                <div style="margin-top:20px;margin-left:10px;">
                                    <?php if (!empty($branch_data['inwards_tc'])) { ?>
                                        <b>Term & Conditions :</b>
                                        <br/>
                                        <p style="font-size: 10px">
                                            <?php echo !empty($branch_data['inwards_tc']) ? $branch_data['inwards_tc'] : '' ?>
                                        </p>
                                        <?php
                                    } ?>
                                    <div  style="border-top: 1px solid #ada7a7;border-bottom: 1px solid #ada7a7;height:100px;">
                                        <div style="float:left;width:100%;">
                                            <div class="pull-left p-5"><p>Repairs Only</p></div>
                                        </div>
                                        <div>
                                            <div class=" col-md-6 col-sm-6 col-xs-6"><h4>Customer's Signature</h4></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><h4 class="ml-50 text-right">For <?php echo !empty($branch_data['name']) ? strtoupper($branch_data['name']) : '' ?></h4></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>      
    </div>
</div>
