<!-- <span class="text-danger pull-right"> * Fields are mandatory </span> -->
<div class="text-center">
    <form class="form-inline" method="get">
        <div class="form-group">
            <label for="email"><span class="text-danger">*</span>Select Option:</label>
            <?php $types = ["customer_id" => "Customer ID", "email" => "Email ID", "mobile" => "Mobile No", "name" => "Name"]; ?>
            <select name="select_type" class="form-control customer_option input-sm">
                <?php foreach ($types as $k => $v) { ?>
                    <option value="<?php echo $k; ?>" <?php echo !empty($_GET['select_type']) && ($_GET['select_type'] == $k) ? "selected='selected'" : ''; ?>><?php echo $v; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <input class="form-control input-sm" id="cust_value" autofocus="autofocus" name="name" type="text" placeholder="Enter Your Input" value="<?php echo !empty($_GET['name']) ? $_GET['name'] : '' ?>" required/>
        </div>
        <button type="submit" class="btn btn-xs btn-primary <?php echo (!empty($_SESSION) && (($_SESSION['ROLE']!='ADMIN') || ($_SESSION['ROLE']!='SUPER_ADMIN')))  ? 'custSearchBtn':''?>"><i class="fa fa-search"></i> Search</button>
        
    </form>
</div>
<script>
    $(document).ready(function () {
        $('.custSearchBtn').prop('disabled', true);
        $('#cust_value').on('keyup', function() {
             if($(this).val().length >= 3) {
                $('.custSearchBtn').prop('disabled', false);
                 } else {
                $('.custSearchBtn').prop('disabled', true);
            }
        });
    });
</script>
