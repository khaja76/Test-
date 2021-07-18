<h3 class="header smaller lighter">
Branch Details
<span class="pull-right">
    <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
</span>
</h3>
<?php
$branch_id = !empty($_GET['branch']) ? $_GET['branch'] :'';
$location_id = !empty($_GET['location_id']) ? $_GET['location_id'] :'';
?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow disabled">
            <h3 class="widget-user-username">Sub Ordinates</h3>
            <h5 class="widget-user-desc"></h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="<?php echo base_url() ?>data/icons/receptionist.png" alt="User Avatar">
        </div>
        <div class="box-footer">
            <div class="row">

                <div class="col-sm-6 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo !empty($receptionCnt['cnt']) ? $receptionCnt['cnt'] : 0; ?></h5>
                        <span class="description-text"><a href="<?php echo base_url() ?>admin/details/subOrdinates/?role=RECEPTIONIST&branch=<?php echo $branch_id ?>">Receptionists</a></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo !empty($engineerCnt['cnt']) ? $engineerCnt['cnt'] : 0; ?></h5>
                        <span class="description-text"><a href="<?php echo base_url() ?>admin/details/subOrdinates/?role=ENGINEER&branch=<?php echo $branch_id ?>">Engineers</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-light-blue disabled">
            <h3 class="widget-user-username">Customers</h3>
            <h5 class="widget-user-desc"></h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="<?php echo base_url() ?>data/icons/customers.png" alt="User Avatar">
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo !empty($customerCnt['cnt']) ? $customerCnt['cnt'] : 0; ?></h5>
                        <span class="description-text text-success"><a href="<?php echo base_url() ?>admin/customers/?branch_id=<?php echo $branch_id ?>&location_id=<?php echo $location_id?>">Total</a></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-teal-gradient">
            <h3 class="widget-user-username">Stock / Jobs</h3>
            <h5 class="widget-user-desc"></h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="<?php echo base_url() ?>data/icons/inwards.png" alt="User Avatar">
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-6 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo !empty($inwardsCnt['cnt']) ? $inwardsCnt['cnt'] : 0; ?></h5>
                        <span class="description-text text-success"><a href="<?php echo base_url() ?>admin/inwards/?location_id=<?php echo $_GET['location_id'] ?>&branch_id=<?php echo $branch_id ?>">Inwards</a></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo !empty($outwardsCnt['cnt']) ? $outwardsCnt['cnt'] : 0; ?></h5>
                        <span class="description-text text-warning"><a href="<?php echo base_url() ?>admin/outwards/?location_id=<?php echo $_GET['location_id'] ?>&branch_id=<?php echo $branch_id ?>">Outwards</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
