<h3 class="header smaller lighter">
    Status : <b><?php echo !empty($page_status) ? $page_status : ''; ?></b>
    <a href="<?php echo base_url(); ?>engineer/" class="btn btn-xs btn-warning pull-right"><i
                class="fa fa-arrow-left"></i> Back</a>
</h3>
<div class="space-6"></div>
<table class="table table-bordered table-hover simple-table">
    <thead>
    <tr>
        <th>S. No.</th>
        <th>Job Id</th>
        
        <th>Remarks</th>
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
                    <?php
                    if (!empty($inward['job_id'])) {
                        include currentModuleView('admin') . 'common_pages/inward-view-url.php';
                    } ?>
                </td>
                <td><?php echo !empty($inward['latest']['remarks']) ? $inward['latest']['remarks'] : ''; ?></td>
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
        echo "<tr><td colspan='7'>
        <div class='text-center text-danger'>No inwards are having with status " . strtolower($page_status) . " </div></td></tr>";
    }
    ?>
    </tbody>
</table>
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
            invalidHandler: function (form) {
            }
        });
        $("#frm").on("submit", function (e) {
            e.preventDefault();
            $('.btn-update').addClass('disabled').attr('type', 'button');
            var jobId = $("#jobId").val();
            var th = $(this);
            var formData = th.serialize();
            var base_url = "<?php echo base_url(); ?>";
            $.ajax({
                url: base_url + 'engineer/inwards/updateInwardStatus/',
                data: formData,
                success: function (data) {
                    if (data == "TRUE") {
                        $("#message").html("<div class='text-success text-center'>Job Id is successfully updated</div>");
                        setInterval(function () {
                            location.reload(true);
                        }, 2000);
                    }
                }
            })
        })
    });
</script>
