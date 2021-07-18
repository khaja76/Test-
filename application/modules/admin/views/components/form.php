<?php
if (!empty($_SESSION['ROLE'])) {
    if ($_SESSION['ROLE'] == 'ADMIN') {
        $role = 'admin';
    } else if ($_SESSION['ROLE'] == 'RECEPTIONIST') {
        $role = 'reception';
    }
    ?>
    <h3 class="header smaller">
        <?php echo !empty($component) ? 'Edit' : 'Add'; ?> Component
        <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-xs btn-success btnSave"><i class="fa fa-floppy-o"></i> Save</button>
        <a href="#" onclick="goBack();" class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    </span>
    </h3>
    <span class="pull-right text-danger">
        * Fields are mandatory
    </span>
    <div class="col-md-9">
        <form class="form-horizontal" id="frm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pk_id" value="<?php echo !empty($component['pk_id']) ? $component['pk_id'] : ''; ?>"/>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Component Name :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="company_name" id="company_name" value="<?php echo !empty($component['company_name']) ? $component['company_name'] : ''; ?>" placeholder="Select or Add Company"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Component Type :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="component_name" id="component_name" value="<?php echo !empty($component['component_name']) ? $component['component_name'] : ''; ?>" placeholder="Select or Add Component"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Model Number :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" id="model_no" name="model_no" value="<?php echo !empty($component['model_no']) ? $component['model_no'] : ''; ?>" placeholder="Enter Model No">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Quantity :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" id="quantity" name="quantity" placeholder="Enter Quantity" value="0"/>
                            <p>Qty in Store is <span class="red" id="final_qty"><?php echo !empty($component['quantity']) ? $component['quantity'] : ''; ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Component Details :</label>
                        <div class="col-md-7">
                            <textarea rows="5" name="description" id="description" class="form-control input-sm" placeholder="Enter Component Details"><?php echo !empty($component['description']) ? $component['description'] : ''; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Alert Quantity :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" id="alert_quantity" name="alert_quantity" placeholder="Enter Quantity" value="<?php echo !empty($component['alert_quantity']) ? $component['alert_quantity'] : ''; ?>" onkeypress="return isNumber(event);"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5">Component Image :</label>
                        <div class="col-md-7">
                            <input type="file" name="photo" class="profile-input-file input-file-2" accept=".png, .jpg, .jpeg, .gif"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Component Location :</label>
                        <div class="col-md-7">
                            <input type="text" name="location" id="location" class="form-control input-sm" placeholder="Enter Component Location" value="<?php echo !empty($component['location']) ? $component['location'] : ''; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3">
        <div class="gallery">
            <?php if (!empty($component['img']) && (file_exists(FCPATH . 'data/components/' . $component['img']))) { ?>
                <a href="<?php echo base_url(); ?>/data/components/<?php echo $component['img'] ?>">
                    <img class="max-200 preview-pic" alt="Component Name" src="<?php echo base_url() . 'data/components/' . $component['img']; ?>"/>
                </a>
            <?php } else { ?>
                <img src="http://placehold.it/200x200" alt="your image" class="preview-pic max-200"/>
            <?php } ?>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.btnSave').click(function () {
                $(this).attr({
                    'type': 'button',
                    'disabled': true
                });
                $('#frm').submit();
            });

            $('#frm').validate({
                errorElement: 'div',
                errorClass: 'help-block',
                focusInvalid: false,
                ignore: "",
                rules: {
                    company_name: {required: true},
                    component_name: {required: true},
                    model_no: {required: true},
                    quantity: {required: true, number: true},
                    alert_quantity: {required: true}

                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                },
                success: function (e) {
                    $(e).closest('.form-group').removeClass('has-error');
                    $(e).remove();
                }
            });
            var companies = [<?php if(!empty($companies)){
                $count = count($companies);
                $i = 1;
                foreach($companies as $k=>$v){ ?>
                {
                    key: "<?php echo $k ?>",
                    value: "<?php echo $v ?>"
                }
                <?php
                echo ($i == $count) ? '' : ',';
                $i++;
                }
                } ?>];
            // Auto Completion Script
            $("#company_name").autocomplete({
                minLength: 0,
                source: companies,
                focus: function (event, ui) {
                    $("#company_name").val(ui.item.value);
                    return false;
                },
                select: function (event, ui) {
                    $("#company_name").val(ui.item.value);
                    return false;
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div>" + item.value + "</div>")
                    .appendTo(ul);
            };
            $("#component_name").on("focus", function () {
                var val = $("#company_name").val();
                var $data = [];
                $.ajax({
                    url: '<?php echo base_url();?>admin/components/getComponentsList/',
                    data: {'company_name': val},
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        if (data) {
                            $.each(data, function (key, val) {
                                console.log();
                                $data.push({value: val});
                            });
                            log($data);
                        }
                    }
                });
                $("#component_name").autocomplete({
                    minLength: 0,
                    source: $data,
                    focus: function (event, ui) {
                        $("#component_name").val(ui.item.value);
                        return false;
                    },
                    select: function (event, ui) {
                        $("#component_name").val(ui.item.value);
                        return false;
                    }
                }).autocomplete("instance")._renderItem = function (ul, item) {
                    return $("<li>")
                        .append("<div>" + item.value + "</div>")
                        .appendTo(ul);
                };
            });
            $("#model_no").on("focus", function () {
                var company = $("#company_name").val();
                var val = $("#component_name").val();
                var branch = "<?php echo $_SESSION['BRANCH_ID'] ?>";
                var $model = [];
                $.ajax({
                    url: '<?php echo base_url();?>admin/components/getComponentModelsList/',
                    data: {'company_name': company, 'component_name': val, 'branch': branch},
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        if (data) {
                            $.each(data, function (key, val) {
                                $model.push({value: val});
                            });
                            log($model);
                        }
                    }
                });
                $("#model_no").autocomplete({
                    minLength: 0,
                    source: $model,
                    focus: function (event, ui) {
                        $("#model_no").val(ui.item.value);
                        return false;
                    },
                    select: function (event, ui) {
                        $("#model_no").val(ui.item.value);
                        return false;
                    }
                }).autocomplete("instance")._renderItem = function (ul, item) {
                    return $("<li>")
                        .append("<div>" + item.value + "</div>")
                        .appendTo(ul);
                };
            });
            function log($data) {
                return $data;
            }

            $("#quantity").on("focus", function () {
                var company = $("#company_name").val();
                var component = $("#component_name").val();
                var model = $("#model_no").val();
                var branch = "<?php echo $_SESSION['BRANCH_ID'] ?>";
                $.ajax({
                    url: '<?php echo base_url();?>admin/components/getComponentDetails/',
                    data: {'company_name': company, 'component_name': component, 'branch': branch, 'model_no': model},
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        if (data) {
                            $("#final_qty").text(data.quantity);
                            $("#description").val(data.description);
                            $("#alert_quantity").val(data.alert_quantity);
                            if (data.img != 0) {
                                $('.preview-pic').attr('src', '<?php echo base_url();?>data/components/' + data.img);
                            }
                        }
                    }
                });
            })
        })
    </script>
    <?php
} else {
    echo "Page not found";
} ?>