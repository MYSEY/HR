@extends('layouts.master')
<style>
    .big-checkbox .custom-control-input {
        transform: scale(1.5); /* make checkbox 1.5x bigger */
        margin-right: 8px;
    }
    .big-checkbox .custom-control-label {
        font-size: 18px; /* adjust label text if you add one */
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.generate_annual_salary_increasement')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.generate_annual_salary_increasement')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn me-2" data-bs-toggle="modal" data-bs-target="#add_annual_salary_increasement"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row filter-btn"> 
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                <div class="form-group">
                    <div class="search">
                        <i class="uil uil-search"></i>
                        <input spellcheck="false" id="employee_id" name="employee_id" class="form-control" type="text" placeholder="Employee ID">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                @if (in_array(Auth::user()->RolePermission, ['admin','HRAdmin','developer','BOD','CEO']))
                    <div class="form-group">
                        <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                            <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                            @foreach ($branch as $item)
                                <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-sm-2 col-md-2">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                        <span class="btn-txt"><i class="fa fa-search"></i></span>
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                        <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="javascript:void(0);" class="btn btn-sm btn-secondary mb-3" id="btnApprovedAll">
                                    Approved
                                </a>
                                <br>
                                <table id="tbl_generate_annual_salary_increas" class="table table-striped custom-table mb-0 datatable dataTable no-footer" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkAll" name="checkAll" id="checkAll" onClick="toggle(this)">
                                                    <label class="custom-control-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="location: activate to sort column ascending">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="department: activate to sort column ascending">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="position: activate to sort column ascending">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="date_of_commencement: activate to sort column ascending">@lang('lang.date_of_commencement')</th>
                                            {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="basic_salary: activate to sort column ascending">@lang('lang.basic_salary')</th> --}}
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ពិន្ទុ</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">បុគ្គលិកផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">ប្រធានផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 50.825px;">@lang('lang.salary_increasement')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="salary request: activate to sort column ascending" style="width: 50.825px;">@lang('lang.salary_request')</th>
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
    <div id="add_annual_salary_increasement" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('lang.annual_salary_increasement')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('generate/annual/salary/increasement')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label>Year <span class="text-danger">*</span></label>
                            <div class="form-group ">
                                <input class="form-control @error('increasement_year') is-invalid @enderror" type="month" id="increasement_year" name="increasement_year" required>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.submit')</span>
                            </button>
                        </div>
                    </form>
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
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
@section('script')
<script>
    $(function(){
        // Initialize only once
        dataTables();
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('generate/annual/salary/increasement') }}");
        });
        $('.btn-search').on('click', function() {
            number_employee = $('#employee_id').val();
            employee_name = $('#employee_name').val();
            branch_id = $('#branch_id').val();
            department_id = $('#department_id').val();
            $('#tbl_generate_annual_salary_increas').DataTable().ajax.reload(null, false);
        });
        $('.checkAll').on('click', function(e) {
            if($(this).is(':checked',true)){
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked',false);
            }
        });
        $('body').on('click','#btnApprovedAll',function(){
            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            var id = allVals.join(",");
            console.log(id);
            
            if(allVals.length <=0)
            {
                $.alert({
                    title: '@lang("lang.approve")!',
                    content: '@lang("lang.please_select_item_befor").',
                    type: 'blue',
                });
            }  else {
                $.confirm({
                    title: 'Approve!',
                    content: '@lang("lang.are_you_sure_want_to_approve")?',
                    type: "blue",
                    buttons: {
                        ok: {
                            text: 'ok',
                            btnClass: 'btn-blue',
                            action: function () {
                                axios.post('{{ URL("generate/annual/salary/increasement/approved") }}', {
                                    'id': id,
                                }).then(function (response) {
                                    if (response.data.success) {
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            icon: true
                                        }).show();
                                        setTimeout(() => {
                                            window.location.replace("{{ URL('generate/annual/salary/increasement') }}");
                                        }, 1500);
                                    } else {
                                        new Noty({
                                            title: "",
                                            text: 'Something went wrong. Please try again.',
                                            type: "error",
                                            icon: true
                                        }).show();
                                    }
                                    dataTables();
                                }).catch(function (error) {
                                    new Noty({
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        timeout: 3000,
                                        progressBar: true,
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: '@lang("lang.cancel")',
                            action: function () {
                                // Action for cancel button (if needed)
                            }
                        }
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
            }
        });
    });
    function toggle(source) {
        checkboxes = $('.checkAll');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }
    function dataTables() {
        $('#loading-overlay').show();
        if ($.fn.DataTable.isDataTable('#tbl_generate_annual_salary_increas')) {
            $('#tbl_generate_annual_salary_increas').DataTable().clear().destroy();
        }
        $('#tbl_generate_annual_salary_increas').DataTable({
            destroy: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            ajax: {
                url: '{{ URL("generate/annual/salary/increasement") }}',
                type: 'GET',
                // dataSrc: function (json) {
                //     console.log("Data:", json.data);
                //     return json.data;
                // }
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<div class="custom-control custom-checkbox custom-control-inline big-checkbox">
                            <input type="checkbox" class="custom-control-input sub_chk" name="checkbox" data-id="${data}" id="${data}" value="${data}">
                            <label class="custom-control-label" for="${data}"></label>
                        </div>`;
                    }
                },
                { data: 'number_employee', name: 'number_employee' },
                { data: 'employee_name_kh', name: 'employee_name_kh' },
                { data: 'branch_name_en', name: 'branch_name_en' },
                { data: 'dep_name', name: 'dep_name' },
                { data: 'positions_name', name: 'positions_name' },
                {
                    data: 'date_of_commencement',
                    name: 'date_of_commencement'
                },
                {
                    data: 'total_score',
                    name: 'total_score',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data == null ? '0.00' : data}</span>`;
                    }
                },
                {
                    data: 'total_score_live_staff',
                    name: 'total_score_live_staff',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data == null ? '0.00' : data}</span>`;
                    }
                },
                {
                    data: 'total_score_direct_chairman',
                    name: 'total_score_direct_chairman',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data == null ? '0.00' : data}</span>`;
                    }
                },
                {
                    data: 'salary_increasement',
                    name: 'salary_increasement',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data}</span>`;
                    }
                },
                {
                    data: 'total_salary_request',
                    name: 'total_salary_request',
                    render: function (data) {
                        return `<span class="badge bg-inverse-success">${data}</span>`;
                    }
                }
            ],
            initComplete: function() {
                $('#loading-overlay').hide();
            }
        });
        $('#tbl_generate_annual_salary_increas').on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#loading-overlay').show();
            } else {
                $('#loading-overlay').hide();
            }
        });
    }
</script>
@endsection