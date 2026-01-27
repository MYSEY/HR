$(document).ready(function() {
    $(document).on("input", ".khmer-toEnglish-number-only", function () {
      let raw = $(this).val();
      raw = raw.replace(/[^០-៩0-9។.]/g, ""); // allow Khmer/English digits and Khmer dot
      const converted = khmerToEnglishNumber(raw);
      $(this).val(converted);
    });

    if ($("#fn_reference").val() && $(".checkbox-group:checked").val() == 1) {
        $("#reviewBtn").css("display", "block");
    }

    totalPaidDollar();
    totalPaidRial();
    $("#fn_approve").on("change", function() {
        let approve_description = $(this).find("option:selected").data("description");
        $("#remark").val(approve_description);
        // $("#remark").val(approve_description);
    });
    document.querySelector('.btn-clear-file').addEventListener('click', function () {
        // Clear file input and fields
        document.getElementById('IrregularFile').value = '';
        document.getElementById('IrregularFileName').value = '';
        document.getElementById('e_fn_invoice').value = '';

        // const input = document.getElementById('IrregularFile');
        // const file = input.files;
        // console.log(file);
    });
    $(".checkbox-group").on("click", function () {
        $("#RI_required").css("display", "none");
        $(".checkbox-group").not(this).prop("checked", false);
        let special_asset = $(".checkbox-group:checked").val();
        $("#special_fixed_asset").css("display", "none");
        $(".checkbox-group-fixed").prop("checked", false);
        if (special_asset =="on" ) {
            $("#special_fixed_asset").css("display", "block");
        }
        if ($(".checkbox-group:checked").length == 0) {
            $("#view-Regular_reference").css("display", "none");
        }else{
            let value = $(this).val();
            $("#IrregularFile").val("");
            $("#IrregularFileName").val("");
            if (value == 1) {
                $("#view-Regular_reference").css("display", "block");
            }else{
                $("#view-Regular_reference").css("display", "none");
            }
        }
    });
    $(".checkbox-group-fixed").on("click", function () {
        $(".checkbox-group-fixed").not(this).prop("checked", false);
    });
    $("#fn_reference").on("change", function() {
        let fileUrl = $(this).find("option:selected").data("file");
        var reviewBtn = document.getElementById("reviewBtn");
        var reviewLink = document.getElementById("reviewLink");
        if (fileUrl) {
            reviewBtn.style.display = "block"; // Show the button
            reviewLink.href = fileUrl; // Set file link to href
        } else {
            reviewBtn.style.display = "none"; // Hide the button if no file exists
            reviewLink.href = "#"; // Reset href
        }
    });
    // $("#fn_subject").on("change", function(){
    //     let value_fn_subject = $(this).val();
    //     $("#fn_reason_subject").text("តបតាមកម្មវត្ថុ និងយោងខាងលើ ខ្ញុំបាទ/នាងខ្ញុំស្នើសុំ "+value_fn_subject);
    // });
    
    $("#addLocations").on("change", function() {
        $("#view-tbl_location").css("display", "block");

        let location_id = $(this).val();
        let location_name = $(this).find("option:selected").data("name");

        // Check if the location is already in the table
        if ($(".tbl-locations input[data-id='" + location_id + "']").length > 0) {
            new Noty({
                title: "",
                text: 'This location is already added.',
                type: "error",
                icon: true,
                timeout: 3000,
            }).show();
            return;
        }

        let tr = `
            <tr class="odd">
                <td class="align-middle">
                    <div class="input-group d-flex justify-content-center">
                        <input type="text" disabled class="form-control" data-id="${location_id}" value="${location_name}">
                    </div>
                </td>
                <td class="align-middle">
                    <div class="input-group d-flex justify-content-center">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control khmer-toEnglish-number-only" placeholder="0.00" aria-label="Amount (to the nearest dollar)">
                    </div>
                </td>
                <td class="align-middle">
                    <div class="input-group d-flex justify-content-center">
                        <span class="input-group-text" style="font-size: 20px">៛</span>
                        <input type="text" placeholder="0" class="form-control khmer-toEnglish-number-only">
                    </div>
                </td>
                <td class="text-center align-middle">
                    <a class="btn btn-danger delete" href="#" data-id="${location_id}">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
        `;

        $(".tbl-locations").append(tr);
    });
    $(document).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).closest("tr").remove();
        if ($(".tbl-locations tr").length === 0) {
            $("#addLocations").val(""); // Reset select
            $("#view-tbl_location").css("display", "none"); // Hide table
        }
    });
    // **** sum  exp  cost dollar ****//
    $(".exp_costs_dollar").on("change", function(){
        let total = 0;
        $(".exp_costs_dollar").each(function() {
            let value = parseFloat($(this).val()) || 0;
            total += value;
        });
        $("#exp_total_cost_dollar").val(total.toFixed(2));
        totalPaidDollar();
    });
    // **** sum  exp  cost rial ****//
    $(".exp_costs_rial").on("change", function(){
        let total = 0;
        $(".exp_costs_rial").each(function() {
            let value = parseFloat($(this).val()) || 0;
            total += value;
        });
        $("#exp_total_cost_rial").val(total);
        totalPaidRial();
    });
    // **** in clude tax WHT ****//
    $(".action_tax_wht_dollar").on("click", function() {
        let tax = $(this).data("tax");
        let exp_LSOC = $("#exp_LSOC_dollar").val();
        let amount = 0;
        if (exp_LSOC) {
            amount = ((exp_LSOC*tax)/100);
        }
        if (tax) {
            $("#withholding_tax_text_usd").text(tax);
        }
        $("#exp_tax_wht_dollar").val(amount);
        totalPaidDollar();
    });
    $(".action_tax_wht_rial").on("click", function() {
        let tax = $(this).data("tax");
        let exp_LSOC = $("#exp_LSOC_rial").val();
        let amount = 0;
        if (exp_LSOC) {
            amount = ((exp_LSOC*tax)/100);
        }
        if (tax) {
            $("#withholding_tax_text_riel").text(tax);
        }
        $("#exp_tax_wht_rial").val(amount);
        totalPaidRial();
    });
    // **** in clude tax WBT ****//
    $(".action_tax_wbt_dollar").on("click", function() {
        let tax = $(this).data("tax");
        let exp_total_cost = $("#exp_total_cost_dollar").val();
        if (exp_total_cost) {
            amount = ((exp_total_cost*tax)/100);
        }
        if (tax) {
            $("#exp_tax_wbt_text_usd").text(tax);
        }
        $("#exp_tax_wbt_dollar").val(amount);
        totalPaidDollar();
    });
    $(".action_tax_wbt_rial").on("click", function() {
        let tax = $(this).data("tax");
        let exp_total_cost = $("#exp_total_cost_rial").val();
        if (exp_total_cost) {
            amount = ((exp_total_cost*tax)/100);
        }
        if (tax) {
            $("#exp_tax_wbt_text_riel").text(tax);
        }
        $("#exp_tax_wbt_rial").val(amount);
        totalPaidRial();
    });
    // **** exp total paid dollar ****//
    $(".exp_total_paid").on("change", function(){
        totalPaidDollar();

        let taxpaid = $(this).data("taxpaid");
        if(taxpaid == 1){
            $("#withholding_tax_text_usd").text("");
        }
        if(taxpaid == 3){
            $("#exp_tax_wbt_text_usd").text("");
        }
        
    });
    $(".exp_total_paid_rial").on("change", function(){
        totalPaidRial();
        let taxpaid = $(this).data("taxpaid");
        if(taxpaid == 2){
            $("#withholding_tax_text_riel").text("");
        }
        if(taxpaid == 4){
            $("#exp_tax_wbt_text_riel").text("");
        }
    });

    // **** Submit request Expense ****//
    $("." + buttonSubmit).on("click", function() {
        totalPaidDollar();
        totalPaidRial();
        $("." + buttonSubmit).attr('disabled',true);
        $(".loading-icon").css("display", "block");
        $(".btn-txt").css("display", "none");
        let type = $("#exp-type:checked").length;
        let expense_type = $(".checkbox-group:checked").val() || 0;
        let fn_reference = "";
        let form_data = new FormData(); // Use FormData for file uploads

        if ($("#fn_id").val()) {
            form_data.append("id", $("#fn_id").val());
            form_data.append("e_fn_invoice", $("#e_fn_invoice").val());
            form_data.append("old_file_name", $("#IrregularFileName").val());
        }''
        let num_miss = 0;
        $(".hr-form-group-select2").each(function(){
            let formGroup = $(this);
            let requeredField = formGroup.find(".hr-select2-option").val();
            let requered = formGroup.find(".required").val();
            if(requeredField == null){ 
                num_miss++;
                formGroup.find(".select2-selection--single").css("border-color","#dc3545");
            }else if (!requeredField && requered == "") {
                formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                num_miss++;
            }
        });
        $(".fn_require").each(function() {
            if($(this).val()==""){ 
                num_miss++;
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
            }else{
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            }
        });
        
        if ($(".checkbox-group:checked").length == 0) {
            $("#RI_required").css("display", "block");
            num_miss++;
        }

        // Handle Regular vs. Irregular Expense Reference
        if (expense_type == 1) {
            $("#IrregularFileName").css("border-color","#198754");
            fn_reference = $("#fn_reference").val();
            if ((fn_reference == "" || fn_reference == null) && ($("#IrregularFileName").val() == "" || $("#IrregularFileName").val() == null)) {
                num_miss++;
                $("#fn_reference").css("border-color","#dc3545");
                $("#IrregularFileName").css("border-color","#dc3545");
                $(".hr-form-group-fn-select2").each(function(){
                    let formGroup = $(this);
                    let requeredField = formGroup.find(".hr-select2-option").val();
                    let requered = formGroup.find(".fn_reference_require").val();
                    if(requeredField == null){ 
                        num_miss++;
                        formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                    }else if (!requeredField && requered == "") {
                        formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                        num_miss++;
                    }
                });
            }else{
                $(".hr-form-group-fn-select2").each(function(){
                    let formGroup = $(this);
                    formGroup.find(".select2-selection--single").css("border-color","#198754");
                });
                $("#fn_reference").css("border-color","#198754");
                form_data.append("fn_reference", fn_reference);
                let attachment = $('#IrregularFile').prop('files')[0];
                let fileSize = attachment ? (attachment['size'] / 1024) : "";
                if (fileSize > 10240) {
                    new Noty({
                        title: "",
                        text: 'Please check file size less than or equal to 10MB.',
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                    setTimeout(function () {
                        $("." + buttonSubmit).attr('disabled',false);
                        $(".loading-icon").css("display", "none");
                        $(".btn-txt").css("display", "block");
                    }, 500);
                    return false;
                }
                let fileInput = $('#IrregularFile')[0];
                if (fileInput.files.length > 0) {
                    let file_data = fileInput.files[0];
                    form_data.append("fn_invoice", file_data);
                }
            }
        } else {
            if (($("#IrregularFileName").val() == "" || $("#IrregularFileName").val() == null) && type == 0) {
                $("#IrregularFileName").css("border-color","#dc3545");
                $("#RI_required").css("display","block");
                if (expense_type == 0 && type == 0) {
                    $("#RI_required").text("Please select any checkbox to request.");
                }else{
                    $("#RI_required").text("Please to choose a file first.");
                }
                num_miss++;
            }else{
                $("#RI_required").css("display","none");
                $("#IrregularFileName").css("border-color","#198754");
                let attachment = $('#IrregularFile').prop('files')[0];
                let fileSize = attachment ? (attachment['size'] / 1024) : "";
                if (fileSize > 10240) {
                    new Noty({
                        title: "",
                        text: 'Please check file size less than or equal to 10MB.',
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                    setTimeout(function () {
                        $("." + buttonSubmit).attr('disabled',false);
                        $(".loading-icon").css("display", "none");
                        $(".btn-txt").css("display", "block");
                    }, 500);
                    return false;
                }
                let fileInput = $('#IrregularFile')[0];
                if (fileInput.files.length > 0) {
                    let file_data = fileInput.files[0];
                    form_data.append("fn_invoice", file_data);
                }
            }
        }
        // Get locations data
        let locations = [];
        let num_bybranchs = 0;
        $(".tbl-locations tr").each(function() {
            let location_id = $(this).find("input[data-id]").data("id"); // Get data-id
            let amount_usd = $(this).find("td:nth-child(2) input").val();
            let amount_kh = $(this).find("td:nth-child(3) input").val();
            if ((amount_usd == "" || amount_usd == 0) && (amount_kh == "" || amount_kh == 0)) {
                $(this).find("td:nth-child(2) input").css("border-color","#dc3545");
                $(this).find("td:nth-child(3) input").css("border-color","#dc3545");
                num_miss++;
                num_bybranchs++;
                // return;
            }else{
                $(this).find("td:nth-child(2) input").css("border-color","#198754");
                $(this).find("td:nth-child(3) input").css("border-color","#198754");
            }
            locations.push({
                id: location_id,
                amount_usd: amount_usd || 0,
                amount_kh: amount_kh || 0
            });
        });
        if (num_bybranchs > 0) {
            new Noty({
                title: "",
                text: "Please input amount USD or amount Kh by branchs",
                type: "error",
                timeout: 3000,
                icon: true
            }).show();
        }
        // costs include required
        let costs_required = 0;
        $(".costs_include_required").each(function () {
            let value = $(this).val();
            if (!value || value==0) {
                costs_required = 1;
            } else {
                costs_required = 0;
                return false;
            }
        });

        if (costs_required === 1) {
            $(".costs_include_required").css("border-color","#dc3545");
            $("#include_required").css("display","block");
            num_miss++;
        } else {
            $(".costs_include_required").css("border-color","#198754");
            $("#include_required").css("display","none");
        }

        // Get payment terms
        let paymentTerms = '';
        $('.fn_paymentterm option:selected').each(function() {
            var value = $(this).val();
            if (value) {
                paymentTerms += value+",";
            }
        });

        if ($("#paymentterm_remark").val()) {
            if (paymentTerms) {
                paymentTerms =  paymentTerms+$("#paymentterm_remark").val();
            }else{
                paymentTerms = $("#paymentterm_remark").val();
            }
        }
        // required payment terms
        if (paymentTerms == "") {
            $("#paymentterm_required").css("display", "block");
            num_miss++;
        }else{
            $("#paymentterm_required").css("display", "none");
        }
        let approved = $("#fn_approve").find("option:selected").data("approved");
        let approved_id = $("#fn_approve").find("option:selected").data("id");
        // Validate
        if (num_miss>0) {
            setTimeout(function () {
                $("." + buttonSubmit).attr('disabled',false);
                $(".loading-icon").css("display", "none");
                $(".btn-txt").css("display", "block");
            }, 500);
            return false;
        }else{
            // Function to get field values (fallback to 0)
            let special_fixed_asset = $(".special_fixed_asset:checked").val();

            const withholding_tax_text_usd = $("#withholding_tax_text_usd").text();
            const withholding_tax_text_riel = $("#withholding_tax_text_riel").text();
            const exp_tax_wbt_text_usd = $("#exp_tax_wbt_text_usd").text();
            const exp_tax_wbt_text_riel = $("#exp_tax_wbt_text_riel").text();

            let getVal = (id) => $("#" + id).val() || 0;
            // Append other form fields
            form_data.append("type", type);
            form_data.append("approve_by", approved);
            form_data.append("approved_id", approved_id);
            form_data.append("expense_type", expense_type);
            form_data.append("special_asset", special_fixed_asset);
            form_data.append("kind_regard", getVal("fn_approve"));
            form_data.append("subject", getVal("fn_subject"));
            form_data.append("reason_subject", getVal("fn_reason_subject"));
            form_data.append("locations", JSON.stringify(locations)); // Convert array to JSON
            form_data.append("paymentTerms", paymentTerms);
            form_data.append("ge_cost_material_usd", getVal("exp_costs_dollar"));
            form_data.append("ge_cost_material_riel", getVal("exp_costs_rial"));
            form_data.append("ge_cost_lso_usd", getVal("exp_LSOC_dollar"));
            form_data.append("ge_cost_lso_riel", getVal("exp_LSOC_rial"));
            form_data.append("ge_total_cost_usd", getVal("exp_total_cost_dollar"));
            form_data.append("ge_total_cost_riel", getVal("exp_total_cost_rial"));
            form_data.append("percentage_tax_wht_usd", withholding_tax_text_usd);
            form_data.append("percentage_tax_wht_riel", withholding_tax_text_riel);
            form_data.append("ge_tax_usd", getVal("exp_tax_wht_dollar"));
            form_data.append("tax_riel", getVal("exp_tax_wht_rial"));
            form_data.append("percentage_tax_wbt_usd", exp_tax_wbt_text_usd);
            form_data.append("percentage_tax_wbt_riel", exp_tax_wbt_text_riel);
            form_data.append("ge_tax_fringe_benefit_usd", getVal("exp_tax_wbt_dollar"));
            form_data.append("tax_fringe_benefit_riel", getVal("exp_tax_wbt_rial"));
            form_data.append("ge_vat_reverse_charge_usd", getVal("exp_reverse_charge_usd"));
            form_data.append("vat_reverse_charge_riel", getVal("exp_reverse_charge_rial"));
            form_data.append("ge_total_amount_usd", getVal("exp_total_paid_dollar"));
            form_data.append("ge_total_amount_riel", getVal("exp_total_paid_rial"));
            form_data.append("remark", getVal("remark"));
            form_data.append("request_by", getVal("fn_request_by"));
            form_data.append("_token", $('meta[name="csrf-token"]').attr("content"));
            // AJAX Request
            $.ajax({
                type: "POST",
                url: expenseRequestUrl,
                data: form_data,
                processData: false,  // Prevent jQuery from processing data
                contentType: false,  // Set content type to false (for file upload)
                dataType: "JSON",
                success: function(response) {
                    if (response.status == 200) {
                        $("." + buttonSubmit).attr('disabled',false);
                        $(".loading-icon").css("display", "none");
                        $(".btn-txt").css("display", "block");
                        new Noty({
                            title: "",
                            text: 'Create successfully',
                            type: "success",
                            icon: true
                        }).show();
                        window.location.replace(expenseRequestListUrl);
                    }
                    if(response.status == 405){
                        $("#fn_approve")
                        .next(".select2-container")
                        .find(".select2-selection--single")
                        .css("border", "1px solid #dc3545");
                        new Noty({
                            title: "",
                            text: response.error,
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                        setTimeout(function () {
                            $("." + buttonSubmit).attr('disabled',false);
                            $(".loading-icon").css("display", "none");
                            $(".btn-txt").css("display", "block");
                        }, 500);
                    }
                    if(response.status == 404){
                        new Noty({
                            title: "",
                            text: 'Please contact the finance team to set up a level review.',
                            type: "error",
                            timeout: 3000,
                            icon: true
                        }).show();
                        setTimeout(function () {
                            $("." + buttonSubmit).attr('disabled',false);
                            $(".loading-icon").css("display", "none");
                            $(".btn-txt").css("display", "block");
                        }, 500);
                    }
                }
            });
        }
    });

});
function totalPaidDollar(){
    $(".costs_include_required").css("border-color","#198754");
    $("#include_required").css("display","none");
    let total_cost = 0;
        let total_cost_dollar = $("#exp_total_cost_dollar").val();
        $(".exp_total_paid").each(function() {
            let value = parseFloat($(this).val()) || 0;
            total_cost += value;
        });
        let total_paid = 0;
        if (total_cost_dollar) {
            total_paid = (total_cost_dollar - total_cost);
        }

        $("#exp_total_paid_dollar").val(total_paid.toFixed(2));
        let convertPaid = total_paid.toFixed(2);
        if (total_paid == 0) {
            $("#convert_money_dollar").text("");
        }else{
            let price_to_word = convertNumberToWordsExp(convertPaid,"dollar");
            $("#convert_money_dollar").text(price_to_word);
        }
        
}
function totalPaidRial(){
    $(".costs_include_required").css("border-color","#198754");
    $("#include_required").css("display","none");
    let total_cost = 0;
        let total_cost_dollar = $("#exp_total_cost_rial").val();
        $(".exp_total_paid_rial").each(function() {
            let value = parseFloat($(this).val()) || 0;
            total_cost += value;
        });
        let total_paid = 0;
        if (total_cost_dollar) {
            total_paid = (total_cost_dollar - total_cost);
        }

        $("#exp_total_paid_rial").val(total_paid.toFixed(2));
        let price_to_word = convertNumberToWordsExp(total_paid,"rial");
        $("#convert_money_rial").text(price_to_word);
}
function openFileInNewTab() {
    const input = document.getElementById('IrregularFile');
    const file = input.files[0];
    console.log(file);
    if (file) {
        const fileURL = URL.createObjectURL(file);
        window.open(fileURL, '_blank');
    } else {
        new Noty({
            title: "",
            text: "Please select a file first.",
            type: "error",
            timeout: 3000,
            icon: true
        }).show();
    }
}
function updateFileName(input) {
    if (input.files.length > 0) {
        document.getElementById('IrregularFileName').value = input.files[0].name;
    }
}