<h3 class="header smaller lighter">
    Delivery Challans
    <span class="pull-right">
         <a  href="#" onclick="goBack();"  class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<div class="clearfix"></div>
    <div class="mt-m10"></div>
    <form class="form-inline text-center" method="get">
    <?php if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
    ?>
        <div class="form-group">
            <select name="location_id" id="location_id" class="form-control input-sm">
                <option value="">-- Select Location Name --</option>
                <?php if (!empty($locations)) {
                    foreach ($locations as $key => $name) { ?>
                        <option value="<?php echo $key; ?>" <?php echo (!empty($_GET) && ($key == $_GET['location_id'])) ? "selected" : "" ?>><?php echo $name; ?></option>
                    <?php }
                } ?>
            </select>
        </div>
        <div class="form-group">
            <select name="branch_id" id="branch_id" class="form-control input-sm">
                <option value="">-- Select Branch Name --</option>
                <?php if (!empty($branches)) {
                    foreach ($branches as $k => $n) { ?>
                        <option value="<?php echo $k; ?>"><?php echo $n; ?></option>
                    <?php }
                } else if (!empty($branches)) {
                    echo "<option value=''>No Branch found</option>";
                } else if ($branches_else) {
                    foreach ($branches_else as $k => $n) {
                        ?>
                        <option value="<?php echo $k; ?>" <?php echo ($_GET['branch_id'] == $k) ? "selected" : "" ?>><?php echo $n; ?></option>
                        <?php
                    }
                } ?>
            </select>
        </div>
        <?php 
}?>
        <div class="form-group">
            <div class="input-daterange input-group">
                <input type="text" class="input-sm form-control" name="from_date" placeholder="Select Start Date" value="<?php echo !empty($_GET['from_date']) ? $_GET['from_date'] : ''; ?>"/>
                <span class="input-group-addon">
					<i class="fa fa-exchange"></i>
                </span>
                <input type="text" class="input-sm form-control" name="to_date" placeholder="Select End Date" value="<?php echo !empty($_GET['to_date']) ? $_GET['to_date'] : ''; ?>"/>
            </div>
        </div>
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Search</button>
        <a href="<?php echo get_role_based_link()?>/outwards/challans/" class="btn btn-danger btn-xs">Refresh</a>
    </form>
    <div class="space-4"></div>
  
<div class="clearfix"></div>
<div class="col-md-12">
    <table id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Customer Name</th>
            <th>Customer Id</th>
            <th>Delivery Challan No</th>
            <th>Created Date</th>
            <th>Created By</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($inwards)) {
            $i = 1;
            foreach ($inwards as $inward) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?php echo $inward['customer_name'] ?></td>
                    <td><?php echo $inward['customer_id'] ?></td>
                    <td>
                        <?php echo $inward['challan'] ?>
                        <span class="info">
                        <a href="<?php echo base_url() ?>admin/outwards/view/?challan=<?php echo $inward['outward_challan_id'] ?>" class="badge badge-success" data-toggle="tooltip" title="View Job on this Challan"><i class="fa fa-search"></i></a>
                    </span>
                    </td>
                    <td><?php echo dateDB2SHOW($inward['challan_created_on']) ?></td>
                    <td><?php echo $inward['created_by'] ?></td>
                </tr>
                <?php
                $i++;
            }
        } else {
            echo "<tr><td colspan='6'><div class='text-center text-danger'>No data found </div></td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
<script>
    $(function () {
        $('#location_id').on("change", function () {
            var location_id = $(this).val();
            if ((location_id == "") || (location_id == null)) {
                $('#branch_id').empty();
                $('#branch_id').append($("<option></option>").attr("value", "").text("-- Select a Branch --"));
            }
            else {
                $('#branch_id').empty();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url() ?>" + "admin/fetch_branches/?location_id=" + location_id,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        //$('#branch_id').empty();
                        $('#branch_id').append($("<option></option>").attr("value", "").text("-- Select a Branch --"));
                        $.each(data, function (key, value) {
                            $('#branch_id').append($("<option></option>").attr("value", key).text(value));
                        });
                    }
                });
            }
        })
    });
</script>