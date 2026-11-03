@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: pre-line !important;
        text-align: left !important;
        max-width: 500px !important; 
        /* word-wrap: break-word !important; */
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fn_special_review')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fn_special_review')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_create == "1")
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formSpecialModal">
                            <i class="fa fa-plus"></i> @lang('lang.new') @lang('lang.special')
                        </button>
                        {{-- <a href="{{url('form-rental/form')}}" class="btn add-btn"><i class="fa fa-plus"></i> @lang('lang.add_new')</a> --}}
                    @endif
                </div>
            </div>
        </div>
        @if ($permission->is_view == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-form-rental"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang._no')</th>
                                                <th>@lang('lang.supporting_department')</th>
                                                <th>@lang('lang.supporting_position')</th>
                                                <th>@lang('lang.supported_branch')</th>
                                                <th>@lang('lang.review') @lang('lang.level')</th>
                                                <th>@lang('lang.effective_from')</th>
                                                <th>@lang('lang.effective_to')</th>
                                                <th>@lang('lang.remark')</th>
                                                <th>@lang('lang.created_by')</th>
                                                <th>@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @include('fn_special_reviews.modal_form')
    </div>
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script>
    $(function(){
        datashowTables();
    });

    function datashowTables() {
        $('#loading-overlay').show();

        var tableId = '#DataTables_Table_0';
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().clear().destroy();
            $(tableId + ' tbody').empty(); 
        }
        $(tableId).DataTable({
            retrieve: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ url("fn/special/review") }}', // កែប្រែដកអក្សរ 't' ចេញត្រង់នេះ
                type: 'GET'
            },
            columns: [
                {
                    data: null, name: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'department', name: 'department', orderable: false, defaultContent: '' },
                {
                    data: 'positions', name: 'positions', orderable: false, searchable: false,
                    render: function (data) {
                        if (!data || !data.length) return '';

                        const esc  = function (s) { return $('<div>').text(s).html(); };
                        const attr = function (s) {
                            return String(s).replace(/&/g, '&amp;').replace(/"/g, '&quot;')
                                            .replace(/</g, '&lt;').replace(/>/g, '&gt;');
                        };

                        // Cell text (cut at 30 characters)
                        const full    = data.join(', ');
                        const limited = full.length > 30 ? full.substring(0, 30) + '...' : full;

                        // Numbered list: "1. Name", one per line
                        const numbered = data.map(function (p, i) { return (i + 1) + '. ' + p; });

                        // Bootstrap tooltip (HTML): lines separated by <br>
                        const htmlTip = attr(numbered.map(esc).join('<br>'));

                        // Fallback native tooltip: lines separated by a newline
                        const plainTitle = numbered.map(attr).join('&#10;');

                        return '<span class="pos-tip" data-tip="' + htmlTip + '" title="' + plainTitle + '" style="cursor:pointer;">'
                            + esc(limited) + '</span>';
                    }
                },
                { data: 'branch',     name: 'branch',     orderable: false, defaultContent: '' },
                { data: 'review',     
                    name: 'review', 
                    orderable: false, defaultContent: '',
                    render: function (data) { 
                        return "@lang('lang.review') "+data; 
                    }
                },
                { data: 'from_date',  name: 'from_date' },
                { data: 'to_date',    name: 'to_date' },
                {
                    data: 'remark', name: 'remark', orderable: false, defaultContent: '',
                    render: function (data) {
                        if (!data) return '';

                        const esc  = function (s) { return $('<div>').text(s).html(); };
                        const attr = function (s) {
                            return String(s).replace(/&/g, '&amp;').replace(/"/g, '&quot;')
                                            .replace(/</g, '&lt;').replace(/>/g, '&gt;');
                        };

                        // Cell text, cut at 30 characters (new lines become spaces)
                        const flat    = String(data).replace(/\s*\n\s*/g, ' ');
                        const limited = flat.length > 30 ? flat.substring(0, 30) + '...' : flat;

                        // Bootstrap HTML tooltip: keep the user's line breaks
                        const htmlTip = attr(esc(data).replace(/\n/g, '<br>'));

                        // Fallback native tooltip
                        const plainTitle = attr(data).replace(/\n/g, '&#10;');

                        return '<span class="remark-tip" data-tip="' + htmlTip + '" title="' + plainTitle + '" style="cursor:pointer;">'
                            + esc(limited) + '</span>';
                    }
                },
                { data: 'created_by', name: 'created_by', orderable: false, defaultContent: '' },
                {
                    data: null, name: 'action', orderable: false, searchable: false, className: 'text-end',
                    render: function (data, type, row) {
                        let isUpdate = '{{ $permission->is_update }}' === '1';
                        let isDelete = '{{ $permission->is_delete }}' === '1';

                        if (!isUpdate && !isDelete) return '';

                        let editUrl = "{{ url('form-rental/edit') }}/" + row.id;
                        let editBtn = isUpdate
                        ? `<a class="dropdown-item btn-edit" data-id="${row.id}" href="javascript:void(0);"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>`
                        : '';
    
                        // let editBtn = isUpdate ? `<a href="${editUrl}" class="dropdown-item update"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>` : '';
                        let deleteBtn = isDelete ? `<a class="dropdown-item btn-delete" data-id="${row.id}"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>` : '';

                        return `
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ${editBtn}
                                    ${deleteBtn}
                                </div>
                            </div>`;
                    }
                }
            ],
            order: [[0, 'desc']],
            drawCallback: function() {
                $('#loading-overlay').hide();
                initPositionTooltips();
            }
        });
    }
    function initPositionTooltips() {
        document.querySelectorAll('#DataTables_Table_0 .pos-tip, #DataTables_Table_0 .remark-tip').forEach(function (el) {
            try {
                if (window.bootstrap && bootstrap.Tooltip) {
                    const old = bootstrap.Tooltip.getInstance && bootstrap.Tooltip.getInstance(el);
                    if (old) old.dispose();

                    new bootstrap.Tooltip(el, {
                        html: true,
                        container: 'body',
                        trigger: 'hover',
                        title: el.getAttribute('data-tip')
                    });
                }
            } catch (e) {
                console.warn('Tooltip init failed, using native title', e);
            }
        });
    }

</script>
@endsection
