<span class="msg"></span>
<style>
    /*page styles will be same in mail template also*/
    @media screen, print {
        .challan-box {
            width: 700px;
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
        .m-15 {
            margin: 15px !important;
        }
        .w-140 {
            width: 140px;
        }
        .mh-450 {
            min-height: 300px;
        }
        .ml-15{
            margin-left: 15px;
        }
        .mw-127{
            max-width: 127px;
        }
    }
</style>
<h3 class="header smaller lighter hidden-print">
    Inwards Challan
    <span class="pull-right">
           <?php
           if ((!empty($inwards) && count($inwards) <6)) { ?>
               <a class="btn btn-xs btn-primary" href="<?php echo !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '#' ?>">
                  <i class="white ace-icon fa fa-plus bigger-120"></i>
                     Add Inwards
               </a>
               <?php
           }
           ?><button form="challanFrm" class="btn btn-xs btn-success enterSubmit">
                    <i class="white ace-icon fa fa-print bigger-120"></i>
                  Get Challan
            </button>                     
    </span>
    <form action="" id="challanFrm" method="POST">
        <?php
        if (!empty($inwards)) {
            if (!empty($_SESSION['ROLE'])) {
                ?>
                <span class="pull-right">
                <input type="hidden" name="customer_id" value="<?php echo (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) ? $_GET['customer_id'] : '' ?>"/>
         </span>
                <?php
            }
        }
        ?>
</h3>
<div class="row">
    <div class="col-xs-12 col-sm-12 ">
        <div class="space-12"></div>
        <div class="challan-box">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 no-padding border">
                    <div class="col-md-9 col-sm-9  col-xs-8 text-center no-padding border-right">
                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                $path = '/data/branches/';
                                if (!empty($branch_data['branch_logo']) && file_exists(FCPATH . $path . $branch_data['branch_logo'])) { ?>
                                    <div class="">
                                        <img style="max-width: 127px" class="max-100 mw-127 m-15 f-l preview-pic" alt="Branch Logo" src="<?php echo base_url() . $path . $branch_data['branch_logo']; ?>"/>
                                    </div>
                                <?php } ?>
                                <h4><?php echo !empty($branch_data['name']) ? $branch_data['name'] : '' ?></h4>
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
                        </div>
                        <div class="space-2"></div>
                        <div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="ml-15">INWARD CHALLAN </h4>
                        <h5 class="ml-15" style="margin-left:15px;"><b><?php echo !empty($inwards) && !empty($inwards[0]['inward_challan']) ? $inwards[0]['inward_challan'] : '' ?></b></h5>
                        <p class="mb-0 ml-15">Date :<?php echo !empty($inwards) && !empty($inwards[0]['created_on']) ? dateDB2SHOW($inwards[0]['created_on']) : date('d-M-Y') ?></p>
                        <p class="ml-15">Timings 9 A.M. to 7 P.M.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 border-right border-left">
                    <?php
                    if (!empty($customer['company_name'])) { ?>
                        <div class="col-md-6 print-half">
                            <h6><b><?php echo $customer['company_name']; ?></b></h6>
                            <?php echo !empty($customer['address1']) ? $customer['address1'] : ''; ?>
                            <?php echo !empty($customer['address2']) ? $customer['address2'] : ''; ?>
                            <?php echo !empty($customer['city']) ? $customer['city'] : ''; ?>
                        </div>
                    <?php } ?>
                    <div class="col-md-6 print-half">
                        <h6>Refer To : <b>
                                <?php
                                echo (!empty($customer['last_name'])) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'];
                                ?>
                            </b>
                            ( <?php echo $customer['customer_id'] ?> )
                        </h6>
                        <?php echo !empty($inwards[0]['gatepass_no']) ? 'Gatepass No. - ' . $inwards[0]['gatepass_no'] : ''; ?>
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
                                <th class="w-15 border-left">S.No</th>
                                <?php echo !isset($_GET['challan']) ? '<th></th>' : '' ?>
                                <th class="w-140">Job Id</th>
                                <th>Description</th>
                                <th class="w-180">Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($inwards as $inward) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <?php if (!isset($_GET['challan'])) { ?>
                                        <td><input type="checkbox" class="ace" name="jobids[]" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>" checked/>
                                            <label class="ace lbl"></label></td>
                                    <?php } ?>
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
                                    <td><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-' ?></td>
                                </tr>
                                <?php
                                $i++;
                            } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 border">
                    <div class="clearfix">
                        <div class="pull-left p-5"><p>Repairs Only</p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6"><h4>Customer's Signature</h4></div>
                        <div class="col-md-6 col-sm-6 col-xs-6"><h4 class=" text-right">For HIFI TECHNOLOGIES</h4></div>
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link href="<?php echo base_url() ?>assets/css/jquery.gritter.min.css" rel="stylesheet"/>
        <script src="<?php echo base_url() ?>assets/js/jquery.gritter.min.js"></script>
        <script>
            $(function () {
                $('body').on('keypress',function(event){
                    if (event.keyCode == 13) {
                        //alert();
                        $('#challanFrm').submit();
                        return false;
                    }
                });
                $('.enterSubmit').click(function(){
                    $(this).attr({'type':'button','disabled':true});
                    $('#challanFrm').submit();
                });
                <?php
                if(!empty($_SESSION['message'])){?>
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: '<?php echo $_SESSION['message'];?>',
                    // (string | mandatory) the text inside the notification
                    image: 'https://newcdn.iconfinder.com/data/icons/small-n-flat/24/678134-sign-check-128.png',
                    text: '',
                    class_name: 'gritter-success'
                });
                return false;
                <?php unset($_SESSION['message']);?>
                <?php }
                ?>
            });
        </script>
    </div>
</div>
</form>