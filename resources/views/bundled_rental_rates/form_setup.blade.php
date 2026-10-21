@extends('layouts.master')
@php
    $isEdit       = isset($id);                          // Edit: controller ផ្ញើ $id, $groupName, $groupedRates
    $groupedRates = collect($groupedRates ?? []);
    $groupName    = $groupName ?? '';
    $first        = $groupedRates->first(); 
    $curType      = ($first['type'] ?? null) ?: 'motorcycle';
    $transferDate = !empty($first['transfer_date']) ? \Carbon\Carbon::parse($first['transfer_date'])->format('Y-m-d') : '';
    $typeGroups = [
        'vehicles'     => ['motorcycle', 'car', 'tuk_tuk', 'truck', 'bicycle'],
        'it_equipment' => ['tablet', 'laptop', 'desktop', 'camera'],
        'other'        => ['leave', 'staff_transfer', 'other'],
    ];
@endphp
@include('bundled_rental_rates._style')

@section('content')
    <style>
        .type-section{ display:none; }
        #bundledRateForm .rental-page{ max-width:none; margin:0 0 24px; }
    </style>

    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">{{ $isEdit ? __('lang.edit') : __('lang.setup') }} @lang('lang.bundled_rental_rate')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('bundled-rental-rate') }}">@lang('lang.bundled_rental_rate')</a></li>
                    <li class="breadcrumb-item active">{{ $isEdit ? __('lang.edit') : __('lang.new') }}</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ⚠ Container តែមួយ គ្របគ្រប់ field (រួមទាំង name និង type) ដើម្បីឱ្យ JS ឆែក validation ត្រូវ --}}
    <div class="rental-ui" id="bundledRateForm">
        @csrf
        <input type="hidden" id="rate_id" value="{{ $id ?? '' }}">

        <div class="row">
            <div class="col-sm-3">
                <div class="f">
                    <label class="lbl">@lang('lang.name') <span class="text-danger">*</span></label>
                    <input type="text" class="form-control data_required set_name" value="{{ $groupName }}" autocomplete="off">
                    <div class="e">@lang('lang.please_fill')</div>
                </div>

                <div class="f">
                    <label class="lbl">@lang('lang.type_form') <span class="text-danger">*</span></label>
                    <select class="form-control data_required type_form">
                        <option value="" disabled @selected($curType === '')>--- @lang('lang.select') ---</option>
                        @foreach ($typeGroups as $group => $values)
                            <optgroup label="@lang('lang.' . $group)">
                                @foreach ($values as $v)
                                    <option value="{{ $v }}" @selected($curType === $v)>@lang('lang.' . $v)</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="e">@lang('lang.please_fill')</div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="rental-page">
                    <div class="sub" id="noTypeHint">--- @lang('lang.select') @lang('lang.type_form') ---</div>

                    {{-- 1. motorcycle: ច្រើនជួរ + Add more --}}
                    <div class="type-section" data-section="rates">
                        <div class="sub">@lang('lang.rates')</div>
                        <div id="rateRows">
                            @if ($isEdit && $curType === 'motorcycle')
                                @foreach ($groupedRates as $rate)
                                    @include('bundled_rental_rates._rate_row', ['r' => $rate])
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn-m" id="btnAddRate">+ @lang('lang.add_more')</button>
                    </div>

                    {{-- 2. tablet: Currency + Amount (គ្មាន Add more) --}}
                    <div class="type-section" data-section="tablet">
                        <div class="g2">
                            <div class="f">
                                <label class="lbl">@lang('lang.currency') <span class="text-danger">*</span></label>
                                <select class="form-control data_required tablet_currency">
                                    <option value="USD" @selected(data_get($first, 'currency', 'USD') === 'USD')>@lang('lang.usd')</option>
                                    <option value="KHR" @selected(data_get($first, 'currency') === 'KHR')>@lang('lang.khr')</option>
                                </select>
                                <div class="e">@lang('lang.please_fill')</div>
                            </div>
                            <div class="f">
                                <label class="lbl">@lang('lang.amount') <span class="text-danger">*</span></label>
                                <input type="text" inputmode="decimal" class="form-control data_required tablet_amount"
                                       value="{{ $curType === 'tablet' ? data_get($first, 'amount', '') : '' }}" autocomplete="off">
                                <div class="e">@lang('lang.please_fill')</div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. leave: Total Leave Day (គ្មាន Add more) --}}
                    <div class="type-section" data-section="leave">
                        <div class="f" style="max-width:300px">
                            <label class="lbl">@lang('lang.total_leave_day') <span class="text-danger">*</span></label>
                               <input type="text" inputmode="decimal" class="form-control data_required leave_days"
                                   value="{{ $curType === 'leave' ? data_get($first, 'leave_day', '') : '' }}" autocomplete="off">
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>

                    {{-- 4. staff_transfer: Select date (គ្មាន Add more) --}}
                    <div class="type-section" data-section="staff_transfer">
                        <div class="f" style="max-width:300px">
                            <label class="lbl">@lang('lang.select_day') <span class="text-danger">*</span></label>
                            <select class="form-control data_required transfer_day">
                                <option value="">--- @lang('lang.select') ---</option>
                                @for ($d = 1; $d <= 31; $d++)
                                    <option value="{{ $d }}" @selected($curType === 'staff_transfer' && (int) data_get($first, 'transfer_day') === $d)>{{ $d }}</option>
                                @endfor
                            </select>
                            <div class="e">@lang('lang.please_fill')</div>
                        </div>
                    </div>

                    <div class="act">
                        <a href="{{ url('bundled-rental-rate') }}" class="btn-m">@lang('lang.cancel')</a>
                        <button type="button" class="btn-m p submit-btn">
                            <span class="btn-text-save">@lang('lang.save')</span>
                            <span id="btn-save-loading" style="display:none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="rateRowTpl">
        @include('bundled_rental_rates._rate_row', ['r' => null])
    </template>
@endsection

@include('includs.script')
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script>
    const submitUrl = "{{ url('bundled-rental-rate/store') }}";
    const listUrl = "{{ url('bundled-rental-rate') }}";
    const updateUrl = "{{ url('bundled-rental-rate/update') }}";
    const buttonSubmit = "submit-btn";
</script>
<script src="{{ asset('/admin/component-js/setup_bundled_rental.js') }}"></script>