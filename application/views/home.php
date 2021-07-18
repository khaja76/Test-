<?php 
//  echo APPPATH;
// echo "<br/>Base path - ".BASEPATH;
// $_SESSION['USER'] = 'Khaja';
// print_r($_SESSION);
// exit;
?>
<div class="main-container">
    <div class="main-content" style="display: none">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <?php echo getMessage(); ?>
                    <div class="space-6"></div>
                    <div class="center">
                        <h1>
                            <i class="ace-icon fa fa-shopping-cart green"></i>
                            <span class="green">Hifi </span>
                            <span class="green" id="id-text2">Package</span>
                        </h1>
                        <h4 class="blue" id="id-company-text">&copy; Hifi Technologies</h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger text-center">
                                       Please enter your Login Details
                                    </h4>
                                    <?php echo (isset($_GET['session_exp']) && $_GET['session_exp']=='1')?  "<span class='text-center text-danger'>Your session is expired,please login again </span>" :''?>
                                    <div class="space-6"></div>

                                    <form method="post" id="frm">
                                        <input type="hidden" name="LOGIN" value="true" />
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="email" name="email" class="form-control" value="<?php echo !empty($user['email']) ? $user['email'] : ''; ?>" placeholder="Username"/>
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                                </label>

                                                <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" name="password" class="form-control" value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>" placeholder="Password"/>
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                                </label>

                                            <div class="space"></div>
                                            <div class="clearfix">
                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">Login</span>
                                                </button>
                                                <a href="<?php echo base_url() ?>forgot-password/" class="forgot-password-link">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
                                                    I forgot my password
                                                </a>
                                            </div>
                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->
</div>
<script type="text/javascript">
    //jQuery(function ($) {
    $(document).ready(function(){
        $('#frm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {email:true,required: true},
                password: {required: true}
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            }
        });
    })
</script>

