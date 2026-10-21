{{-- resources/views/bundled_rental_rates/index.blade.php
     បង្ហាញបញ្ជី Bundled Rental Rate ជា card តាម group (style ដូច form create)
     Controller ផ្ញើ: $groups (ពី index()), $permission --}}
@extends('layouts.master')
@include('bundled_rental_rates._style')

@section('content')
    <style>
        .bnd-bar{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px; }
        .bnd-bar .search{ flex:1; min-width:200px; max-width:320px; font:inherit; font-size:14px; height:40px; padding:0 12px; border:1px solid #e6e0e0; border-radius:8px; background:#fff; color:#2a1b1c; }
        .bnd-bar .search:focus{ outline:0; border-color:#9f2e32; box-shadow:0 0 0 2px rgba(159,46,50,.15); }
        .chip-f{ font:inherit; font-size:13px; padding:5px 12px; border:1px solid #e6e0e0; border-radius:99px; background:#fff; color:#2a1b1c; cursor:pointer; }
        .chip-f.on{ background:#9f2e32; border-color:#9f2e32; color:#fff; }

        .bnd-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:14px; align-items:start; }
        .bnd-card{ background:#fff; border:1px solid #e6e0e0; border-radius:12px; padding:16px; display:flex; flex-direction:column; color:#2a1b1c; }
        .bnd-head{ display:flex; justify-content:space-between; align-items:flex-start; gap:10px; margin-bottom:12px; }
        .bnd-name{ font-size:16px; font-weight:700; margin-bottom:4px; }
        .bnd-badge{ display:inline-block; font-size:12px; font-weight:500; padding:2px 10px; border-radius:99px; background:#f1f1f1; color:#444; }
        .bnd-badge.t-motorcycle{ background:#f5e1e2; color:#9f2e32; }
        .bnd-badge.t-tablet{ background:#e2f3e1; color:#2d7a2b; }
        .bnd-badge.t-leave{ background:#fff1bd; color:#7a5600; }
        .bnd-badge.t-staff_transfer{ background:#e5edf7; color:#2f4a73; }
        .bnd-act{ display:flex; gap:6px; }
        .bnd-ico{ width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; padding:0; line-height:1; border:1px solid #e6e0e0; border-radius:8px; background:#fff; color:#6b6264 !important; cursor:pointer; text-decoration:none; transition:.15s; }
        .bnd-ico svg{ width:16px !important; height:16px !important; display:block !important; fill:none !important; stroke:currentColor !important; pointer-events:none; }
        .bnd-ico:hover{ border-color:#9f2e32; color:#9f2e32 !important; background:#fbf3f3; }
        .bnd-ico.danger:hover{ background:#f5e1e2; }
        .bnd-ico:focus-visible{ outline:2px solid #9f2e32; outline-offset:2px; }
        .btn-bnd{ display:inline-flex; align-items:center; gap:6px; background:#9f2e32; border:1px solid #9f2e32; color:#fff; border-radius:7px; font-size:13px; padding:7px 14px; text-decoration:none; }
        .btn-bnd svg{ width:15px; height:15px; }
        .btn-bnd:hover{ background:#862629; border-color:#862629; color:#fff; }
        .bnd-body{ flex:1; }
        .bnd-foot{ margin-top:12px; padding-top:10px; border-top:1px solid #f0ebeb; font-size:12px; color:#6b6264; }

        .bnd-tbl{ width:100%; border-collapse:collapse; font-size:13px; }
        .bnd-tbl th{ text-align:left; font-weight:500; color:#6b6264; padding:4px 6px 6px 0; border-bottom:1px solid #f0ebeb; }
        .bnd-tbl td{ padding:8px 6px 8px 0; border-bottom:1px solid #f7f3f3; vertical-align:top; }
        .bnd-tbl tr:last-child td{ border-bottom:0; }
        .bnd-tbl .amt{ font-weight:700; white-space:nowrap; }
        .chip{ display:inline-block; font-size:12px; padding:1px 8px; margin:0 4px 4px 0; border-radius:6px; background:#f5e1e2; color:#2a1b1c; }
        .tier{ padding:10px 0; border-bottom:1px solid #f0ebeb; }
        .tier:first-child{ padding-top:0; } .tier:last-child{ border-bottom:0; }
        .tier-top{ display:flex; justify-content:space-between; align-items:baseline; gap:8px; margin-bottom:6px; }
        .yrs{ font-size:13px; color:#6b6264; white-space:nowrap; }
        .tier .amt{ font-weight:700; white-space:nowrap; }
        .chip{ max-width:100%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; vertical-align:top; }
        .chip.more{ cursor:pointer; background:transparent; border:1px dashed #9f2e32; color:#9f2e32; font:inherit; font-size:12px; padding:1px 8px; }
        .chips .x{ display:none; } .chips.open .x{ display:inline-block; }
        .chips.open .m1, .chips:not(.open) .m2{ display:none; }
        .tier.extra{ display:none; } .bnd-card.open .tier.extra{ display:block; }
        .tgl{ margin-top:8px; background:none; border:0; padding:0; font:inherit; font-size:13px; color:#9f2e32; cursor:pointer; }
        .bnd-card.open .t1, .bnd-card:not(.open) .t2{ display:none; }
        .bnd-ticon{ width:40px; height:40px; border-radius:10px; display:inline-flex; align-items:center; justify-content:center; flex:none; background:#f1f1f1; color:#444; }
        .bnd-title{ flex:1; min-width:0; }
        .bnd-badge.tn-veh, .bnd-ticon.tn-veh{ background:#f5e1e2; color:#9f2e32; }
        .bnd-badge.tn-it, .bnd-ticon.tn-it{ background:#e2f3e1; color:#2d7a2b; }
        .bnd-badge.tn-leave, .bnd-ticon.tn-leave{ background:#fff1bd; color:#7a5600; }
        .bnd-badge.tn-move, .bnd-ticon.tn-move{ background:#e5edf7; color:#2f4a73; }
        .bnd-badge.tn-other, .bnd-ticon.tn-other{ background:#f1f1f1; color:#444; }
        .chip-f{ display:inline-flex; align-items:center; gap:6px; }
        .chip-f .ti{ flex:none; }
        .bnd-big{ font-size:28px; font-weight:700; line-height:1.2; }
        .bnd-sub{ font-size:13px; color:#6b6264; }
        .bnd-empty{ display:none; text-align:center; padding:40px 0; color:#6b6264; }
    </style>

    @php
        $sym   = fn ($c) => $c === 'KHR' ? '៛' : '$';
        // ពណ៌តាមក្រុម: veh (យានយន្ត), it (IT), leave, move (transfer), other
        $tones  = ['motorcycle'=>'veh','car'=>'veh','tuk_tuk'=>'veh','truck'=>'veh','bicycle'=>'veh','tablet'=>'it','laptop'=>'it','desktop'=>'it','camera'=>'it','leave'=>'leave','staff_transfer'=>'move'];
        $toneOf = fn ($t) => 'tn-' . ($tones[$t] ?? 'other');
        $types = collect($groups)->pluck('type')->unique()->values();
    @endphp

    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.bundled_rental_rate')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.bundled_rental_rate')</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                @if ($permission->is_create == '1')
                    <a href="{{ url('bundled-rental-rate/form') }}" class="btn-bnd">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg> @lang('lang.new') @lang('lang.bundled_rental_rate')
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if ($permission->is_view == '1')
        {!! Toastr::message() !!}

        <div class="rental-ui">
            <div class="bnd-bar">
                <input type="text" id="bndSearch" class="search" placeholder="@lang('lang.search')..." autocomplete="off">
                <button type="button" class="chip-f on" data-type="all">@lang('lang.all')</button>
                @foreach ($types as $t)
                    <button type="button" class="chip-f" data-type="{{ $t }}">@include('bundled_rental_rates.type_icon', ['type' => $t, 'size' => 14])@lang('lang.' . $t)</button>
                @endforeach
            </div>

            <div class="bnd-grid">
                @foreach ($groups as $g)
                    <div class="bnd-card" data-type="{{ $g['type'] }}" data-name="{{ mb_strtolower($g['name']) }}">
                        <div class="bnd-head">
                            <span class="bnd-ticon {{ $toneOf($g['type']) }}">@include('bundled_rental_rates.type_icon', ['type' => $g['type'], 'size' => 22])</span>
                            <div class="bnd-title">
                                <div class="bnd-name">@lang('lang.condition'): {{ $g['name'] }}</div>
                                <span class="bnd-badge {{ $toneOf($g['type']) }}">@lang('lang.' . $g['type'])</span>
                            </div>
                            <div class="bnd-act">
                                @if ($permission->is_update == '1')
                                    {{-- ប្តូរ URL ឱ្យត្រូវនឹង route formEdit របស់អ្នក --}}
                                    <a href="{{ url('bundled-rental-rate/edit/' . $g['id']) }}" class="bnd-ico" title="@lang('lang.edit')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></a>
                                @endif
                                @if ($permission->is_delete == '1')
                                    <button type="button" class="bnd-ico danger btn-delete" data-id="{{ $g['id'] }}" title="@lang('lang.delete')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg></button>
                                @endif
                            </div>
                        </div>

                        <div class="bnd-body">
                            @switch($g['type'])
                                @case('tablet')
                                    @php $r = $g['rates']->first(); @endphp
                                    <div class="bnd-sub">@lang('lang.amount')</div>
                                    <div class="bnd-big">{{ $sym($r['currency'] ?? 'USD') }}{{ number_format((float) ($r['amount'] ?? 0), 2) }}</div>
                                    @break

                                @case('leave')
                                    <div class="bnd-sub">@lang('lang.total_leave_day')</div>
                                    <div class="bnd-big">{{ rtrim(rtrim(number_format((float) ($g['leave_day'] ?? 0), 2, '.', ''), '0'), '.') }} <span class="bnd-sub">@lang('lang.day')</span></div>
                                    @break

                                @case('staff_transfer')
                                    <div class="bnd-sub">@lang('lang.select_day')</div>
                                    <div class="bnd-big">{{ $g['transfer_day'] ?? '-' }}</div>
                                    <div class="bnd-sub">@lang('lang.every_month')</div>
                                    @break

                                @default
                                    {{-- motorcycle (និង type ផ្សេងដែលមាន rates) --}}
                                    @php $maxChips = 2; $visTiers = 2; @endphp
                                    @foreach ($g['rates'] as $r)
                                        @php $ps = $r['positions']; $extra = max(count($ps) - $maxChips, 0); @endphp
                                        <div class="tier {{ $loop->index >= $visTiers ? 'extra' : '' }}">
                                            <div class="tier-top">
                                                <span class="yrs">{{ $r['from'] ?? '-' }} – {{ $r['to'] ?? '-' }} @lang('lang.year')</span>
                                                <span class="amt">{{ $sym($r['currency']) }}{{ number_format((float) $r['amount'], 2) }}</span>
                                            </div>
                                            <div class="chips">
                                                @foreach ($ps as $p)
                                                    <span class="chip {{ $loop->index >= $maxChips ? 'x' : '' }}" title="{{ $p }}">{{ $p }}</span>
                                                @endforeach
                                                @if ($extra > 0)
                                                    <button type="button" class="chip more"><span class="m1">+{{ $extra }}</span><span class="m2">@lang('lang.show_less')</span></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($g['rates']->count() > $visTiers)
                                        <button type="button" class="tgl"><span class="t1">@lang('lang.show_all') ({{ $g['rates']->count() }})</span><span class="t2">@lang('lang.show_less')</span></button>
                                    @endif
                            @endswitch
                        </div>

                        <div class="bnd-foot">@lang('lang.created_at'): {{ optional($g['created_at'])->format('d M Y') }}</div>
                    </div>
                @endforeach
            </div>

            <div class="bnd-empty" id="bndEmpty">@lang('lang.no_data')</div>
            @if (collect($groups)->isEmpty())
                <div class="bnd-empty" style="display:block">@lang('lang.no_data')</div>
            @endif
        </div>
    @endif
@endsection

@include('includs.script')
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/js/noty.js') }}"></script>
@section('script')
<script>
    const deleteUrl = "{{ url('bundled-rental-rate/delete') }}";   // ប្តូរតាម route របស់អ្នក

    $(function () {
        let type = 'all';

        function applyFilter() {
            const q = $.trim($('#bndSearch').val()).toLowerCase();
            let shown = 0;
            $('.bnd-card').each(function () {
                const ok = (type === 'all' || String($(this).data('type')) === type)
                        && (!q || String($(this).data('name')).indexOf(q) > -1);
                $(this).toggle(ok);
                if (ok) shown++;
            });
            $('#bndEmpty').toggle(shown === 0 && $('.bnd-card').length > 0);
        }

        $('#bndSearch').on('input', applyFilter);

        $(document).on('click', '.chip.more', function () { $(this).closest('.chips').toggleClass('open'); });
        $(document).on('click', '.tgl', function () { $(this).closest('.bnd-card').toggleClass('open'); });

        $(document).on('click', '.chip-f', function () {
            $('.chip-f').removeClass('on');
            $(this).addClass('on');
            type = String($(this).data('type'));
            applyFilter();
        });

        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: '@lang("lang.delete")',
                text: '@lang("lang.are_you_sure_want_to_delete")?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang("lang.delete")',
                cancelButtonText: '@lang("lang.cancel")',
                customClass: { confirmButton: 'btn btn-primary' }
            }).then(function (r) {
                if (!r.isConfirmed) return;
                $.ajax({
                    type: 'POST', url: deleteUrl, dataType: 'JSON',
                    data: { id: id, _token: '{{ csrf_token() }}' },
                    success: function (res) {
                        if (res.status === 200) {
                            new Noty({ text: res.message, type: 'success', timeout: 1500 }).show();
                            setTimeout(function () { window.location.reload(); }, 800);
                        } else {
                            new Noty({ text: res.message || 'Error', type: 'error', timeout: 3000 }).show();
                        }
                    },
                    error: function (xhr) {
                        new Noty({ text: (xhr.responseJSON && xhr.responseJSON.message) || 'Error', type: 'error', timeout: 3000 }).show();
                    }
                });
            });
        });
    });
</script>
@endsection