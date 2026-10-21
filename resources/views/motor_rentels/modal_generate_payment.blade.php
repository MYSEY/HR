<div id="add_pay_motor_rentel" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-ms" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.new_payment_rental')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('rental-pay/generate')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <label class="">@lang('lang.from_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="from_date" name="from_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="">@lang('lang.to_date') <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="to_date" name="to_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('lang.status') <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="">-- @lang('lang.select') --</option>
                                    <option value="1">@lang('lang.active')</option>
                                    <option value="0">@lang('lang.inactive')</option>
                                </select>
                                <div class="invalid-feedback">
                                    សូមជ្រើសរើស Status!
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">@lang('lang.tax_rate') (%)<span class="text-danger">*</span></label>
                                <input class="form-control @error('tax_rate') is-invalid @enderror" type="number" id="tax_rate" required name="tax_rate" value="{{$TaxRental ? $TaxRental->tax_rate : 0}}">
                                <input class="form-control" type="number" hidden id="tax_rate_id" name="tax_rate_id" value="{{$TaxRental ? $TaxRental->id : ''}}">
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                        <button type="submit" class="btn btn-primary submit-btn" data-dismiss="modal">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.submit')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('includs.script')
<script type="text/javascript">
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>