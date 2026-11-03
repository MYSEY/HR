@php
    $data   = $data ?? null;
    $isEdit = !empty($data);
@endphp
<style>
    #formSpecialModal .modal-dialog{ max-width:440px; }
    #formSpecialModal .modal-content{ border:0; border-radius:12px; background:#fff; padding:20px; color:#2a1b1c; }
    #formSpecialModal .modal-title{ font-size:17px; font-weight:700; margin:0 0 14px; color:#2a1b1c; }
    #formSpecialModal .f{ margin-bottom:12px; }
    #formSpecialModal .lbl{ display:block; font-size:13px; color:#6b6264; margin-bottom:4px; }
    #formSpecialModal .lbl .text-danger{ color:inherit !important; }
    #formSpecialModal .form-control{ font:inherit; font-size:14px; padding:8px 12px; border:1px solid #e6e0e0; border-radius:8px; background:#f8f9fa; color:#2a1b1c; box-shadow:none; }
    #formSpecialModal .form-control:focus{ border-color:#9f2e32; box-shadow:0 0 0 2px rgba(159,46,50,.15); }
    #formSpecialModal .f > .form-control:not([multiple]){ height:40px; }

    /* error state */
    #formSpecialModal .f .e{ display:none; color:#9f2e32; font-size:12px; margin-top:3px; }
    #formSpecialModal .f:has(.is-invalid) .e{ display:block; }
    #formSpecialModal .is-invalid{ border-color:#9f2e32 !important; background-image:none !important; }
    #formSpecialModal .f:has(.is-invalid) .select2-selection{ border-color:#9f2e32 !important; }

    /* select2 (multi) to match the other inputs */
    #formSpecialModal .select2-container{ width:100% !important; }
    #formSpecialModal .select2-container--default .select2-selection--multiple{
        min-height:40px; border:1px solid #e6e0e0; border-radius:8px; background:#f8f9fa; padding:2px 6px;
    }
    #formSpecialModal .select2-container--default.select2-container--focus .select2-selection--multiple,
    #formSpecialModal .select2-container--default.select2-container--open .select2-selection--multiple{
        border-color:#9f2e32; box-shadow:0 0 0 2px rgba(159,46,50,.15);
    }
    #formSpecialModal .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background:#f3e4e5; border:1px solid #e6c9cb; color:#2a1b1c; border-radius:6px; font-size:13px;
    }
    .select2-container--open{ z-index:2000; }

    /* buttons */
    #formSpecialModal .btn-m{ font:inherit; font-size:13px; padding:6px 14px; border-radius:7px; border:1px solid #e6e0e0; background:#fff; color:#2a1b1c; cursor:pointer; }
    #formSpecialModal .btn-m.p{ background:#9f2e32; border-color:#9f2e32; color:#fff; }
    #formSpecialModal .btn-m:disabled{ opacity:.6; cursor:wait; }
    #formSpecialModal .act{ display:flex; justify-content:flex-end; gap:8px; margin-top:16px; }
</style>

<div class="modal fade" id="formSpecialModal" tabindex="-1" aria-labelledby="formSpecialModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <h5 class="modal-title" id="formSpecialModalLabel"
                data-title-new="{{ __('lang.new') }} {{ __('lang.special') }}"
                data-title-edit="{{ __('lang.edit') }} {{ __('lang.special') }}">
                {{ $isEdit ? __('lang.edit') : __('lang.new') }} @lang('lang.special') @lang('lang.review')
            </h5>

            <form id="formSpecialForm" novalidate>
                @csrf
                <input type="hidden" id="form_id" name="form_rental_id" value="">

                <div class="row">
                    {{-- Department --}}
                    <div class="col-md-6">
                        <div class="f">
                            <label class="lbl">@lang('lang.supporting_department') <span class="text-danger">*</span></label>
                            <select class="form-control data_required type_form" name="department_id">
                                <option value="" selected disabled>--- @lang('lang.select') ---</option>
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_english }}</option>
                                @endforeach
                            </select>
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>

                    {{-- Branch --}}
                    <div class="col-md-6">
                        <div class="f">
                            <label class="lbl">@lang('lang.supported_branch') <span class="text-danger">*</span></label>
                            <select class="form-control data_required branch_id" name="branch_id">
                                <option value="">--- @lang('lang.select') ---</option>
                                @foreach ($branchs as $item)
                                    <option value="{{ $item->id }}">{{ $item->branch_name_en }}</option>
                                @endforeach
                            </select>
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>

                    {{-- Position (multi, loaded by department) --}}
                    <div class="col-md-12">
                        <div class="f">
                            <label class="lbl">@lang('lang.supporting_position')<span class="text-danger">*</span></label>
                            <select class="form-control data_required position" name="position[]" multiple></select>
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>

                    {{-- Review --}}
                    <div class="col-md-12">
                        <div class="f">
                            <label class="lbl">@lang('lang.review') @lang('lang.level')<span class="text-danger">*</span></label>
                            <select class="form-control data_required review" name="review">
                                <option value="">--- @lang('lang.select') ---</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">@lang('lang.review') {{ $i }}</option>
                                @endfor
                            </select>
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div class="col-md-6">
                        <div class="f">
                            <label class="lbl">@lang('lang.effective_from') <span class="text-danger">*</span></label>
                            <input type="date" class="form-control data_required from_date" name="from_date" autocomplete="off">
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="f">
                            <label class="lbl">@lang('lang.effective_to') <span class="text-danger">*</span></label>
                            <input type="date" class="form-control data_required to_date" name="to_date" autocomplete="off">
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="f">
                            <label class="lbl">@lang('lang.remark')</label>
                            <textarea class="form-control remark" name="remark" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="act">
                    <button type="button" class="btn-m" data-bs-dismiss="modal">@lang('lang.cancel')</button>
                    <button type="button" class="btn-m p submit-btn">
                        <span class="btn-text-save">@lang('lang.save')</span>
                        <span id="btn-save-loading" style="display:none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('includs.script') {{-- must load jQuery, Bootstrap 5, Select2, Noty, SweetAlert2 --}}
<script>
    const submitUrl    = "{{ url('/fn/special/store') }}";
    const updateUrl    = "{{ url('/fn/special/update') }}";
    const listUrl      = "{{ url('/fn/special/review') }}";
    const employeeUrl  = "{{ url('/fn/special/employee') }}";
    const showUrl      = "{{ url('/fn/special/show') }}";
    const destroyUrl   = "{{ url('/fn/special/destroy') }}";
    const buttonSubmit = "submit-btn";
</script>
<script src="{{ asset('/admin/component-js/fn_special_review.js') }}?v={{ time() }}"></script>