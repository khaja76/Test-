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
        Product Categories
        <span class="pull-right">
        <a href="<?php echo get_role_based_link(); ?>/products/category/add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>  Add</a>
    </span>
    </h3>
    <?php echo getMessage(); ?>
    <div class="clearfix"></div>
    <div class="space"></div>

    <table class="table table-bordered table-hover" id="<?php echo !empty($product_categories) ? 'dtable' : ''; ?>">
        <thead>
        <tr>
            <th>S. No.</th>
            <th>Category Name</th>
            <th>Products</th>
            <th>Description</th>
            <th>Added By</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($product_categories)) {
            $i = 1;
            foreach ($product_categories as $category) {
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td class="w-140"><?php echo !empty($category['category_name']) ? $category['category_name'] : '' ?></td>
                    <td class="w-140"><?php echo $category['product_count']; ?>
                    <td><?php echo !empty($category['product_category_description']) ? strip_tags($category['product_category_description']) : '' ?></td>
                    <td class="w-140"><?php echo !empty($category['created_by']) ? $category['created_by'] : ''; ?></td>
                    <td class="w-100">
                        <a href="<?php echo get_role_based_link(); ?>/products/categroy/edit/<?php echo $category['pk_id']; ?>" title='Edit' class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom"><i class="ace-icon fa fa-pencil bigger-120"></i></a>
                        <!--<a href="<?php /*echo get_role_based_link(); */?>/products/categroy/<?php /*echo $category['pk_id']; */?>" title='View' class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="bottom"><i class="ace-icon fa fa-eye bigger-120"></i></a>-->
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