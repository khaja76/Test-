<style>
    .fs-count {
        font-size: 16px;
        line-height: 1;
    }

    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        border-top: 0;
    }
</style>
<h3 class="header smaller lighter">
    Spare Component Details
    <span class="pull-right">
        <a href="<?php echo get_role_based_link(); ?>/spares/" class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<div class="row">
    <div class="col-md-6">
        <?php if (!empty($inward)) { ?>
            <div class="panel panel-default">
                <div class="panel-body">
                        <span class="pull-right fs-count">
                            <?php if ($inward['request_status'] != 'REJECTED' && empty($inward['supplied_quantity'])) { ?>
                                <a href="<?php echo base_url() . 'admin/spares/view/' . $inward['pk_id'] . '?act=status&pk_id=' . $inward['pk_id']; ?>" class="btn btn-danger btn-xs"> Reject this Request  </a>
                            <?php } else if ($inward['request_status'] == 'REJECTED') { ?>
                                <label class="label label-danger">Rejected</label>
                            <?php } ?>
                        </span>
                    <table class="table">
                        <thead>
                        </thead>
                        <tbody>
                        <tr>
                            <td><b>Requested Component Type </b></td>
                            <td><span class="text-info"><?php echo !empty($inward['component_name']) ? $inward['component_name'] : ''; ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Requested Component Model </b></td>
                            <td><span class="text-info"><?php echo !empty($inward['component_model']) ? $inward['component_model'] : ''; ?></span></td>
                        </tr>
                        <?php
                        if (!empty($inward['component_image'])) {
                            ?>
                            <tr>
                                <td><b>Component Image</b></td>
                                <td class="gallery"><a href="<?php echo base_url() . $inward['component_image'] ?>"><img src="<?php echo base_url() . $inward['component_image'] ?>" class="max-150 p-1" alt="Spare Image" width="150" height="100"/></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td><b>Supplied Component Type</b></td>
                            <td><span class="text-info"><?php echo !empty($inward['supplied_component_name']) ? $inward['supplied_component_name'] : ''; ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Job Id </b></td>
                            <td><?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>Customer Name</b></td>
                            <td><?php echo !empty($inward['customer_name']) ? $inward['customer_name'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>Remarks </b></td>
                            <td><?php echo !empty($inward['remarks']) ? $inward['remarks'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>Request From </b></td>
                            <td><?php echo !empty($inward['user_name']) ? $inward['user_name'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b> Requested Quantity </b></td>
                            <td><?php echo !empty($inward['quantity']) ? $inward['quantity'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>Requested Date </b></td>
                            <td> <?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b> Supplied Quantity</b></td>
                            <td> <?php echo !empty($inward['supplied_quantity']) ? $inward['supplied_quantity'] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>Supplied Date </b></td>
                            <td> <?php echo !empty($inward['updated_on']) ? dateDB2SHOW($inward['updated_on']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>Pending Items </b></td>
                            <td> <?php echo ((!empty($inward['supplied_quantity']) && $inward['supplied_quantity'] > 0) && ($inward['supplied_quantity'] < $inward['quantity'])) ? $inward['quantity'] - $inward['supplied_quantity'] : ''; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-md-6">
        <?php if (($inward['supplied_quantity'] < $inward['quantity']) && ($inward['request_status'] != 'REJECTED')) { ?>
            <form class="form-inline" id="_search">
                <div class="form-group">
                    <?php $array = ["company" => "Component Name", "component" => "Component Type", "model" => "Model Name", "description" => "Description"] ?>
                    <select class="form-control input-sm required" name="type" id="type">
                        <option value="">--Select With--</option>
                        <?php
                        foreach ($array as $k => $v) { ?>
                            <option value="<?php echo $k; ?>" <?php echo (!empty($_GET['type']) && ($_GET['type'] == $k)) ? "selected='selected'" : ('model' == $k) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control input-sm required" id="name" name="name" value="<?php echo !empty($_GET['name']) ? $_GET['name'] : ''; ?>" placeholder="Enter name"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-xs"><i class="fa fa-search"></i> Submit</button>
                </div>
            </form>
            <?php
            if (!empty($components)) { ?>
                <div class="space-6"></div>
                <div class="clearfix"></div>
                <div>
                    <div class="table-header">
                        Select Component to Serve
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Component Name</th>
                            <th>Component Type</th>
                            <th>Model</th>
                            <th>Store Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($components as $component) { ?>
                            <tr>
                                <td><input <?php echo (empty($component['quantity']) && ($component['quantity']=='0')) ? 'disabled':'' ?> type="radio" name="sqp_ty" data-q="<?php echo !empty($component['quantity']) ? $component['quantity'] : ''; ?>" class="ace tbl_component_id" value="<?php echo $component['pk_id'] ?>"/><label class="lbl"></label></td>
                                <td><?php echo !empty($component['company_name']) ? $component['company_name'] : ''; ?></td>
                                <td><?php echo !empty($component['component_name']) ? $component['component_name'] : ''; ?></td>
                                <td><?php echo !empty($component['model_no']) ? $component['model_no'] : ''; ?></td>
                                <td><?php echo !empty($component['quantity']) ? $component['quantity'] : '0'; ?></td>
                            </tr>
                        <?php }
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php } elseif (!empty($_GET)) { ?>
                <h4 class="text-danger text-center">No Component Found</h4>
            <?php } ?>
            <div class="space-6"></div>
            <form method="post" id="CSub" class="form-horizontal  <?php echo !empty($_GET) ? '' : 'hide'; ?>">
                <input type="hidden" name="inward_id" value="<?php echo !empty($inward['inward_id']) ? $inward['inward_id'] : '' ?>"/>
                <input type="hidden" name="inward_no" value="<?php echo !empty($inward['inward_no']) ? $inward['inward_no'] : '' ?>"/>
                <input type="hidden" name="spare_request_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : '' ?>"/>
                <input type="hidden" name="component_id" class="component_id"/>
                <?php if (!empty($components)) { ?>
                    <div class="form-group">
                        <label class="col-md-4">Supply Quantity :</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control input-sm" id="spare_quantity" name="spare_quantity" onkeypress="return isNumber(event);"/>
                        </div>
                    </div>
                <?php } ?>
                <?php if (empty($components)) { ?>
                    <div class="form-group">
                        <label class="col-md-4">Required Component :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-sm" name="component_name"/>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-offset-4 col-md-3">
                    <button class="btn btn-success disBtn btn-xs" type="submit" name="submit"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        <?php } ?>
    </div>
</div>
<div class="row">
    <?php if (!empty($history)) { ?>
        <div class="col-md-12">
            <div class="table-header">
                History
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Component Type</th>
                    <th>Component Model</th>
                    <th>Supplied Quantity</th>
                    <th>Supplied On</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                foreach ($history as $component) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo !empty($component['component_name']) ? $component['component_name'] : ''; ?></td>
                        <td><?php echo !empty($component['model_no']) ? $component['model_no'] : ''; ?></td>
                        <td><?php echo !empty($component['quantity']) ? $component['quantity'] : ''; ?></td>
                        <td><?php echo !empty($component['created_on']) ? dateTimeDB2SHOW($component['created_on']) : ''; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>
<script>
    $(document).ready(function () {
        var store_q=0;
        $(document).on("change", ".tbl_component_id", function () {
            var th = $(this).val();
            $(document).find(".component_id").val(th);
            store_q=$(this).data('q');
        });

        $('#spare_quantity').keyup(function () {
            var supply_q = $(this).val();
            var request_q = parseInt(<?php echo $inward['quantity']?>);
            var given_q = parseInt( <?php echo (!empty($inward['supplied_quantity'])) ? $inward['supplied_quantity'] : 0 ?>);

            if(supply_q <=store_q) {
                if (request_q >= supply_q) {
                    var pending_q = request_q - given_q;
                    if (pending_q != '' && pending_q != 0) {

                        if (pending_q >= supply_q) {
                            return true;
                        } else {
                            alert('Supply Quantity Should be equal or Less than requested Quantity');
                            $(this).val('');
                            $(this).attr('required', true);
                            return false;
                        }
                    } else {
                        return true;
                    }
                } else {
                    alert('Supply Quantity Should be equal or Less than requested Quantity');
                    $(this).val('');
                    $(this).attr('required');
                    return false;
                }
            }else{
                alert('Please check store Quantity ');
                $(this).val('');
                $(this).attr('required');
                return false;
            }
        });
    })
</script>