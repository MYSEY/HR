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
                    <h3 class="page-title">@lang('lang.candidate_CVs')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.candidate_CVs')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if ($permission->is_import == "1")
                    <a href="#" class="btn add-btn" data-toggle="modal" id="import_new_cvs"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    @endif
                    @if ($permission->is_create == "1")
                    <a href="#" class="btn add-btn me-2" id="add_new" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        @if ($permission->is_view == "1")
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table" id="Candidate_CVs">
                                            <thead>
                                                <tr>
                                                    <th class="sorting stuck-scroll-3" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="#: activate to sort column descending">#</th>
                                                    <th class="sorting stuck-scroll-3" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.en'))</th>
                                                    <th class="sorting stuck-scroll-3" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.kh'))</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">@lang('lang.gender')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Current Position at: activate to sort column ascending">@lang('lang.current_position')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Company Name: activate to sort column ascending" >@lang('lang.company_name')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Current Address: activate to sort column ascending" >@lang('lang.current_address')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Position Applied: activate to sort column ascending" >@lang('lang.position_applied')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Location Applied: activate to sort column ascending" >@lang('lang.location_applied')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Received Date: activate to sort column ascending" >@lang('lang.received_date')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Recruitment Channel: activate to sort column ascending" >@lang('lang.applied_channel')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Contact Number: activate to sort column ascending" >@lang('lang.contact_number')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Recruitement Status: activate to sort column ascending" >@lang('lang.status')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="CV: activate to sort column ascending" >@lang('lang.cv')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" >@lang('lang.remark')</th>
                                                    <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" >@lang('lang.action')</th>
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
        @endif
        @include('recruitments.candidate_resumes.modal_form_create')
        @include('recruitments.candidate_resumes.modal_form_edit')
        @include('recruitments.candidate_resumes.import')
        <!-- Delete Modal -->
        <div class="modal custom-modal fade" id="delete_candidate" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('recruitment/candidate-resume/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading Data...</p>
            </div>
        </div> --}}
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
        getdata:"{{ URL('recruitment/candidate-resume/edit') }}",
        currentPage:"{{ URL('recruitment/candidate-resume/cvs') }}"
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
    function showDatas() {
        let canUpdate = $('#permission-data').data('update');
        let canDelete = $('#permission-data').data('delete');
        $('#loading-overlay').show();

        if ($.fn.DataTable.isDataTable('#Candidate_CVs')) {
            $('#Candidate_CVs').DataTable().clear().destroy();
        }

        $('#Candidate_CVs').DataTable({
            destroy: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '{{ URL("recruitment/candidate-resume/indexshow") }}',
                type: 'GET',
            },
            columns: [
                {
                    data: null,
                    name: 'num',
                    className: 'ids stuck-scroll-3',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'name_en', className: 'stuck-scroll-3' },
                { data: 'name_kh', className: 'stuck-scroll-3' },
                { data: 'CandidateGender' },
                { data: 'current_position' },
                { data: 'companey_name' },
                { data: 'current_address' },
                { data: 'CandidatePosition' },
                { data: 'CandidateBranch' },
                {
                    data: 'received_date',
                    render: function (data) {
                        return data ? moment(data).format('DD-MMM-YYYY') : '';
                    }
                },
                { data: 'recruitment_channel' },
                { data: 'contact_number' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (id) {
                        return `
                            <div class="dropdown action-label">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                href="#" data-toggle="dropdown">
                                    <i class="fa fa-dot-circle-o text-purple"></i>
                                    <span>@lang('lang.received_cv')</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="btn-status">
                                    <a class="dropdown-item"
                                    data-emp-id="${id}" data-id="2" href="#">
                                        <i class="fa fa-dot-circle-o text-warning"></i>
                                        @lang('lang.shortlisted')
                                    </a>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'cv',
                    orderable: false,
                    searchable: false,
                    render: function (cv) {
                        if (cv) {
                            return `
                                <small class="block text-ellipsis">
                                    <a href="{{asset("/uploads/images")}}/${cv}" target="_blank">
                                        <i class="la la-file-pdf"></i>
                                        <span>@lang('lang.preview_cv')</span>
                                    </a>
                                </small>
                            `;
                        }
                        return `<span>@lang('lang.no_cv')</span>`;
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

                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (id) {

                        if (canUpdate !== 1 && canDelete !== 1) {
                            return '';
                        }

                        let editBtn = '';
                        let deleteBtn = '';

                        if (canUpdate === 1) {
                            editBtn = `
                                <a class="dropdown-item update" data-id="${id}">
                                    <i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')
                                </a>
                            `;
                        }

                        if (canDelete === 1) {
                            deleteBtn = `
                                <a class="dropdown-item delete"
                                href="#"
                                data-id="${id}"
                                data-bs-toggle="modal"
                                data-bs-target="#delete_candidate">
                                    <i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')
                                </a>
                            `;
                        }

                        return `
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ${editBtn}
                                    ${deleteBtn}
                                </div>
                            </div>
                        `;
                    }
                }
            ],
            order: [[0, 'desc']],
            initComplete: function () {
                $('#loading-overlay').hide();
            }
        });

        $('#Candidate_CVs').on('processing.dt', function (e, settings, processing) {
            processing ? $('#loading-overlay').show() : $('#loading-overlay').hide();
        });
    }
</script>
@endsection
