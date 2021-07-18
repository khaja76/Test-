<style>
    #serial_no-error {
        display: block !important;
    }

    .mceEditor td.mceIframeContainer iframe {
        min-height: 350px !important;
    }

    .mceEditor table {
        height: auto !important;
    }
</style>
<h3 class="header smaller">
    Add Product Category
    <span class="pull-right">
        <button type="submit" form="frm" class="btn btn-xs btn-success"><i class="fa fa-floppy-o"></i> Save</button>
        <a href="#" onclick="goBack();" class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<span class="pull-right text-danger">
    * Fields are mandatory
</span>
<form class="form-horizontal" id="frm" method="post" enctype="multipart/form-data">
    <input type="hidden" name="pk_id" value="<?php echo !empty($category['pk_id']) ? $category['pk_id'] : ''; ?>"/>
    <div class="col-md-12">
        <?php echo getMessage(); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-6"><sup class="text-danger">*</sup>Category :</label>
                    <div class="col-md-6">
                        <input type="text" name="category_name" class="form-control input-sm" placeholder="Category Name" value="<?php echo !empty($category['category_name']) ? $category['category_name'] : ''; ?>"/>
                    </div>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-3"><sup class="text-danger">*</sup>Description :</label>
                    <div class="col-md-8">
                        <textarea name="product_category_description" class="form-control input-sm"><?php echo !empty($category['product_category_description']) ? $category['product_category_description'] : ''; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    $(function () {
        var base_url = $('.base_url').val();
        tinymce.init({
            selector: "textarea",
            theme: "modern",
            plugins: ["advlist  autolink lists link charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
            convert_urls: false,
            content_css: 'http://skin.tinymce.com/css/preview.content.css',
            toolbar: "insertfile undo redo code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link  ",
            images_upload_url: base_url + 'home/upload-post-image',

            images_dataimg_filter: function (img) {
                return img.hasAttribute('internal-blob');
            },

        });

    })
</script>