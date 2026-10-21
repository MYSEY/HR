<!-- Modal Display Duplicate Approved Records -->
<div class="modal fade" id="modal_duplicate_records" tabindex="-1" aria-labelledby="modalDuplicateLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="modalDuplicateLabel">
                    <i class="fa fa-exclamation-triangle me-2"></i>ទិន្នន័យស្ទួន (Duplicate Records)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <small class="text-muted d-block mb-3">ទិន្នន័យខាងក្រោមត្រូវ បាន Approve ក្នុងខែ/ឆ្នាំនេះរួចរាល់ហើយ ដូច្នេះប្រព័ន្ធមិនបាន Approve ស្ទួនឡើយ៖</small>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Net Amount</th>
                                <th class="text-center" style="width: 150px;">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody id="duplicate_table_body">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-reload-page" data-bs-dismiss="modal">យល់ព្រម</button>
            </div>
        </div>
    </div>
</div>
@include('includs.script')
<script type="text/javascript">
    (function () {
        $('body').on('click','.btn_approved', function() {
            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });
            var id = allVals.join(",");
            
            if (allVals.length <= 0) {
                $.alert({
                    title: '@lang("lang.approve")!',
                    content: '@lang("lang.please_select_item_befor_approve").',
                    type: 'blue',
                });
            } else {
                $.confirm({
                    title: '@lang("lang.approve")',
                    content: "@lang('lang.are_you_sure_want_to_approve')?",
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'ok',
                            btnClass: 'btn-blue',
                            action: function() {
                                $(".loading-icon").css('display', 'block');

                                axios.post('{{ URL('rental-pay/approved') }}', {
                                    'id': id,
                                }).then(function(response) {
                                    $(".loading-icon").css('display', 'none');
                                    let res = response.data;

                                    // 1. ករណីមាន Duplicate Data (Status 207)
                                    if (res.status === 207 && res.duplicates && res.duplicates.length > 0) {
                                        let rowsHtml = '';
                                        res.duplicates.forEach(function(item) {
                                            let net_amount      = `${parseFloat(item.total_net_amount_usd || 0).toFixed(2)}`;
                                            let replaceDataBtn = `
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger btn-replace-single" 
                                                        data-preview-id="${item.preview_id}"
                                                        data-motor-id="${item.motor_rental_id}">
                                                    <i class="fa fa-refresh me-1"></i> Replace
                                                </button>`;
                                            rowsHtml += `
                                                <tr id="row_duplicate_${item.preview_id}">
                                                    <td>${item.user.number_employee}</td>
                                                    <td>${item.user.employee_name_en}</td>
                                                    <td>$${net_amount}</td>
                                                    <td class="text-center">${replaceDataBtn}</td>
                                                </tr>`;
                                        });

                                        // Inject Rows ចូលក្នុង Modal Table Body
                                        $('#duplicate_table_body').html(rowsHtml);

                                        // បង្ហាញ Bootstrap Modal
                                        $('#modal_duplicate_records').modal('show');

                                    } else if (res.status === 200) {
                                        // 2. ករណី Approve ជោគជ័យទាំងអស់ (គ្មាន Duplicate)
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            icon: true
                                        }).show();
                                        $('.card-footer').remove();
                                        window.location.replace("{{ URL('rental-pay/generate') }}");
                                    } else {
                                        // 3. ករណី Status ផ្សេងៗ
                                        new Noty({
                                            title: "",
                                            text: res.message || '@lang("lang.something_went_wrong_please_try_again_later")',
                                            type: "error",
                                            icon: true
                                        }).show();
                                    }

                                }).catch(function(error) {
                                    $(".loading-icon").css('display', 'none');
                                    let errorMsg = error.response && error.response.data && error.response.data.message 
                                        ? error.response.data.message 
                                        : '@lang("lang.something_went_wrong_please_try_again_later")';

                                    new Noty({
                                        title: "",
                                        text: errorMsg,
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        close: function () {
                            $(".loading-icon").css('display', 'none');
                        }
                    }
                });
            }
        });
        // Event ពេល User បិទ Duplicate Modal ឱ្យវា Reload/Redirect ទំព័រ
        $(document).on('click', '.btn-reload-page, #modal_duplicate_records .btn-close', function () {
            window.location.replace("{{ URL('rental-pay/generate') }}");
        });

        $(document).on('click', '.btn-replace-single', function() {
            let previewId = $(this).data('preview-id');
            let motorId   = $(this).data('motor-id');
            let $btn      =$(this);

            $.confirm({
                title: 'ជំនួសទិន្នន័យ (Replace Approval)',
                content: 'តើអ្នកពិតជាចង់ លុបទិន្នន័យ Approved ចាស់ ហើយជំនួសដោយទិន្នន័យថ្មីនេះមែនទេ?',
                type: 'orange',
                typeAnimated: true,
                buttons: {
                    confirm: {
                        text: 'ជំនួស (Replace)',
                        btnClass: 'btn-orange',
                        action: function() {
                            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

                            axios.post('{{ URL("rental-pay/replace-approve") }}', {
                                'preview_id': previewId,
                                'motor_rental_id': motorId
                            }).then(function(response) {
                                if (response.data.status === 200) {
                                    new Noty({
                                        text: 'ជំនួសទិន្នន័យជោគជ័យ!',
                                        type: 'success'
                                    }).show();

                                    // លុប Row ចេញពី Table ក្នុង Modal
                                    $(`#row_duplicate_${previewId}`).fadeOut(300, function() {
                                        $(this).remove();
                                        // បើគ្មាន Row សល់ ត្រូវបិទ Modal
                                        if ($('#duplicate_table_body tr').length === 0) {
                                            $('#modal_duplicate_records').modal('hide');
                                            window.location.replace("{{ URL('rental-pay/generate') }}");
                                        }
                                    });
                                } else {
                                    new Noty({
                                        text: response.data.message || 'ជំនួសទិន្នន័យបរាជ័យ!',
                                        type: 'error'
                                    }).show();
                                    $btn.prop('disabled', false).html('<i class="fa fa-refresh me-1"></i> Replace');
                                }
                            }).catch(function(error) {
                                new Noty({
                                    text: 'មានបញ្ហាក្នុងការភ្ជាប់ទៅកាន់ Server!',
                                    type: 'error'
                                }).show();
                                $btn.prop('disabled', false).html('<i class="fa fa-refresh me-1"></i> Replace');
                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        });
    })()
</script>