<div class="space-2"></div>
<table class="table  table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
    <thead>
    <tr>
        <th>S.No</th>
        <th width="190">Job Id</th>
        <th>Customer Name</th>
        <th>Inward Date</th>
        <th>Inward Challan</th>
        <th>Outward Date</th>

        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($inwards)) {
        $i = 1;
        foreach ($inwards as $inward) {
            ?>

            <tr>
                <td><?php echo $i; ?></td>
                <td>
                    <?php include currentModuleView('admin') . 'common_pages/inward-view-url.php' ?>
                </td>
                <td><?php echo !empty($inward['customer_name']) ? $inward['customer_name'] : '-'; ?></td>
                <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : '-'; ?></td>

                <td><?php echo $inward['inward_challan'] ?></td>
                <td><?php echo !empty($inward['outward_date']) ? dateDB2SHOW($inward['outward_date']) : '-'; ?></td>

                <td><?php echo !empty($inward['status']) ? $inward['status'] : '-'; ?></td>
            </tr>
            <?php $i++;
        }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="7">No Inward Found</td>
        </tr>
        <?php
    } ?>
    </tbody>
</table>
