@php
    $data   = $data ?? null;
    $isEdit = !empty($data);
@endphp
<style>
    #formRentalModal .modal-dialog{ max-width:440px; }
    #formRentalModal .modal-content{ border:0; border-radius:12px; background:#fff; padding:20px; color:#2a1b1c; }
    #formRentalModal .modal-title{ font-size:17px; font-weight:700; margin:0 0 14px; }
    #formRentalModal .f{ margin-bottom:12px; }
    #formRentalModal .lbl{ display:block; font-size:13px; color:#6b6264; margin-bottom:4px; }
    #formRentalModal .form-control{ font:inherit; font-size:14px; padding:8px 12px; border:1px solid #e6e0e0; border-radius:8px; background:#f8f9fa; color:#2a1b1c; box-shadow:none; }
    #formRentalModal .form-control:focus{ border-color:#9f2e32; box-shadow:0 0 0 2px rgba(159,46,50,.15); }
    #formRentalModal .f .e{ display:none; color:#9f2e32; font-size:12px; margin-top:3px; }
    #formRentalModal .f:has(.is-invalid) .e{ display:block; }
    #formRentalModal .is-invalid{ border-color:#9f2e32 !important; background-image:none !important; }
    #formRentalModal .sub{ font-size:13px; color:#6b6264; margin:6px 0 8px; }

    /* ជួរ field */
    #formRentalModal .fr{ display:flex; gap:6px; flex-wrap:nowrap; align-items:flex-start; margin-bottom:8px; }
    #formRentalModal .fr .fl{ flex:1; min-width:0; margin:0; }
    #formRentalModal .fr .ft{ width:116px; flex:none; }
    @media (max-width:480px){ #formRentalModal .fr{ flex-wrap:wrap; } }
    #formRentalModal .chk{ display:flex; align-items:center; gap:5px; font-size:13px; color:#6b6264; padding-top:8px; white-space:nowrap; margin:0; }
    #formRentalModal .chk input{ width:17px; height:17px; accent-color:#9f2e32; }
    #formRentalModal .delete-row{ width:36px; height:36px; border:1px solid #e6e0e0; background:#fff; border-radius:8px; color:#2a1b1c; cursor:pointer; line-height:1; }
    #formRentalModal .delete-row:hover{ border-color:#9f2e32; color:#9f2e32; }
    #formRentalModal .option-wrapper{ margin:0 0 12px; }

    /* ទំហំ control ដូចរូប: input 40px, ជួរ field 38px */
    #formRentalModal .f > .form-control{ height:40px; }
    #formRentalModal .fr .form-control{ height:38px; padding-top:0; padding-bottom:0; }
    #formRentalModal .fr .chk{ height:38px; padding-top:0; }
    #formRentalModal .fr .delete-row{ height:38px; width:38px; flex:none; }
    #formRentalModal .lbl .text-danger{ color:inherit !important; }
    #formRentalModal .modal-title{ color:#2a1b1c; }
    #formRentalModal .cond{ padding:0 0 10px 2px; margin-top:-2px; }

    /* ប៊ូតុង */
    #formRentalModal .btn-m{ font:inherit; font-size:13px; padding:6px 14px; border-radius:7px; border:1px solid #e6e0e0; background:#fff; color:#2a1b1c; cursor:pointer; }
    #formRentalModal .btn-m.p{ background:#9f2e32; border-color:#9f2e32; color:#fff; }
    #formRentalModal .btn-m:disabled{ opacity:.6; cursor:wait; }
    #formRentalModal .act{ display:flex; justify-content:flex-end; gap:8px; margin-top:16px; }
</style>
<div class="modal fade" id="formRentalModal" tabindex="-1" aria-labelledby="formRentalModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <h5 class="modal-title" id="formRentalModalLabel"
                data-title-new="{{ __('lang.new') }} {{ __('lang.form_rental') }}"
                data-title-edit="{{ __('lang.edit') }} {{ __('lang.form_rental') }}">
                {{ $isEdit ? __('lang.edit') : __('lang.new') }} @lang('lang.form_rental')
            </h5>
            <form id="formRentalForm" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" id="form_id" name="form_rental_id" value="">

                <div class="f">
                    <label class="lbl">@lang('lang.form_name') <span class="text-danger">*</span></label>
                    <input type="text" class="form-control data_required field_tile" name="field_tile" autocomplete="off">
                    <div class="e">@lang('lang.please_fill')</div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="f">
                            <label class="lbl">@lang('lang.type_form') <span class="text-danger">*</span></label>
                            <select class="form-control data_required type_form" name="type_form">
                                <option value="" selected disabled>--- @lang('lang.select') ---</option>

                                <optgroup label="@lang('lang.vehicles')">
                                    <option value="motorcycle">@lang('lang.motorcycle')</option>
                                    <option value="car">@lang('lang.car')</option>
                                    <option value="tuk_tuk">@lang('lang.tuk_tuk')</option>
                                    <option value="truck">@lang('lang.truck')</option>
                                    <option value="bicycle">@lang('lang.bicycle')</option>
                                </optgroup>

                                <optgroup label="@lang('lang.it_equipment')">
                                    <option value="tablet">@lang('lang.tablet')</option>
                                    <option value="laptop">@lang('lang.laptop')</option>
                                    <option value="desktop">@lang('lang.desktop')</option>
                                    <option value="camera">@lang('lang.camera')</option>
                                </optgroup>

                                <optgroup label="@lang('lang.other')">
                                    <option value="machinery">@lang('lang.machinery')</option>
                                    <option value="other">@lang('lang.other')</option>
                                </optgroup>
                            </select>
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="f">
                            <label class="lbl">@lang('lang.select_condition') <span class="text-danger">*</span></label>
                            <select class="form-control data_required bunledrental_id" name="bundled_rental_id">
                                <option value="">--- @lang('lang.select') ---</option>
                                @foreach ($bundledRentals as $item)
                                    <option value="{{ $item->group_id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>
                </div>

                <div class="sub">@lang('lang.form_fields')</div>

                {{-- ជួរ field ត្រូវបានបន្ថែមដោយ JS --}}
                <div id="fieldRows"></div>

                <button type="button" class="btn-m" id="btnAddMore">+ @lang('lang.add_field')</button>

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

{{-- Template សម្រាប់ជួរ field មួយ (__i__ ត្រូវជំនួសដោយលេខរៀង) --}}
<template id="fieldRowTpl">
    <div class="field-row">
        <input type="hidden" class="field_id" value="">
        <div class="fr">
            <div class="f fl">
                <input type="text" class="form-control data_required field_label" name="fields[__i__][label]"
                       placeholder="@lang('lang.field_label')" aria-label="@lang('lang.field_label')" autocomplete="off">
                <div class="e">@lang('lang.please_fill')</div>
            </div>

            <select class="form-control field_type ft" name="fields[__i__][type]" aria-label="@lang('lang.field_type')">
                <option value="text">@lang('lang.text')</option>
                <option value="number">@lang('lang.number')</option>
                <option value="select">@lang('lang.select')</option>
                <option value="date">@lang('lang.date')</option>
            </select>

            <label class="chk">
                <input type="hidden" name="fields[__i__][is_required]" value="0">
                <input type="checkbox" class="is_required" name="fields[__i__][is_required]" value="1"> @lang('lang.required')
            </label>

            <button type="button" class="delete-row" aria-label="@lang('lang.delete')">✕</button>
        </div>

        {{-- បង្ហាញតែពេល type = select --}}
        <div class="option-wrapper f" style="display:none">
            <label class="lbl">@lang('lang.option') <span class="text-danger">*</span></label>
            <select class="select form-control optiop" name="fields[__i__][options][]" multiple>
                @foreach ($motorBrands as $item)
                    <option value="{{ $item->id }}">{{ $item->brand_name }}</option>
                @endforeach
            </select>
            <div class="e">@lang('lang.please_fill')</div>
        </div>
    </div>
</template>
@include('includs.script')
<script>
    const submitUrl = "{{ url('form-rental/store') }}";
    const updateUrl = "{{ url('form-rental/update') }}";
    const listUrl = "{{ url('form-rental') }}";
    const buttonSubmit = "submit-btn";
</script>
<script src="{{asset('/admin/component-js/form_rental.js')}}"></script>