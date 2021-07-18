<style>
    td.w-140 {
        min-width: 140px !important;
        max-width: 140px !important;
        word-wrap: break-word;
    }
</style>
<?php
if (!empty($_SESSION['ROLE'])) {
    if (($_SESSION['ROLE'] == 'ADMIN') || ($_SESSION['ROLE'] == 'SUPER_ADMIN')) {
        $role = 'admin';
    } else if ($_SESSION['ROLE'] == 'RECEPTIONIST') {
        $role = 'reception';
    }
    ?>
    <h3 class="header smaller lighter">
        Products
        <span class="pull-right">
            <?php
            if ($_SESSION['ROLE'] != 'RECEPTIONIST') {
                ?>
                <a href="<?php echo get_role_based_link(); ?>/products/export" class="btn btn-sm btn-warning"><i
                            class="fa fa-file-excel-o"></i>  Export Data</a>
                <a href="<?php echo get_role_based_link(); ?>/products/import/" class="btn btn-sm btn-info"><i
                            class="fa fa-download"></i>  Import</a>
                <a href="<?php echo get_role_based_link(); ?>/products/add" class="btn btn-sm btn-primary"><i
                            class="fa fa-plus"></i>  Add</a>
                <?php
            }
            ?>
    </span>
    </h3>
    <?php echo getMessage(); ?>
    <div class="clearfix"></div>
    <div class="space"></div>
    <table class="table table-bordered table-hover" id="<?php echo !empty($products) ? 'dtable' : ''; ?>">
        <thead>
        <tr>
            <th>S. No.</th>
            <th>Company Name</th>
            <th>Product Name</th>
            <th>Model No</th>
            <th>Serial No</th>
            <th>Details</th>
            <th>Added By</th>            
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($products)) {
            $i = 1;
            foreach ($products as $product) {
                ?>
                <tr>
                    <td width="20"><?php echo $i ?></td>
                    <td class="w-140"><?php echo !empty($product['company_name']) ? $product['company_name'] : '' ?></td>
                    <td class="w-140"><?php echo !empty($product['product_name']) ? $product['product_name'] : '' ?></td>
                    <td class="w-140"><?php echo !empty($product['model_no']) ? $product['model_no'] : '' ?></td>
                    <td class="w-140"><?php echo !empty($product['serial_no']) ? $product['serial_no'] : '' ?></td>
                    <td class="w-140"><?php echo !empty($product['description']) ? shortDesc(strip_tags($product['description']), 50) . '....' : '' ?></td>
                    <td class="w-100"><?php echo !empty($product['created_by']) ? $product['created_by'] : ''; ?></td>
                    <td class="w-100">
                    <?php
                    if ($_SESSION['ROLE'] != 'RECEPTIONIST') {
                ?>
                        <a href="<?php echo get_role_based_link(); ?>/products/edit/<?php echo $product['pk_id']; ?>"
                           title='Edit' class="label label-info" data-toggle="tooltip" data-placement="bottom"><i
                                    class="ace-icon fa fa-pencil bigger-120"></i></a>
                        <a href="<?php echo get_role_based_link(); ?>/products/?act=status&pk_id=<?php echo $product['pk_id']; ?>&sta=<?php echo ($product['is_active'] == '0') ? '1' : '0'; ?>"
                            title='Publish/Un Publish' class="label label-default" data-toggle="tooltip"
                            data-placement="bottom"><i class="ace-icon fa fa-star <?php echo ($product['is_active'] == '0') ? 'text-danger' : 'text-success' ?>"></i></a>
                    <?php } ?>
                        <a href="<?php echo get_role_based_link(); ?>/products/view/<?php echo $product['pk_id']; ?>"
                           title='View' class="label label-primary" data-toggle="tooltip" data-placement="bottom"><i
                                    class="ace-icon fa fa-eye bigger-120"></i></a>                        
                    </td>
                </tr>
                <?php $i++;
            }
        } else {
            echo "<tr><td colspan='8' class='text-center text-danger'>No data found</td></tr>";
        } ?>
        </tbody>
    </table>
    <?php
} else {
}
?>