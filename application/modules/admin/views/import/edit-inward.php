<?php
if (!empty($_SESSION['ROLE'])) {
    if ($_SESSION['ROLE'] == 'ADMIN') {
        $role = 'admin';
    } else if ($_SESSION['ROLE'] == 'RECEPTIONIST') {
        $role = 'reception';
    }
    ?>
    <h3 class="header smaller">
        Edit Inward [ Imported ]
        <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
        <a  href="#" onclick="goBack();"  class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    </span>
    </h3>
    <span class="pull-right text-danger">
        * Fields are mandatory
    </span>
    <div class="col-md-9">
        <form class="form-horizontal" id="frm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pk_id" value="<?php echo !empty($inward['pk_id']) ? $inward['pk_id'] : ''; ?>"/>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Job Id :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" readonly name="job_id" id="job_id" value="<?php echo !empty($inward['job_id']) ? $inward['job_id'] : ''; ?>"/>
                        </div>
                    </div>                                        
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Added On :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" readonly name="created_on" id="created_on" value="<?php echo !empty($inward['created_on']) ? dateDB2SHOW($inward['created_on']) : ''; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Status :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="status" id="status" value="<?php echo !empty($inward['status']) ? $inward['status'] : ''; ?>"/>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Gatepass :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="gatepass" id="gatepass" value="<?php echo !empty($inward['gatepass']) ? $inward['gatepass'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Delivery Details :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="delivery_details" id="delivery_details" value="<?php echo !empty($inward['delivery_details']) ? $inward['delivery_details'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5">Mobile :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="mobile" value="<?php echo !empty($inward['mobile']) ? $inward['mobile'] : ''; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Description :</label>
                        <div class="col-md-7">
                            <textarea rows="5" name="description" class="form-control input-sm"><?php echo !empty($inward['description']) ? ltrim($inward['description']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Estimation :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="estimation" id="estimation" value="<?php echo !empty($inward['estimation']) ? $inward['estimation'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Payment :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="payment" id="payment" value="<?php echo !empty($inward['payment']) ? $inward['payment'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Cheeque No :</label>
                        <div class="col-md-7">
                            <input class="form-control input-sm" name="cheque_no" id="cheque_no" value="<?php echo !empty($inward['cheque_no']) ? $inward['cheque_no'] : '' ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Problem :</label>
                        <div class="col-md-7">
                            <textarea rows="5" name="problem" class="form-control input-sm"><?php echo !empty($inward['problem']) ? ltrim($inward['problem']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5"><sup class="text-danger">*</sup>Customer Name/Details :</label>
                        <div class="col-md-7">
                            <textarea rows="5" name="customer_details" class="form-control input-sm"><?php echo !empty($inward['customer_details']) ? ltrim($inward['customer_details']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
} else {
    echo "Page not found";
} ?>