<h3 class="header smaller lighter">
    <?php echo !empty($location['name']) ? $location['name'] : 'HIFI '?> -Outward Full Details
</h3>

<table  class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th>S.No</th>
        <th>Job Id</th>
        <th>Customer Name</th>
        <th>Created On</th>
        <th>Status</th>
        <th>Outward Date</th>
    </tr>
    </thead>
    <tbody>
    <?php /*if (!empty($_GET['pk_id'])) {*/
    for ($i = 1; $i <= 10; $i++) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><a href="#" target="_blank">HFT/2017/08/01<?php echo $i ?></a></td>
            <td>Customer - <?php echo $i; ?></td>
            <td><?php echo $i; ?>/08/2017</td>
            <td><span class="label label-sm label-success arrowed">Active</span></td>
            <td><?php echo $i; ?>/08/2017</td>
        </tr>
            <!-- <?php /*}
            }else{
                */?>
            <tr><td class="text-center" colspan="6">No Inward Found</td></tr>
            --><?php
    } ?>


    </tbody>
</table>


