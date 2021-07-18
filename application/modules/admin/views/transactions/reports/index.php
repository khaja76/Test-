<h3 class="header smaller lighter">
    Transaction Reports
    
</h3>
<span class="pull-right text-danger">
    Note : Fields are mandatory 
</span>
<div class="trans-header">
    <form class="form-horizontal text-center" id="frm" action="" method="GET" enctype="multipart/form-data">
        <div class="col-md-10">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="col-xs-12">
                        <?php $types = ["quotation" => "Quotation", "proforma" => "Pro-Forma Invoice", "invoice" => "Invoice"]; ?>
                        <select class="form-control input-sm required" id="transac" name="transac">
                            <option value="">----- Transaction Type -----</option>
                            <?php foreach ($types as $k => $v) { ?>
                                <option value="<?php echo $k; ?>" <?php echo !empty($_GET['transac']) && (str_replace('+', ' ', $_GET['transac'] == $k)) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="col-xs-12 ">
                        <select id="customer_id" class="form-control input-sm required" name="customer_id">
                            <option value="">-- Select a Customer --</option>
                            <?php
                            if (!empty($customers_else)) {
                                foreach ($customers_else as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key ?>" <?php echo (!empty($_GET['customer_id']) && $key == $_GET['customer_id']) ? 'selected' : '' ?>><?php echo $value ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" id="trans_value_div">
                    <label for="no" class="col-xs-6">Transaction No :</label>
                    <div class="col-xs-6">
                        <input id="no" class="form-control input-sm" onkeypress="return isNumber(event)" name="transaction_value" value="<?php echo !empty($_GET['transaction_value']) ? $_GET['transaction_value'] : '' ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group pull-left">
                <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-sign-in"></i> Search</button>
            </div>
        </div>
    </form>
</div>
<div class="clearfix"></div>
<div class="space-2"></div>
<div class="col-md-12">
    <?php
    if (!empty($_GET) && !empty($transactions) && !empty($_GET['customer_id']) && isset($_GET['customer_id'])) {
        ?>
        <span class="pull-right">
              <?php if (isset($_GET['view']) && !empty($_GET['view'])) { ?>
                  <a href="#" onclick="return goBack();" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
              <?php } ?>
            <?php if (!isset($_GET['mail'])) {
                ?>
                <a href="<?php echo base_url() ?>admin/transactions/send/mail/<?php echo $_GET['transac'] ?>/<?php echo $_GET['transaction_value'] ?>/customer/<?php echo $_GET['customer_id'] ?>/" class="btn btn-success btn-sm tooltip-success" data-rel="tooltip" data-placement="top" title="Click to Send Email"><i class="fa fa-envelope"></i> Send Email</a>
            <?php } ?>
            <a class="btn btn-info btn-sm" href="<?php echo base_url() ?>admin/transactions/pdf/?customer_id=<?php echo $_GET['customer_id'] ?>&transaction=<?php echo ($_GET['transac'] != 'proforma') ? $_GET['transac'] : 'pro-forma-invoice' ?>&trans_id=<?php echo (!empty($transactions) && ($_GET['transac'] != 'proforma')) ? $transactions[0][$_GET['transac'] . '_pk_id'] : $transactions[0]['pro_invoice_pk_id'] ?>"><i class="fa fa-print"></i> Print Preview</a>
        </span>
        <div class="clearfix"></div>
        <div class="space-2"></div>
        <div class="table-header">
            Transaction Id : <?php
            if (!empty($transactions[0]['quotation'])) {
                echo $transactions[0]['quotation'];
            } else if (!empty($transactions[0]['pro_invoice'])) {
                echo $transactions[0]['pro_invoice'];
            } else if (!empty($transactions[0]['invoice'])) {
                echo $transactions[0]['invoice'];
            }
            ?>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Job Id</th>
                <th>Inward Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($transactions)) {
                $i = 1;
                foreach ($transactions as $transaction) {
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo !empty($transaction['last_name']) ? $transaction['first_name'] . '' . $transaction['last_name'] : $transaction['first_name'] ?></td>
                        <td>
                            <?php echo $transaction['job_id'] ?>
                            <span class="info">
                    <a href="<?php echo base_url() ?>admin/inwards/history/?inward=<?php echo $transaction['inward_no'] ?>" class="badge badge-success tooltip-success" data-rel="tooltip" data-placement="right" title="Full Information"><i class="fa fa-info"></i></a>
                    <a href="<?php echo base_url() ?>admin/inwards/view/?inward=<?php echo $transaction['inward_no'] ?>" class="badge badge-warning tooltip-success" data-rel="tooltip" data-placement="right" title="Inward Details"><i class="fa fa-eye"></i></a>
                   </span>
                        </td>
                        <td><?php echo dateTimeDB2SHOW($transaction['inward_date']) ?></td>
                        <td><?php echo $transaction['status'] ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                echo "<h5 class='text-center text-danger'>No Data found !</h5>";
            }
            ?>
            </tbody>
        </table>
        <?php
    } else if (!empty($transactions_list)) {
        ?>
        <div class="table-header">
            Customer Name : <?php echo !empty($transactions_list) ? $transactions_list[0]['customer_name'] : '' ?>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo !empty($_GET['transac']) ? ucwords($_GET['transac']) : '' ?></th>
                <th><?php echo !empty($_GET['transac']) ? ucwords($_GET['transac']) : '' ?> Date</th>
                <th><?php echo !empty($_GET['transac']) ? ucwords($_GET['transac']) : '' ?> Amount</th>
                <th><?php echo !empty($_GET['transac']) ? ucwords($_GET['transac']) : '' ?> Created On</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($transactions_list as $tracation_data) { ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $tracation_data['transaction'] ?></td>
                    <td><?php echo $tracation_data['t_date'] ?></td>
                    <td><?php echo $tracation_data['t_amount'] ?></td>
                    <td><?php echo dateTimeDB2SHOW($tracation_data['t_created_on']) ?></td>
                    <td><a href="<?php echo base_url() ?>admin/transactions/reports/?transac=<?php echo !empty($_GET['transac']) ? $_GET['transac'] : '' ?>&customer_id=<?php echo !empty($_GET['customer_id']) ? $_GET['customer_id'] : '' ?>&transaction_value=<?php echo $tracation_data['t_no'] ?>&view=true" class="btn btn-xs btn-info tooltip-info" data-placement="left" data-rel="tooltip" title="Click to View Quoted Jobs"><i class="fa fa-search"></i></a></td>
                </tr>
                <?php
                $i++;
            } ?>
            </tbody>
        </table>
    <?php } else if (!isset($_GET) && (empty($transactions) || empty($transactions_list))) {
        echo "<h5 class='text-center text-danger'>No Data found !</h5>";
    } else if (isset($_GET) && empty($transactions_list)) {
        echo "<h5 class='text-center text-danger'>No data Found !</h5>";
    } ?>
</div>
<script>
    $(function () {
        $('[data-rel=tooltip]').tooltip();
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                customer_id: {required: true},
                transac: {required: true}
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            invalidHandler: function (form) {
            }
        })
        $('#transac').on("change", function () {
            var transation_value = $(this).val();
            if ((transation_value == "") || (transation_value == null)) {
                $('#customer_id').empty();
                $('#customer_id').append($("<option></option>").attr("value", "").text("-- Select a Customer --"));
            }
            else {
                $('#customer_id').empty();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url() ?>" + "admin/transactions/fetchCustomersByTransaction/?transaction=" + $(this).val() + "",
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        $('#customer_id').append($("<option></option>").attr("value", "").text("-- Select a Customer --"));
                        $.each(data, function (key, value) {
                            $('#customer_id').append($("<option></option>").attr("value", key).text(value));
                        });
                    }
                });
            }
        })
    });
</script>