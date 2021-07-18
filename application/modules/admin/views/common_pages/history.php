<style>
.widget-box.transparent{
    border-radius:0;
    border-width:0;
    padding:0;
}
</style>
<h3 class="header smaller lighter">
    Inward History - <strong><?php echo !empty($dates) ? $dates[0]['job_id'] : ''; ?></strong>
    <span class="pull-right">
        <a href="#" onclick="goBack()" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php if(!empty($dates)){ ?>
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
            <?php foreach ($dates as $date){ ?>
                <div class="timeline-container">
                    <div class="timeline-label">
                        <span class="label label-primary arrowed-in-right label-lg">
                            <b><?php echo !empty($date) ? dateDB2SHOW($date['date']) : ''; ?></b>
                        </span>
                    </div>
                    <?php if (!empty($date['inwards'])) {
                        foreach ($date['inwards'] as $inward) { ?>
                            <div class="timeline-items">
                                <div class="timeline-item clearfix">
                                    <div class="timeline-info">
                                        <?php
                                            if($inward['status']=='ADDED')
                                                $icon="plus";
                                            else if($inward['status']=='ASSIGNED')
                                                $icon="hand-o-right";
                                            else if($inward['status']=='STARTED')
                                                $icon="pause";
                                            else if($inward['status']=='REPAIRABLE')
                                                 $icon="wrench";
                                            else if($inward['status']=='NOT REPAIRABLE')
                                                 $icon="ban";
                                            else if($inward['status']=='WAITING FOR APPROVAL')
                                                 $icon="clock-o";
                                            else if($inward['status']=='SPARE REQUIREMENT')
                                                 $icon="microchip";
                                            else if($inward['status']=='PAYMENT')
                                                $icon="money";
                                            else if($inward['status']=='QUOTATION')
                                                $icon="inr";
                                            else if($inward['status']=='Pro-Forma INVOICE')
                                                $icon="credit-card";
                                            else if($inward['status']=='INVOICE')
                                                $icon="credit-card-alt  ";
                                            else if($inward['status']=='OUTWARD')
                                                $icon="archive";
                                            else if($inward['status']=='OUTWARD CHALLAN')
                                                $icon="sticky-note-o";
                                            else if($inward['status']=='APPROVAL')
                                                $icon="thumbs-o-up";
                                            else if($inward['status']=='INWARD CHALLAN')
                                                $icon="sticky-note-o";
                                            else 
                                                $icon="check";

                                        ?>
                                        <i class="timeline-indicator ace-icon fa fa-<?php echo $icon;?> btn btn-warning no-hover green"></i>
                                    </div>
                                    <div class="widget-box transparent">
                                        <div class="widget-header widget-header-small">
                                            <h5 class="widget-title smaller">
                                            <?php echo !empty($inward['status_type']) ? $inward['status_type'] : ''; ?></h5>
                                                <span class='orange m-l-30'><?php echo (!empty($inward['remarks']) && strlen($inward['remarks'])>40 )? substr($inward['remarks'],0,40).' ......' : $inward['remarks']; ?></span>
                                            <span class="widget-toolbar no-border pull-right">
                                                <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                                <?php echo !empty($inward['created_on']) ? dateTimeDB2SHOW($inward['created_on']) : ''; ?>
                                            </span>
                                            <?php if (!empty($inward['remarks'])) { ?>
                                                <span class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-down"></i>
                                        </a>
                                    </span>
                                            <?php } ?>
                                        </div>
                                        <?php if (!empty($inward['remarks'])) { ?>
                                            <div class="widget-body" style="display:none;">
                                                <div class="widget-main">
                                                    <?php echo !empty($inward['remarks']) ? $inward['remarks'] : '--'; ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php }else{
    echo "<h4 class='text-danger text-center'>No Data Found</h4>";
} ?>
