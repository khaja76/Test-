<style>.info{visibility: hidden;}</style>
<h3 class="header smaller lighter">
    Track Ordinates
</h3>
<span class="pull-right text-danger">
     Note : Fields are mandatory 
</span>
<form class="form-inline text-center" action="" id="frm" enctype="multipart/form-data" method="get">
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
                <?php if (!empty($branches_else) && isset($_GET['location_id'])) {
                    foreach ($branches_else as $k => $n) { ?>
                        <option value="<?php echo $k; ?>" <?php echo (isset($_GET['branch_id']) && $_GET['branch_id'] == $k) ? 'selected' : '' ?>><?php echo $n; ?></option>
                    <?php }
                } else if (!empty($branches)) {
                    echo "<option value=''>No Branch found</option>";
                } ?>
            </select>
        </div>
        <?php
    } ?>
    <div class="form-group">
        <div>
            <?php $roles = ['ENGINEER', "RECEPTIONIST"]; ?>
            <select class="form-control input-sm" name="role" id="role">
                <option value="">-- Select Role --</option>
                <?php if ($_SESSION['ROLE'] == "SUPER_ADMIN") {
                    if (!empty($_GET['role'])) {
                        foreach ($roles as $k => $v) { ?>
                            <option value="<?php echo $v; ?>" <?php echo !empty($_GET['role']) && ($_GET['role'] == $v) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                        <?php }
                    }
                } else {
                    foreach ($roles as $k => $v) { ?>
                        <option value="<?php echo $v; ?>" <?php echo !empty($_GET['role']) && ($_GET['role'] == $v) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                    <?php }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <select class="form-control input-sm" name="sub_ordinates" id="sub-ordinates">
            <option value="">-- Select Sub Ordinate --</option>
            <?php if (!empty($sub_ordinates)) {
                foreach ($sub_ordinates as $k => $v) { ?>
                    <option value="<?php echo $k; ?>" <?php echo !empty($_GET['sub_ordinates']) && ($_GET['sub_ordinates'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                <?php }
            } ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-files-o"></i> Get Records</button>
    </div>
</form>
<div class="space-6"></div>
<?php if (!empty($_GET['role'])) { ?>
    <div class="hr-4">
        <form class="form-inline  text-center" method="get">
            <input name="location_id" type="hidden" value="<?php echo isset($_GET['location_id']) ? $_GET['location_id'] : 0 ?>">
            <input name="branch_id" type="hidden" value="<?php echo isset($_GET['branch_id']) ? $_GET['branch_id'] : 0 ?>">
            <input name="role" type="hidden" value="<?php echo isset($_GET['role']) ? $_GET['role'] : 0 ?>">
            <input name="sub_ordinates" type="hidden" value="<?php echo isset($_GET['sub_ordinates']) ? $_GET['sub_ordinates'] : 0 ?>">
            <div class="form-group">
                <label>Date Range :</label>
            </div>
            <div class="form-group">
                <div class="input-daterange input-group">
                    <input type="text" class="input-sm form-control" name="from_date" placeholder="Select Start Date" value="<?php echo !empty($_GET['from_date']) ? $_GET['from_date'] : ''; ?>"/>
                    <span class="input-group-addon">
					<i class="fa fa-exchange"></i>
                </span>
                    <input type="text" class="input-sm form-control" name="to_date" placeholder="Select End Date" value="<?php echo !empty($_GET['to_date']) ? $_GET['to_date'] : ''; ?>"/>
                </div>
            </div>
            <?php if ((isset($_GET['role'])) && ($_GET['role'] == 'ENGINEER')) { ?>
                <div class="form-group">
                    <select class="form-control input-sm" name="status">
                        <option value="">--Select Status--</option>
                        <?php
                        if (!empty($status_list)) {
                            foreach ($status_list as $key => $value) {
                                echo "<option value='" . $key . "' >" . $value . "</option>";
                            }
                        } else {
                            echo "<option value=''>No Status Found</option>";
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>
            <div class="form-group">
                <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Search</button>
                <a href="<?php echo base_url(); ?>admin/SubOrdinates/track/" class="btn btn-xs btn-danger"><i class="fa fa-refresh"></i> Refresh</a>
            </div>
        </form>
    </div>
<?php } ?>
<div class="hr4">
    <div class="clearfix"></div>
    <div class="space-2"></div>
    <?php
    if ((isset($_GET['role']) && $_GET['role'] == 'ENGINEER')) {
        ?>
        <div class="table-header">
            Engineer Activities <?php echo !empty($inwards[0]) ? ' -' . $inwards[0]['assigned_to'] : '' ?>
        </div>
        <table class="table table-bordered table-hover" id="<?php echo !empty($inwards) ? 'dtable' : ''; ?>">
            <thead>
            <tr>
                <th>S. No.</th>
                <th>Job Id</th>
                <th>Assigned Date</th>
                <th>Outward Date</th>
                <th>Current status</th>
            </tr>
            </thead>
            <tbody>

            <?php
            if (!empty($inwards)) {
                $i = 1;
                foreach ($inwards as $inward) {
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td>
                            <?php echo $inward['job_id'] ?>
                            <span class="info">
                        <a href="<?php echo get_role_based_link(); ?>/inwards/history/?inward=<?php echo !empty($inward['inward_no']) ? $inward['inward_no'] : '' ?>" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
                        <a href="<?php echo get_role_based_link(); ?>/inwards/view/?inward=<?php echo !empty($inward['inward_no']) ? $inward['inward_no'] : '' ?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
                      </span>
                        </td>
                        <td><?php echo dateDB2SHOW($inward['created_on']); ?></td>
                        <td><?php echo !empty($inward['outward_date']) ? dateDB2SHOW($inward['outward_date']):'';?></td>
                        <td><?php echo $inward['status'] ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                echo "<tr><td colspan='5'><div class='text-center text-danger'>No Inwards assigned added</div></td></tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
    if (isset($_GET['role']) && $_GET['role'] == 'RECEPTIONIST') {
        ?>
        <div class="table-header">
            Receptionist Activities <?php echo !empty($activities[0]) ? ' -' . $activities[0]['user_name'] : '' ?>
        </div>
        <table class="table table-bordered table-hover" id="<?php echo !empty($activities) ? 'dtable' : ''; ?>">
            <thead>
            <tr>
                <th>S. No.</th>
                <th>Type</th>
                <th>Title</th>
                <th>Activity Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($activities)) {
                $i = 1;
                foreach ($activities as $activity) {
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo !empty($activity['type']) ? ucwords($activity['type']) : '' ?></td>
                        <td><?php echo !empty($activity['title']) ? $activity['title'] : '' ?></td>
                        <td><?php echo !empty($activity['created_on']) ? dateTimeDB2SHOW($activity['created_on']) : '' ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                echo "<tr><td colspan='4'><div class='text-danger text-center'>No Activity found !</div></td></tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    } ?>
</div>
<?php echo !empty($PAGING) ? $PAGING : ''; ?>
<script>
    //$(function ($) {
    $(document).ready(function(){
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                <?php
                if(!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == 'SUPER_ADMIN'))
                {
                ?>
                location_id: {
                    required: true
                },
                branch_id: {
                    required: true
                },
                <?php
                }
                ?>
                role: {
                    required: true
                },
                sub_ordinates: {
                    required: true
                }
            },
            messages: {
                role: "Please Select Role.",
                sub_ordinates: "Please Select Role."
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            }
        });
        $("#branch_id").on('change', function () {
            var roles = ["ENGINEER", "RECEPTIONIST"];
            $('#role').empty().append($("<option></option>").attr("value", "").text("--Select Role--"));
            $('#sub-ordinates').empty().append($("<option></option>").attr("value", "").text("-- Select Sub Ordinates--"));
            $.each(roles, function (key, value) {
                $('#role').append($("<option></option>").attr("value", value).text(value));
            });
        });
        $('#role').change(function () {
            var val, branch_id;
            val = $(this).val();
            <?php if(!empty($_SESSION['ROLE']) && ($_SESSION['ROLE'] == "SUPER_ADMIN")){ ?>
            branch_id = $("#branch_id").val();
            <?php } else{ ?>
            branch_id = "<?php echo $_SESSION['BRANCH_ID'] ?>";
            <?php }?>
            if ((val == "") || (val == null)) {
                $('#sub-ordinates').empty().append('<option value="">-- Select Sub Ordinates --</option>');
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url()?>admin/subOrdinates/getSubOrdinatesByRole/',
                    data: {role: val, branch_id: branch_id},
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        $('#sub-ordinates').empty().append($("<option></option>").attr("value", "").text("--Select Sub Ordinates--"));
                        $.each(data, function (key, value) {
                            $('#sub-ordinates').append($("<option></option>").attr("value", key).text(value));
                        });
                    }
                });
            }
        });
    });
</script>
<?php include currentModuleView('admin') . 'common_pages/location_search_js.php' ?>