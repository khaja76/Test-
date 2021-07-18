<h3 class="header smaller lighter">
     <?php echo (!empty($_SESSION['ROLE']) && $_SESSION['ROLE']=='SUPER_ADMIN') ? $_GET['role'] :'Sub Ordinate'; ?> Details
    <span class="pull-right">
        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<table id="<?php echo !empty($users) ? 'dtable' : ''; ?>" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th>S.No</th>
        <th>Sub Ordinate Name</th>
        <th>Location Name</th>
        <th>Branch Name</th>
        <th>Joined Date</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($users)) {
        $i = 1;
        foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo !empty($user['name']) ? '<a href="' . base_url() . 'admin/details/profile/?user=' . $user['user_id'] . '">' . $user['name'] . '</a>' : '-'; ?></td>
                <td><?php echo !empty($user['location_name']) ? $user['location_name'] : ''; ?></td>
                <td><?php echo !empty($user['branch_name']) ? $user['branch_name'] : ''; ?></td>
                <td><?php echo !empty($user['created_on']) ? dateDB2SHOW($user['created_on']) : ''; ?></td>
                <td>
                    <?php
                    $label = !empty($user['status']) ? "success" : "warning";
                    $status = !empty($user['status']) ? "Active" : "Inactive";
                    ?>
                    <span class="label label-sm arrowed label-<?php echo $label; ?>"><?php echo $status; ?></span>
                </td>
            </tr>
            <?php $i++;
        }
    } else {
        echo "<tr><td colspan='6'>No data found</td></tr>";
    }
    ?>
    </tbody>
</table>
