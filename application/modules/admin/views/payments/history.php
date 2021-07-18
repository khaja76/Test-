<style>
    .profile-image {
        width: 120px;
        float: left;
    }

    .profile-image img {
        width: 96px;
        height: 96px;
    }

    img.circle-border {
        border: 6px solid #307ecc2b;
        border-radius: 50%;
    }

    .profile-info {
        margin-left: 120px;
    }

    .no-margins {
        margin: 0;
    }

    .m-b-lg {
        margin-bottom: 5px;
    }

    .font-normal {
        font-weight: 100;
    }
</style>
<h3 class="header smaller lighter">
    Payment History
    <span class="pull-right">
        <a href="#" onclick="goBack()" class="btn btn-xs btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<div class="clearfix"></div>
<div class="space-2"></div>
<div class="clearfix"></div>
<div class="row m-b-lg">
    <div class="col-md-4">
        <div class="clearfix"></div>
        <div>
            <div class="profile-image">
                <?php if (!empty($inward['img']) && file_exists(FCPATH . $inward['customer_path'] . $inward['img'])) { ?>
                    <img class="img-circle circle-border m-b-md" alt="Avatar" src="<?php echo base_url() . $inward['customer_path'] . $inward['img']; ?>"/>
                <?php } else { ?>
                    <img src="<?php echo dummyLogo() ?>" alt="Customer image" class="img-circle circle-border m-b-md"/>
                <?php } ?>
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h3 class="no-margins font-normal">
                            <?php echo !empty($inward['customer_name']) ? $inward['customer_name'] : '' ?>
                        </h3>
                        <h4><?php echo !empty($inward['customer_id']) ? $inward['customer_id'] : '' ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php
    if (!empty($_GET['inward'])) {
        ?>
        <div class="col-md-5">
            <table class="table table-bordered table-hovered">
                <tr>
                    <td>Product</td>
                    <td><?php echo !empty($inward['product']) ? $inward['product'] : '' ?></td>
                </tr>
                <tr>
                    <td>Make</td>
                    <td><?php echo !empty($inward['manufacturer_name']) ? $inward['manufacturer_name'] : '' ?></td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td><?php echo !empty($inward['model_no']) ? $inward['model_no'] : '' ?></td>
                </tr>
                <tr>
                    <td>Serial</td>
                    <td><?php echo !empty($inward['serial_no']) ? $inward['serial_no'] : '' ?></td>
                </tr>
                <tr>
                    <td>Job Id</td>
                    <td><?php echo !empty($inward['job_id']) ? $inward['job_id'] : '' ?></td>
                </tr>

            </table>
        </div>
        <?php
    }
    ?>
    <div class="col-md-3">
        <?php if (!empty($_GET['inward'])) : ?>
            <table class="table table-bordered">
                <tr>
                    <th>Estimated Amount</th>
                    <th><?php echo !empty($inward['estimation_amt']) ? number_format($inward['estimation_amt'], 2) : '-' ?></th>
                </tr>
                <tr>
                    <th>Payment Done</th>
                    <th><?php echo !empty($inward['paid_amt']) ? number_format($inward['paid_amt'], 2) : '-' ?></th>
                </tr>
                <tr>
                    <th>Payment Due Amount</th>
                    <th><?php echo (($inward['estimation_amt']) > 0 && $inward['paid_amt'] > 0) ? number_format($inward['estimation_amt'] - $inward['paid_amt'], 2) : '-' ?></th>
                </tr>
            </table>
        <?php endif; ?>
        <?php if (!empty($invoice)) : ?>
            <table class="table table-bordered">
                <tr>
                    <th>Estimated Amount</th>
                    <th><?php echo !empty($invoice['final_amount']) ? number_format($invoice['final_amount'], 2) : '-' ?></th>
                </tr>
                <tr>
                    <th>Payment Done</th>
                    <th><?php echo !empty($invoice['paid_amt']) ? number_format($invoice['paid_amt'], 2) : '-' ?></th>
                </tr>
                <tr>
                    <th>Payment Due Amount</th>
                    <th><?php echo (($invoice['final_amount']) > 0 && $invoice['paid_amt'] > 0) ? number_format($invoice['final_amount'] - $invoice['paid_amt'], 2) : '-' ?></th>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</div>
<div class="clearfix"></div>
<div class="row padding-10">
    <div class="col-md-12 col-xs-12">
        <div class="table-header">
            Payments Information
        </div>
        <table class="table table-bordered table-hovered" id="">
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Mode</th>
                <th>Cheque ( If Available)</th>
                <th>Bank details</th>
                <th>Amount( <i class=" fa fa-inr"></i> )</th>
                <th>Remarks</th>
                <th>Added By</th>
                <th>Payment Date</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($inward['payments'])) {
                $i = 1;
                foreach ($inward['payments'] as $inward) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo !empty($inward['payment_mode']) ? $inward['payment_mode'] : '-'; ?></td>
                        <td><?php echo !empty($inward['cheque_no']) ? $inward['cheque_no'] : '-'; ?></td>
                        <td><?php echo !empty($inward['bank_details']) ? $inward['bank_details'] : '-'; ?></td>
                        <td><?php echo !empty($inward['amount']) ? $inward['amount'] : '-'; ?></td>
                        <td><?php echo !empty($inward['remarks']) ? $inward['remarks'] : '-'; ?></td>
                        <td><?php echo !empty($inward['user_name']) ? $inward['user_name'] : '-'; ?></td>
                        <td><?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : '-'; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                echo "<tr><td colspan='8' class='text-center text-danger'>No history found !</td></tr>";
            }
            ?>
            </tbody>
        </table>

    </div>
</div>