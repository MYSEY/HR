$(function(){
    $(document).on('click', '#btnAddMore', function() {
        var $clone = $('.education-repeatable-element:first').clone();

        // Reset values
        $clone.find('input').val('');
        
        $clone.find('.position-review-select').val('').trigger('change');
        $clone.find('.select2-container').remove();
        $clone.find('.position-review-select').off();     

        // Append the clean clone
        $('#education-container-repeatable-elements').append($clone);
        $('.position-review-select').select2({
            width: '100%'
        });
    });
    $('body').on('click', '.education-delete-element', function() {
        if ($('.education-repeatable-element').length > 1) {
            $(this).closest('.education-repeatable-element').remove();
        }
    });

    $("#request_type").on("change", function() {
        let value = $(this).find("option:selected").val();
        $("#reference_type").val("");
        $(".checkbox-group").prop("checked", false);
        $("#special_fixed_asset").css("display","none");
        if (value == "1") {
            $("#special_fixed_asset").css("display","block");
        }
        if (value == "0") {
            $(".reference_type").css("display","block");
        } else {
            $(".reference_type").css("display","none");
        }
    });
    $(".checkbox-group").on("click", function () {
        $(".checkbox-group").not(this).prop("checked", false);
    });

    $("#from_location").on("change", function() {
        let value = $(this).find("option:selected").val();
        $("#model_review").val("");
        if (value == "2") {
            $("#view_model_review").css("display","block");
            $(".branch_view").css("display","none");
        } else {
            $("#view_model_review").css("display","none");
            $(".branch_view").css("display","block");
        }
    });

    $("."+buttonSubmit).on("click", function() {
        var num_miss = 0;
        $("."+buttonSubmit).attr('disabled',true);
        $("#btn-save-loading").css('display', 'block');
        $(".btn-text-save").css("display", 'none');
        if ($("#request_type").val() =="0") {
            if ($("#reference_type").val() == "" || $("#reference_type").val() == null) {
                num_miss++;
                $("#reference_type").addClass("is-invalid");
                $("#reference_type").removeClass("is-valid");
            }
        }else{
            $("#reference_type").val("");
            $("#reference_type").removeClass("is-invalid");
            $("#reference_type").addClass("is-valid");
        }
        if ($("#from_location").val() =="2") {
            if ($("#model_review").val() == "" || $("#model_review").val() == null) {
                num_miss++;
                $("#model_review").addClass("data_required");
                $("#model_review").addClass("is-invalid");
                $("#model_review").removeClass("is-valid");
            }else{
                $("#model_review").removeClass("data_required");
            }
            if ($(".department_review").val() == "" || $(".department_review").val() == null) {
                num_miss++;
                $(".department_review").addClass("data_required");
            }else{
                $(".department_review").removeClass("data_required");
            }
        }else{
            $("#model_review").removeClass("data_required");
            $("#model_review").removeClass("is-invalid");
            $("#model_review").addClass("is-valid");

            $(".department_review").removeClass("data_required");
            $(".department_review").removeClass("is-invalid");
            $(".department_review").addClass("is-valid");
            
        }
        $(".data_required").each(function(){
            if($(this).val()==""){ 
                num_miss++;
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
                $("."+buttonSubmit).attr('disabled',false);
                $("#btn-save-loading").css('display', 'none');
                $(".btn-text-save").css("display", 'block');
            }else{
                num_miss - 1; 
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            }
        });
        if(num_miss < 1){
            let data_levels = [];
            let group_id = '';
            $(".education-repeatable-element").each(function(){
                var positions = $(this).find(".position-review-select").val() || [];
                // Remove empty values
                positions = positions.filter(function(item) {
                    return item !== "";
                });
                if (buttonSubmit == "submit-update-btn") {
                    group_id = $("#group_id").val();
                    data_levels.push({
                        "id":                   $(this).find(".id_edit").val(),
                        "type":                 $(this).find(".level_type").val(),
                        "department_review":    $(this).find(".department_review").val(),
                        "verify_print":         $(this).find(".verify_print").is(":checked") ? 1 : "",
                        "id_positions":         positions
                    });
                }else{
                    data_levels.push({
                        "type":                 $(this).find(".level_type").val(),
                        "department_review":    $(this).find(".department_review").val(),
                        "verify_print":         $(this).find(".verify_print").is(":checked") ? 1 : "",
                        "id_positions":         positions
                    });
                }
            })
            
            $.ajax({
                type: "POST",
                url: submitUrl,
                data: {
                    "group_id":                 group_id,
                    "levels":                   data_levels,
                    "from_amount":              $("#from_amount").val(),
                    "to_amount":                $("#to_amount").val(),
                    "from_location":            $("#from_location").val(),
                    "model_review":             $("#model_review").val(),
                    "branch_id":                $("#branch_id").val(),
                    "request_type":             $("#request_type").val(),
                    "special_fixed_asset":      $(".special_fixed_asset:checked").val(),
                    "reference_type":           $("#reference_type").val(),
                    "description":              $("#description").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status === 200) {
                        new Noty({
                            title: "",
                            text: response.message,
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                        window.location.replace(listUrl);
                    }else{
                        new Noty({
                            title: "",
                            text: response.message,
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                    }
                   
                }
            });
        }else{
            new Noty({
                title: "",
                text: "Please check fiel required",
                type: "error",
                timeout: 3000,
                icon: true
            }).show();
            $("."+buttonSubmit).attr('disabled',false);
            $("#btn-save-loading").css('display', 'none');
            $(".btn-text-save").css("display", 'block');
        }
    });
})