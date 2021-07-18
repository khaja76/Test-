<h3 class="header smaller lighter">
    Inward Details
    <span class="pull-right">
        <a href="#" onclick="goBack();" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<form class="form-inline text-center" method="get">
    <div class="form-group">
        <label>Date Range :</label>
    </div>
    <div class="form-group">
        <div class="input-daterange input-group">
            <input type="text" class="input-sm form-control" name="from_date" placeholder="Select Start Date" value="<?php echo !empty($_GET['from_date']) ? $_GET['from_date'] : ''; ?>"/>
            <span class="input-group-addon">
					<i class="fa fa-exchange"></i>
                </span>
            <input type="text" class="input-sm form-control" name="to_date" placeholder="Select End Date" value="<?php echo !empty($_GET['to_date']) ? $_GET['to_date'] : ''; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Get Records</button>
    </div>
</form>
<div class="space-6"></div>
<table class="table table-bordered table-hover simple-table">
    <thead>
    <tr>
        <th>S. No.</th>
        <th>Job Id</th>
        <th>Remarks</th>
        <th>Status</th>
        <th>Updated On</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($inwards)) {
        $i = 1;
        foreach ($inwards as $inward) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td>
                    <input type="hidden" class="inward_pk_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>
                    <input type="hidden" class="job_id" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>"/>
                    <?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>
                    <?php if (!empty($inward['job_id'])) { ?>
                        <span class="info">
                    <a href="<?php echo get_role_based_link(); ?>/inwards/history/?inward=<?php echo $inward['inward_no'] ?>" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
                    <a href="<?php echo get_role_based_link(); ?>/inwards/view/?inward=<?php echo $inward['inward_no'] ?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
                   </span>
                    <?php } ?>
                </td>
                <td><?php echo !empty($inward['remarks']) ? $inward['remarks'] : ''; ?></td>
                <td><?php echo !empty($inward['status']) ? $inward['status'] : ''; ?></td>
                <td><?php echo !empty($inward['updated_on']) ? dateDB2SHOW($inward['updated_on']) : ''; ?></td>
                <td class="text-center">
                    <?php if ($inward['is_outwarded'] == 'NO') { ?>
                        <a href="#" class="btn btn-xs btn-info assign-engineer-dialog">
                            <i class="ace-icon fa fa-pencil bigger-120"></i> Update
                        </a>
                    <?php } else {
                        echo "<label class='label label-success'>Delivered</label>";
                    } ?>
                </td>
            </tr>
            <?php $i++;
        }
    } else {
        echo "<tr><td colspan='6'>No Inwards Assigned</td></tr>";
    }
    ?>
    </tbody>    
</table>
<div class="text-center"><?php echo !empty($PAGING) ? $PAGING : ''; ?></div>
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
        })
        $('#frm').validate({
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
            invalidHandler: function (form) {
            }
        });
        $("#frm").on("submit", function (e) {
            e.preventDefault();
            $('.btn-update').addClass('disabled').attr('type', 'button');
            var jobId = $("#jobId").val();
            var th = $(this);
            var formData = new FormData(this);
            $.ajax({
                url: '<?php echo base_url(); ?>engineer/inwards/updateInwardStatus/',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function (data) {
                    if (data == "TRUE") {
                        $("#message").html("<div class='text-success text-center'>Job Id is successfully updated</div>");
                        setInterval(function () {
                            location.reload(true);
                        }, 900);
                    }
                }
            })
        })
    });
</script>
