<h3 class="header smaller lighter">
    Branches List
    <span class="pull-right">
        <a href="<?php echo base_url() ?>admin/branches/add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
    </span>
</h3>
<?php echo getMessage(); ?>
<div class="clearfix"></div>
<table id="<?php echo !empty($branches) ? 'dtable' : ''; ?>" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>S.No</th>
        <th>Branch Name</th>
        <th>Branch Code</th>
        <th>Inward Code</th>
        <th>Location Name</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($branches)) {
        $i = 1;
        foreach ($branches as $branch) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo !empty($branch['name']) ? '<a href="' . base_url() . 'admin/details/branches/?location_id=' . $branch['location_id'] . '&branch=' . $branch['pk_id'] . '">' . $branch['name'] . '</a>' : '-'; ?></td>
                <td><?php echo !empty($branch['branch_code']) ? $branch['branch_code'] : "-" ?></td>
                <td><?php echo !empty($branch['inward_code']) ? $branch['inward_code'] : "-" ?></td>
                <td><?php echo !empty($branch['location_name']) ? $branch['location_name'] : ''; ?></td>
                <td>
                    <div class="hidden-sm hidden-xs btn-group">
                        <a href="<?php echo base_url() ?>admin/branches/edit/<?php echo $branch['pk_id']; ?>" title='Edit' class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom"><i class="ace-icon fa fa-pencil bigger-120"></i></a>
                    </div>
                </td>
            </tr>
            <?php $i++;
        } ?>
    <?php } else {
        ?>
        <tr>
            <td class="text-center" colspan="6"> No Branches Added</td>
        </tr>
        <?php
    } ?>
    </tbody>
</table>
<div class="text-center"><?php echo !empty($PAGING) ? $PAGING : ""; ?></div>
<space class="space-6"></space>
