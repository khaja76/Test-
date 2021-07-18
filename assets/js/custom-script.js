//jQuery(function($) {
$(document).ready(function(){
    //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
    //so disable dragging when clicking on label
    /*var agent = navigator.userAgent.toLowerCase();
    if (ace.vars['touch'] && ace.vars['android']) {
        $('#tasks').on('touchstart', function (e) {
            var li = $(e.target).closest('#tasks li');
            if (li.length == 0) return;
            var label = li.find('label.inline').get(0);
            if (label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation();
        });
    }*/
	$('input').attr('autocomplete','off');
	$('form').attr('autocomplete','off');
    var loader = $($.parseHTML('<p>')).addClass('loader');
    //var url="<?php echo base_url();?>";
    $($.parseHTML('<object>')).attr({ 'data': '//hifitech.in/package/data/icons/preloader.svg', 'type': 'image/svg+xml' }).addClass('loader_img').appendTo(loader);
    loader.prependTo('body');
    $(window).load(function() {
        $('body').find(".loader").fadeOut("slow");
        $('.main-content').fadeIn("slow");
    });
    $('ul.nav-list li a').each(function() {
        var a = location.pathname.split('/')[location.pathname.split('/').length - 2];
        var c = location.pathname;
        var b = $(this).attr('href');
        //console.log(c);
        if (a == b) {
            $(this).closest('li').addClass('active');
            $(this).parent('li').parent('ul').parent('li').addClass('active');
        } else if (b == c) {
            $(this).closest('li').addClass('active');
            $(this).parent('li').parent('ul').parent('li').addClass('active');
        }
    });
    // For Removing Script
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function(title) {
            var $title = this.options.title || '&nbsp;';
            if (("title_html" in this.options) && this.options.title_html == true)
                title.html($title);
            else title.text($title);
        }
    }));
    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            var array = [];
            var val;
            $(".job-gallery img").each(function() {
                val = ($(this).attr('src'));
                array.push(val);
            });
            // console.log(array);
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var value = event.target.result;
                    if ($.inArray(value, array) == -1) {
                        //$($.parseHTML('<img>')).attr('src', value).addClass('max-200 b-1').appendTo(placeToInsertImagePreview);
                        $("<div class='pip'>" +
                            "<img class='max-200 b-1' src='" + value + "' />" +
                            "<br/><span class='remove'>Remove image</span>" +
                            "</div>").appendTo(placeToInsertImagePreview);
                        $(".remove").click(function() {
                            $(this).parent(".pip").remove();
                        });
                    }
                };
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    var readURL = function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.preview-pic').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
    $('.profile-input-file').on('change', function() {
        readURL(this);
    });
    $('.input-file-2').ace_file_input({
        no_file: 'No File ...',
        btn_choose: 'Choose',
        btn_change: 'Change',
        droppable: false,
        onchange: null,
        thumbnail: false //| true | large
    });
    $('body').on('change', '.inward_imgs', function() {
        imagesPreview(this, 'div.job-gallery');
    });
    $('.gallery').each(function() {
        $(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
    $(".delete_row").on('click', function(e) {
        e.preventDefault();
        $("#dialog-confirm").removeClass('hide').dialog({
            resizable: false,
            width: '320',
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> Remove this Item ?</h4></div>",
            title_html: true,
            buttons: [{
                    html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete Item",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var href = $('.delete_row').attr('href');
                        $.ajax({
                            type: 'GET',
                            url: href,
                            success: function(op) {
                                window.location.reload(1);
                            }
                        });
                        //window.location(href);
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                    "class": "btn btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                }
            ]
        });
    });
    $("[data-toggle='tooltip']").tooltip({ placement: "bottom" });
    $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd-mm-yyyy'
        })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
    $('.input-daterange').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    $("table tr").hover(function() {
        $(this).find('.info').css("visibility", "visible");
    }).mouseleave(function() {
        $(this).find('.info').css("visibility", "hidden");
    });
    $('#dtable').DataTable();
});
/* end of js for image preview */
/* js for payment form */
/*function dropdownPayment(value) {
    console.log(value);
    if (value == 'cheque') {
        $('.payment-cheque').removeClass("hide");
    }
    else {
        $('.payment-cheque').addClass("hide");
    }
}*/
/* end of js for payment form */
/*only numbers allowing in text fields*/
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}
function onlyAlphabets(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        }
        else if (e) {
            var charCode = e.which;
        }
        else { return true; }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
            return true;
        else
            return false;
    }
    catch (err) {
        alert(err.Description);
    }
}
function goBack() {
    window.history.go(-1);
}
//Convert Number to words  Ex:10 ->Ten
function withDecimal(n) {
    var nums = n.toString().split('.')
    var whole = convertNumberToWords(nums[0])
    if (nums.length == 2) {
        var fraction = convertNumberToWords(nums[1])
        if (fraction != '')
            return whole + 'Rupees .' + fraction + 'Paise';
        else
            return whole + 'Rupees ';
    } else {
        return whole;
    }
}
function convertNumberToWords(amount) {
    var words = new Array();
    words[0] = '';
    words[1] = 'One';
    words[2] = 'Two';
    words[3] = 'Three';
    words[4] = 'Four';
    words[5] = 'Five';
    words[6] = 'Six';
    words[7] = 'Seven';
    words[8] = 'Eight';
    words[9] = 'Nine';
    words[10] = 'Ten';
    words[11] = 'Eleven';
    words[12] = 'Twelve';
    words[13] = 'Thirteen';
    words[14] = 'Fourteen';
    words[15] = 'Fifteen';
    words[16] = 'Sixteen';
    words[17] = 'Seventeen';
    words[18] = 'Eighteen';
    words[19] = 'Nineteen';
    words[20] = 'Twenty';
    words[30] = 'Thirty';
    words[40] = 'Forty';
    words[50] = 'Fifty';
    words[60] = 'Sixty';
    words[70] = 'Seventy';
    words[80] = 'Eighty';
    words[90] = 'Ninety';
    amount = amount.toString();
    var atemp = amount.split(".");
    var number = atemp[0].split(",").join("");
    var n_length = number.length;
    var words_string = "";
    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                value = n_array[i] * 10;
            } else {
                value = n_array[i];
            }
            if (value != 0) {
                words_string += words[value] + " ";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Crores ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Lakhs ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Thousand ";
            }
            if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                words_string += "Hundred and ";
            } else if (i == 6 && value != 0) {
                words_string += "Hundred ";
            }
        }
        words_string = words_string.split("  ").join(" ");
    }
    return words_string;
}