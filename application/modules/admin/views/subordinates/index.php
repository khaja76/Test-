<h3 class="header smaller lighter">
    Sub Ordinates
    <a href="<?php echo base_url() ?>admin/subOrdinates/add" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add</a>
</h3>
<?php echo getMessage(); ?>
<div class="mb-m10"></div>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th class="center">S.No</th>
        <th>Name</th>
        <th>Role</th>
        <th>Location Name</th>
        <th>Branch Name</th>
        <th>Profile Pic</th>
        <th>Created On</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($users)) {
        $i = 1;
        foreach ($users as $user) {
            ?>
            <tr>
                <td class="center">
                    <?php echo $i ?>
                </td>
                <td><?php echo !empty($user['name']) ? '<a href="' . base_url() . 'admin/details/profile/?user=' . $user['user_id'] . '">' . $user['name'] . '</a>' : '-'; ?></td>
                <td><?php echo !empty($user['role']) ? $user['role'] : ''; ?></td>
                <td><?php echo !empty($user['location_name']) ? $user['location_name'] : ''; ?></td>
                <td><?php echo !empty($user['branch_name']) ? $user['branch_name'] : ''; ?></td>
                <td>
                    <?php if (!empty($user['img']) && file_exists(FCPATH . $user['img_path'] . $user['thumb_img'])) { ?>
                        <div class="gallery">
                            <a href="<?php echo base_url() . $user['img_path'] . $user['img']; ?>">
                                <img class="width-height-50" src="<?php echo base_url() . $user['img_path'] . $user['thumb_img']; ?>"/>
                            </a>
                        </div>
                    <?php } else { ?>
                        <img src="<?php echo dummyLogo() ?>" class="width-height-50"/>
                    <?php } ?>
                </td>
                <td><?php echo !empty($user['created_on']) ? dateDB2SHOW($user['created_on']) : ''; ?></td>
                <td>
                    <?php
                    if ($user['status'] == "ACTIVE") {
                        $label = "success";
                    } elseif ($user['status'] == "INACTIVE") {
                        $label = "warning";
                    } elseif ($user['status'] == "BLOCKED") {
                        $label = "danger";
                    } elseif ($user['status'] == "PENDING") {
                        $label = "info";
                    }
                    $status = !empty($user['status']) ? "Active" : "Inactive";
                    ?>
                    <span class="label label-sm label-<?php echo $label; ?> arrowed"><?php echo !empty($user['status']) ? $user['status'] : ''; ?></span>
                </td>
                <td>
                    <div class="hidden-sm hidden-xs btn-group">
                        <a href="<?php echo base_url() ?>admin/subOrdinates/edit/<?php echo $user['user_id']; ?>" title='Edit' class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom"><i class="ace-icon fa fa-pencil bigger-120"></i></a>
                    </div>
                    <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                <li>
                                    <a href="<?php echo base_url() ?>admin/subOrdinates/edit/<?php echo $user['user_id']; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
                                    <span class="green">
                                        <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <?php $i++;
        }
    } else { ?>
        <tr>
            <td class="text-center" colspan="10"> No Data found</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<div class="text-center">
    <?php echo !empty($PAGING) ? $PAGING : ''; ?>
</div>
<script>
    $(document).ready(function () {
        $('#location_id').on("change", function () {
            var location_id = $(this).val();
            if ((location_id == "") || (location_id == null)) {
                $('#branch_id').empty();
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url() ?>" + "admin/fetch_branches/?location_id=" + location_id,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        $('#branch_id').empty();
                        $('#branch_id').append($("<option></option>").attr("value", "").text("-- Select a Branch --"));
                        $.each(data, function (key, value) {
                            $('#branch_id').append($("<option></option>").attr("value", key).text(value));
                        });
                    }
                });
            }
        })
    })
</script>