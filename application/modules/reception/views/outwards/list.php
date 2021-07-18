<span class="msg"></span>
<style>
    /*page styles will be same in mail template also*/
    @media screen, print {  
        .max-100{
            margin:10px;
        }              
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
        /* .mh-450 {
            min-height: 300px;
        } */
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
    }
</style>
<h3 class="header smaller lighter hidden-print">
    Outwards List
    <span class="pull-right">
        <a class="btn btn-xs btn-info" href="<?php echo get_role_based_link() . '/outwards/add/' ?>">
                    <i class="white ace-icon fa fa-plus bigger-120"></i>
                  Add One More
     </a>
    <button type="submit" form="frm" class="btn btn-xs btn-success _saveOut">
                    <i class="white ace-icon fa fa-save bigger-120"></i>
                  Save
     </button>
     
    </span>
</h3>
<div class="col-xs-12 col-sm-12 ">
    <div class="space-12"></div>
    <div class="challan-box">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 no-padding border border-b-none">
                <div class="col-md-9 col-sm-9  col-xs-8 text-center no-padding border-right">
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
                            <div class="mb-0"><?php echo !empty($branch_data['address1']) ? $branch_data['address1'] . ',' : '' ?>
                                <?php echo !empty($branch_data['address2']) ? $branch_data['address2'] : '' ?>,
                                <?php echo !empty($branch_data['city']) ? $branch_data['city'] : '' ?>,
                            </div>
                            <div><?php echo !empty($branch_data['state_name']) ? $branch_data['state_name'] : '' ?>-
                                <?php echo !empty($branch_data['pincode']) ? $branch_data['pincode'] : '' ?>
                            </div>
                            <div> <?php echo !empty($branch_data['phone_1']) ? 'Ph:' . $branch_data['phone_1'] . ',' : '' ?>
                                <?php echo !empty($branch_data['phone_2']) ? $branch_data['phone_2'] : '' ?>
                                <?php echo !empty($branch_data['mobile_1']) ? $branch_data['mobile_1'] . ',' : '' ?>
                                <?php echo !empty($branch_data['mobile_2']) ? $branch_data['mobile_2'] : '' ?>
                            </div>
                        </div>
                    </div>  
                <div class="space-2"></div>                                              
            </div>          
            <div class="col-md-3 col-sm-4  col-xs-4 clp">
                <div class="clp">
                    <h4>DELIVERY CHALLAN</h4>
                    <h5 class="mb-0"><?php echo (!empty($outwards) && !empty($outwards['challan'])) ? $outwards['challan'] : '' ?></h5>
                    <p class="mb-0">Date :<?php echo date('d-m-Y') ?></p>
                    <p style="font-size: 12px;">Timings 9 A.M. to 7 P.M.</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 no-padding border">
                <div class="text-center">
                    <p style="font-size: 11px;margin:0 0 4px;padding:0 4px;text-align:center"> <?php echo !empty($branch_data['branch_info']) ? $branch_data['branch_info'] : '' ?></p>
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
                        </div>
                    <?php } ?>
                    <div class="col-md-6 print-half">
                        Refer To :
                            <?php
                            echo (!empty($customer['last_name'])) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'];
                            ?>
                            <?php echo !empty($customer['address1']) ? $customer['address1'] : '';
                                echo !empty($customer['address2']) ? $customer['address2'] : ''; 
                                echo !empty($customer['city']) ? ', ' . $customer['city'] : '';
                            ?>
                            ( <?php echo $customer['customer_id'] ?> )
                            
                    </div>
                    <div class="col-md-6 print-half"><?php echo !empty($outwards[0]['gatepass_no']) ? 'Gatepass No. - ' . $outwards[0]['gatepass_no'] : ''; ?></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mh-150 border-left border-right">
                <form method="post" id="frm">
                    <table class="table table-bordered table-striped mb-0 ">
                        <thead>
                        <tr>
                            <th class="w-15 border-left">S.No</th>
                            <th class="w-140">Job Id</th>
                            <th>Description</th>
                            <th class="w-180">Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($outwards)) {
                            $j = 1;
                            foreach ($outwards as $inward) {
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="ace" name="outward_ids[]" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>" checked/>
                                        <label class="ace lbl"></label>
                                        <input type="hidden" name="inward_ids[]" value="<?php echo !empty($inward['inward_id']) ? $inward['inward_id'] : ''; ?>"/>
                                        <?php echo $j; ?>
                                    </td>
                                    <td><b><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></b></td>
                                    <td>
                                        <div>
                                            <span class="small"><b><?php echo !empty($inward['product']) ? $inward['product'] . ',' : '-' ?></b></span>
                                            <span class="small"><b><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] . ',' : '-' ?></b></span>
                                        </div>
                                        <div>
                                            <span class="small"><b><?php echo !empty($inward['model_no']) ? $inward['model_no'] . ',' : '-' ?></b></span>
                                            <span class="small"><b><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] . '' : '-' ?></b></span>
                                            <span class="small"><b><?php echo !empty($inward['description']) ? ',' . $inward['description'] : '-' ?></b></span>
                                        </div>
                                    </td>
                                    <td><textarea name="remarks[]" class="textarea-custom h-auto" rows="2" cols="15"><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-' ?></textarea></td>
                                </tr>
                                <?php
                                $j++;
                            }
                        } ?>
                        <?php
                        if (!empty($outwardss) && ($_SESSION['ROLE'] != 'RECEPTIONIST')) {
                            $i = 1;
                            foreach ($outwards as $inward) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><b><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></b></td>
                                    <td><?php echo !empty($inward['gatepass_no']) ? $inward['gatepass_no'] : ''; ?></td>
                                    <td>
                                        <div>
                                            <span class="small"><b><?php echo !empty($inward['product']) ? $inward['product'] . ',' : '-' ?></b></span>
                                            <span class="small"><b><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] . ',' : '-' ?></b></span>
                                        </div>
                                        <div>
                                            <span class="small"><b><?php echo !empty($inward['model_no']) ? $inward['model_no'] . ',' : '-' ?></b></span>
                                            <span class="small"><b><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] . '' : '-' ?></b></span>
                                            <span class="small"><b><?php echo !empty($inward['description']) ? ',' . $inward['description'] : '-' ?></b></span>
                                        </div>
                                    </td>
                                    <td><textarea name="remarks[]" class="textarea-custom h-auto" rows="2" cols="15"><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-' ?></textarea></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    <div class="row">
        <div class="border-left border-right">        
            <div style="border-top: 1px solid #ada7a7;border-bottom: 1px solid #ada7a7;min-height:80px;">
                <div style="float:left;width:100%;">
                    <div class="pull-left p-5"><p>Repairs Only</p></div>
                </div>
                
                <div class=" col-md-6 col-sm-6 col-xs-6"><h4>Customer's Signature</h4></div>
                <div class="col-md-6 col-sm-6 col-xs-6"><h4 class="ml-50 text-right">For <?php echo !empty($branch_data['name']) ? strtoupper($branch_data['name']) : '' ?></h4></div>                                
            </div>
        </div>
</div>
</div>
</div>
<script>
    $(function () {
        $('._saveOut').click(function () {
            $(this).attr({'type': 'button', 'disabled': true});
            $('#frm').submit();
        });
    });
</script>
