@extends('layouts.master')
<style>
    .jconfirm-buttons-center{
        float: none !important;
        text-align: center !important;
    }
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 30px;
        /* margin-bottom: 5px; */
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.inter-result')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.inter-result')</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table no-footer tbl-result"
                                        aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                                <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.en'))</th>
                                                <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.kh'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">@lang('lang.gender')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position Applied: activate to sort column ascending" >@lang('lang.position_applied')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Location Applied: activate to sort column ascending" >@lang('lang.location_applied')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Interviewed Date: activate to sort column ascending" >@lang('lang.interviewed_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Interviewed Result: activate to sort column ascending" >@lang('lang.interviewed_result')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" >@lang('lang.status')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" >@lang('lang.remark')</th>
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
        </div>
         <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading Data...</p>
            </div>
        </div>
    </div>
    <div id="permission-data"
        data-update="{{ $permission->is_update }}"
        data-delete="{{ $permission->is_delete }}">
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script src="{{asset('/admin/component-js/candidate_resume.js')}}"></script>
<script>
    appUrls = {
        status:"{{ URL('recruitment/candidate-resume/status') }}",
        currentPage:"{{ URL('recruitment/candidate-resume/interresult') }}"
    };
    window.Lang = @json(__('lang'));
</script>
<script type="text/javascript">
    $(function(){
        showDatas();
    });
    function strLimit(str, limit = 30, end = '...') {
        return str.length > limit ? str.substring(0, limit) + end : str;
    }
    function showDatas(){
        var localeLanguage = '{{ config('app.locale') }}';
        let is_update = $('#permission-data').data('update');
        var status_tab = 3;
        var btn_tab = 3;
        $('.tbl-result').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            ajax: {
                 url: "{{ url('/recruitment/candidate-resume/ajaxShow') }}",
                type: "GET",
                data: function (d) {
                    d.status = btn_tab;
                }
            },
            columns: [

                // No
                {
                    className: 'ids stuck-scroll-3',
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },

                { 
                    className: 'ids stuck-scroll-3',
                    data: 'name_kh', defaultContent: '' 
                },
                { 
                    className: 'ids stuck-scroll-3',
                    data: 'name_en', defaultContent: '' 
                },
                { data: 'option.name_english', defaultContent: '' },
                { data: 'position.name_english', defaultContent: '' },
                { data: 'branch.branch_name_en', defaultContent: '' },

                {
                    data: 'interviewed_date',
                    render: function (data) {
                        return data ? moment(data).format('MMM-D-YYYY') : '';
                    }
                },
                {
                    data: 'interviewed_result',
                    render: function (data) {
                        if (data == 1) return `<span class="badge bg-inverse-success">@lang("lang.passed")</span>`;
                        if (data == 3) return `<span class="badge bg-inverse-success">@lang("lang.waiting")</span>`;
                        if (data == 4) return `<span class="badge bg-inverse-info">@lang("lang.pending")</span>`;
                        return '';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function (staff_result) {

                        let text_status = '';
                        let tag_i = '';
                        let complete = '';

                        if (staff_result.status == 3) {
                            text_status = '@lang("lang.interviewed")';
                            tag_i = '<i class="fa fa-dot-circle-o text-info"></i>';
                        } else if (staff_result.status == 4) {
                            text_status = '@lang("lang.signed_contract")';
                            tag_i = '<i class="fa fa-dot-circle-o text-success"></i>';
                        }

                        if (staff_result.interviewed_result == 1) {
                            complete = `
                                <a class="dropdown-item" data-emp-id="${staff_result.id}" data-id="4" href="#">
                                    <i class="fa fa-dot-circle-o text-success"></i> @lang("lang.complete")
                                </a>`;
                        }

                        let dropdown_menu = `
                            <a class="btn btn-white btn-sm btn-rounded">
                                ${tag_i} <span>${text_status}</span>
                            </a>`;

                        if (is_update == 1) {
                            dropdown_menu = `
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown">
                                    ${tag_i} <span>${text_status}</span>
                                </a>`;
                        }

                        return `
                            <div class="dropdown action-label">
                                ${dropdown_menu}
                                <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                    <a class="dropdown-item" data-emp-id="${staff_result.id}" data-id="3" data-status="${staff_result.status}">
                                        <i class="fa fa-dot-circle-o text-info"></i> @lang("lang.interviewed")
                                    </a>
                                    ${complete}
                                </div>
                            </div>`;
                    }
                },

                { 
                    data: 'remark',
                    defaultContent: '',
                    render: function (data, type, row) {

                        if (!data) return '';

                        return `
                            <span data-toggle="tooltip"
                                data-html="true"
                                title="${data}">
                                ${strLimit(data, 30, '...')}
                            </span>
                        `;
                    }

                }
            ],
            order: [[0, 'desc']],
            initComplete: function () {
                $('#loading-overlay').hide();
            }
        });

    }
</script>
@endsection
