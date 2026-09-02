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
                    <h3 class="page-title">@lang('lang.upcoming_staff')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.upcoming_staff')</li>
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
                                    <table class="table table-striped custom-table mb-0 no-footer tbl-upcoming"
                                    aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                                <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">@lang('lang.profile')</th>
                                                <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                                <th class="sorting sorting_asc stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.kh'))</th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 265.913px;">@lang('lang.name')(@lang('lang.en'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.gender')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.date_of_birth')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.position_type')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 83.3625px;">@lang('lang.contact_number')</th>
                                                {{-- @if (permissionAccess("m2-s1","is_view_salary")->value == "1")
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.basic_salary')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">@lang('lang.salary_increase')</th>
                                                @endif --}}
                                                <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.join_date')</th>
                                                <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Past Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.past_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 135.163px;">@lang('lang.status')</th>
                                                <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
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
        <!-- Delete User Modal -->
        <div class="modal custom-modal fade" id="delete_user" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.deleted')!</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('users/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="d_id">
                                <input type="hidden" name="hidden_image" id="e_profile">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="permission-data"
        data-update="{{$permission->is_update}}"
        data-delete="{{$permission->is_delete}}"
        data-print="{{$permission->is_print}}">
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script src="{{asset('/admin/component-js/candidate_resume.js')}}"></script>
<script>
    appUrls = {
        status:"{{ URL('employee/status') }}",
        currentPage:"{{ URL('recruitment/candidate-resume/upcoming/staff') }}"
    };
    window.Lang = @json(__('lang'));
</script>
<script type="text/javascript">
    $(function(){
        showDatas();
    });
    function showDatas() {

        var localeLanguage = '{{ config('app.locale') }}';

        let is_update  = $('#permission-data').data('update');
        let is_delete  = $('#permission-data').data('delete');
        let is_print   = $('#permission-data').data('print');

        let btn_tab = 7;
        if ($.fn.DataTable.isDataTable('.tbl-upcoming')) {
            $('.tbl-upcoming').DataTable().clear().destroy();
        }

        $('.tbl-upcoming').DataTable({
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

                {
                    className: 'ids stuck-scroll-4',
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },

                {
                    className: 'ids stuck-scroll-4',
                    data: "profile",
                    render: function (data) {
                        if (data) {
                            return `
                                <a href="{{asset('/uploads/images')}}/${data}" class="avatar">
                                    <img src="{{asset('/uploads/images')}}/${data}">
                                </a>`;
                        }
                        return `
                            <a href="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                <img src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                            </a>`;
                    }
                },

                {
                    className: 'ids stuck-scroll-4',
                    data: "number_employee",
                    render: function (data, type, row) {
                        return `<a href="{{url('/recruitment/candidate-resume/preview')}}/${row.id}">${data}</a>`;
                    }
                },

                {
                    className: 'ids stuck-scroll-4',
                    data: "employee_name_kh",
                    render: function (data, type, row) {
                        return `<a href="{{url('/recruitment/candidate-resume/preview')}}/${row.id}">${data}</a>`;
                    }
                },

                {
                    data: "employee_name_en",
                    render: function (data, type, row) {
                        return `<a href="{{url('/recruitment/candidate-resume/preview')}}/${row.id}">${data}</a>`;
                    }
                },

                {
                    data: "gender",
                    render: function (data) {
                        if (!data) return "";
                        return localeLanguage == 'en'
                            ? data.name_english
                            : data.name_khmer;
                    }
                },

                {
                    data: "date_of_birth",
                    render: function (data) {
                        return moment(data).format('D-MMM-YYYY');
                    }
                },

                {
                    data: "branch",
                    render: function (data) {
                        if (!data) return "";
                        return localeLanguage == 'en'
                            ? data.branch_name_en
                            : data.branch_name_kh;
                    }
                },

                {
                    data: "department",
                    render: function (data) {
                        if (!data) return "";
                        return localeLanguage == 'en'
                            ? data.name_english
                            : data.name_khmer;
                    }
                },

                {
                    data: "position",
                    render: function (data) {
                        if (!data) return "";
                        return localeLanguage == 'en'
                            ? data.name_english
                            : data.name_khmer;
                    }
                },

                {
                    data: "position",
                    render: function (data) {
                        return data ? data.position_type : "";
                    }
                },

                { data: "personal_phone_number" },

                {
                    data: "date_of_commencement",
                    render: function (data) {
                        return moment(data).format('D-MMM-YYYY');
                    }
                },

                {
                    data: "fdc_date",
                    render: function (data) {
                        return moment(data).format('D-MMM-YYYY');
                    }
                },

                {
                    data: null,
                    render: function (emp) {

                        if (is_update != 1) {
                            return `
                                <a class="btn btn-white btn-sm btn-rounded">
                                    <i class="fa fa-dot-circle-o text-info"></i>
                                    <span>${emp.emp_status}</span>
                                </a>`;
                        }

                        return `
                            <div class="dropdown action-label">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-dot-circle-o text-success"></i>
                                    <span>${emp.emp_status}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right btn-emp-status" id="btn-emp-status">
                                    <a class="dropdown-item"
                                    data-emp-id="${emp.id}"
                                    data-start-date="${emp.fdc_date}"
                                    data-join-date="${emp.date_of_commencement}"
                                    data-id="Probation">
                                    <i class="fa fa-dot-circle-o text-success"></i> @lang('lang.probation')
                                    </a>
                                    <a class="dropdown-item"
                                    data-emp-id="${emp.id}"
                                    data-id="Cancel">
                                    <i class="fa fa-dot-circle-o text-danger"></i> @lang('lang.cancel')
                                    </a>
                                </div>
                            </div>`;
                    }
                },

                {
                    data: null,
                    className: "text-end",
                    render: function (emp) {

                        if (is_print != 1 && is_delete != 1 && is_update != 1) return "";

                        return `
                            <div class="dropdown dropdown-action">
                                <a class="action-icon dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ${is_update == 1 ? `<a class="dropdown-item" href="{{url('/recruitment/candidate-resume/upcoming/edit')}}/${emp.id}">
                                        <i class="fa fa-pencil"></i> @lang('lang.edit')</a>` : ``}

                                    ${is_update == 1 ? `<a class="dropdown-item" href="{{url('/recruitment/candidate-resume/preview')}}/${emp.id}">
                                        <i class="fa fa-eye"></i> @lang('lang.preview')</a>` : ``}

                                    ${is_delete == 1 ? `<a class="dropdown-item upcomingDelete" href="#" data-toggle="modal" data-id="${emp.id}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> @lang("lang.delete")</a>` : ``}
                                </div>
                            </div>`;
                    }
                }
            ],
            // order: [[0, 'desc']],
            initComplete: function () {
                $('#loading-overlay').hide();
            }
        });
    }

</script>
@endsection
