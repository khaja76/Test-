<style>
    .infobox-md {
        width: 100%;
        height: 45px;
        margin-bottom: 3px;
    }
    .infobox-md > .infobox-icon {
        width: 50px !important;
    }
    .infobox-md > .infobox-data {
        font-size: 14px;
        line-height: 20px;
    }
    .infobox-md > .infobox-icon > .ace-icon {
        height: 30px !important;
        width: 30px !important;
        padding:0;
        
    }
    .infobox-md > .infobox-icon > .ace-icon:before {
        font-size: 16px;
        width: 26px;
         margin: 1px auto !important; 
    }
    .infobox-data-number{
        float:right;
        padding: 15px;
        font-size: 26px;
        line-height: 0;
    }
    .infobox .infobox-content:first-child, .infobox > .badge, .infobox > .stat, .percentage{
        font-weight:600;
        line-height:1.5;
    }
    
</style>
<div class="space-6"></div>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
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
                                    <h5 class="description-header"><?php echo !empty($inwardsCnt) ? $inwardsCnt : 0; ?></h5>
                                    <span class="description-text text-success"><a href="<?php echo base_url()?>engineer/inwards/">Current</a></span>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo !empty($inwardsCntAll) ? $inwardsCntAll : 0; ?></h5>
                                    <span class="description-text text-success"><a href="<?php echo base_url()?>engineer/inwards/?type=all">All</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 ">
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
                                    <span class="description-text"><a href="<?php echo base_url()?>engineer/messages/latest/">Current</a></span>
                                </div>
                            </div>
                            <div class="col-sm-6  col-md-6 col-xs-6  border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo !empty($messagesCntAll) ? $messagesCntAll: 0 ?></h5>
                                    <span class="description-text"><a href="<?php echo base_url()?>engineer/messages/">All</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="row">
            <div class="col-md-12">

                <h5>Current Inwards</h5>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Inward No</th>
                        <th>Remarks</th>
                        <th>Assigned On</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($inwards)) {
                        $i = 1;
                        foreach ($inwards as $inward) { ?>
                            <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <input type="hidden" class="inward_pk_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>
                                <input type="hidden" class="job_id" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>"/>
                                <a href="<?php echo base_url() ?>engineer/inwards/view/?inward=<?php echo $inward['inward_no'] ?>"><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></a></td>
                            <td><?php echo !empty($inward['admin_remarks']) ? $inward['admin_remarks'] : ''; ?></td>

                            <td><?php echo !empty($inward['assigned_on']) ? dateDB2SHOW($inward['assigned_on']) : ''; ?></td>
                            <td><?php echo !empty($inward['status']) ? $inward['status'] : ''; ?></td>
                            <td class="text-center">
                                <?php if($inward['is_outwarded']=='NO'){?>
                                    <a href="#" class="btn btn-xs btn-info assign-engineer-dialog">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i> Update
                                    </a>
                                <?php }else{
                                    echo "<label class='label label-success'>Delivered</label>";
                                }?>
                            </td>
                            <?php $i++;
                        } ?>
                        </tr>
                    <?php } else {
                        echo "<tr><td colspan='7'>No Inwards Assigned </td></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        
        <div class="dashboard">
            <div class="panel panel-danger" style="margin-bottom:0">
                <div class="panel-heading" style="padding:2px 15px;">
                    <h5 class="text-center blue">Engineer Activity</h5>
                </div>
                <div class="panel-body" style="padding:5px 15px">
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/started/'" class="infobox infobox-md infobox-green">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-users"></i>
                        </div>
                        <div class="infobox-data">
                            <div class="infobox-content">Started</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($started_cnt) ? $started_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/not-repairable/'" class="infobox infobox-md infobox-black">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-close"></i>
                        </div>
                        <div class="infobox-data">
                            <div class="infobox-content">Not Repairable</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($not_repair_cnt) ? $not_repair_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/repairable/'" class="infobox infobox-md infobox-blue">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-product-hunt"></i>
                        </div>
                        <div class="infobox-data">

                            <div class="infobox-content">Repairable</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($repair_cnt) ? $repair_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/spares/pending-spares/'" class="infobox infobox-md infobox-blue">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-product-hunt"></i>
                        </div>
                        <div class="infobox-data">
                            <div class="infobox-content">
                                Spare Requirement<!-- ( <span class="orange" title="In Progress" data-toggle="tooltip">*</span> )-->
                            </div>

                        </div>
                        <span class="infobox-data-number">
                    <?php echo !empty($spare_req_cnt) ? $spare_req_cnt : 0 ?>

                </span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/spare-received/'" class="infobox infobox-md infobox-green">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-users"></i>
                        </div>
                        <div class="infobox-data">

                            <div class="infobox-content">Spare Received</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($received_cnt) ? $received_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/waiting-for-approval/'" class="infobox infobox-md infobox-brown">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-inbox"></i>
                        </div>
                        <div class="infobox-data">

                            <div class="infobox-content">Waiting For Approval</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($wait_for_appr_cnt) ? $wait_for_appr_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/sent-as-it-is/'" class="infobox infobox-md infobox-black">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-print"></i>
                        </div>
                        <div class="infobox-data">

                            <div class="infobox-content">Sent As it is</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($send_same) ? $send_same : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/send-for-testing/'" class="infobox infobox-md infobox-blue">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-product-hunt"></i>
                        </div>
                        <div class="infobox-data">

                            <div class="infobox-content">Send for Testing</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($send_for_test_cnt) ? $send_for_test_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/repaired/'" class="infobox infobox-md infobox-brown">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-check-circle"></i>
                        </div>
                        <div class="infobox-data">
                            <div class="infobox-content">Repaired</div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($repaired_cnt) ? $repaired_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/outward/'"  class="infobox infobox-md infobox-brown">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-check-circle"></i>
                        </div>
                        <div class="infobox-data">
                            <div class="infobox-content">Delivered / Outward </div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($delivered_cnt) ? $delivered_cnt : 0 ?></span>
                    </div>
                    <div onclick="javascript:location.href='<?php echo base_url() ?>engineer/status/type/others/'"  class="infobox infobox-md infobox-brown">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-check-circle"></i>
                        </div>
                        <div class="infobox-data">
                            <div class="infobox-content">Others </div>
                        </div>
                        <span class="infobox-data-number"><?php echo !empty($others_cnt) ? $others_cnt : 0 ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include_once currentModuleView('admin') . 'common_pages/job_status_popup.php';
?>
<script>
    $(document).ready(function () {
        $(".assign-engineer-dialog").on('click', function (e) {
            e.preventDefault();
            var inward_pk_id, job_id;
            inward_pk_id = $(this).closest('tr').find('.inward_pk_id').val();
            job_id = $(this).closest('tr').find('.job_id').val();
            $("#jobId").val(job_id);
            $(".inwardPkId").val(inward_pk_id);
            $(".assign-engineer").removeClass('hide').dialog({
                resizable: false,
                width: '400',
                modal: true,
                title: "<div class='widget-header'><h5 class='smaller'><i class='ace-icon fa fa-tasks'></i> Update Status</h5></div>",
                title_html: true
            });
        });
        $("table tr").hover(function () {
            $(this).find('.info').css("visibility", "visible");
        }).mouseleave(function () {
            $(this).find('.info').css("visibility", "hidden");
        });
        $(document).find('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                inwardPkId: {required: true},
                status: {required: true}
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            submitHandler: function() {                               
                $('.btn-update').addClass('disabled').attr('type', 'button');                                                
                var jobId = $("#jobId").val();                                
                var formData = $("#frm").serialize();
                $.ajax({               
                    url: '<?php echo base_url(); ?>engineer/inwards/updateInwardStatus/',
                    type:'post',
                    data: formData,                    
                    //processData:false,
                    //contentType:false,
                    //cache:false,
                    //async:false,
                    success: function (data) {
                        if (data == "TRUE") {
                            $("#message").html("<div class='text-success text-center'>Job Id is successfully updated</div>");
                            setInterval(function () {
                                location.reload(true);
                            }, 900);
                        }
                    }
                })
            }
        });
    });
</script>
