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
                            <span class="white" id="id-text2">Package</span>
                        </h1>
                        <h4 class="blue" id="id-company-text">&copy; Hifi Technologies</h4>
                    </div>
                    <div class="space-6"></div>
                    <div class="position-relative">
                        <div id="forgot-box" class="forgot-box widget-box no-border visible">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                        <i class="ace-icon fa fa-key"></i>
                                        Reset Password
                                    </h4>
                                    <div class="space-6"></div>
                                    <p>
                                        Enter your Password Details
                                    </p>
                                    <form method="post" id="frm">
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="hidden" name="RESET" value="TRUE" />
                                                    <input type="password" class="form-control" id="password" placeholder="Password" name="pwd" />
                                                    <i class="ace-icon fa fa-key"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_pwd" />
                                                    <i class="ace-icon fa fa-key"></i>
                                                </span>
                                            </label>
                                            <div class="clearfix">
                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                    <i class="ace-icon fa fa-lightbulb-o"></i>
                                                    <span class="bigger-110">Reset</span>
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div><!-- /.widget-main -->
                                <div class="toolbar center">
                                    <a href="<?php echo base_url() ?>" class="back-to-login-link">
                                        Back to login
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div><!-- /.widget-body -->
                        </div><!-- /.forgot-box -->
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
                pwd: "required",
                confirm_pwd: {
                    equalTo: "#password"
                }
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            }
        })
    })
</script>
