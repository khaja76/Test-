<h3 class="header smaller lighter">
    Sign in for Transactions
</h3>
<form class="hr16 form-horizontal" action="" enctype="multipart/form-data">
    <div class="col-md-offset-3 col-md-5">
        <div class="form-group">
            <label class="control-label col-sm-5" for="userName">Company UserName :</label>
            <div class="col-sm-7">
                <select class="form-control input-sm" id="userName" name="userName">
                    <option>----- Select UserName -----</option>
                    <option>Sai Babu</option>
                    <option>Company 1</option>
                    <option>Company 2</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="password">Password :</label>
            <div class="col-sm-7">
                <input class="form-control input-sm" name="password" id="password" type="text" placeholder="Enter Password" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-3">
                <!--<button type="submit" class="btn btn-sm btn-primary form-control">Submit</button>-->
                <a href="<?php echo base_url(); ?>admin/transactions/add" class="btn btn-sm btn-primary"><i class="fa fa-sign-in"></i> Submit</a>
            </div>
            <!-- /.col -->
        </div>
    </div>
</form>

<form class="hr16 form-horizontal" action="" enctype="multipart/form-data">
    <div class="col-md-offset-3 col-md-5">
        <div class="form-group">
            <label class="control-label col-sm-5" for="job_id">Job Id :</label>
            <div class="col-sm-7">
                <input readonly="" class="form-control  input-sm" name="job_id" id="job_id" type="text" value="HFT/2017/07/011" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="unit_price">Unit Price (INR) :</label>
            <div class="col-sm-7">
                <input class="form-control  input-sm" name="unit_price" id="unit_price" type="text" value="5500"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-3">
                <button type="submit" class="btn btn-sm btn-primary form-control"><i class="fa fa-pencil"></i> Update</button>
            </div>
            <!-- /.col -->
        </div>
    </div>
</form>