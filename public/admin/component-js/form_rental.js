$(function () {
    const $modal = $('#formRentalModal');
    const $form  = $('#formRentalForm');
    const $rows  = $('#fieldRows');
    const tpl    = document.getElementById('fieldRowTpl').innerHTML;
    let idx = 0;

    // ================= Rows (ជួរ field) =================
    function initSelect2($row) {
        if ($.fn.select2) {
            $row.find('.optiop').select2({ dropdownParent: $modal, width: '100%' });
        }
    }

    // បង្ហាញ/លាក់ option តាម type (ដូចកូដចាស់ ប៉ុន្តែប្រើ .field-row)
    function toggleOption($row, selected) {
        const isSelect = $row.find('.field_type').val() === 'select';
        const $opt = $row.find('.optiop');

        if (isSelect) {
            $row.find('.option-wrapper').slideDown(200);
            $opt.prop('required', true).addClass('data_required');
            if (selected && selected.length) {
                $opt.val(selected.map(String)).trigger('change');
            }
        } else {
            $row.find('.option-wrapper').slideUp(200);
            $opt.prop('required', false).removeClass('data_required').val(null).trigger('change');
        }
    }

    // d (មិនចាំបាច់) = ទិន្នន័យសម្រាប់ Edit
    function addRow(d) {
        d = d || {};
        const $row = $(tpl.replaceAll('__i__', idx++));

        $row.find('.field_id').val(d.field_id || '');
        $row.find('.field_label').val(d.field_label || '');
        $row.find('.field_type').val(d.field_type || 'text');
        $row.find('.is_required').prop('checked', String(d.is_required) === '1');
        $row.find('.is_condition').prop('checked', String(d.is_condition) === '1');

        $rows.append($row);
        initSelect2($row);
        toggleOption($row, d.option || []);
        return $row;
    }

    function resetForm() {
        // គ្មាន <form> tag ដូច្នេះ reset ដោយដៃ
        $('.field_tile', $form).val('');
        $('.bunledrental_id', $form).val('');
        $('.type_form', $form).prop('selectedIndex', 0);
        $('#form_id').val('');
        if (!$modal.is('[data-edit]')) {
            const $t = $('#formRentalModalLabel');
            $t.text($t.data('titleNew') || $t.text());
        }
        $form.find('.is-invalid').removeClass('is-invalid');
        $rows.empty();
        idx = 0;
        addRow();
    }

    // ជំនួយសម្រាប់ Edit: openFormRentalModal({form_rental_id, title, type, condition_id, datas:[...]})
    window.openFormRentalModal = function (data) {
        resetForm();
        if (data) {
            $('#form_id').val(data.form_rental_id || '');
            if (data.form_rental_id) {
                const $t = $('#formRentalModalLabel');
                $t.text($t.data('titleEdit') || $t.text());
            }
            $('.field_tile', $form).val(data.title || '');
            $('.type_form', $form).val(data.type || '');
            $('.bunledrental_id', $form).val(data.condition_id || '');
            if (data.datas && data.datas.length) {
                $rows.empty();
                data.datas.forEach(addRow);
            }
        }
        showModal();
    };

    // ================= Modal helpers (Bootstrap 5 ឬ 4) =================
    // ប្រើ jQuery plugin ជាមុន (ដូច $("#delete_rental").modal("show") ក្នុងទំព័រអ្នក)
    // ព្រោះ window.bootstrap ក្នុង project នេះមិនមាន Modal.getInstance
    function modalCall(action) {
        if ($.fn.modal) {
            $modal.modal(action);
        } else if (window.bootstrap && bootstrap.Modal && typeof bootstrap.Modal.getOrCreateInstance === 'function') {
            bootstrap.Modal.getOrCreateInstance($modal[0])[action]();
        } else {
            console.error('Bootstrap modal is not available');
        }
    }
    function showModal() { modalCall('show'); }
    function hideModal() { modalCall('hide'); }

    // ================= Events =================
    // Create: reset form / Edit: ត្រលប់ទៅបញ្ជី
    $modal.on('hidden.bs.modal', function () {
        if ($modal.is('[data-edit]')) window.location.href = listUrl;
        else resetForm();
    });

    $('#btnAddMore').on('click', function () { addRow(); });

    $rows.on('click', '.delete-row', function () {
        if ($rows.children().length > 1) {
            $(this).closest('.field-row').remove();
        }
    });

    $rows.on('change', '.field_type', function () {
        toggleOption($(this).closest('.field-row'));
    });

    $form.on('input change', '.is-invalid', function () {
        $(this).removeClass('is-invalid');
    });

    if ($rows.children().length) {
        // Edit: មានជួរពី server រួចហើយ → គ្រាន់តែ init Select2 និងបង្ហាញ/លាក់ option
        idx = $rows.children().length;
        $rows.children().each(function () {
            initSelect2($(this));
            toggleOption($(this));
        });
    } else {
        resetForm(); // Create: ចាប់ផ្តើមជាមួយ ១ ជួរ (ចង់បាន ៤ ជួរ: ហៅ addRow() បន្ថែមទៀត)
    }

    if ($modal.is('[data-auto-open]')) showModal();

    // ================= Submit =================
    $("." + buttonSubmit).on("click", function () {
        let num_miss = 0;

        // ១. Client-side validation (ឆែកមុន ទើបបើក loading)
        $form.find(".data_required").each(function () {
            if ($.trim($(this).val()) === "") {
                num_miss++;
                $(this).addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid");
            }
        });

        if (num_miss > 0) {
            new Noty({ text: "Please check required fields", type: "error", timeout: 3000 }).show();
            $form.find(".is-invalid:first").trigger("focus");
            return;
        }

        $("." + buttonSubmit).attr('disabled', true);
        $("#btn-save-loading").css('display', 'block');
        $(".btn-text-save").css("display", 'none');

        // ២. Create ឬ Update (មាន form_id = Update)
        let formRentalId = $.trim($("#form_id").val()) || null;

        // ៣. ប្រមូល datas ពីជួរនីមួយៗ
        let datas = [];
        $rows.find(".field-row").each(function () {
            datas.push({
                "field_id":     $(this).find(".field_id").val() || null,
                "field_label":  $.trim($(this).find(".field_label").val()),
                "field_type":   $(this).find(".field_type").val(),
                "is_required":  $(this).find(".is_required").is(":checked") ? "1" : "0",
                "is_condition": $(this).find(".is_condition").is(":checked") ? "1" : "0",
                "option":       $(this).find(".optiop").val() || []
            });
        });

        // ៤. Payload (រចនាសម្ព័ន្ធដដែលនឹងកូដចាស់ Controller មិនបាច់កែ)
        let payload = {
            "form_rental_id":  formRentalId,
            "title":           $.trim($(".field_tile", $form).val()),
            "type":            $.trim($(".type_form", $form).val()),
            "field_tile":      $.trim($(".field_tile", $form).val()),
            "condition_id":    $(".bunledrental_id", $form).val(),
            "rental_rates_id": $(".bunledrental_id", $form).val(),
            "datas":           datas,
            "field_id":        datas.map(d => d.field_id),
            "field_label":     datas.map(d => d.field_label),
            "field_type":      datas.map(d => d.field_type),
            "is_required":     datas.map(d => d.is_required),
            "is_condition":    datas.map(d => d.is_condition),
            "option":          datas.map(d => d.option)
        };

        // ៥. AJAX
        $.ajax({
            type: "POST",
            url: (formRentalId && typeof updateUrl !== 'undefined') ? updateUrl : submitUrl,
            data: payload,
            dataType: "JSON",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $form.find('input[name="_token"]').val() },
            success: function (response) {
                if (response.status === 200) {
                    new Noty({ text: response.message, type: "success", timeout: 2000, progressBar: true }).show();
                    hideModal();
                    setTimeout(function () { window.location.replace(listUrl); }, 1500);
                } else {
                    new Noty({ text: response.message || "មានបញ្ហាក្នុងការរក្សាទុក!", type: "error", timeout: 3000 }).show();
                    resetSaveButton(buttonSubmit);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON || {};
                    let errorMsg = '';

                    if (res.errors) {
                        errorMsg = Array.isArray(res.errors)
                            ? res.errors.join('<br>')
                            : Object.values(res.errors).flat().join('<br>');
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
                    new Noty({
                        text: (xhr.responseJSON && xhr.responseJSON.message) || 'មានបញ្ហាក្នុងការ Save Data!',
                        type: "error",
                        timeout: 3000
                    }).show();
                }
                resetSaveButton(buttonSubmit);
            }
        });
    });
});

function resetSaveButton(buttonClass) {
    $("." + buttonClass).attr('disabled', false);
    $("#btn-save-loading").css('display', 'none');
    $(".btn-text-save").css("display", 'block');
}