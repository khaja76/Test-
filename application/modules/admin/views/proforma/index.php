<div class="header smaller lighter">
    <h4><i class="fa fa-user"></i> Proforma Invoice Information
        <?php if (!empty($_SESSION) && ($_SESSION['ROLE'] != "SUPER_ADMIN")) { ?>
            <span class="pull-right">
            <a href="<?php echo base_url(); ?>admin/proforma/add/" class="btn btn-info btn-bold btn-sm"><i class="fa fa-plus-circle"></i> Add</a>
        </span>
        <?php } ?>
    </h4>
</div>
<?php echo getMessage(); ?>
<?php
if ($_SESSION['ROLE'] == 'SUPER_ADMIN') {
    ?>
    <div class="space-6"></div>
    <form class="form-inline text-center" id="frm" method="get">
        <!--<div class="form-group">
            <select name="location_id" id="location_id" class="form-control input-sm">
                <option value="">-- Select Location Name --</option>
                <?php /*if (!empty($locations)) {
                    foreach ($locations as $key => $name) { */?>
                        <option value="<?php /*echo $key; */?>" <?php /*echo (!empty($_GET['location_id']) && ($key == $_GET['location_id'])) ? "selected" : "" */?>><?php /*echo $name; */?></option>
                    <?php /*}
                } */?>
            </select>
        </div>-->
        <div class="form-group">
            <select name="branch_id" id="branch_id" class="form-control input-sm required">
                <option value="">-- Select Branch Name --</option>
                <?php if (!empty($branches)) {
                    foreach ($branches as $k => $n) { ?>
                        <option value="<?php echo $k; ?>"><?php echo $n; ?></option>
                    <?php }
                } else if (!empty($branches)) {
                    echo "<option value=''>No Branch found</option>";
                } else if (!empty($branches_else)) {
                    foreach ($branches_else as $k => $n) {
                        ?>
                        <option value="<?php echo $k; ?>" <?php echo (!empty($_GET) && ($k == $_GET['branch_id'])) ? "selected" : "" ?>><?php echo $n; ?></option>
                        <?php
                    }
                } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-xs btn-primary "><i class="fa fa-search"></i> Search</button>
        <a href="<?php echo base_url() ?>admin/proforma/" class="btn btn-danger btn-xs">Refresh</a>
    </form>
    <div class="space-6"></div>
    <?php
} ?>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>S.No.</th>
        <th>Proforma No</th>
        <th>Customer Name</th>
        <th>Customer Id</th>
        <th>Amount ( <i class="fa fa-inr"></i> )</th>
        <th>Created On</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($invoices)) {
        $i = 1;
        foreach ($invoices as $invoice) { ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo !empty($invoice['proforma']) ? $invoice['proforma'] : ''; ?></td>
                <td><?php echo !empty($invoice['customer_name']) ? $invoice['customer_name'] : ''; ?></td>
                <td><?php echo !empty($invoice['customer_number']) ? $invoice['customer_number'] : ''; ?></td>
                <td><?php echo !empty($invoice['final_amount']) ? $invoice['final_amount'] : ''; ?></td>
                <td><?php echo !empty($invoice['created_on']) ? dateDB2SHOW($invoice['created_on']) : ''; ?></td>
                <td>
                    <?php if (!empty($_SESSION) && ($_SESSION['ROLE'] != "SUPER_ADMIN")) { ?>
                        <a href="<?php echo base_url() ?>admin/proforma/edit/<?php echo $invoice['pk_id'] ?>" data-toggle="tooltip" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
                    <?php } ?>
                    <a href="<?php echo get_role_based_link() ?>/proforma/view/<?php echo $invoice['pk_id'] ?>" data-toggle="tooltip" title="View" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> </a>
                </td>
            </tr>
            <?php $i++;
        }
    } else {
        echo "<tr><td colspan='8'>No data Found</td></tr>";
    }
    ?>
    </tbody>
</table>
<?php include currentModuleView('admin') . 'common_pages/location_search_js.php' ?>
<script>
    $(document).ready(function () {
        <?php
        if(!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'SUPER_ADMIN'){
        ?>
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                location_id: {required: true}
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
        <?php
        }
        ?>
    });
</script>