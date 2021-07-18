<h3 class="header smaller lighter">
    Sequence Numbers
    <span class="pull-right">
        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage(); ?>

<div class="space-10"></div>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>S. No.</th>        
        <th>Type Name</th>
        <th>Number</th>        
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($sequences)) {
        $i = 1;
        foreach ($sequences as $sequence) {            
            ?>
            <tr>
                <td><?php echo $i ?></td>                
                <td><?php echo !empty($sequence['action_type']) ? $sequence['action_type'] : '-'; ?></td>
                <td><?php echo !empty($sequence['number']) ? $sequence['number'] : '-'; ?></td>
                <td>
                    <a href="<?php echo get_role_based_link(); ?>/sequence/edit/?id=<?php echo $sequence['pk_id']; ?>" title='View' class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom"><i class="ace-icon fa fa-eye bigger-120"></i></a>
                </td>
            </tr>
            <?php
            $i++;
        }
    } else if (empty($sequences) && isset($_GET)) {
        echo "<tr><td colspan='4'><div class='text-center text-danger'>No data Found</div></td></tr>";
    } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $(".assign-engineer-dialog").on('click', function (e) {
            e.preventDefault();
            var sequence_pk_id, job_id;
            sequence_pk_id = $(this).closest('tr').find('.sequence_pk_id').val();
            job_id = $(this).closest('tr').find('.job_id').val();
            $("#jobId").val(job_id);
            $(".sequencePkId").val(sequence_pk_id);
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
                sequencePkId: {required: true},
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
                url: base_url + 'engineer/sequences/updatesequenceStatus/',
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