<script>
    $(function () {
        $('#location_id').on("change", function () {
            var location_id = $(this).val();
            if ((location_id == "") || (location_id == null)) {
                $('#branch_id').empty();
                $('#branch_id').append($("<option></option>").attr("value", "").text("-- Select a Branch --"));
            }
            else {
                $('#branch_id').empty();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url() ?>" + "admin/fetch_branches/?location_id=" + location_id,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                       
                        $('#branch_id').append($("<option></option>").attr("value", "").text("-- Select a Branch --"));
                        $.each(data, function (key, value) {
                            $('#branch_id').append($("<option></option>").attr("value", key).text(value));
                        });
                    }
                });
            }
        })
    });
</script>