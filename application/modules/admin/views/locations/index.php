<h3 class="header smaller lighter">
    Locations List
    <span class="pull-right">
        <span class="pull-right">
            <a href="<?php echo base_url() ?>admin/locations/add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>
        </span>
    </span>
</h3>
<?php echo getMessage(); ?>
<div class="clearfix"></div>
<table  class="table table-bordered table-hover">
    <thead>
    <tr>
        <th class="detail-col">S.No</th>
        <th>Country Name</th>
        <th>Location Name</th>
        <th>Location Code</th>
        <th>Branch Count</th>

        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($locations)) {
        $i = 1;
        foreach ($locations as $location) { ?>
            <tr>
                <td>
                    <?php echo $i; ?>
                </td>
                <td><?php echo !empty($location['country']) ? $location['country'] :'-' ?></td>
                <td><?php echo !empty($location['location_name']) ? '<a href="' . base_url() . 'admin/branches/?location=' . $location['pk_id'] . '">' . $location['location_name'] . '</a>' : '-'; ?></td>
                <td><?php echo !empty($location['location_code']) ? $location['location_code'] : ''; ?></td>
                <td><?php echo !empty($location['branch_cnt']['CNT']) ? $location['branch_cnt']['CNT'] : 0; ?></td>

                <td>
                    <a href="<?php echo base_url() ?>admin/locations/edit/<?php echo $location['pk_id'] ?>" data-rel="tooltip" title="Edit" class="btn btn-xs btn-info">
                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                    </a>

                </td>
            </tr>
            <?php $i++;
        }
    } else {
        ?>
        <tr><td class="text-center" colspan="6"> No Locations Added</td></tr>
        <?php
    } ?>
    </tbody>
</table>
