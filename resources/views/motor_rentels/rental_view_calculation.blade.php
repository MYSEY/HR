<!-- Single Form Detail Modal -->
<div class="modal fade" id="modal_view_form_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-primary" id="modal_form_title">
                    <i class="fa fa-file-text-o me-2"></i> Form Detail
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detail_form_container" class="row g-3">
                    <!-- Dynamic form details will be injected here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div>
    </div>
</div>
@include('includs.script')
<script type="text/javascript">
    $(function() {
        $(document).on("click", ".btn-view-single-form", function () {
            let formIndex = $(this).data('form-index');
            
            let table = $('#DataTables_Table_0').DataTable();
            let rowData = table.row($(this).closest('tr')).data();
            
            if (!rowData) return;

            let detailsList = rowData.details || [];
            let clickedDetail = detailsList[formIndex] || {};

            if (!clickedDetail.type) return;

            // 1. ទាញយក Detail Records ទាំងអស់ដែលមាន Form Type ដូចគ្នា (ឧទាហរណ៍៖ type = 'motorcycle')
            let targetType = clickedDetail.type.toLowerCase().trim();
            let sameTypeDetails = detailsList.filter(item => (item.type || '').toLowerCase().trim() === targetType);

            // 2. Parse dynamic fields JSON ពី record ដំបូង
            let fieldsData = {};
            if (clickedDetail.fields) {
                try {
                    fieldsData = typeof clickedDetail.fields === 'string' ? JSON.parse(clickedDetail.fields) : clickedDetail.fields;
                } catch (e) {
                    fieldsData = {};
                }
            }

            let currency = (clickedDetail.currency || 'USD').toUpperCase();
            let formTitle = clickedDetail.type ? clickedDetail.type.toUpperCase() : 'Rental Form Detail';
            $('#modal_form_title').html(`<i class="fa fa-file-text-o me-2"></i> ${formTitle}`);

            let detailHtml = '';

            // ==========================================
            // SECTION 1: Dynamic Form Fields (Brand, Plate, etc.)
            // ==========================================
            if (Object.keys(fieldsData).length > 0) {
                detailHtml += `<div class="col-12 mb-2"><h6 class="fw-bold text-primary border-bottom pb-1 mb-2"><i class="fa fa-info-circle me-1"></i> Form Information</h6></div>`;
                $.each(fieldsData, function (key, fieldObj) {
                    let label = fieldObj.field_label || 'Field';
                    let val = fieldObj.value || '-';
                    detailHtml += `
                        <div class="col-6 mb-2">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block fw-normal" style="font-size: 11px;">${label}</small>
                                <span class="fw-bold text-dark" style="font-size: 13px;">${val}</span>
                            </div>
                        </div>`;
                });
            }

            // ==========================================
            // SECTION 2: Calculation & Work Details (Loop តាម Position)
            // ==========================================
            detailHtml += `<div class="col-12 mt-2 mb-1"><h6 class="fw-bold text-primary border-bottom pb-1"><i class="fa fa-calculator me-1"></i> Calculation & Work Details (By Position)</h6></div>`;

            sameTypeDetails.forEach(function (detail, idx) {
                // ឈ្មោះ Position (បើមាន relation position ទាញយកឈ្មោះ ៖ detail.position?.name ឬ detail.position_name)
                let posName = detail.position ? detail.position.name_english : (detail.position_name || `Position Period ${idx + 1}`);

                let priceVal      = `${parseFloat(detail.price || 0).toFixed(2)} ${currency}`;
                let amountVal     = `${parseFloat(detail.amount || 0).toFixed(2)} ${currency}`;
                let amountExclTax = `${parseFloat(detail.amount_excl_tax || 0).toFixed(2)} ${currency}`;
                let taxFeeVal     = `${parseFloat(detail.tax_fee || 0).toFixed(2)} ${currency}`;
                let netAmountVal  = `${parseFloat(detail.net_amount || 0).toFixed(2)} ${currency}`;
                let workDays      = parseFloat(detail.total_work_day || 0).toFixed(1);
                let leaveDays     = detail.total_leave_days ? parseFloat(detail.total_leave_days).toFixed(1) : '0';
                let leaveAmt      = `${parseFloat(detail.leave_amount || 0).toFixed(2)} ${currency}`;

                let adjEx  = `${parseFloat(detail.adjust_amount_excl || 0).toFixed(2)} ${currency}`;
                let adjIn  = `${parseFloat(detail.adjust_amount_incl || 0).toFixed(2)} ${currency}`;
                let adjTax = `${parseFloat(detail.adjust_tax_fee || 0).toFixed(2)} ${currency}`;
                let adjKhr = `${parseFloat(detail.adjust_amount_khr || 0)}`;

                detailHtml += `
                    <div class="col-12">
                        <div class="card border border-primary-subtle shadow-sm mb-0">
                            <div class="card-header bg-primary text-white py-1 px-3 d-flex justify-content-between align-items-center">
                                <span class="fw-bold" style="font-size: 13px;"><i class="fa fa-briefcase me-1"></i> ${posName}</span>
                                <span class="badge bg-light text-primary fw-bold">${priceVal}</span>
                            </div>
                            <div class="card-body p-2">
                                <div class="row g-2">
                                    <!-- Work Days & Leave -->
                                    <div class="col-4">
                                        <div class="p-2 border rounded bg-light border-info">
                                            <small class="text-muted d-block" style="font-size: 11px;">Rental Price</small>
                                            <span class="fw-bold text-dark" style="font-size: 13px;">${priceVal}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded bg-light border-info">
                                            <small class="text-muted d-block" style="font-size: 11px;">Total Work Days</small>
                                            <span class="fw-bold text-primary" style="font-size: 13px;">${workDays} ថ្ងៃ</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded bg-light border-info">
                                            <small class="text-muted d-block" style="font-size: 11px;">Total Leave Days / Amt</small>
                                            <span class="fw-bold text-warning" style="font-size: 13px;">${leaveDays} ថ្ងៃ / ${leaveAmt}</span>
                                        </div>
                                    </div>

                                    <!-- Calculations -->
                                    <div class="col-4">
                                        <div class="p-2 border rounded bg-light">
                                            <small class="text-muted d-block" style="font-size: 11px;">Calculated Amount</small>
                                            <span class="fw-bold text-dark" style="font-size: 13px;">${amountVal}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded bg-light">
                                            <small class="text-muted d-block" style="font-size: 11px;">Tax Fee (${detail.tax_rate || 0}%)</small>
                                            <span class="fw-bold text-danger" style="font-size: 13px;">${taxFeeVal}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded bg-light border-success">
                                            <small class="text-muted d-block" style="font-size: 11px;">Excl. Tax Amount</small>
                                            <span class="fw-bold text-success" style="font-size: 13px;">${amountExclTax}</span>
                                        </div>
                                    </div>

                                    <!-- Adjustments -->
                                    <div class="col-3">
                                        <div class="p-2 border rounded bg-light">
                                            <small class="text-muted d-block" style="font-size: 10px;">Adj Excl. Tax</small>
                                            <span class="fw-bold text-secondary" style="font-size: 11px;">${adjEx}</span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="p-2 border rounded bg-light">
                                            <small class="text-muted d-block" style="font-size: 10px;">Adj Incl. Tax</small>
                                            <span class="fw-bold text-secondary" style="font-size: 11px;">${adjIn}</span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="p-2 border rounded bg-light">
                                            <small class="text-muted d-block" style="font-size: 10px;">Adj Tax Fee</small>
                                            <span class="fw-bold text-secondary" style="font-size: 11px;">${adjTax}</span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="p-2 border rounded bg-light">
                                            <small class="text-muted d-block" style="font-size: 10px;">Adj (KHR)</small>
                                            <span class="fw-bold text-secondary" style="font-size: 11px;">${formatMoney(adjKhr, "KHR")} KHR</span>
                                        </div>
                                    </div>

                                    <!-- Net Amount -->
                                    <div class="col-12 mt-1">
                                        <div class="p-2 border rounded bg-success-subtle border-success d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-success" style="font-size: 12px;">Net Amount Payment:</span>
                                            <span class="fw-bold text-success fs-6">${netAmountVal}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
            });

            // ==========================================
            // SECTION 3: Status / Termination Check
            // ==========================================
            if (clickedDetail.status === 'terminated') {
                detailHtml += `
                    <div class="col-12 mt-2">
                        <div class="alert alert-danger d-flex align-items-center mb-0 p-2" role="alert">
                            <i class="fa fa-exclamation-triangle me-2 fs-5"></i>
                            <div>
                                <strong>ស្ថានភាព៖ </strong> បានបញ្ចប់ការជួល (Terminated)<br>
                                <small><strong>កាលបរិច្ឆេទបញ្ចប់៖ </strong> ${clickedDetail.terminate_date || 'N/A'}</small>
                            </div>
                        </div>
                    </div>`;
                $('.btnStopRenting').addClass('d-none');$('.btnPrint').addClass('d-none');
            } else {
                let formType = (clickedDetail.type || '').toLowerCase().trim();

                $('.btnPrint').removeClass('d-none').attr('data-type', formType);

                $('.btnStopRenting')
                    .removeClass('d-none')
                    .attr('data-motor-id', rowData.id)
                    .attr('data-form-id', clickedDetail.id);
            }

            // Inject ចូលទៅក្នុង Modal
            $('#detail_form_container').html(detailHtml);
            $('#modal_view_form_details').modal('show');
        });
    });
</script>