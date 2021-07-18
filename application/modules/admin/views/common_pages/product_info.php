<style>
    .modal-dialog {
        width: 850px;
    }
</style>
<?php
$reception_dash = '';
$j = !empty($i) ? $i : '';
if (!empty($inward)) {
    if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'ENGINEER') {
        $close = true;
    } else {
        $close = false;
    }
    ?>
    <div class="panel panel-primary">
        <div class="row padding-10 no-margin">
            <div class="space-2"></div>
            <div class="col-md-4 col-xs-12">
                <div class="text-center">
                    <div class="space-6"></div>
                    <div id="accordion" class="accordion-style1 panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#customerInfo<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-<?php echo ($close) ? 'right' : 'down' ?> bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        Customer Information
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php echo ($close) ? '' : 'in' ?>" id="customerInfo<?php echo $j; ?>">
                                <div class="panel-body">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name">Id</div>
                                            <div class="profile-info-value">
                                                <span><?php echo !empty($inward['customer_id']) ? $inward['customer_id'] : ''; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Name</div>
                                            <div class="profile-info-value">
                                                <span><?php echo !empty($inward['customer_name']) ? $inward['customer_name'] : ''; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Photo</div>
                                            <div class="profile-info-value">
                                                <?php
                                                if (!empty($inward['img']) && file_exists(FCPATH . $inward['customer_path'] . $inward['img'])) {
                                                    $img = $inward['customer_path'] . $inward['img'];
                                                    $thumb_img = $inward['customer_path'] . "thumb_" . $inward['img'];
                                                }
                                                if (!empty($img)) { ?>
                                                    <div class="gallery">
                                                        <a href="<?php echo base_url() . $img; ?>">
                                                            <img src="<?php echo base_url() . $thumb_img; ?>" class="max-200" alt="customer name"/>
                                                        </a>
                                                    </div>
                                                <?php } else { ?>
                                                    <div id="img-preview">
                                                        <img src="<?php echo dummyLogo(); ?>" alt="customer name"/>
                                                    </div>
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        if (!empty($inward['company_name']) && ($_SESSION['ROLE'] == 'ADMIN' || $_SESSION['ROLE'] == 'SUPER_ADMIN')) {
                                            ?>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name">Company Name :</div>
                                                <div class="profile-info-value">
                                                    <span><?php echo !empty($inward['company_name']) ? $inward['company_name'] : '-'; ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> GST No. :</div>
                                                <div class="profile-info-value">
                                                    <span><?php echo !empty($inward['gst_no']) ? $inward['gst_no'] : '-'; ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Person Name :</div>
                                                <div class="profile-info-value">
                                                    <span><?php echo !empty($inward['contact_name']) ? $inward['contact_name'] : '-'; ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Email :</div>
                                                <div class="profile-info-value">
                                                    <span><?php echo !empty($inward['company_mail']) ? $inward['company_mail'] : '-'; ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Phone No :</div>
                                                <div class="profile-info-value">
                                                    <span><?php echo !empty($inward['company_mobile']) ? $inward['company_mobile'] : '-'; ?></span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] != 'ENGINEER') { ?>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"></div>
                                                <div class="profile-info-value">
                                                    <space>
                                                        <a class="label label-primary  btn-xs send-sms-dialog" data-inward="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : '' ?>" data-toggle="modal" data-target="#SmsModal">
                                                            <span data-toggle="tooltip" data-placement="top" title="Click to Send SMS/Email"> <i class="fa fa-envelope "></i> Send Message</span>
                                                        </a>
                                                    </space>
                                                </div>
                                            </div>
                                            <?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Inwards-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#inwards<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-<?php echo (!$close) ? 'right' : 'down' ?> bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Inward Images
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php echo (!$close) ? '' : 'in' ?>" id="inwards<?php echo $j; ?>">
                                <div class="panel-body">
                                    <?php $imgs = getFiles($inward['img_path']);
                                    if (!empty($imgs)) { ?>
                                        <div class="gallery">
                                            <?php
                                            foreach ($imgs as $img) {
                                                $thumb_img = str_replace(FCPATH, '', $img);
                                                $img = str_replace($inward['img_path'], '', $thumb_img);
                                                $img = str_replace('thumb_', '', $thumb_img);
                                                ?>
                                                <a href="<?php echo base_url() . $img ?>">
                                                    <img src="<?php echo base_url() . $thumb_img ?>" class="max-150 p-1" alt="Inward Image"/>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    } else {
                                        echo "<span class='text-center text-danger'>No Inward Images were Found</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!--Damage Images-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#damage<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Damaged Images
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse " id="damage<?php echo $j; ?>">
                                <div class="panel-body">
                                    <?php
                                    if (!empty($inward['damage_img_path'])) {
                                        $imgs = getFiles($inward['damage_img_path']);
                                        if (!empty($imgs)) { ?>
                                            <div class="gallery">
                                                <?php
                                                foreach ($imgs as $img) {
                                                    $thumb_img = str_replace(FCPATH, '', $img);
                                                    $img = str_replace($inward['img_path'], '', $thumb_img);
                                                    $img = str_replace('thumb_', '', $thumb_img);
                                                    ?>
                                                    <a href="<?php echo base_url() . $img ?>">
                                                        <img src="<?php echo base_url() . $thumb_img ?>" class="max-150 p-1" alt="Inward Image"/>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<span class='text-center text-danger'>No Damaged Images were Found</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Delivery Images -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#outward<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Delivery Images
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse " id="outward<?php echo $j; ?>">
                                <div class="panel-body">
                                    <?php
                                    if (!empty($inward['outward_images_path'])) {
                                        $imgs = getFiles($inward['outward_images_path']);
                                        if (!empty($imgs)) { ?>
                                            <div class="gallery">
                                                <?php
                                                foreach ($imgs as $img) {
                                                    $thumb_img = str_replace(FCPATH, '', $img);
                                                    $img = str_replace($inward['outward_images_path'], '', $thumb_img);
                                                    $img = str_replace('thumb_', '', $thumb_img);
                                                    ?>
                                                    <a href="<?php echo base_url() . $img ?>">
                                                        <img src="<?php echo base_url() . $thumb_img ?>" class="max-150 p-1" alt="Delivery Image"/>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<span class='text-center text-danger'>No Delivery Images were Found</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  col-xs-12">
                <h5 class="pull-left">Product Information </h5>
                <span class="pull-right">
                    <?php
                    if ((!empty($_SESSION['ROLE'])) && (($_SESSION['ROLE'] == 'ADMIN'))) {
                        if (empty($inward['assigned_to']) && $inward['is_outwarded'] == 'NO') {
                            ?>
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger  assign-engineer-dialog pull-right" title="Click here to assign the job to Engineer " data-placement="top" data-toggle="tooltip">
                            <i class="ace-icon fa fa-hourglass bigger-120"></i>  Assign to Engineer
                        </a>
                            <?php
                        }
                    }
                    ?>
                    
                </span>
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Job Id</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['job_id']) ? $inward['job_id'] : '-'; ?> <a href="<?php echo get_role_based_link() . '/inwards/history/?inward=' . $inward['inward_no'] ?>" class="label label-success pull-right"><i class="fa fa-history"></i> History</a> </span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Name</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['product']) ? $inward['product'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Manufacturer</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Model Number</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['model_no']) ? $inward['model_no'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Serial No</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Assigned to</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['assign_to']) ? $inward['assign_to'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Created by</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['created_by']) ? $inward['created_by'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Received From</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['inward_dispatch_through']) ? $inward['inward_dispatch_through'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">Current Status</div>
                        <div class="profile-info-value">
                            <span> <?php echo !empty($inward['status']) ? $inward['status'] : '-'; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Inward Date</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : '-'; ?></span>
                        </div>
                    </div>
                    <?php if ((!empty($_SESSION['ROLE'])) && (($_SESSION['ROLE'] == 'ADMIN') || ($_SESSION['ROLE'] == 'SUPER_ADMIN'))) { ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Inward Challan</div>
                            <div class="profile-info-value">
                                <span> <?php echo !empty($inward['inward_challan']) ? $inward['inward_challan'] : '-'; ?> </span>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Delivery Date</div>
                        <div class="profile-info-value">
                            <span><?php echo !empty($inward['outward_date']) ? dateDB2SHOW($inward['outward_date']) : '-'; ?></span>
                        </div>
                    </div>
                    <?php if ((!empty($_SESSION['ROLE'])) && (($_SESSION['ROLE'] == 'ADMIN') || ($_SESSION['ROLE'] == 'SUPER_ADMIN'))) { ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Delivery Challan</div>
                            <div class="profile-info-value">
                                <span> <?php echo !empty($inward['outward_challan']) ? $inward['outward_challan'] : '-'; ?> </span>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Gate pass</div>
                        <div class="profile-info-value">
                            <span> <?php echo !empty($inward['gatepass_no']) ? $inward['gatepass_no'] : '-'; ?> </span>
                        </div>
                    </div>
                    <?php
                    if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] != 'ENGINEER') {
                        if (!empty($_workorder['work_order'])) {
                            $work = explode('$', $_workorder['work_order']);
                            if (!empty($work)) {
                                $_workOrder = $work[0];
                                $_workOrderDate = $work[1];
                            }
                        }
                        ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Work Order</div>
                            <div class="profile-info-value">
                                <span> <?php echo !empty($_workOrder) ? $_workOrder : '-'; ?> </span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Work Order Date</div>
                            <div class="profile-info-value">
                                <span> <?php echo !empty($_workOrderDate) ? dateDB2SHOW($_workOrderDate) : '-'; ?> </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="space"></div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div id="accordion2" class="accordion-style1 panel-group">
                    <!--Customer Approval-->
                    <?php if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] != 'ENGINEER') {
                        if (!empty($transaction['quotation'])) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                           href="#customerApproval<?php echo $j; ?>">
                                            <i class="ace-icon fa fa-angle-<?php echo ($close) ? 'right' : 'down' ?> bigger-110"
                                               data-icon-hide="ace-icon fa fa-angle-down"
                                               data-icon-show="ace-icon fa fa-angle-right"></i>
                                            Customer Approval
                                        </a>
                                    </h4>
                                </div>
                                <div class="panel-collapse collapse <?php echo ($close) ? '' : 'in' ?>"
                                     id="customerApproval<?php echo $j; ?>">
                                    <div class="panel-body">
                                        <form class="form-horizontal" id="acceptanceForm" method="post">
                                            <input type="hidden" name="ap_pk_id"
                                                   value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : '' ?>"/>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="accepted_by col-md-5 control-label">Accepted
                                                        By</label>
                                                    <div class="col-md-7">
                                                        <?php if (empty($inward['approved_by'])) { ?>
                                                            <input type="text" class="form-control input-sm"
                                                                   placeholder="Approved By ( Name )" id="approved_by"
                                                                   name="approved_by"/>
                                                        <?php } else { ?>
                                                            <label class="control-label"><b><?php echo !empty($inward['approved_by']) ? $inward['approved_by'] : '' ?></b></label>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?php if (!empty($inward['approved_by'])) { ?>
                                                        <label class="col-md-8 control-label">Accepted On
                                                            <b><?php echo (!empty($inward['approved_time']) && $inward['approved_time'] != '0000-00-00 00:00:00') ? dateDB2SHOW($inward['approved_time']) : '-' ?></b></label>
                                                    <?php } else { ?>
                                                        <div class="pull-right">
                                                            <button id="saveCustApprovalBtn"
                                                                    class="btn btn-xs btn-success"><i
                                                                        class="fa fa-check"></i> Approve
                                                            </button>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                    <!--Inward Remarks-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#inwardsRemarks<?php echo $j; ?>">
                                    <i class="ace-icon fa fa-angle-<?php echo (!$close) ? 'right' : 'down' ?> bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;Inward Remarks
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse in" id="inwardsRemarks<?php echo $j; ?>">
                            <div class="panel-body">
                                <p><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-'; ?></p>
                            </div>
                        </div>
                    </div>
                    <!--Delivery Remarks-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#outwardRemarks<?php echo $j; ?>">
                                    <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;Delivery Remarks
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse " id="outwardRemarks<?php echo $j; ?>">
                            <div class="panel-body">
                                <p> <?php echo !empty($inward['outward_remarks']) ? $inward['outward_remarks'] : '-'; ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- Accessories -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#Accessories<?php echo $j; ?>">
                                    <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;Accessories
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse " id="Accessories<?php echo $j; ?>">
                            <div class="panel-body">
                                <p><?php echo !empty($inward['description']) ? $inward['description'] : '-'; ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Info -->
                    <?php if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] != 'ENGINEER') { ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#Payment<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Payment Info.
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse " id="Payment<?php echo $j; ?>">
                                <div class="panel-body">
                                    <?php
                                    if ((!empty($_SESSION['ROLE'])) && (($_SESSION['ROLE'] == 'ADMIN') || ($_SESSION['ROLE'] == 'SUPER_ADMIN'))) {
                                    ?>
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Estimation ( <i class="fa fa-inr"></i> )</div>
                                            <div class="profile-info-value">
                                                <span> <?php echo !empty($inward['estimation_amt']) ? number_format($inward['estimation_amt'], 2) : '-'; ?> </span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Paid ( <i class="fa fa-inr"></i> )</div>
                                            <div class="profile-info-value">
                                                <span> <?php echo !empty($inward['paid_amt']) ? number_format($inward['paid_amt'], 2) : '-'; ?> </span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Balance ( <i class="fa fa-inr"></i> )</div>
                                            <div class="profile-info-value">
                                                <span> <?php echo (!empty($inward['paid_amt']) && !empty($inward['estimation_amt'])) ? number_format($inward['estimation_amt'] - $inward['paid_amt'], 2) : '-'; ?> </span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"></div>
                                            <div class="profile-info-value">
                                                <?php
                                                if ($inward['paid_amt'] > 0) {
                                                    ?>
                                                    <a href="<?php echo base_url() ?>admin/payments/history/?inward=<?php echo $inward['inward_no'] ?><?php echo (!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == 'SUPER_ADMIN')) ? '&branch_id=' . $inward['branch_id'] : '' ?>" class="btn btn-success btn-xs">Payment History</a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        } ?>
                                        <?php
                                        if (!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == 'RECEPTIONIST' || $_SESSION['ROLE'] == 'ADMIN') ) {
                                            if (($inward['estimation_amt'] > 0 && $inward['paid_amt'] < $inward['estimation_amt'])) {
                                                ?>
                                                <div class="profile-user-info profile-user-info-striped">
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name"></div>
                                                        <div class="profile-info-value">
                                                            <a class="label label-warning add-payment-dialog" data-inward="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : '' ?>" data-toggle="modal" data-target="#myModal"><span data-toggle="tooltip" data-placement="top" title="Click to Add Payment"> <i class="fa fa-hourglass-o"></i>Make Payment</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!--Transactions-->
                    <?php
                    if ((!empty($_SESSION['ROLE'])) && (($_SESSION['ROLE'] == 'ADMIN') || ($_SESSION['ROLE'] == 'SUPER_ADMIN'))) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#Transaction<?php echo $j; ?>">
                                        <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                        &nbsp;Transactions Info.
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse " id="Transaction<?php echo $j; ?>">
                                <div class="panel-body">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Quotation</div>
                                            <div class="profile-info-value">
                                            <span>
                                                <?php echo !empty($transaction['quotation']) ? $transaction['quotation'] : ''; ?>
                                                <?php if (!empty($transaction['q_id'])) { ?>
                                                    <a href="<?php echo get_role_based_link() ?>/quotations/view/<?php echo !empty($transaction['q_id']) ? $transaction['q_id'] : ''; ?>" class="label label-success">View</a>
                                                <?php } else { ?>
                                                    <a href="<?php echo get_role_based_link() ?>/quotations/add/?type=inward_no&value=<?php echo !empty($inward['inward_no']) ? $inward['inward_no'] : '-'; ?>" class="label label-danger">Make Quote</a>
                                                <?php } ?>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Proforma Invoice</div>
                                            <div class="profile-info-value">
                                            <span>
                                                <?php echo !empty($transaction['proforma']) ? $transaction['proforma'] : ''; ?>
                                                <?php if (!empty($transaction['p_id'])) { ?>
                                                    <a href="<?php echo get_role_based_link() ?>/proforma/view/<?php echo $transaction['p_id'] ?>" class="label label-success">View</a>
                                                <?php } else if (!empty($transaction['q_id'])) { ?>
                                                    <a href="<?php echo get_role_based_link() ?>/proforma/add/?quotation_no=<?php echo !empty($transaction['q_id']) ? $transaction['q_id'] : ''; ?>" class="label label-danger ">Make Proforma</a>
                                                <?php } else { ?>
                                                    <label> No Quotation added  </label>
                                                <?php } ?>
                                            </span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Invoice</div>
                                            <div class="profile-info-value">
                                            <span> <?php echo !empty($transaction['invoice']) ? $transaction['invoice'] : ''; ?>
                                                <?php if (!empty($transaction['i_id'])) { ?>
                                                    <a href="<?php echo get_role_based_link() ?>/invoice/view/<?php echo !empty($transaction['i_id']) ? $transaction['i_id'] : '-'; ?>" class="label label-success">View</a>
                                                <?php }else if (empty($transaction['i_id']) && !empty($transaction['q_id'])) { ?>
                                                    <label class="control-label">
                                                        <input type="radio" name="ins" class="check_ins" value="<?php echo get_role_based_link() . '/invoice/add/?type=Quotation&quotation_no=' .$transaction['q_id']; ?>"/>
                                                        <p class="label label-danger"> Make Invoice [ <span title="Using Quotation Number" data-toggle="tooltip">Q</span> ]</p>
                                                    </label>
                                                <?php } if (empty($transaction['i_id']) &&!empty($transaction['p_id'])) { ?>
                                                    <label class="control-label">
                                                        <input type="radio" name="ins" class="check_ins" value="<?php echo get_role_based_link() . '/invoice/add/?type=Proforma&proforma_no=' .$transaction['p_id'];?>"/>
                                                         <p class="label label-danger"> Make Invoice [ <span title="Using Proforma Number" data-toggle="tooltip"> P </span> ] </p>
                                                    </label>
                                                <?php } else if(empty($transaction['p_id']) && empty($transaction['q_id'])) { ?>
                                                    No Quotation / Proforma found
                                                <?php } ?>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="space-10">
        </div>
    </div>
<?php } elseif (!empty($_GET) && empty($inwards) && isset($_GET['job_id'])) {
    echo "<div class='text-danger text-center'>Sorry, No Job Id Found with searching Data</div>";
} ?>
<div class="hide assign-engineer">
    <form id="frm2" class="form-horizontal" method="post">
        <div class="form-group">
            <label class="control-label col-sm-3" for="job-id-edit">Job Id :</label>
            <div class="col-sm-9">
                <input readonly class="form-control input-sm" id="jobId">
                <input type="hidden" class="inwardPkId" name="inwardPkId">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="engineer">Engineer :</label>
            <div class="col-sm-9">
                <select class="form-control input-sm" name="engineerId" required>
                    <option value="">-- Select Engineer --</option>
                    <?php if (!empty($engineers)) {
                        foreach ($engineers as $k => $v) {
                            echo "<option value='" . $k . "'>" . $v . "</option>";
                        }
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Remarks :</label>
            <div class="col-sm-9">
                <textarea class="autosize-transition form-control" name="remarks" rows="3" placeholder="Enter Description...">Please Check this</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitButtonAss" class="btn btn-xs btn-info"><i class="fa fa-save"></i> Assign</button>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <div id="message"></div>
</div>
<span class="hide tbl_inward_pk_id"><?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?></span>
<span class="hide tbl_job_id"><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></span>
<script>
    $(function () {
        $(".assign-engineer-dialog").on('click', function (e) {
            e.preventDefault();
            var inward_pk_id, job_id;
            inward_pk_id = $('.tbl_inward_pk_id').text();
            job_id = $('.tbl_job_id').text();
            $("#jobId").val(job_id);
            $(".inwardPkId").val(inward_pk_id);
            $(".assign-engineer").removeClass('hide').dialog({
                resizable: false,
                width: '400',
                modal: true,
                title: "<div class='widget-header'><h5 class='smaller'><i class='ace-icon fa fa-tasks'></i> Assign Engineer</h5></div>",
                title_html: true,
            });
        });
        $('#frm2').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                inwardPkId: {required: true},
                engineerId: {required: true}
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        });
        $("#frm2").on("submit", function (e) {
            e.preventDefault();
            $("#submitButtonAss").prop('disabled', 'disabled');
            var jobId = $("#jobId").val();
            var th = $(this);
            var formData = th.serialize();
            var base_url = "<?php echo base_url(); ?>";
            $.ajax({
                url: base_url + 'admin/inwards/inwardAssignToEngineer/',
                data: formData,
                success: function (data) {
                    if (data == "TRUE") {
                        $("#message").html("<div class='text-success text-center'>Job Id is successfully assigned</div>");
                        setInterval(function () {
                            location.reload(true);
                        }, 700);
                    }
                }
            })
        })
    });
</script>
<?php include_once currentModuleView('admin') . '/common_pages/payment-modal.php' ?>
<?php include_once currentModuleView('admin') . '/common_pages/send-sms.php' ?>
<script>
    $(function () {
        $("#saveCustApprovalBtn").on("click", function () {
            $("#saveCustApprovalBtn").prop('disabled', 'disabled');
            var th = $('#acceptanceForm');
            var formData = th.serialize();
            var base_url = "<?php echo base_url(); ?>";
            $.ajax({
                url: base_url + 'admin/accept-approval/',
                data: formData,
                success: function (data) {
                    if (data == "TRUE") {
                        setInterval(function () {
                            location.reload(true);
                        }, 1500);
                    }
                }
            });
        });
        $('.check_ins').click(function(){
             var invoice_url = $(this).val();
             window.location.href=invoice_url;
        });
        $('.amount').focusout(function () {
            var dAmt = $('#dueAmt').html();
            dAmt = parseFloat(dAmt);
            var a = $(this).val();
            a = parseFloat(a);
            if (a != ' ' && a != 'NaN') {
                elem = $(this).parent().parent().parent();
                if (a > dAmt) {
                    $(this).attr('required', true);
                    elem.addClass('has-error');
                    $('#submitButton').addClass('disabled').attr({type: 'button'});
                    $("#message").html("<div class='text-danger text-center'>Amount  should be equal to  or less than due amount !</div>");
                } else {
                    $(this).attr('required', false);
                    elem.removeClass('has-error');
                    $('#submitButton').removeClass('disabled').attr({type: 'submit'});
                    $("#message").html("");
                }
            }
        });
    })
</script>