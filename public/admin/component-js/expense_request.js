// ================= ================= =================
// 0. HELPER FUNCTIONS FOR NUMBER CLEANING & FORMATTING
// ================= ================= =================

// ១. បំប្លែង Selector / jQuery / DOM / String ឲ្យទៅជាលេខ Float សុទ្ធ
function parseNum(val) {
    if (!val) return 0;
    
    if (typeof val === 'string' && (val.startsWith('#') || val.startsWith('.'))) {
        val = $(val).val();
    } 
    else if (val instanceof jQuery) {
        val = val.val();
    } 
    else if (typeof val === 'object' && val.value !== undefined) {
        val = val.value;
    }
    
    if (!val) return 0;
    
    let clean = val.toString().replace(/,/g, '');
    return parseFloat(clean) || 0;
}

// ២. Format លេខសុទ្ធ ឲ្យមានក្បៀស (Comma)
function formatWithComma(val) {
    if (val === undefined || val === null || val === '') return '';
    let parts = val.toString().split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
}

// ៣. បំប្លែងលេខខ្មែរ ទៅ លេខអង់គ្លេស
function khmerToEnglishNumber(str) {
    if (!str) return "";
    const khmerNumbers = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
    return str.toString().replace(/[០-៩]/g, function (w) {
        return khmerNumbers.indexOf(w);
    });
}

