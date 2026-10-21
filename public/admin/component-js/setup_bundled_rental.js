$(function () {
    const $form = $('#bundledRateForm');
    const $rows = $('#rateRows');
    const tpl   = document.getElementById('rateRowTpl').innerHTML;

    // type_form → section ដែលត្រូវបង្ហាញ (បន្ថែម type ថ្មីត្រង់នេះ)
    const SECTION = {
        motorcycle:     'rates',           // ច្រើនជួរ + Add more
        tablet:         'tablet',          // Currency + Amount
        leave:          'leave',           // Total Leave Day
        staff_transfer: 'staff_transfer'   // Select date
    };

    // ================= Rows (motorcycle) =================
    function initSelect2($row) {
        const $s = $row.find('.position-review-select');
        if (!$.fn.select2) { console.warn('Select2 is not loaded'); return; }
        if ($s.hasClass('select2-hidden-accessible')) $s.select2('destroy');
        $s.select2({ width: '100%', closeOnSelect: false, dropdownParent: $(document.body) });
    }

    function addRow() {
        const $row = $(tpl);
        $rows.append($row);
        initSelect2($row);
        return $row;
    }

    // ================= បង្ហាញ/លាក់ តាម type =================
    function currentSection() { return SECTION[$('.type_form', $form).val()] || null; }

    function showSection() {
        const sec = currentSection();
        $('.type-section', $form).hide();
        $form.find('.is-invalid').removeClass('is-invalid');

        if (sec) {
            $('.type-section[data-section="' + sec + '"]', $form).show();
            $('#noTypeHint').hide();
            if (sec === 'rates' && !$rows.children().length) addRow();   // motorcycle ត្រូវមានយ៉ាងតិច ១ ជួរ
        } else {
            $('#noTypeHint').toggle(true);
        }
    }

    // ================= Events =================
    $('.type_form', $form).on('change', showSection);

    $('#btnAddRate').on('click', function () {
        const $row = addRow();
        $row.find('.from').trigger('focus');
    });

    $rows.on('click', '.delete-row', function () {
        if ($rows.children().length > 1) $(this).closest('.rate-row').remove();
    });

    // អនុញ្ញាតតែលេខ និងចុច . មួយ (ឧ. 1.5) សម្រាប់ amount និងចំនួនថ្ងៃឈប់
    function cleanDecimal(el) {
        let v = el.value.replace(/[^0-9.]/g, '');
        const i = v.indexOf('.');
        if (i > -1) v = v.slice(0, i + 1) + v.slice(i + 1).replace(/\./g, '');
        el.value = v;
    }
    $form.on('input', '.amount, .tablet_amount, .leave_days', function () { cleanDecimal(this); });

    $form.on('input change', '.is-invalid', function () { $(this).removeClass('is-invalid'); });

    // Edit: មានជួរពី server រួចហើយ → init Select2
    $rows.children().each(function () { initSelect2($(this)); });
    showSection();

    // ================= Submit =================
    $("." + buttonSubmit).on("click", function () {
        let num_miss = 0;
        $form.find('.is-invalid').removeClass('is-invalid');

        // ឆែកតែ field ដែលនៅខាងក្រៅ section (name, type) ឬ section ដែលកំពុងបង្ហាញ
        $form.find(".data_required").filter(function () {
            const $sec = $(this).closest('.type-section');
            return !$sec.length || $sec.is(':visible');
        }).each(function () {
            if ($.trim($(this).val()) === "") { num_miss++; $(this).addClass("is-invalid"); }
        });

        const sec = currentSection();

        if (sec === 'rates') {
            $rows.find('.rate-row').each(function () {
                const f = parseInt($(this).find('.from').val(), 10), t = parseInt($(this).find('.to').val(), 10);
                if (!isNaN(f) && !isNaN(t) && f > t) { $(this).find('.from, .to').addClass('is-invalid'); num_miss++; }
            });
        }
        if (sec === 'leave' && !(parseFloat($('.leave_days', $form).val()) > 0)) {   // ត្រូវធំជាង 0 (អនុញ្ញាត 0.5, 1.5)
            $('.leave_days', $form).addClass('is-invalid'); num_miss++;
        }

        if (num_miss > 0) {
            new Noty({ text: "Please check required fields", type: "error", timeout: 3000 }).show();
            const $first = $form.find(".is-invalid:first");
            const $box = $first.closest('.f').length ? $first.closest('.f') : $first;
            $('html, body').animate({ scrollTop: Math.max($box.offset().top - 140, 0) }, 200);
            if ($first.hasClass('position-review-select')) $first.select2('open'); else $first.trigger("focus");
            return;
        }

        $("." + buttonSubmit).attr('disabled', true);
        $("#btn-save-loading").css('display', 'block');
        $(".btn-text-save").css("display", 'none');

        const rateId = $.trim($("#rate_id").val()) || null;     // Edit = group_id
        const type   = $('.type_form', $form).val();
        const name   = $.trim($('.set_name', $form).val());
        const posKey = rateId ? 'position_ids' : 'id_positions'; // Edit / Create ប្រើឈ្មោះផ្សេងគ្នា (ដូចកូដចាស់)

        // ប្រមូលទិន្នន័យតាម type
        let items = [];
        if (sec === 'rates') {
            $rows.find('.rate-row').each(function () {
                let positions = $(this).find('.position-review-select').val() || [];
                if (!Array.isArray(positions)) positions = [positions];
                positions = positions.filter(p => p !== "" && p !== null);

                let item = {
                    "from":     $(this).find('.from').val(),
                    "to":       $(this).find('.to').val(),
                    "currency": $(this).find('.currency').val(),
                    "amount":   $.trim($(this).find('.amount').val())
                };
                item[posKey] = positions;
                items.push(item);
            });
        } else if (sec === 'tablet') {
            items.push({
                "currency": $('.tablet_currency', $form).val(),
                "amount":   $.trim($('.tablet_amount', $form).val())
            });
        } else if (sec === 'leave') {
            items.push({ "leave_day": $.trim($('.leave_days', $form).val()) });
        } else if (sec === 'staff_transfer') {
            items.push({ "transfer_day": $('.transfer_day', $form).val() });
        }

        // ធ្វើឱ្យគ្រប់ item មាន key ដូចគ្នា (type ដែលគ្មាន Position ក៏ផ្ញើ [] មិនមែន undefined/null)
        const DEFAULTS = { from: null, to: null, currency: null, amount: null, leave_day: null, transfer_day: null };
        items = items.map(i => Object.assign({}, DEFAULTS, { [posKey]: [] }, i));

        let payload;
        if (rateId) {
            // Edit
            payload = { "group_id": rateId, "name": name, "type": type, "rates": items };
        } else {
            // Create: name និង type ជាប់ក្នុងគ្រប់ item (ដូចកូដចាស់)
            payload = { "type": type, "datas": items.map(i => Object.assign({ "name": name, "type": type }, i)) };
        }

        $.ajax({
            type: "POST",
            url: (rateId && typeof updateUrl !== 'undefined') ? updateUrl : submitUrl,
            data: JSON.stringify(payload),
            contentType: "application/json",
            dataType: "JSON",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $form.find('input[name="_token"]').val() },
            success: function (response) {
                if (response.status === 200) {
                    new Noty({ text: response.message, type: "success", timeout: 2000, progressBar: true }).show();
                    setTimeout(function () { window.location.replace(listUrl); }, 1500);
                } else {
                    new Noty({ text: response.message || "មានបញ្ហាក្នុងការរក្សាទុក!", type: "error", timeout: 3000 }).show();
                    resetSaveButton(buttonSubmit);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON || {}, msg = '';
                    if (res.errors) {
                        msg = Array.isArray(res.errors) ? res.errors.join('<br>') : Object.values(res.errors).flat().join('<br>');
                    } else {
                        msg = res.message || 'ទិន្នន័យបញ្ចូលមិនត្រឹមត្រូវ!';
                    }
                    Swal.fire({ icon: 'error', title: 'បរាជ័យ (Validation Error)', html: msg, confirmButtonText: 'យល់ព្រម', customClass: { confirmButton: 'btn btn-primary' } });
                } else {
                    new Noty({ text: (xhr.responseJSON && xhr.responseJSON.message) || 'មានបញ្ហាក្នុងការ Save Data!', type: "error", timeout: 3000 }).show();
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