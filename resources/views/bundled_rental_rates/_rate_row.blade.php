{{-- resources/views/bundled-rental/_rate_row.blade.php
     params: $r (nullable = ជួរថ្មី), $positions --}}
@php
    $rt  = $r ? (object) $r : null;   // ទទួល array ពី $groupedRates
    $pos = $rt->position_ids ?? [];
    $pos = is_array($pos) ? $pos : [];
    $cur = $rt->currency ?? 'USD';
@endphp
<div class="rate-row">
    <input type="hidden" class="rate_row_id" value="{{ $rt->id ?? '' }}">

    <div class="rr-head">
        <span class="rr-no"></span>
        <button type="button" class="delete-row" aria-label="@lang('lang.delete')">✕</button>
    </div>

    <div class="g2">
        <div class="f">
            <label class="lbl">@lang('lang.from') @lang('lang.year') <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control data_required from" value="{{ $rt->from ?? '' }}">
            <div class="e">@lang('lang.please_fill')</div>
        </div>
        <div class="f">
            <label class="lbl">@lang('lang.to') @lang('lang.year') <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control data_required to" value="{{ $rt->to ?? '' }}">
            <div class="e">@lang('lang.please_fill')</div>
        </div>
    </div>

    <div class="g2">
        <div class="f">
            <label class="lbl">@lang('lang.currency') <span class="text-danger">*</span></label>
            <select class="form-control data_required currency">
                <option value="USD" @selected($cur === 'USD')>@lang('lang.usd')</option>
                <option value="KHR" @selected($cur === 'KHR')>@lang('lang.khr')</option>
            </select>
            <div class="e">@lang('lang.please_fill')</div>
        </div>
        <div class="f">
            <label class="lbl">@lang('lang.amount') <span class="text-danger">*</span></label>
            <input type="text" class="form-control data_required amount" inputmode="decimal" value="{{ $rt->amount ?? '' }}" autocomplete="off">
            <div class="e">@lang('lang.please_fill')</div>
        </div>
    </div>

    <div class="f" style="margin-bottom:0">
        <label class="lbl">@lang('lang.position') <span class="text-danger">*</span></label>
        <select class="form-control data_required position-review-select" multiple>
            @foreach ($positions as $item)
                <option value="{{ $item->id }}" @selected(in_array($item->id, $pos))>{{ $item->name_english }}</option>
            @endforeach
        </select>
        <div class="e">@lang('lang.please_fill')</div>
    </div>
</div>