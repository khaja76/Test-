<h3 class="header smaller lighter">
    Welcome to Dashboard
</h3>
<div class="row">
    <?php if (!empty($_SESSION) && ($_SESSION['ROLE'] == "SUPER_ADMIN")) { ?>
        <div class="col-md-4  col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-maroon disabled">
                    <h3 class="widget-user-username">Locations</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/location.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4  col-md-4 col-xs-4 col-sm-offset-4  col-md-offset-4 col-xs-offset-4 ">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($locationCnt['cnt']) ? $locationCnt['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/locations/">View</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4  col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-light-blue disabled">
                    <h3 class="widget-user-username">Branches</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/branches.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4  col-md-4 col-xs-4 col-sm-offset-4  col-md-offset-4 col-xs-offset-4 ">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($branchCnt['cnt']) ? $branchCnt['cnt'] : 0; ?></h5>
                                <span class="description-text text-warning"><a href="<?php echo base_url() ?>admin/branches/">View</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-purple disabled">
                    <h3 class="widget-user-username">Admins</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/admin.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4  col-md-4 col-xs-4 col-sm-offset-4  col-md-offset-4 col-xs-offset-4 ">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($adminCnt['cnt']) ? $adminCnt['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/subOrdinates/">View</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-teal-gradient">
                    <h3 class="widget-user-username">Stock / Jobs</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/inwards.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6  col-md-6 col-xs-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($inwardsCntAll['cnt']) ? $inwardsCntAll['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/inwards/?type=all">Inwards</a></span>
                            </div>
                        </div>
                        <div class="col-sm-6  col-md-6 col-xs-6">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($outwardsCntAll['cnt']) ? $outwardsCntAll['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/outwards/?type=all">Outwards</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-yellow disabled">
                    <h3 class="widget-user-username">Sub Ordinates</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/receptionist.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6  col-md-6 col-xs-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($receptionCnt['cnt']) ? $receptionCnt['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/details/subOrdinates/?role=RECEPTIONIST">Receptionists</a></span>
                            </div>
                        </div>
                        <div class="col-sm-6  col-md-6 col-xs-6">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($engineerCnt['cnt']) ? $engineerCnt['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/details/subOrdinates/?role=ENGINEER">Engineers</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">

                <div class="widget-user-header bg-light-blue disabled">
                    <h3 class="widget-user-username">Customers</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/customers.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4  col-md-4 col-xs-4 col-sm-offset-4  col-md-offset-4 col-xs-offset-4 ">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($customerCnt['cnt']) ? $customerCnt['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/customers/">View</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty($_SESSION) && ($_SESSION['ROLE'] == "ADMIN")) { ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-red">
                    <h3 class="widget-user-username">Inwards</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/location.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($inwardsCnt['cnt']) ? $inwardsCnt['cnt'] : 0; ?></h5>
                                <span class="description-text text-success"><a href="<?php echo base_url() ?>admin/inwards/">Current</a></span>
                            </div>
                        </div>
                        <div class="col-sm-6 ">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($inwardsCntAll['cnt']) ? $inwardsCntAll['cnt'] : 0; ?></h5>
                                <span class="description-text text-success"><a href="<?php echo base_url() ?>admin/inwards/?type=all">All</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-light-blue">
                    <h3 class="widget-user-username">Outwards</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/branches.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6  col-md-6 col-xs-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($outwardsCnt['cnt']) ? $outwardsCnt['cnt'] : 0; ?> </h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/outwards/">Current</a></span>
                            </div>
                        </div>
                        <div class="col-sm-6   col-md-6 col-xs-6  border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($outwardsCntAll['cnt']) ? $outwardsCntAll['cnt'] : 0; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/outwards/?type=all">All</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-green">
                    <h3 class="widget-user-username">Payments</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/location.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-xs-4  border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($duesAmt['cnt']) ? $duesAmt['cnt'] : 0 ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() . 'admin/payments/?payment-status=due' ?>">Dues</a></span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-xs-4  border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($doneAmt['cnt']) ? $doneAmt['cnt'] : 0 ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() . 'admin/payments/?payment-status=success' ?>">Done</a></span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-xs-4  border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo $duesAmt['cnt'] + $doneAmt['cnt']; ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() . 'admin/payments/?payment-status=all' ?>">All</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-yellow">
                    <h3 class="widget-user-username">Spare Requests</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/branches.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6   col-md-6 col-xs-6  border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($spareReqCnt) ? $spareReqCnt : 0; ?> </h5>
                                <span class="description-text"><a href="<?php echo base_url(); ?>admin/spares/">Current</a></span>
                            </div>
                        </div>
                        <div class="col-sm-6   col-md-6 col-xs-6  border-left">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($spareReqCntAll) ? $spareReqCntAll : 0; ?> </h5>
                                <span class="description-text"><a href="<?php echo base_url(); ?>admin/spares/?type=all">All</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="col-md-4 col-sm-6 col-xs-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-danger">
                    <h3 class="widget-user-username">Notifications </h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php /*echo base_url() */?>data/icons/admin.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php /*echo !empty($notificationCnt) ? $notificationCnt : 0; */?></h5>
                                <span class="description-text"><a href="<?php /*echo base_url() */?>admin/notifications/?view=current">Current</a></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-xs-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php /*echo !empty($notificationCntAll) ? $notificationCntAll : 0; */?> </h5>
                                <span class="description-text"><a href="<?php /*echo base_url(); */?>admin/notifications/?view=all">All </a></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>-->
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">Messages </h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/admin.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6  col-md-6 col-xs-6  border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($messagesCnt) ? $messagesCnt : 0 ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/messages/latest/">Current</a></span>
                            </div>
                        </div>
                        <div class="col-sm-6  col-md-6 col-xs-6  border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($messagesCntAll) ? $messagesCntAll : 0 ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/messages/">All</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">Transactions </h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo base_url() ?>data/icons/admin.png" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($quotationCntAll) ? $quotationCntAll : 0 ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/quotations/">Quotations</a></span>
                            </div>
                        </div>
                        <div class="col-xs-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($proformaCntAll) ? $proformaCntAll : 0 ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/proforma/">Proforma</a></span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="description-block">
                                <h5 class="description-header"><?php echo !empty($paymentCntAll) ? $paymentCntAll : 0 ?></h5>
                                <span class="description-text"><a href="<?php echo base_url() ?>admin/invoice/">Invoices</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
