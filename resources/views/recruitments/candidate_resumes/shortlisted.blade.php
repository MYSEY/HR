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
                    <h3 class="page-title">@lang('lang.shortlisted')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.shortlisted')</li>
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
                                    <table class="table table-striped custom-table no-footer tbl-short-list"
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
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Time: activate to sort column ascending" >@lang('lang.time')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Time: activate to sort column ascending" >@lang('lang.interviewed_channel')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Committee Interview: activate to sort column ascending" >@lang('lang.committee_interview')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" >@lang('lang.status')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="CV: activate to sort column ascending" >@lang('lang.cv')</th>
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
        employee: "{{ url('recruitment/candidate-resume/employee') }}",
        status:"{{ URL('recruitment/candidate-resume/status') }}",
        currentPage:"{{ URL('recruitment/candidate-resume/shortlisted') }}"
    };
    window.Lang = @json(__('lang'));
</script>
<script type="text/javascript">
    $(function(){
        showDatas();
    });

    function showDatas(){
        var localeLanguage = '{{ config('app.locale') }}';
        let is_update  = $('#permission-data').data('update');

        var btn_tab = 2;

        if ($.fn.DataTable.isDataTable('.tbl-short-list')) {
            $('.tbl-short-list').DataTable().clear().destroy();
        }

        $('.tbl-short-list').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ url("recruitment/candidate-resume/ajaxShow") }}',
                type: 'GET',
                data: function (d) {
                    d.status = btn_tab;
                    d.short_list = [1];
                }
            },
            columns: [
                { 
                    data: null,
                    className: 'ids stuck-scroll-3',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { 
                    className: 'ids stuck-scroll-3',
                    data: 'name_kh'
                },
                { 
                    className: 'ids stuck-scroll-3',
                    data: 'name_en' 
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
                    data: 'interviewed_date',
                    render: function (data) {
                        return data ? moment(data).format('hh:mm A') : '';
                    }
                },
                {
                    data: 'interviewed_channel',
                    render: function (data) {
                        return data
                            ? `<span class="badge bg-inverse-success">${data}</span>`
                            : '';
                    }
                },
                { data: 'committee_interview', defaultContent: '' },

                /* ===== STATUS DROPDOWN ===== */
                {
                    data: null,
                    orderable: false,
                    render: function (data) {

                        let text_status = '';
                        let tag_i = '';

                        if (data.status == '1') {
                            text_status = "@lang('lang.received_cv')";
                            tag_i = '<i class="fa fa-dot-circle-o text-purple"></i>';
                        } else if (data.status == '2') {
                            text_status = "@lang('lang.shortlisted')";
                            tag_i = '<i class="fa fa-dot-circle-o text-warning"></i>';
                        } else if (data.status == '3') {
                            text_status = "@lang('lang.interviewed')";
                            tag_i = '<i class="fa fa-dot-circle-o text-info"></i>';
                        }

                        let btn = `
                            <a class="btn btn-white btn-sm btn-rounded" href="#">
                                ${tag_i} <span>${text_status}</span>
                            </a>
                        `;

                        if (is_update == 1) {
                            btn = `
                            <div class="dropdown action-label">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                data-toggle="dropdown">
                                    ${tag_i} <span>${text_status}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                    <a class="dropdown-item"
                                    data-emp-id="${data.id}"
                                    data-id="3"
                                    data-id-short="shortlist"
                                    href="#">
                                        <i class="fa fa-dot-circle-o text-info"></i>
                                        @lang("lang.interviewed")
                                    </a>
                                </div>
                            </div>`;
                        }

                        return btn;
                    }
                },

                /* ===== CV PREVIEW ===== */
                {
                    data: 'cv',
                    orderable: false,
                    render: function (data) {
                        if (!data) return '';
                        return `
                            <small class="block text-ellipsis">
                                <a href="{{ asset('/uploads/images') }}/${data}"
                                target="_blank">
                                <i class="la la-file-pdf"></i>
                                <span>@lang("lang.preview_cv")</span>
                                </a>
                            </small>
                        `;
                    }
                },

                { data: 'remark', defaultContent: '' }
            ],
            order: [[0, 'desc']],
            initComplete: function () {
                $('#loading-overlay').hide();
            }
        });

    }
</script>
@endsection
