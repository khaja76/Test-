<h3 class="header smaller lighter no-border-bottom">
    <p class="text-primary hidden-print">Transactions</p>
    <span class="pull-right hidden-print">
        <a href="<?php echo base_url() ?>admin/transactions/" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
        <a href="#" target="_blank" onclick="javascript:print()" class="btn btn-info btn-sm"><i class="fa fa-print"></i> Print</a>
    </span>
</h3>
<div class="col-md-12">
    <?php
    if ((isset($_GET['customer_id']) && !empty($pro_forma_invoice) && !empty($_GET['customer_id']))) {
    ?>
    <div class="quote">
        <div class="widget-box transparent">
            <div class="row">
                <div class="col-sm-6 print-half">
                    <img src="<?php echo base_url() ?>data/ltheader.png" alt="HiFi"/>
                </div>
                <div class="col-sm-6 text-right print-half">
                    <?php
                    if (!empty($branch)) {
                        ?>
                        <h4><?php echo $branch['name'] ?></h4>
                        <p><?php echo !empty($branch['address1']) ? $branch['address1'] . ',' : '' ?><?php echo !empty($branch['address2']) ? $branch['address2'] . ',' : '' ?> </p>
                        <p><?php echo !empty($branch['city']) ? $branch['city'] : '' ?>-<?php echo !empty($branch['pincode']) ? $branch['pincode'] . ',' : '' ?> <?php echo !empty($branch['state']) ? $branch['state'] : '' ?>, India</p>
                        <p><?php echo !empty($branch['email']) ? $branch['email'] : '' ?></p>
                        <p><?php echo !empty($branch['mobile_1']) ? $branch['mobile_1'] : '' ?></p>
                    <?php }
                    ?>
                </div>
            </div>
            <div class="hr hr8 hr-double hr-dotted"></div>
            <div class="widget-body">
                <div>
                    <div class="row">
                        <div class="col-sm-6 print-half">
                            <div class="row">
                                <div class="col-xs-11">
                                    <h4 class="gray">Pro-Forma Invoice To</h4>
                                </div>
                            </div>
                            <div>
                                <?php
                                if (!empty($customer)) {
                                    ?>
                                    <ul class="list-unstyled  spaced">
                                        <li>
                                            <b><?php echo !empty($customer['last_name']) ? $customer['first_name'] . ' ' . $customer['last_name'] : $customer['first_name'] ?></b>
                                        </li>
                                        <li>
                                            <?php echo !empty($customer['address1']) ? $customer['address1'] : '' ?>
                                            <?php echo !empty($customer['address2']) ? ',' . $customer['address2'] : '' ?>
                                        </li>
                                        <li>
                                            <?php echo !empty($customer['city']) ? $customer['city'] : '' ?>
                                            <?php echo !empty($customer['state']) ? ',' . $customer['state'] : '' ?>
                                        </li>
                                        <li>
                                            <?php echo !empty($customer['pincode']) ? $customer['pincode'] : '' ?>- India.
                                        </li>
                                        <li>
                                            Contact :<?php echo !empty($customer['mobile']) ? $customer['mobile'] : '' ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-sm-4 print-half col-md-offset-2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 class="grey">Pro-Forma Invoice Information</h4>
                                </div>
                            </div>
                            <div
                            <ul class="list-unstyled spaced">
                                <li>
                                    <b><span class="w-150 f-l"><?php echo (!empty($_GET['transaction'])) ? "Pro-Forma Invoice" : '' ?> No</span> </b> : <span class="m-l-10"><?php echo !empty($pro_forma_invoice) ? $pro_forma_invoice['pro_invoice'] : '' ?></span>
                                </li>
                                <li>
                                    <b><span class="w-150 f-l">Pro-Forma Invoice Date</span> </b>: <span class="m-l-10"><?php echo !empty($pro_forma_invoice) ? dateDB2SHOW($pro_forma_invoice['pro_invoice_date']) : '' ?></span>
                                </li>
                                <li class="bg-gray p-10">
                                    <div>
                                        <b><span class="w-150 f-l">Invoice Amount </span> </b>: <span class="m-l-10"><b><i class='fa fa-inr'></i> <?php echo !empty($pro_forma_invoice) ? number_format($pro_forma_invoice['final_amount'], 2) : '' ?></b></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="space"></div>
                <div class="row inv">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="w-550">Job ID</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th class="w-100">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($pro_forma_invoice_jobs)) {
                                $i = 1;
                                foreach ($pro_forma_invoice_jobs as $pro_forma_invoice_job) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td>
                                            <b><?php echo $pro_forma_invoice_job['job_id'] ?></b><br>
                                            <?php echo $pro_forma_invoice_job['description'] ?>
                                        </td>
                                        <td><?php echo $pro_forma_invoice_job['status'] ?></td>
                                        <td><?php echo $pro_forma_invoice_job['remarks'] ?></td>
                                        <td><?php echo $pro_forma_invoice_job['amount'] ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="hr hr8 hr-double hr-dotted"></div>
                <div class="row">
                    <div class="col-sm-4 pull-right">
                        <h6><b><span class="w-150 f-l">Net Amount</span> </b>
                            :
                            <span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($pro_forma_invoice) ? number_format($pro_forma_invoice['total_amount'], 2) : '' ?></span>
                        </h6>
                        <h6><b><span class="w-150 f-l">CGST Amount </span> </b>
                            :
                            <span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($pro_forma_invoice) ? number_format($pro_forma_invoice['cgst_amount'], 2) : '' ?></span>
                        </h6>
                        <h6><b><span class="w-150 f-l">SGST Amount  </span> </b>
                            :
                            <span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($pro_forma_invoice) ? number_format($pro_forma_invoice['sgst_amount'], 2) : '' ?></span>
                        </h6>
                        <h6><b><span class="w-150 f-l">IGST Amount </span> </b>
                            :
                            <span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($pro_forma_invoice) ? number_format($pro_forma_invoice['igst_amount'], 2) : '' ?></span>
                        </h6>
                        <h6><b><span class="w-150 f-l">Shipping & Handling </span> </b>
                            :
                            <span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($pro_forma_invoice) ? number_format($pro_forma_invoice['ship_handling_amount'], 2) : '' ?></span>
                        </h6>
                        <h5 class="bg-gray p-10">
                            <b><span class="w-150 f-l">Final Amount</span> </b> :
                            <span class="m-l-10"><i class="fa fa-inr"></i> <?php echo !empty($pro_forma_invoice) ? number_format($pro_forma_invoice['final_amount'], 2) : '' ?></span>
                        </h5>
                    </div>
                    <div class="col-sm-7 pull-left">
                        <?php
                        if (!empty($pro_forma_invoice) && !empty($pro_forma_invoice['notes'])) { ?>
                            <h5 class='red '>Notes : </h5>
                            <textarea readonly class="textarea-custom notes">
                                    <?php
                                    echo trim($pro_forma_invoice['notes']);
                                    ?>
                                </textarea>
                        <?php } ?>
                    </div>
                </div>
                <div class="space-6"></div>
                <h5 class='red bg-gray p-10'>Terms and Conditions :</h5>
              
                <ol class="list-unstyled" style="list-style-type:lower-alpha">
                    <li> The Pro-Forma invoice will be invalid, if the confirmation is not received within validity.</li>
                    <li> In case of payment being done by any other currencies except the issued Pro-forma invoice currency, conversion would be calculated under "Ex-Change Rate" of Pro-forma Invoice issuance date.</li>
                    <li> The unit price mentioned in this proforma invoice is valid for the first month delivery of the above ordered quantity.</li>
                    <li> The unit price for the next lot will be negtiated 15 days prior to the completion of currently shippinng lot and the documents for the negotiated price should be exchanged between the Buyer and the Seller.</li>
                    <li> The Force Majeure (exemption) clause of the international chamber of commerce (ICC PUBLICATION NO. : 421 is hereby incorporated in this pro-forma invoice.</li>
                </ol>
                <h6><b>Thanks for your Business !</b></h6>
            </div>
        </div>
    </div>
</div>
<?php } ?>
</div>
