<h3 class="header smaller lighter">
    Assign Engineers
</h3>
<?php echo getMessage(); ?>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>S. No.</th>
        <th>Details</th>
        <th>Job Id</th>
        <th>Added On</th>
        <th>Added By</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($inwards)) {
        $i = 1;
        foreach ($inwards as $inward) { ?>
            <tr>
                <td><?php echo $i ?></td>
                <td class="center">
                    <div class="action-buttons">
                        <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                            <i class="ace-icon fa fa-angle-double-down"></i>
                            <span class="sr-only">Details</span>
                        </a>
                    </div>
                </td>
                <td>
                    <span class="hide tbl_inward_pk_id"><?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?></span>
                    <span class="hide tbl_job_id"><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></span>
                    <?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>
                </td>
                <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : ''; ?></td>
                <td><?php echo !empty($inward['created_by']) ? $inward['created_by'] : ''; ?></td>
                <td>
                    <a href="" class="btn btn-xs btn-info assign-engineer-dialog">
                        <i class="ace-icon fa fa-pencil bigger-120"></i> Assign Engineer
                    </a>
                </td>
            </tr>
            <tr class="detail-row">
                <td colspan="6">
                    <div class="table-detail">
                        <?php include currentModuleView('admin').'common_pages/product_info.php' ?>
                    </div>
                </td>
            </tr>
            <?php $i++;
        }
    }
    else{
        echo "<tr><td colspan='6'>No Data found</td></tr>";
    }
    ?>
    </tbody>
</table>

<div class="clearfix"></div>


<div class="hide assign-engineer">
    <form id="frm" class="form-horizontal" method="post">
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
                    <?php if(!empty($engineers)){
                        foreach($engineers as $k=>$v){
                            echo "<option value='".$k."'>".$v."</option>";
                        }
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Remarks :</label>
            <div class="col-sm-9">
                <textarea class="autosize-transition form-control" name="remarks" rows="3" placeholder="Enter Description..."></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitButton" class="btn btn-xs btn-info"><i class="fa fa-save"></i> Assign</button>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <div id="message"></div>
</div>
<script>
    $(document).ready(function () {
        $(".assign-engineer-dialog").on('click', function (e) {
            e.preventDefault();
            var inward_pk_id,job_id;
            inward_pk_id = $(this).closest('tr').find('.tbl_inward_pk_id').text();
            job_id = $(this).closest('tr').find('.tbl_job_id').text();
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


        $('#frm').validate({
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
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $("#submitButton").prop('disabled',false);
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        });
        $("#frm").on("submit",function(e){
            e.preventDefault();
            $("#submitButton").prop('disabled','disabled');
            var jobId = $("#jobId").val();
            var th = $(this);
            var formData = th.serialize();
            var base_url = "<?php echo base_url(); ?>";
            $.ajax({
                url : base_url+'admin/inwards/inwardAssignToEngineer/',
                data : formData,
                success: function(data){
                    if(data == "TRUE"){
                        $("#message").html("<div class='text-success text-center'>Job Id is successfully assigned</div>");
                        setInterval(function(){
                            location.reload(true);
                        },2000);

                    }
                }
            })
        })
    });
</script>