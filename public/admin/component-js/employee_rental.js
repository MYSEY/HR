// កំណត់ Base URL ជា Global ដោយស្វ័យប្រវត្តិ (ករណីមិនបានបញ្ជូនមកពី Blade)
// var appBaseUrl = window.appUrl || window.location.origin;

$(function () {
    $(document).ready(function () {
        // ឆែកមើលថាបើមាន #rental_id (ទំព័រ Edit) ឱ្យ Call តែ Edit Function
        if ($('#rental_id').length > 0 && $('#rental_id').val() !== "") {
            loadDynamicFormsForEdit();
        } else {
            // បើគ្មាន #rental_id ទេ (ទំព័រ Create New) ឱ្យ Call តែ Create Function
            loadDynamicForms();
        }
    });
    $(document).on("change", ".action-dynamic-select", function() {
        let $selectedOption = $(this).find('option:selected');
        
        // ទាញយកតម្លៃ value និង data-name
        let selectedVal = String($(this).val()).toLowerCase();
        let dataName = String($selectedOption.data('name') || '').trim().toLowerCase();
        
        let fieldId = $(this).data('field-id');
        let $otherContainer = $(`#other_input_container_${fieldId}`);
        let $otherInput = $(`#other_input_${fieldId}`);

        let parentIsRequired = $(this).hasClass('data_required') || $(this).prop('required');

        // ឆែកលក្ខខណ្ឌ "Other" ដោយផ្អែកលើ value ឬ data-name
        if (selectedVal === "other" || dataName === "other") {
            $otherContainer.slideDown(200);

            if (parentIsRequired) {
                $otherInput.prop('required', true)
                        .addClass('emp_required data_required');
            }

            $otherInput.focus();
        } else {
            $otherContainer.slideUp(200);

            $otherInput.prop('required', false)
                    .removeClass('emp_required data_required is-invalid is-valid')
                    .val('');
        }
    });

    $(document).on("click", "." + buttonSubmit, function () {
        var num_miss = 0;
        // Set UI State Loading
        $("." + buttonSubmit).attr('disabled', true);
        $("#btn-save-loading").css('display', 'block');
        $(".btn-text-save").css("display", 'none');
        $(".employee-form-group-select2").each(function(){
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
        $(".single-form-block").not(".d-none").find(".hr-form-group-select2").each(function(){
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

        // ១. Client-side Validation Checking
        $(".single-form-block").not(".d-none").find(".data_required").each(function () {
            if ($.trim($(this).val()) === "") {
                num_miss++;
                $(this).addClass("is-invalid").removeClass("is-valid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });

        if (num_miss < 1) {
            let formsData = [];

            // ទាញយក Data ចាស់ពី variable savedRentalData (ករណី Edit)
            let oldFormsData = [];
            if (typeof savedRentalData !== 'undefined' && savedRentalData) {
                try {
                    oldFormsData = typeof savedRentalData === 'string' 
                        ? JSON.parse(savedRentalData) 
                        : savedRentalData;
                    
                    if (!Array.isArray(oldFormsData)) {
                        oldFormsData = Object.values(oldFormsData);
                    }
                } catch (e) {
                    oldFormsData = [];
                }
            }

            // ២. Loop តាម Form Block នីមួយៗ (Motorcycle Form, Tablet Form, ...)
            $(".single-form-block").not(".d-none").each(function () {
                let $formBlock = $(this);
                
                let formRentalId = $formBlock.data('form-id') || null;
                let formRentalName = $formBlock.data('form-name') || null; 
                
                let fieldsPayload = {};

                // Loop ប្រមូលទិន្នន័យពីគ្រប់ Input/Select Dynamic ទាំងអស់ក្នុង Form Block នោះ
                $formBlock.find("input[name^='fields['], select[name^='fields[']").each(function () {
                    let $input = $(this);
                    let inputName = $input.attr('name');
                    let fieldVal = $input.val();

                    let matches = inputName.match(/\[(.*?)\]/);
                    if (matches && matches[1]) {
                        let fieldId = matches[1];

                        let fieldLabel = $.trim($input.closest('.form-group').find('.form-label').text())
                                                .replace('*', '') // លុបសញ្ញា * ចោល
                                                .trim();

                        let optionId = null;
                        if ($input.is('select')) {
                            optionId = fieldVal;
                            let $selectedOption = $input.find('option:selected');
                            let dataName = String($selectedOption.data('name') || '').trim().toLowerCase();

                            if (fieldVal === "other" || dataName === "other") {
                                let customVal = $formBlock.find(`#other_input_${fieldId}`).val();
                                fieldVal = customVal || fieldVal;
                            } else {
                                let optionName = $selectedOption.data('name') || $selectedOption.text().trim();
                                fieldVal = optionName || fieldVal;
                            }
                        }

                        // រក្សាទុកជារាង Object មានទាំង label, option_id និង value
                        fieldsPayload[fieldId] = {
                            field_id: fieldId,
                            field_label: fieldLabel,
                            option_id: optionId,
                            value: fieldVal
                        };
                    }
                });

                // 💡 ស្វែងរក status និង terminate_date ចាស់តាមរយៈ form_rental_id
                let oldForm = oldFormsData.find(f => f.form_rental_id == formRentalId);
                let formStatus = (oldForm && oldForm.status) ? oldForm.status : 'active';
                let terminateDate = (oldForm && oldForm.terminate_date) ? oldForm.terminate_date : null;

                formsData.push({
                    "form_rental_id": formRentalId,
                    "form_name": formRentalName,
                    "status": formStatus,  
                    "terminate_date": terminateDate, 
                    "fields": fieldsPayload   
                });
            });
            
            let isEdit = (buttonSubmit === "submit-update-btn");
            let id_edit = isEdit ? $("#rental_id").val() : null;
            let payload = {
                "id": id_edit,
                "employee_id": $("#employee_id").val(),
                "forms": formsData
            };
            
            $.ajax({
                type: "POST",
                url: submitUrl,
                data: payload,
                dataType: "JSON",
                success: function (response) {
                    if (response.status === 200) {
                        new Noty({
                            text: response.message,
                            type: "success",
                            timeout: 2000,
                            progressBar: true
                        }).show();

                        setTimeout(function () {
                            let redirectUrl = (typeof listUrl !== 'undefined') ? listUrl : `${appBaseUrl}/motor-rentel/form`;
                            window.location.replace(redirectUrl);
                        }, 1500);
                    } else {
                        new Noty({
                            text: response.message || "មានបញ្ហាក្នុងការរក្សាទុក!",
                            type: "error",
                            timeout: 3000
                        }).show();

                        resetSaveButton(buttonSubmit);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let res = xhr.responseJSON;
                        let errorMsg = '';

                        if (res.errors) {
                            if (Array.isArray(res.errors)) {
                                errorMsg = res.errors.join('<br>');
                            } else if (typeof res.errors === 'object') {
                                errorMsg = Object.values(res.errors).flat().join('<br>');
                            }
                        } else {
                            errorMsg = res.message || 'ទិន្នន័យបញ្ចូលមិនត្រឹមត្រូវ!';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'បរាជ័យ (Validation Error)',
                            html: errorMsg,
                            confirmButtonText: 'យល់ព្រម',
                            customClass: { confirmButton: 'btn btn-primary' }
                        });
                    } else {
                        let serverMsg = xhr.responseJSON?.message || 'មានបញ្ហាក្នុងការ Save Data!';
                        new Noty({
                            text: serverMsg,
                            type: "error",
                            timeout: 3000
                        }).show();
                    }

                    resetSaveButton(buttonSubmit);
                }
            });
        } else {
            new Noty({
                text: "Please check required fields",
                type: "error",
                timeout: 3000
            }).show();
            resetSaveButton(buttonSubmit);
        }
    });

    $(document).on("click", ".education-delete-element", function (e) {
        e.preventDefault();

        let $formBlock = $(this).closest('.single-form-block');

        // 1. Clear ទិន្នន័យ (Inputs, Selects) និង Reset Validation states
        $formBlock.find("input, select, textarea").val("").trigger("change");
        $formBlock.find(".is-invalid, .is-valid").removeClass("is-invalid is-valid");

        // 2. លាក់ Form Block ចេញពី Screen
        $formBlock.addClass("d-none");

        // 3. (Optional) ជូនដំណឹងទៅ User
        if (typeof Noty !== 'undefined') {
            new Noty({
                text: "បានលុប Form រួចរាល់!",
                type: "warning",
                timeout: 1500
            }).show();
        }
    });
});

let globalDataForms = [];

function loadDynamicForms() {
    // ដំណោះស្រាយ៖ ប្រើប្រាស់ Relative URL ឬ appBaseUrl ជំនួសឱ្យ Blade syntax {{ url(...) }}
    let fetchFormUrl = (typeof formFetchUrl !== 'undefined') ? formFetchUrl : `${appBaseUrl}/motor-rentel/form`;

    $.ajax({
        type: "GET",
        url: fetchFormUrl,
        dataType: "JSON",
        success: function (response) {
            if (response.dataForms && response.dataForms.length > 0) {
                globalDataForms = response.dataForms;

                let defaultVisibleCount = 1;
                let selectOptionsHtml = '<option value="" selected disabled>-- Select Form --</option>';
                let formsHtml = '';

                $.each(globalDataForms, function (index, form) {
                    selectOptionsHtml += `<option value="${index}">${form.title || 'Form ' + (index + 1)}</option>`;

                    let isHiddenClass = (index >= defaultVisibleCount) ? 'd-none' : '';
                    formsHtml += generateFormHtml(form, index, isHiddenClass);
                });

                $('#select_additional_form').html(selectOptionsHtml);
                $('#select_form_wrapper').show();

                $("#dynamic_form_container").html(formsHtml);

                if ($.fn.select2) {
                    $('.dynamic-select2').select2({ width: '100%' });
                }
                if ($.fn.datepicker) {
                    $('.datepicker-ddmmyyyy').datepicker({
                        dateFormat: "dd-mm-yy",
                        changeMonth: true,
                        numberOfMonths: 1,
                        autoclose: true,
                        todayHighlight: true,
                        clearBtn: true,
                        forceParse: false // បង្ខំកុំឱ្យ Browser ដូរមក MM/DD/YYYY វិញ
                    });
                }
            } else {
                $("#dynamic_form_container").html('<div class="alert alert-warning">No forms found.</div>');
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", error);
            $("#dynamic_form_container").html('<div class="alert alert-danger">Failed to load form.</div>');
        }
    });
}

function generateFormHtml(form, index, extraClass = '') {
    let formHtml = `
        <div data-form-id="${form.id}" data-form-name='${form.title}' class="single-form-block ${extraClass} form_type_${form.type} mb-4 p-3 form-index-${index}" style="border: 1px solid #dfe6e9; border-radius: 6px; background: #fff;">
            <a href="javascript:void(0);" class="delete-icon education-delete-element"><i class="fa fa-trash-o"></i></a>
            <div class="form-group col-md-12 col-12">
                <label class="navbar-brand custom-navbar-brand mb-0" 
                    style="width: 100%; background: #dfe6e9; padding: 8px; font-size: 15px; font-weight: bold; color: #2d3436;">
                    ${form.title || 'Motor Rental Form'}
                </label>
            </div>
            <div class="row">`;

    if (form.fields && form.fields.length > 0) {
        $.each(form.fields, function (fIndex, field) {
            let rawType = field.field_type ? String(field.field_type).trim().toLowerCase() : 'text';
            let isRequired = (field.is_required == 1 || field.is_required == 'yes');

            let hr_form_group = ";"
            if (['select'].includes(rawType)){
                hr_form_group =  isRequired ? "hr-form-group-select2": "";
            }
            isRequired ? "hr-form-group-select2": "";
            let hr_select2_option = isRequired ? "hr-select2-option requered": "";

            let requiredClass = isRequired ? 'emp_required data_required' : '';
            let requiredAttr = isRequired ? 'required' : '';
            let requiredStar = isRequired ? '<span class="text-danger">*</span>' : '';

            formHtml += `
                <div class="col-sm-6" id="condition_field_${field.id}">
                    <div class="form-group ${hr_form_group}">
                        <label class="form-label">${field.field_label || ''} ${requiredStar}</label>`;

            if (['date', 'datetime', 'datepicker', 'date_picker'].includes(rawType)) {
                
                formHtml += `
                    <input type="text" 
                           class="form-control datepicker-ddmmyyyy ${requiredClass} m_clear" 
                           name="fields[${field.id}]" 
                           placeholder="DD-MM-YYYY" 
                           autocomplete="off" 
                           ${requiredAttr}>`;
            
            } else if (['number', 'numeric', 'integer'].includes(rawType)) {
                formHtml += `<input type="number" step="any" class="form-control ${requiredClass} m_clear" name="fields[${field.id}]" ${requiredAttr}>`;
            // 3. SELECT TYPE (DYNAMIC OPTIONS LOOP)
            } else if (['select', 'dropdown', 'select2', 'select_option'].includes(rawType)) {
                formHtml += `
                    <select class="form-control dynamic-select2 action-dynamic-select ${requiredClass} ${hr_select2_option} m_clear" name="fields[${field.id}]" ${requiredAttr} data-field-id="${field.id}">
                        <option selected disabled value="">--- Select ---</option>`;

                        // ករណី Controller បាញ់មកជា Relationship Array (field.brands)
                        if (Array.isArray(field.brands) && field.brands.length > 0) {
                            $.each(field.brands, function (bIdx, brand) {
                                formHtml += `<option value="${brand.id}" data-name="${brand.brand_name || brand.name}">${brand.brand_name || brand.name}</option>`;
                            });
                        } else {
                            let optionsList = field.options;
                            if (typeof optionsList === 'string') {
                                try { optionsList = JSON.parse(optionsList); } catch (e) { optionsList = []; }
                            }

                            if (Array.isArray(optionsList) && optionsList.length > 0) {
                                $.each(optionsList, function (oIdx, optVal) {
                                    if (typeof optVal === 'object' && optVal !== null) {
                                        formHtml += `<option value="${optVal.id}" data-name="${optVal.brand_name || optVal.name}">${optVal.brand_name || optVal.name || optVal.id}</option>`;
                                    } else {
                                        formHtml += `<option value="${optVal}" data-name="${optVal}">${optVal}</option>`;
                                    }
                                });
                            }
                        }
                formHtml += `</select>`;

                // ២. បន្ថែម Container សម្រាប់ Text Input (លាក់ទុកជាមុន)
                formHtml += `
                    <div id="other_input_container_${field.id}" class="mt-2 custom-other-wrapper" style="display: none;">
                        <input type="text" 
                               class="form-control m_clear" 
                               id="other_input_${field.id}" 
                               name="fields_custom[${field.id}]" 
                               placeholder="Enter new for ${field.field_label}...">
                    </div>`;
            } else {
                formHtml += `<input type="text" class="form-control ${requiredClass} m_clear" name="fields[${field.id}]" ${requiredAttr}>`;
            }

            formHtml += `
                    </div>
                </div>`;
        });
    }

    formHtml += `</div></div>`;
    return formHtml;
}

$(document).on('click', '#btn_add_selected_form', function () {
    let selectedIndex = $('#select_additional_form').val();

    if (!selectedIndex) {
        new Noty({
            title: "",
            text: "សូមជ្រើសរើស Form មួយជាមុនសិន!",
            type: "error",
            timeout: 3000,
            icon: true
        }).show();
        return;
    }

    let $targetForm = $('.form-index-' + selectedIndex);

    if ($targetForm.hasClass('d-none')) {
        $targetForm.removeClass('d-none');

        $('html, body').animate({
            scrollTop: $targetForm.offset().top - 80
        }, 400);

        $('#select_additional_form').val('');
    } else {
        Swal.fire({
            icon: 'warning',
            title: '<strong style="font-size: 28px;">Form នេះមាននៅលើ Screen រួចហើយ!</strong>',
            html: `
                <div style="text-align: left; font-size: 14px; color: #555; line-height: 1.6;">
                    <p class="mb-2">ទម្រង់ (Form) ដែលអ្នកបានជ្រើសរើស ត្រូវបានបើកបង្ហាញរួចរាល់ហើយនៅខាងស្តាំដៃ។</p>
                    <div style="background-color: #f8f9fa; border-left: 4px solid #17a2b8; padding: 10px; border-radius: 4px; margin-top: 10px;">
                        <i class="fa fa-info-circle text-info"></i> 
                        <strong>ណែនាំ៖</strong> សូមពិនិត្យមើល Form ខាងស្តាំ ឬរំកិល (Scroll) ចុះក្រោមដើម្បីបំពេញព័ត៌មាន។
                    </div>
                </div>
            `,
            confirmButtonText: 'យល់ព្រម',
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
    }
});

function loadDynamicFormsForEdit() {
    let fetchFormUrl = (typeof formFetchUrl !== 'undefined') ? formFetchUrl : `${appBaseUrl}/motor-rentel/form`;
    
    $.ajax({
        type: "GET",
        url: fetchFormUrl,
        dataType: "JSON",
        success: function (response) {
            if (response.dataForms && response.dataForms.length > 0) {
                globalDataForms = response.dataForms;
                let selectOptionsHtml = '<option value="" selected disabled>-- Select Form --</option>';
                let formsHtml = '';

                // ១. Render Form Templates ទាំងអស់ (លាក់ d-none ជាមុន)
                $.each(globalDataForms, function (index, form) {
                    selectOptionsHtml += `<option value="${index}">${form.title || 'Form ' + (index + 1)}</option>`;
                    formsHtml += generateFormHtml(form, index, 'd-none');
                });

                $('#select_additional_form').html(selectOptionsHtml);
                $('#select_form_wrapper').show();
                $("#dynamic_form_container").html(formsHtml);

                // Init Select2 & Datepicker ឡើងវិញ
                if ($.fn.select2) $('.dynamic-select2').select2({ width: '100%' });
                if ($.fn.datepicker) {
                    $('.datepicker-ddmmyyyy').datepicker({
                        dateFormat: "dd-mm-yy",
                        changeMonth: true,
                        numberOfMonths: 1,
                        autoclose: true,
                        todayHighlight: true,
                        clearBtn: true,
                        forceParse: false
                    });
                }

                // ២. ចាប់ផ្តើម Populate Data ចូល Form
                let dataToPopulate = savedRentalData;

                // ករណី savedRentalData ជា String JSON
                if (typeof dataToPopulate === 'string') {
                    try {
                        dataToPopulate = JSON.parse(dataToPopulate);
                    } catch (e) {
                        dataToPopulate = [];
                    }
                }

                if (dataToPopulate) {
                    populateEditData(dataToPopulate);
                }
            }
        }
    });
}
function populateEditData(savedForms) {
    // បំប្រែ data ឱ្យទៅជា Array ជានិច្ច ទោះជាវា Obj ឬ Array
    let formsArray = Array.isArray(savedForms) ? savedForms : Object.values(savedForms);

    $.each(formsArray, function (idx, savedForm) {
        if (!savedForm) return;

        let formRentalId = savedForm.form_rental_id;

        // ស្វែងរក Block ដោយប្រៀបធៀប data-form-id ដោយផ្ទាល់
        let $formBlock = $('.single-form-block').filter(function () {
            return $(this).attr('data-form-id') == formRentalId || $(this).data('form-id') == formRentalId;
        });

        // បើស្វែងរកតាម data-form-id មិនឃើញ ឱ្យស្វែងរកតាម form_type_ ឬ Index ជំនួស
        if ($formBlock.length === 0) {
            $formBlock = $(`.single-form-block.form_type_${formRentalId}, .single-form-block.form-index-${idx}`);
        }

        if ($formBlock.length > 0) {
            // បង្ហាញ Form Block ដែលមាន Data
            $formBlock.removeClass('d-none');

            // 💡 1. ឆែក និង បង្ហាញ Termination Status ប្រសិនបើ Form ត្រូវ បានបញ្ចប់ (Terminated)
            if (savedForm.status === 'terminated') {
                let terminateDate = savedForm.terminate_date || 'N/A';
                
                // បង្កើត HTML Banner Alert បង្ហាញប្រាប់អ្នកប្រើប្រាស់
                let terminateHtml = `
                    <div class="col-12 mb-3 termination-alert-block">
                        <div class="alert alert-danger d-flex align-items-center mb-0 p-2 border-danger rounded" role="alert">
                            <i class="fa fa-ban me-2 fs-4"></i>
                            <div>
                                <strong class="d-block">ទម្រង់នេះត្រូវ បានបញ្ចប់ការជួល (Terminated)</strong>
                                <small>កាលបរិច្ឆេទបញ្ចប់៖ <strong>${terminateDate}</strong></small>
                            </div>
                        </div>
                    </div>`;

                // ការពារការ Append ជាន់គ្នា (បើមាន Alert រួចហើយ)
                $formBlock.find('.termination-alert-block').remove();
                
                // បញ្ចូល Alert ទៅលើគេបង្អស់នៃ Form Block
                $formBlock.find('.row:first').prepend(terminateHtml);

                // Disable Inputs/Selects ទាំងអស់ក្នុង Form នេះដើម្បីកុំឱ្យ Edit ឬកែប្រែ data
                $formBlock.find('input, select, textarea').prop('disabled', true);
                
                // បន្ថែម data attribute សម្រាប់សម្គាល់ status
                $formBlock.attr('data-status', 'terminated');
            }

            // 2. Set Data សម្រាប់ Dynamic Fields
            if (savedForm.fields) {
                $.each(savedForm.fields, function (fieldId, fieldObj) {
                    let val = fieldObj.value !== undefined ? fieldObj.value : '';
                    let optionId = fieldObj.option_id;

                    // ស្វែងរក Input/Select តាម name attribute
                    let $fieldInput = $formBlock.find(`[name="fields[${fieldId}]"]`);

                    if ($fieldInput.length > 0) {
                        if ($fieldInput.is('select')) {
                            if (optionId === "1") {
                                $fieldInput.val("other").trigger('change');
                                $formBlock.find(`#other_input_${fieldId}`).val(val);
                            }
                            if (optionId === "other" || val === "other") {
                                $fieldInput.val("other").trigger('change');
                                $formBlock.find(`#other_input_${fieldId}`).val(val);
                                $formBlock.find(`#other_input_container_${fieldId}`).show();
                            } else {
                                // ឆែកមើលក្រែងលោ Option match តាម ID ឬ Value (Name)
                                let targetVal = optionId;
                                if (!$fieldInput.find(`option[value="${targetVal}"]`).length) {
                                    // រក option តាម data-name ឬ Text
                                    $fieldInput.find('option').each(function () {
                                        if ($(this).text().trim() === val || $(this).data('name') === val) {
                                            targetVal = $(this).val();
                                        }
                                    });
                                }
                                $fieldInput.val(targetVal).trigger('change');
                            }
                        } else {
                            $fieldInput.val(val);
                        }
                    }
                });
            }
        }
    });
}
function resetSaveButton(buttonClass) {
    $("." + buttonClass).attr('disabled', false);
    $("#btn-save-loading").css('display', 'none');
    $(".btn-text-save").css("display", 'block');
}