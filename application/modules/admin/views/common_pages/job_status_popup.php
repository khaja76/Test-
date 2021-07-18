<div class="hide assign-engineer">
    <form id="frm" class="form-horizontal" method="post"  enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label col-sm-3" for="job-id-edit">Job Id :</label>
            <div class="col-sm-9">
                <input readonly class="form-control input-sm" id="jobId">
                <input type="hidden" class="inwardPkId" name="inwardPkId">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Status :</label>
            <div class="col-sm-9">
                <select class="form-control input-sm" name="status" id="job_status_change" required>
                    <option value="">-- Select status to Update --</option>
                    <?php if (!empty($status_list)) {
                        foreach ($status_list as $status) {
                            echo "<option value='" . $status . "'>" . $status . "</option>";
                        }
                    } ?>
                </select>
            </div>
        </div>
        <div class="hide-component">
            <div class="form-group">
                <label class="control-label col-sm-3">Component:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control component input-sm" name="component" placeholder="Component Name"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Component Model:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control component_model input-sm" name="component_model" placeholder="Component Model"/>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="control-label col-sm-3"> Image:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control input-sm input-file-2" name="component_image" accept=".png, .jpg, .gif"/>
                </div>
            </div> -->
            <div class="form-group">
                <label class="control-label col-sm-3">Quantity :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm q" maxlength="3" onkeypress="return isNumber(event)" placeholder="Enter No of Required Components" name="quantity"/>
                </div>
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
                <button type="submit" class="btn btn-xs btn-info btn-update"><i class="fa fa-save"></i> Update</button>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <div id="message"></div>
</div>
<script>
    $(function () {
        $('.hide-component').addClass('hide');
        $('#job_status_change').change(function () {
            if ($(this).val() == 'SPARE REQUIREMENT') {
                $('.hide-component').removeClass('hide');
                $(".component_model,.component,.q").addClass('required');
            } else {
                $('.hide-component').addClass('hide');
                $(".component_model,.component,.q").removeClass('required');
            }
        });
    });
</script>
