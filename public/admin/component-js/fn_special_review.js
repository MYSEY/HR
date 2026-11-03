$(function () {
    // Ids used by the Blade modal. They MUST match the HTML exactly.
    const MODAL_ID = '#formSpecialModal';
    const FORM_ID  = '#formSpecialForm';
    const LABEL_ID = '#formSpecialModalLabel';

    let $modal, $form, $title, $dept, $position;

    // Look the elements up every time, so it still works if the modal is rendered later
    function bindElements() {
        $modal    = $(MODAL_ID);
        $form     = $(FORM_ID);
        $title    = $(LABEL_ID);
        $dept     = $('.type_form', $form);
        $position = $('.position', $form);
        return $form.length > 0;
    }

    function csrf() {
        return $('meta[name="csrf-token"]').attr('content') || $(FORM_ID).find('input[name="_token"]').val();
    }

    // Works with Bootstrap 4, 5.0 and 5.1+
    function showModal() {
        bindElements();
        if (typeof $.fn.modal === 'function') {
            $modal.modal('show');                       // jQuery plugin (BS4 / BS5 with jQuery)
        } else if (window.bootstrap && bootstrap.Modal) {
            const inst = (bootstrap.Modal.getInstance && bootstrap.Modal.getInstance($modal[0]))
                      || new bootstrap.Modal($modal[0]);
            inst.show();
        }
    }

    function hideModal() {
        bindElements();
        if (typeof $.fn.modal === 'function') {
            $modal.modal('hide');
        } else if (window.bootstrap && bootstrap.Modal) {
            const inst = bootstrap.Modal.getInstance && bootstrap.Modal.getInstance($modal[0]);
            if (inst) inst.hide();
        }
    }

    // ================= Select2 (multi) =================
    function initSelect2() {
        if (!bindElements() || !$position.length) return false;
        if (!$position.hasClass('select2-hidden-accessible')) {
            $position.select2({
                dropdownParent: $modal,
                width: '100%',
                placeholder: '--- Select ---',
                closeOnSelect: false
            });
        }
        return true;
    }

    initSelect2();

    // ================= Load positions =================
    // Returns a promise so edit mode can wait before pre-selecting values
    function loadPositions(departmentId, selectedIds) {
        initSelect2();
        $position.empty().trigger('change');
        if (!departmentId) return $.Deferred().resolve().promise();

        $position.prop('disabled', true);

        return $.ajax({
            type: 'GET',
            url: employeeUrl,
            data: { id: departmentId },
            dataType: 'JSON'
        }).done(function (res) {
            (res.data || []).forEach(function (pos) {
                $position.append(new Option(pos.name, pos.id, false, false));
            });
            // Select2 compares values as strings, so cast ids
            $position.val((selectedIds || []).map(String)).trigger('change');
        }).fail(function () {
            new Noty({ text: 'Failed to load positions!', type: 'error', timeout: 3000 }).show();
        }).always(function () {
            $position.prop('disabled', false);
        });
    }

    // Department change
    $(document).on('change', FORM_ID + ' .type_form', function () {
        loadPositions($(this).val());
    });

    // Clear the red state as soon as the user fixes a field
    $(document).on('input change', FORM_ID + ' .data_required', function () {
        $(this).removeClass('is-invalid');
    });

    // ================= Open modal for EDIT =================
    // Edit button: class .btn-edit and data-id
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: showUrl + '/' + id,
            dataType: 'JSON'
        }).done(function (res) {
            if (res.status === 200) {
                fillSpecialForm(res.data);
            } else {
                new Noty({ text: res.message || 'Not found!', type: 'error', timeout: 3000 }).show();
            }
        }).fail(function (xhr) {
            new Noty({
                text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to load data!',
                type: 'error',
                timeout: 3000
            }).show();
        });
    });

    window.fillSpecialForm = function (d) {
        console.log(d);
        
        resetForm();
        if (!bindElements()) return;

        $('#form_id').val(d.id);
        $dept.val(d.department_id);
        $('.branch_id', $form).val(d.branch_id);
        $('.review', $form).val(d.review);
        $('.from_date', $form).val(d.from_date);
        $('.to_date', $form).val(d.to_date);
        $('.remark', $form).val(d.remark || '');

        $title.text($title.data('title-edit'));
        loadPositions(d.department_id, d.position_ids);   // load first, then pre-select
        showModal();
    };

    // ================= Submit (store / update) =================
    $(document).on('click', '.' + buttonSubmit, function () {
        if (!bindElements()) return;

        let num_miss = 0;

        $form.find('.data_required').each(function () {
            const v     = $(this).val();
            const empty = Array.isArray(v) ? v.length === 0 : $.trim(v || '') === '';
            $(this).toggleClass('is-invalid', empty);
            if (empty) num_miss++;
        });

        if (num_miss > 0) {
            new Noty({ text: 'Please check required fields', type: 'error', timeout: 3000 }).show();
            $form.find('.is-invalid:first').trigger('focus');
            return;
        }

        $('.' + buttonSubmit).attr('disabled', true);
        $('#btn-save-loading').css('display', 'block');
        $('.btn-text-save').css('display', 'none');

        const formId = $.trim($('#form_id').val()) || null;
        var positions = $position.val() || [];
        // Remove empty values
        positions = positions.filter(function(item) {
            return item !== "";
        });
        

        const payload = {
            form_rental_id: formId,
            department_id:  $dept.val(),
            branch_id:      $('.branch_id', $form).val(),
            position_ids:   positions,
            review:         $('.review', $form).val(),
            from_date:      $('.from_date', $form).val(),
            to_date:        $('.to_date', $form).val(),
            remark:         $.trim($('.remark', $form).val() || '')
        };

        $.ajax({
            type: 'POST',
            url: formId ? updateUrl : submitUrl,
            data: payload,
            dataType: 'JSON',
            headers: { 'X-CSRF-TOKEN': csrf() },
            success: function (response) {
                if (response.status === 200) {
                    new Noty({ text: response.message, type: 'success', timeout: 2000, progressBar: true }).show();
                    hideModal();
                    setTimeout(function () { window.location.replace(listUrl); }, 1500);
                } else {
                    new Noty({ text: response.message || 'Failed to save!', type: 'error', timeout: 3000 }).show();
                    resetSaveButton(buttonSubmit);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const res = xhr.responseJSON || {};
                    let errorMsg = res.message || 'Invalid data!';
                    if (res.errors) {
                        errorMsg = Array.isArray(res.errors)
                            ? res.errors.join('<br>')
                            : Object.values(res.errors).flat().join('<br>');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMsg,
                        confirmButtonText: 'OK',
                        customClass: { confirmButton: 'btn btn-primary' }
                    });
                } else {
                    new Noty({
                        text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to save data!',
                        type: 'error',
                        timeout: 3000
                    }).show();
                }
                resetSaveButton(buttonSubmit);
            }
        });
    });

    // ================= Delete =================
    // Delete button: class .btn-delete and data-id
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to delete?',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#9f2e32'
        }).then(function (r) {
            if (!r.isConfirmed) return;

            $.ajax({
                type: 'DELETE',
                url: destroyUrl + '/' + id,
                dataType: 'JSON',
                headers: { 'X-CSRF-TOKEN': csrf() },
                success: function (res) {
                    new Noty({ text: res.message, type: 'success', timeout: 2000 }).show();
                    setTimeout(function () { window.location.replace(listUrl); }, 1000);
                },
                error: function (xhr) {
                    new Noty({
                        text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to delete!',
                        type: 'error',
                        timeout: 3000
                    }).show();
                }
            });
        });
    });

    // ================= Reset =================
    function resetForm() {
        // If the form is not on the page, stop here instead of throwing
        if (!bindElements()) {
            console.warn('Form ' + FORM_ID + ' not found. Check the id in the Blade file.');
            return;
        }
        initSelect2();
        $form[0].reset();
        $position.empty().trigger('change');
        $form.find('.is-invalid').removeClass('is-invalid');
        $('#form_id').val('');
        $title.text($title.data('title-new'));
        resetSaveButton(buttonSubmit);
    }

    $(document).on('hidden.bs.modal', MODAL_ID, resetForm);
});

function resetSaveButton(buttonClass) {
    $('.' + buttonClass).attr('disabled', false);
    $('#btn-save-loading').css('display', 'none');
    $('.btn-text-save').css('display', 'block');
}