// ================= ================= =================
// MAIN DOCUMENT READY
// ================= ================= =================
$(document).ready(function() {

    // ១. AUTO-FORMAT ទិន្នន័យចាស់ពេលបើកទំព័រ EDIT & RE-CALCULATE
    initExpenseForm();

    // FORMAT INPUT WITH KHMER TO ENGLISH & THOUSAND SEPARATOR
    $(document).on("input", ".khmer-toEnglish-number-only", function () {
        let raw = $(this).val();
        raw = raw.replace(/[^០-៩0-9។.]/g, "");
        let converted = khmerToEnglishNumber(raw);

        let parts = converted.split('.');
        if (parts.length > 2) {
            converted = parts[0] + '.' + parts.slice(1).join('');
            parts = converted.split('.');
        }

        // រក្សាទុកលេខសុទ្ធ (គ្មានក្បៀស) ទៅក្នុង data-raw
        $(this).attr('data-raw', converted);

        // បង្ហាញលេខមានក្បៀសលើ UI
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $(this).val(parts.join('.'));
    });

    if ($("#fn_reference").val() && $(".checkbox-group:checked").val() == 1) {
        $("#reviewBtn").css("display", "block");
    }

    $("#fn_approve").on("change", function() {
        let approve_description = $(this).find("option:selected").data("description");
        $("#remark").val(approve_description);
    });

    document.querySelector('.btn-clear-file')?.addEventListener('click', function () {
        document.getElementById('IrregularFile').value = '';
        document.getElementById('IrregularFileName').value = '';
        document.getElementById('e_fn_invoice').value = '';
    });

    $(".checkbox-group").on("click", function () {
        $("#RI_required").css("display", "none");
        $(".checkbox-group").not(this).prop("checked", false);
        let special_asset = $(".checkbox-group:checked").val();
        $("#special_fixed_asset").css("display", "none");
        $(".checkbox-group-fixed").prop("checked", false);
        if (special_asset == "on" ) {
            $("#special_fixed_asset").css("display", "block");
        }
        if ($(".checkbox-group:checked").length == 0) {
            $("#view-Regular_reference").css("display", "none");
        } else {
            let value = $(this).val();
            $("#IrregularFile").val("");
            $("#IrregularFileName").val("");
            if (value == 1) {
                $("#view-Regular_reference").css("display", "block");
            } else {
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
            reviewBtn.style.display = "block";
            reviewLink.href = fileUrl;
        } else {
            reviewBtn.style.display = "none";
            reviewLink.href = "#";
        }
    });

    $("#addLocations").on("change", function() {
        $("#view-tbl_location").css("display", "block");

        let location_id = $(this).val();
        let location_name = $(this).find("option:selected").data("name");

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
            $("#addLocations").val("");
            $("#view-tbl_location").css("display", "none");
        }
    });

    // **** SUM EXP COST DOLLAR **** //
    $(document).on("input change", ".exp_costs_dollar", function(){
        let total = 0;
        $(".exp_costs_dollar").each(function() {
            total += parseNum($(this));
        });
        $("#exp_total_cost_dollar").val(formatWithComma(total.toFixed(2)));
        totalPaidDollar();
    });

    // **** SUM EXP COST RIAL **** //
    $(document).on("input change", ".exp_costs_rial", function(){
        let total = 0;
        $(".exp_costs_rial").each(function() {
            total += parseNum($(this));
        });
        $("#exp_total_cost_rial").val(formatWithComma(total.toFixed(2)));
        totalPaidRial();
    });

    // **** INCLUDE TAX WHT **** //
    $(".action_tax_wht_dollar").on("click", function() {
        let tax = parseNum($(this).data("tax"));
        let exp_LSOC = parseNum($("#exp_LSOC_dollar"));
        let amount = 0;
        if (exp_LSOC) {
            amount = ((exp_LSOC * tax) / 100);
        }
        if (tax) {
            $("#withholding_tax_text_usd").text(tax);
        }
        $("#exp_tax_wht_dollar").val(formatWithComma(amount.toFixed(2)));
        totalPaidDollar();
    });

    $(".action_tax_wht_rial").on("click", function() {
        let tax = parseNum($(this).data("tax"));
        let exp_LSOC = parseNum($("#exp_LSOC_rial"));
        let amount = 0;
        if (exp_LSOC) {
            amount = ((exp_LSOC * tax) / 100);
        }
        if (tax) {
            $("#withholding_tax_text_riel").text(tax);
        }
        $("#exp_tax_wht_rial").val(formatWithComma(amount.toFixed(2)));
        totalPaidRial();
    });

    // **** INCLUDE TAX WBT **** //
    $(".action_tax_wbt_dollar").on("click", function() {
        let tax = parseNum($(this).data("tax"));
        let exp_total_cost = parseNum($("#exp_total_cost_dollar"));
        let amount = 0;
        if (exp_total_cost) {
            amount = ((exp_total_cost * tax) / 100);
        }
        if (tax) {
            $("#exp_tax_wbt_text_usd").text(tax);
        }
        $("#exp_tax_wbt_dollar").val(formatWithComma(amount.toFixed(2)));
        totalPaidDollar();
    });

    $(".action_tax_wbt_rial").on("click", function() {
        let tax = parseNum($(this).data("tax"));
        let exp_total_cost = parseNum($("#exp_total_cost_rial"));
        let amount = 0;
        if (exp_total_cost) {
            amount = ((exp_total_cost * tax) / 100);
        }
        if (tax) {
            $("#exp_tax_wbt_text_riel").text(tax);
        }
        $("#exp_tax_wbt_rial").val(formatWithComma(amount.toFixed(2)));
        totalPaidRial();
    });

    // **** EXP TOTAL PAID DOLLAR **** //
    $(".exp_total_paid").on("change input", function(){
        totalPaidDollar();

        let taxpaid = $(this).data("taxpaid");
        if(taxpaid == 1){
            $("#withholding_tax_text_usd").text("");
        }
        if(taxpaid == 3){
            $("#exp_tax_wbt_text_usd").text("");
        }
    });

    $(".exp_total_paid_rial").on("change input", function(){
        totalPaidRial();
        let taxpaid = $(this).data("taxpaid");
        if(taxpaid == 2){
            $("#withholding_tax_text_riel").text("");
        }
        if(taxpaid == 4){
            $("#exp_tax_wbt_text_riel").text("");
        }
    });

    // **** SUBMIT REQUEST EXPENSE **** //
    $(document).on("click", "." + buttonSubmit, function() {
        totalPaidDollar();
        totalPaidRial();
        $("." + buttonSubmit).attr('disabled', true);
        $(".loading-icon").css("display", "block");
        $(".btn-txt").css("display", "none");
        let type = $("#exp-type:checked").length;
        let expense_type = $(".checkbox-group:checked").val() || 0;
        let fn_reference = "";
        let form_data = new FormData();

        if ($("#fn_id").val()) {
            form_data.append("id", $("#fn_id").val());
            form_data.append("e_fn_invoice", $("#e_fn_invoice").val());
            form_data.append("old_file_name", $("#IrregularFileName").val());
        }

        let num_miss = 0;
        $(".hr-form-group-select2").each(function(){
            let formGroup = $(this);
            let requeredField = formGroup.find(".hr-select2-option").val();
            let requered = formGroup.find(".required").val();
            if(requeredField == null){ 
                num_miss++;
                formGroup.find(".select2-selection--single").css("border-color","#dc3545");
            } else if (!requeredField && requered == "") {
                formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                num_miss++;
            }
        });

        $(".fn_require").each(function() {
            if($(this).val() == ""){ 
                num_miss++;
                $(this).addClass("is-invalid").removeClass("is-valid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        
        if ($(".checkbox-group:checked").length == 0) {
            $("#RI_required").css("display", "block");
            num_miss++;
        }

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
                    } else if (!requeredField && requered == "") {
                        formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                        num_miss++;
                    }
                });
            } else {
                $(".hr-form-group-fn-select2").each(function(){
                    $(this).find(".select2-selection--single").css("border-color","#198754");
                });
                $("#fn_reference").css("border-color","#198754");
                form_data.append("fn_reference", fn_reference);
                let attachment = $('#IrregularFile').prop('files')[0];
                let fileSize = attachment ? (attachment['size'] / 1024) : "";
                if (fileSize > 10240) {
                    new Noty({
                        title: "", text: 'Please check file size less than or equal to 10MB.',
                        type: "error", timeout: 3000, icon: true
                    }).show();
                    setTimeout(function () {
                        $("." + buttonSubmit).attr('disabled', false);
                        $(".loading-icon").css("display", "none");
                        $(".btn-txt").css("display", "block");
                    }, 500);
                    return false;
                }
                let fileInput = $('#IrregularFile')[0];
                if (fileInput && fileInput.files.length > 0) {
                    form_data.append("fn_invoice", fileInput.files[0]);
                }
            }
        } else {
            if (($("#IrregularFileName").val() == "" || $("#IrregularFileName").val() == null) && type == 0) {
                $("#IrregularFileName").css("border-color","#dc3545");
                $("#RI_required").css("display","block");
                if (expense_type == 0 && type == 0) {
                    $("#RI_required").text("Please select any checkbox to request.");
                } else {
                    $("#RI_required").text("Please to choose a file first.");
                }
                num_miss++;
            } else {
                $("#RI_required").css("display","none");
                $("#IrregularFileName").css("border-color","#198754");
                let attachment = $('#IrregularFile').prop('files')[0];
                let fileSize = attachment ? (attachment['size'] / 1024) : "";
                if (fileSize > 10240) {
                    new Noty({
                        title: "", text: 'Please check file size less than or equal to 10MB.',
                        type: "error", timeout: 3000, icon: true
                    }).show();
                    setTimeout(function () {
                        $("." + buttonSubmit).attr('disabled', false);
                        $(".loading-icon").css("display", "none");
                        $(".btn-txt").css("display", "block");
                    }, 500);
                    return false;
                }
                let fileInput = $('#IrregularFile')[0];
                if (fileInput && fileInput.files.length > 0) {
                    form_data.append("fn_invoice", fileInput.files[0]);
                }
            }
        }

        // Get locations data (CLEANED COMMAS BEFORE SAVE)
        let locations = [];
        let num_bybranchs = 0;
        $(".tbl-locations tr").each(function() {
            let location_id = $(this).find("input[data-id]").data("id");
            let amount_usd = parseNum($(this).find("td:nth-child(2) input"));
            let amount_kh = parseNum($(this).find("td:nth-child(3) input"));
            
            if (amount_usd == 0 && amount_kh == 0) {
                $(this).find("td:nth-child(2) input").css("border-color","#dc3545");
                $(this).find("td:nth-child(3) input").css("border-color","#dc3545");
                num_miss++;
                num_bybranchs++;
            } else {
                $(this).find("td:nth-child(2) input").css("border-color","#198754");
                $(this).find("td:nth-child(3) input").css("border-color","#198754");
            }
            locations.push({
                id: location_id,
                amount_usd: amount_usd,
                amount_kh: amount_kh
            });
        });

        if (num_bybranchs > 0) {
            new Noty({
                title: "", text: "Please input amount USD or amount Kh by branchs",
                type: "error", timeout: 3000, icon: true
            }).show();
        }

        // Costs include required validation
        let costs_required = 0;
        $(".costs_include_required").each(function () {
            let value = parseNum($(this));
            if (value == 0) {
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

        let paymentTerms = '';
        $('.fn_paymentterm option:selected').each(function() {
            var value = $(this).val();
            if (value) paymentTerms += value + ",";
        });

        if ($("#paymentterm_remark").val()) {
            paymentTerms = paymentTerms ? (paymentTerms + $("#paymentterm_remark").val()) : $("#paymentterm_remark").val();
        }

        if (paymentTerms == "") {
            $("#paymentterm_required").css("display", "block");
            num_miss++;
        } else {
            $("#paymentterm_required").css("display", "none");
        }

        let approved = $("#fn_approve").find("option:selected").data("approved");
        let approved_id = $("#fn_approve").find("option:selected").data("id");

        if (num_miss > 0) {
            setTimeout(function () {
                $("." + buttonSubmit).attr('disabled', false);
                $(".loading-icon").css("display", "none");
                $(".btn-txt").css("display", "block");
            }, 500);
            return false;
        } else {
            let special_fixed_asset = $(".special_fixed_asset:checked").val();
            const withholding_tax_text_usd = $("#withholding_tax_text_usd").text();
            const withholding_tax_text_riel = $("#withholding_tax_text_riel").text();
            const exp_tax_wbt_text_usd = $("#exp_tax_wbt_text_usd").text();
            const exp_tax_wbt_text_riel = $("#exp_tax_wbt_text_riel").text();

            // APPEND RAW NUMBERS (NO COMMAS) TO SERVER / DATABASE
            form_data.append("type", type);
            form_data.append("approve_by", approved);
            form_data.append("approved_id", approved_id);
            form_data.append("expense_type", expense_type);
            form_data.append("special_asset", special_fixed_asset);
            form_data.append("kind_regard", $("#fn_approve").val() || 0);
            form_data.append("subject", $("#fn_subject").val() || "");
            form_data.append("reason_subject", $("#fn_reason_subject").val() || "");
            form_data.append("locations", JSON.stringify(locations));
            form_data.append("paymentTerms", paymentTerms);

            form_data.append("ge_cost_material_usd", parseNum("#exp_costs_dollar"));
            form_data.append("ge_cost_material_riel", parseNum("#exp_costs_rial"));
            form_data.append("ge_cost_lso_usd", parseNum("#exp_LSOC_dollar"));
            form_data.append("ge_cost_lso_riel", parseNum("#exp_LSOC_rial"));
            form_data.append("ge_total_cost_usd", parseNum("#exp_total_cost_dollar"));
            form_data.append("ge_total_cost_riel", parseNum("#exp_total_cost_rial"));
            form_data.append("percentage_tax_wht_usd", withholding_tax_text_usd);
            form_data.append("percentage_tax_wht_riel", withholding_tax_text_riel);
            form_data.append("ge_tax_usd", parseNum("#exp_tax_wht_dollar"));
            form_data.append("tax_riel", parseNum("#exp_tax_wht_rial"));
            form_data.append("percentage_tax_wbt_usd", exp_tax_wbt_text_usd);
            form_data.append("percentage_tax_wbt_riel", exp_tax_wbt_text_riel);
            form_data.append("ge_tax_fringe_benefit_usd", parseNum("#exp_tax_wbt_dollar"));
            form_data.append("tax_fringe_benefit_riel", parseNum("#exp_tax_wbt_rial"));
            form_data.append("ge_vat_reverse_charge_usd", parseNum("#exp_reverse_charge_usd"));
            form_data.append("vat_reverse_charge_riel", parseNum("#exp_reverse_charge_rial"));
            form_data.append("ge_total_amount_usd", parseNum("#exp_total_paid_dollar"));
            form_data.append("ge_total_amount_riel", parseNum("#exp_total_paid_rial"));

            form_data.append("remark", $("#remark").val() || "");
            form_data.append("request_by", $("#fn_request_by").val() || "");
            form_data.append("_token", $('meta[name="csrf-token"]').attr("content"));

            // AJAX Request
            $.ajax({
                type: "POST",
                url: expenseRequestUrl,
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(response) {
                    if (response.status == 200) {
                        $("." + buttonSubmit).attr('disabled', false);
                        $(".loading-icon").css("display", "none");
                        $(".btn-txt").css("display", "block");
                        new Noty({
                            title: "", text: 'Create successfully',
                            type: "success", icon: true
                        }).show();
                        window.location.replace(expenseRequestListUrl);
                    }
                    if(response.status == 405){
                        $("#fn_approve").next(".select2-container").find(".select2-selection--single").css("border", "1px solid #dc3545");
                        new Noty({
                            title: "", text: response.error,
                            type: "error", timeout: 3000, icon: true
                        }).show();
                        setTimeout(function () {
                            $("." + buttonSubmit).attr('disabled', false);
                            $(".loading-icon").css("display", "none");
                            $(".btn-txt").css("display", "block");
                        }, 500);
                    }
                    if(response.status == 404){
                        new Noty({
                            title: "", text: 'Please contact the finance team to set up a level review.',
                            type: "error", timeout: 3000, icon: true
                        }).show();
                        setTimeout(function () {
                            $("." + buttonSubmit).attr('disabled', false);
                            $(".loading-icon").css("display", "none");
                            $(".btn-txt").css("display", "block");
                        }, 500);
                    }
                }
            });
        }
    });

});

// ================= ================= =================
// CALCULATION & INITIALIZATION FUNCTIONS
// ================= ================= =================

// Function សម្រាប់ Format ទិន្នន័យចាស់ទាំងអស់នៅលើ Input ពេល Load View Edit
function initExpenseForm() {
    $(".khmer-toEnglish-number-only").each(function () {
        let val = $(this).val();
        if (val !== "" && val !== null && !isNaN(parseNum(val))) {
            let num = parseNum(val);
            let formatted = formatWithComma(num);
            $(this).val(formatted);
            $(this).attr('data-raw', num);
        }
    });

    // គណនា Total Costs និង Total Paid ឡើងវិញពេល Load ទិន្នន័យដំបូង
    $(".exp_costs_dollar").first().trigger("change");
    $(".exp_costs_rial").first().trigger("change");
    totalPaidDollar();
    totalPaidRial();
}

function totalPaidDollar(){
    $(".costs_include_required").css("border-color","#198754");
    $("#include_required").css("display","none");
    
    let total_cost = 0;
    // parseNum ឥឡូវស្គាល់ string selector "#exp_total_cost_dollar" ហើយ
    let total_cost_dollar = parseNum("#exp_total_cost_dollar");
    
    $(".exp_total_paid").each(function() {
        total_cost += parseNum($(this));
    });
    
    let total_paid = 0;
    if (total_cost_dollar) {
        total_paid = (total_cost_dollar - total_cost);
    }

    $("#exp_total_paid_dollar").val(formatWithComma(total_paid.toFixed(2)));
    
    let convertPaid = total_paid.toFixed(2);
    if (total_paid == 0) {
        $("#convert_money_dollar").text("");
    } else {
        let price_to_word = convertNumberToWordsExp(convertPaid, "dollar");
        $("#convert_money_dollar").text(price_to_word);
    }
}

function totalPaidRial(){
    $(".costs_include_required").css("border-color","#198754");
    $("#include_required").css("display","none");
    
    let total_cost = 0;
    let total_cost_rial = parseNum("#exp_total_cost_rial");
    
    $(".exp_total_paid_rial").each(function() {
        total_cost += parseNum($(this));
    });
    
    let total_paid = 0;
    if (total_cost_rial) {
        total_paid = (total_cost_rial - total_cost);
    }

    $("#exp_total_paid_rial").val(formatWithComma(total_paid.toFixed(2)));
    
    // បន្ថែមលក្ខខណ្ឌបើ 0 ឲ្យលុបអក្សរចេញដូច dollar ដែរ
    if (total_paid == 0) {
        $("#convert_money_rial").text("");
    } else {
        let price_to_word = convertNumberToWordsExp(total_paid.toFixed(2), "rial");
        $("#convert_money_rial").text(price_to_word);
    }
}
function openFileInNewTab() {
    const input = document.getElementById('IrregularFile');
    if (input && input.files[0]) {
        const fileURL = URL.createObjectURL(input.files[0]);
        window.open(fileURL, '_blank');
    } else {
        new Noty({
            title: "", text: "Please select a file first.",
            type: "error", timeout: 3000, icon: true
        }).show();
    }
}

function updateFileName(input) {
    const fileNameDisplay = document.getElementById('IrregularFileName');
    const reviewBtn = document.getElementById('reviewFileBtn');
    const previewLink = document.getElementById('filePreviewLink');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (fileNameDisplay) fileNameDisplay.value = file.name;
        const blobUrl = URL.createObjectURL(file);
        if (previewLink) previewLink.href = blobUrl;
        if (reviewBtn) reviewBtn.style.display = "inline-block";
    }
}

function clearAll() {
    const fileInput = document.getElementById('IrregularFile');
    const fileName = document.getElementById('IrregularFileName');
    const invoice = document.getElementById('e_fn_invoice');
    
    if (fileInput) fileInput.value = ""; 
    if (fileName) fileName.value = "";
    if (invoice) invoice.value = "";
    
    const reviewBtn = document.getElementById('reviewFileBtn');
    if (reviewBtn) reviewBtn.style.display = "none";
    const previewLink = document.getElementById('filePreviewLink');
    if (previewLink) previewLink.href = "#";
}