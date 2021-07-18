<h3 class="header smaller lighter">
    Components Usage
</h3>
<div class="space"></div>
<div class="clearfix"></div>
<form class="form-inline text-center" method="get">
    <div class="form-group">
        <label>Company Name:</label>
        <select class="form-control input-sm select2" id="company_id" name="company_id">
            <option value="">--Select Company Name--</option>
            <?php if (!empty($companies)) {
                foreach ($companies as $k => $v) { ?>
                    <option value="<?php echo $k; ?>" <?php echo !empty($_GET) && ($_GET['company_id'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                <?php }
            } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Component Name:</label>
        <select class="form-control input-sm select2" id="component_id" name="component">
            <option value="">--Select Component Name--</option>
            <?php if (!empty($components)) {
                foreach ($components as $k => $v) { ?>
                    <option value="<?php echo $k; ?>" <?php echo !empty($_GET) && ($_GET['component'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                <?php }
            } ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Search</button>
        <a href="<?php echo base_url(); ?>admin/components/history/" class="btn btn-xs btn-info"><i class="fa fa-refresh"></i> Refresh</a>
    </div>
</form>
<div class="space"></div>
<table class="table table-bordered table-hover" id="<?php echo !empty($history) ? 'dtable' : ''; ?>">
    <thead>
    <tr>
        <th>S. No.</th>
        <th>Company Name</th>
        <th>Component Name</th>
        <th>Model No</th>
        <th>Job Id</th>
        <th>Quantity</th>
      
        <th>Added / Supplied Date</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($history)) {
        $i = 1;
        foreach ($history as $his) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo !empty($his['company_name']) ? $his['company_name'] : '' ?></td>
                <td><?php echo !empty($his['component_name']) ? $his['component_name'] : '' ?></td>
                <td><?php echo !empty($his['model_no']) ? $his['model_no'] : '' ?></td>
                <td><?php echo !empty($his['job_id']) ? $his['job_id'] : '-' ?></td>
                <td><?php echo !empty($his['quantity']) ? $his['quantity'] : '0' ?></td>
                
                <td><?php echo !empty($his['created_on']) ? dateDB2SHOW($his['created_on']) : '' ?></td>
            </tr>
            <?php $i++;
        }
    } else { ?>
        <tr>
            <td colspan="9"><div class="text-center text-danger">No data found</div></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("#company_id").on("change", function () {
            var th = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>admin/components/getComponentsList/',
                data: {'company_id': th},
                dataType: 'json',
                cache: false,
                success: function (data) {
                    $('#component_id').empty().append($("<option></option>").attr("value", "").text("-- Select Component Name --"));
                    $.each(data, function (key, value) {
                        $('#component_id').append($("<option></option>").attr("value", key).text(value));
                    });
                }
            })
        })
    })
</script>