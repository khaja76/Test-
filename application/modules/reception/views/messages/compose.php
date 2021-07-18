<h3 class="header smaller lighter">
    Messages - Compose
    <span class="pull-right">
        <a class="btn btn-xs btn-info" href="<?php echo base_url() ?>reception/messages/inbox/">
            <i class="white ace-icon fa fa-envelope bigger-120"></i>
            Inbox
        </a>
        <a class="btn btn-xs btn-primary" href="<?php echo base_url() ?>reception/messages/sent/">
            <i class="white ace-icon fa fa-paper-plane-o bigger-120"></i>
            Sent
        </a>
    </span>
</h3>
<?php echo getMessage(); ?>
<div class="col-sm-12">
    <form class="form-horizontal" action="" id="frm" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="compose_role">Role :</label>
                    <div class="col-sm-8">
                        <?php $roles = ["SUPER_ADMIN" => 'SUPER ADMIN', 'ADMIN' => 'ADMIN', 'ENGINEER' => 'ENGINEER', 'RECEPTIONIST' => 'RECEPTIONIST'] ?>
                        <select class="form-control input-sm required" id="compose_role" name="role">
                            <option value="">-- Select Role --</option>
                            <?php
                            foreach ($roles as $k => $v) {
                                echo "<option value='" . $k . "'>" . $v . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="send_to">Send To :</label>
                    <div class="col-sm-8">
                        <select class="form-control input-sm select2 required" id="send_to" name="sent_to">
                            <option value="">----- Message To -----</option>
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
                        <select class="form-control input-sm " id="job_ids" name="job_id">
                            <option value="">--Select Job Id--</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label class="control-label col-sm-4"> Subject :</label>
                    <div class="col-sm-8">
                        <input class="form-control input-sm required" name="subject" placeholder="Enter Your Subject of Message ..."/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="control-label col-sm-2"> Message :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control input-sm required" name="description" rows="5" placeholder="Enter Your Text Message ..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-paper-plane-o"></i> Send</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(function () {
        $("#compose_role").on("change", function () {
            var th = $(this);
            var role = th.val();
            if (role != "SUPER_ADMIN") {
                var branch_id = "<?php echo $_SESSION['BRANCH_ID'] ?>";
            }
            var url = '<?php echo base_url(); ?>';
            if (role != '' && role != '<?php echo $_SESSION['ROLE']?>') {

                $.ajax({
                    url: url + "admin/fetchUserByRole/",
                    type: 'POST',
                    data: {'role': role, 'branch_id': branch_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#send_to').empty().append($("<option></option>").attr("value", "").text("-- Select a Employee --"));
                        if (data) {
                            $.each(data, function (key, value) {
                                $('#send_to').append($("<option></option>").attr("value", key).text(value));
                            });
                        }
                    },
                    error: function () {
                        alert("failed to Load Data");
                    }
                });

            } else {
                console.log(role);
                $('#job_ids').empty().append($("<option></option>").attr("value", "").text("-- Select a Job Id --"));
                $('#send_to').empty().append($("<option></option>").attr("value", "").text("-- Select Employee  --"));
            }
        });
        $('#send_to').on("change", function () {

            var branch_id = "<?php echo $_SESSION['BRANCH_ID'] ?>";
            var user_id = $(this).val();

            if (user_id != '') {

                var url = '<?php echo base_url(); ?>';
                if ($("#compose_role").val() == 'ENGINEER') {

                    $.ajax({
                        url: url + "admin/fetchJobsByUserId/",
                        type: 'POST',
                        data: {'role': $("#compose_role").val(), 'branch_id': branch_id, 'user_id': user_id},
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
                            alert("failed to Load Data");
                        }
                    });
                } else if ($("#compose_role").val() != 'RECEPTIONIST') {
                    $('#job_ids').empty().append($("<option></option>").attr("value", "").text("-- Select a Job Id --"));
                    $.ajax({
                        url: url + "admin/fetchJobsByBranchId/",
                        type: 'POST',
                        data: {'branch_id': branch_id, 'user_id': $(this).val()},
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
                            alert("failed to Load Data");
                        }
                    });
                } else {
                    $('#job_ids').empty().append($("<option></option>").attr("value", "").text("-- Select a Job Id --"));
                }
            }
        });
        $('#frm').validate();
    });
</script>
