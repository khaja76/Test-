<?php
if (($_SESSION['ROLE'] == "ADMIN") || ($_SESSION['ROLE'] == "SUPER_ADMIN")) {
    $role = "admin";
} elseif ($_SESSION['ROLE'] == "RECEPTIONIST") {
    $role = "reception";
} else {
    $role = "engineer";
}
function is_session_user_not($role = '', $restrictions = [])
{
    if ($_SESSION['ROLE'] != $role) {
        $cont = '';
        foreach ($restrictions as $con) {
            $cont .= ' ' . $con;
        }
        return $cont;
    }
}
?>
<h3 class="header smaller lighter">
    Messages - Compose
    <span class="pull-right">
        <button class="btn btn-xs btn-warning" href="#" onclick="goBack();">
            <i class="white ace-icon fa fa-arrow-left bigger-120"></i>
            Back
        </button>
          <button type="submit" form="frm" class="btn btn-xs btn-primary"><i class="fa fa-paper-plane-o"></i> Send</button>
    </span>
</h3>
<span class="pull-right text-danger"> * Fields are mandatory </span>
<div class="col-sm-12">
    <form class="form-horizontal" action="" id="frm" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-5 <?php echo is_session_user_not('SUPER_ADMIN', ['hide']); ?>">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="compose_role"><span class="text-danger">*</span>Role :</label>
                    <div class="col-sm-8">
                        <?php $roles = ["SUPER_ADMIN" => 'SUPER ADMIN', 'ADMIN' => 'ADMIN', 'ENGINEER' => 'ENGINEER', 'RECEPTIONIST' => 'RECEPTIONIST'] ?>
                        <select class="form-control input-sm required" id="compose_role" name="role">
                            <option value="">-- Select Role --</option>
                            <?php
                            foreach ($roles as $k => $v) {
                                ?>
                                <option value="<?php echo $k; ?>" <?php echo ($_SESSION['ROLE'] && $_SESSION['ROLE'] != 'SUPER_ADMIN') ? 'selected' : '' ?>><?php echo $v ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="control-label col-sm-4"><span class="text-danger">*</span>Send To :</label>
                    <div class="col-sm-8">
                        <select class="form-control input-sm select2 required" id="send_to" name="sent_to">
                            <option value="">----- Message To -----</option>
                            <?php if (!empty($_SESSION['USER_ID']) && ($_SESSION['ROLE'] == "ADMIN")) {
                                echo "<option value='1'>SUPER ADMIN</option>";
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="control-label col-sm-4">Job Id :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm" name="job_id" placeholder="Enter Job Id"/>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="control-label col-sm-4"><span class="text-danger">*</span> Subject :</label>
                    <div class="col-sm-8">
                        <input class="form-control input-sm required" id="subject" name="subject" placeholder="Enter Your Subject of Message ..."/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="control-label col-sm-2"><span class="text-danger">*</span> Message :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control input-sm required" name="description" rows="5" placeholder="Enter Your Text Message ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var getUsers = (data) =>
    {
        if (data) {
            data = data;
        } else {
            data = {'branch_id': "<?php echo $_SESSION['BRANCH_ID'] ?>"};
        }
        <?php if(!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'ADMIN'){?>
        //$('#send_to').append($("<option></option>").attr("value", 1).text('SUPER_ADMIN'));
        <?php }?>
        var Baseurl = "<?php echo base_url();?>";
        $.ajax({
            url: Baseurl + "admin/fetchUserByRole/",
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data) {
                $('#send_to').empty().append($("<option></option>").attr("value", "").text("-- Select a Employee --"));
                if (data) {
                    $.each(data, function (key, value) {
                        $('#send_to').append($("<option></option>").attr("value", key).text(value));
                    });
                    <?php if($_SESSION['ROLE'] == 'ADMIN'){?>
                    $('#send_to').append($("<option></option>").attr("value", '1').text('SUPER_ADMIN'));
                    <?php } ?>
                }
            },
            error: function () {
                console.log("failed to Load Data");
            }
        });
    }
    $(function () {
        var req_data;
        if ('<?php echo $_SESSION['ROLE'] ?>' != 'SUPER_ADMIN') {
            $('#compose_role').trigger("change");
            req_data = {branch_id: "<?php echo $_SESSION['BRANCH_ID']?>"}
            getUsers(req_data);
        }
        else {
            $("#compose_role").on("change", function () {
                var th = $(this);
                var role = th.val();
                if (role != "SUPER_ADMIN") {
                    var branch_id = "<?php echo $_SESSION['BRANCH_ID'] ?>";
                }
                var url = '<?php echo base_url(); ?>';
                if (role != '' && role != '<?php echo $_SESSION['ROLE']?>') {
                    var req_data = {'role': role, 'branch_id': branch_id}
                    getUsers(req_data);
                } else {
                    $('#job_ids').empty().append($("<option></option>").attr("value", "").text("-- Select a Job Id --"));
                    $('#send_to').empty().append($("<option></option>").attr("value", "").text("-- Select a Employee --"));
                }
            });
        }
        $('#send_to').on("change", function () {
            var branch, branch_id, user_id;
            var th = $(this);
            user_id = th.val();
            $.ajax({
                url: "<?php echo base_url() ?>admin/getUserById/",
                type: 'POST',
                data: {'user_id': user_id},
                dataType: 'json',
                async: false,
                success: function (data) {
                    branch = data.branch_id;
                },
                error: function () {
                    console.log("failed to Load Data");
                }
            });
            branch_id = $("#compose_role").val() != 'SUPER_ADMIN' ? branch : "<?php echo $_SESSION['BRANCH_ID'] ?>";
            if ((user_id != null) || (user_id != '')) {
                var url = '<?php echo base_url(); ?>';
                var arr;
                if ($("#compose_role").val() == 'ENGINEER') {
                    arr = {'role': $("#compose_role").val(), 'branch_id': branch_id, 'user_id': user_id};
                }
                else if ($("#compose_role").val() == 'SUPER_ADMIN') {
                    arr = {'branch_id': branch_id, 'user_id': '<?php echo $_SESSION['USER_ID'] ?>'};
                }
                else {
                    arr = {'branch_id': branch_id, 'user_id': $(this).val()};
                }
                $.ajax({
                    url: url + "admin/fetchJobsByUserId/",
                    type: 'POST',
                    data: arr,
                    dataType: 'json',
                    success: function (data) {
                        $('#job_ids').empty().append($("<option></option>").attr("value", "").text("-- Select a Job Id --"));
                        if (data) {
                            $.each(data, function (key, value) {
                                $('#job_ids').append($("<option></option>").attr("value", key).text(value));
                            });
                        }
                    },
                    error: function () {
                        console.log("failed to Load Data");
                    }
                });
            }
        });
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {},
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        });
    });
</script>