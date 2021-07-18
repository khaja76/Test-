<h3 class="header smaller lighter">
    Make a Transaction
    <span class="pull-right">
    </span>
</h3>
<span class="pull-right text-danger">
    Note :Fields are mandatory 
</span>
<form class="form-inline text-center" id="frm" action="" enctype="multipart/form-data">
    <div class="form-group">
        <?php $types = ["QUOTATION" => "Quotation", "PRO-FORMA INVOICE" => "Pro-Forma Invoice", "INVOICE" => "Invoice"]; ?>
        <select class="form-control input-sm required" id="transac" name="transac">
            <option value="">----- Select Transaction Type -----</option>
            <?php foreach ($types as $k => $v) { ?>
                <option value="<?php echo $k; ?>" <?php echo !empty($_GET['transac']) && (str_replace('+', ' ', $_GET['transac'] == $k)) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <?php $types = ["customer_id" => "Customer Id", "inward_no" => "Job Id"]; ?>
        <select class="form-control input-sm required" id="search_type" name="transac_type">
            <option value="">----- Select Search Type -----</option>
            <?php foreach ($types as $k => $v) { ?>
                <option value="<?php echo $k; ?>" <?php echo !empty($_GET['transac_type']) && ($_GET['transac_type'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <input class="form-control input-sm required searchValue" name="value" type="text" placeholder="Enter Your Input" value="<?php echo !empty($_GET['value']) ? $_GET['value'] : "" ?>"/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-xs btn-primary custSearchBtn"><i class="fa fa-sign-in"></i> Search</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="space-12"></div>
<div class="row">
    <div class="col-md-12">
        <?php
        if (!empty($inward)) {
            require_once currentModuleView('admin') . 'common_pages/product_info.php';
            if(($inward['is_outwarded']=='NO')){
                echo "<span class='pull-right'>";
                echo "<a class='btn btn-success btn-sm' href='" . base_url() . "admin/transactions/transaction-details/?inward_no=" . $inward['inward_no'] . "&transaction=" . str_replace(' ', '-', strtolower($_GET['transac'])) . "'>Get " . ucfirst(strtolower($_GET['transac'])) . " </a>";
                echo "</span>";
            }
        }
        if (empty($inward) && isset($_GET['transac_type']) && $_GET['transac_type'] == 'inward_no') {
            echo "<h5 class='text-center text-danger'>No Inward Found !</h5>";
        }
        ?>
    </div>
</div>

<?php
if (!empty($inwards) && (!empty($_GET['transac_type']) && ($_GET['transac_type'] == 'customer_id'))) {
    ?>
    <span class="pull-right">
        <form action="" method="post">
            <input type="hidden" name="job_id" id="job_ids"/>
            <input type="hidden" name="customer_id" value="<?php echo !empty($inwards[0]['customer_no']) ? $inwards[0]['customer_no'] : "" ?>"/>
            <input type="hidden" name="transaction" value="<?php echo str_replace(' ', '-', strtolower($_GET['transac'])) ?>"/>
            <input type="button" id="submitBtn" value="Submit" class="btn btn-success btn-sm disabled"/>
        </form>
    </span>
    <div class="clearfix"></div>
    <div class="space-2"></div>
    <div class="table-header">
        <!--Details-->
        Customer Id :<?php echo !empty($inwards[0]['customer_id']) ? $inwards[0]['customer_id'] : "" ?>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Job Id</th>
            <th>Inward Date</th>
            <th>Status</th>
            <th class="maxw-20"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($inwards as $inward) { ?>
            <tr>
                <td>
                    <?php echo $inward['job_id'] ?>
                    <input type="hidden" name="job_id[]" value="<?php echo $inward['pk_id'] ?>"/>
                    <?php if (!empty($inward['job_id'])) { ?>
                        <span class="info">
                    <a href="<?php echo base_url() ?>admin/inwards/history/?inward=<?php echo $inward['inward_no'] ?>" target="" class="badge badge-success" data-toggle="tooltip" title="Full Information"><i class="fa fa-info"></i></a>
                    <a href="<?php echo base_url() ?>admin/inwards/view/?inward=<?php echo $inward['inward_no'] ?>" class="badge badge-warning" data-toggle="tooltip" title="Inward Details"><i class="fa fa-eye"></i></a>
                   </span>
                    <?php } ?>
                </td>
                <td><?php echo dateTimeDB2SHOW($inward['created_on']) ?></td>
                <td><?php echo $inward['status'] ?></td>
                <td><input id="checkbox1" type="checkbox" class="ace " value="<?php echo $inward['pk_id'] ?>"/> <label class="lbl" for="checkbox1"></label></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php }
else if (empty($inwards) && (!empty($_GET['transac_type']) && ($_GET['transac_type'] == 'customer_id'))) {
    echo "<h5 class='text-center text-danger'>No data Found !</h5>";
} ?>
<script>
    $(function () {
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
        $checks = $(":checkbox");
        $checks.on('change', function () {
            if ($checks.filter(":checked").length > 0) {
                $('#submitBtn').attr('type', 'submit').removeClass('disabled');
            } else {
                $('#submitBtn').attr('type', 'button').addClass('disabled');
            }
            var string = $checks.filter(":checked").map(function (i, v) {
                return this.value;
            }).get().join(", ");
            $('#job_ids').val(string);
        });
        $(".send-sms-dialog").on('click', function (e) {
            e.preventDefault();
            $(".send-sms").removeClass('hide').dialog({
                resizable: false,
                width: '450',
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-comment-o'></i> Send SMS For Token No 'HFT/2017/07/004'</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-paper-plane-o bigger-110'></i>&nbsp; Send",
                        "class": "btn btn-primary btn-minier",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                    ,
                    {
                        html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                        "class": "btn btn-danger btn-minier",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                ]
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.custSearchBtn').prop('disabled', true);
        $('.searchValue').on('keyup', function() {
             if($(this).val().length >= 3) {
                $('.custSearchBtn').prop('disabled', false);
                 } else {
                $('.custSearchBtn').prop('disabled', true);
            }
        });
    });
</script>