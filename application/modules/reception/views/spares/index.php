<h3 class="header smaller lighter">
    Spare Requests
    <span class="pull-right">
        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<form class="form-inline text-center" action="" enctype="multipart/form-data" method="get">
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
        <button type="submit" class="btn btn-xs btn-primary search_inbtn"><i class="fa fa-search"></i> Search</button>
    </div>
    <a href="<?php echo base_url() ?>reception/spares/" class="btn btn-xs btn-danger"><i class="fa fa-refresh"></i> Refresh</a>
</form>
<div class="space-10"></div>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>S. No.</th>
        <th width="180">Job Id</th>
        <th>Request Engineer</th>
        <th>Component</th>
        <th>Model</th>
        <th>Remarks</th>
        <th>Req. Quantity</th>
        <th>Supplied Quantity</th>
        <th>Balance</th>
        <th>View</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($inwards)) {
        $i = 1;
        foreach ($inwards as $inward) {
            $balance = (!empty($inward['supplied_quantity']) >= 0 && ($inward['supplied_quantity'] < $inward['quantity'])) ? $inward['quantity'] - $inward['supplied_quantity'] : 0;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td>
                    <input type="hidden" class="inward_pk_id" value="<?php echo !empty($inward['inward_id']) ? $inward['inward_id'] : ''; ?>"/>
                    <input type="hidden" class="job_id" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>"/>
                    <?php
                    if (!empty($inward['job_id'])) {
                        include currentModuleView('admin') . 'common_pages/inward-view-url.php';
                    } ?>
                </td>
                <td><?php echo !empty($inward['user_name']) ? $inward['user_name'] : '-'; ?></td>
                <td><?php echo !empty($inward['component_name']) ? $inward['component_name'] : '-'; ?></td>
                <td><?php echo !empty($inward['component_model']) ? $inward['component_model'] : '-'; ?></td>
                <td><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-'; ?></td>
                <td><?php echo !empty($inward['quantity']) ? $inward['quantity'] : '-'; ?></td>
                <td><?php echo !empty($inward['supplied_quantity']) ? $inward['supplied_quantity'] : '-'; ?></td>
                <td><?php echo $balance; ?></td>
                <td>
                    <a href="<?php echo get_role_based_link() ?>/spares/view/<?php echo $inward['pk_id']; ?>/" title='View' class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom"><i class="ace-icon fa fa-eye bigger-120"></i></a>
                </td>
            </tr>
            <?php
            $i++;
        }
    } else if (empty($inwards) && isset($_GET)) {
        echo "<tr><td colspan='10'><div class='text-center text-danger'>No data Found</div></td></tr>";
    } ?>
    </tbody>
</table>
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
                $(e).closest('.form-group').removeClass('has-error');
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
                    // console.log(data);
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