@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .card_background_color {
        background-color: #f8f9fa !important;
    }
    /* The container checkbox */
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 5px;
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
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
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
                <h3 class="page-title">@lang('lang.category_permission')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.roles')</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_category"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="">
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable dataTable no-footer tbl_role"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="#: activate to sort column ascending">#</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name : activate to sort column descending">@lang('lang.menu_name')</th>
                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="sub_mune : activate to sort column descending">@lang('lang.sub_menu')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="create: activate to sort column ascending">@lang('lang.created_at') </th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="action: activate to sort column ascending">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data)>0)
                                                @foreach ($data as $key=>$item)
                                                    <tr class="odd">
                                                        <td>{{++$key ?? ""}}</td>
                                                        <td>@lang($item->menu->name)</td>
                                                        <td>@lang($item->name)</td>
                                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-M-Y')}}</td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                @if (Auth::user()->RolePermission == 'developer' || Auth::user()->RolePermission == 'admin')
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item roleEdit" href="#" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        @if (Auth::user()->RolePermission == "admin" || Auth::user()->RolePermission == "developer")
                                                                            <a class="dropdown-item roleDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_role"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- add new category --}}
    <div id="add_category" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('lang.add_new_category_permission')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('category-permission/store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('lang.menu') <span class="text-danger">*</span></label>
                                    <select class="form-control category_menu cate_required" name="menu_id" id="menu_id" required>
                                        <option value="">--select--</option>
                                        @foreach ($permissiontypes as $item)
                                            <option value="{{$item->menu_id}}" data-menu_name="{{$item->name}}" data-icon="{{$item->icon}}">@lang($item->name) </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('lang.url') <span class="text-danger">*</span></label>
                                    <input class="form-control cate_required @error('name_en') is-invalid @enderror" type="text" id="per_url" name="url" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('lang.name_en') <span class="text-danger">*</span></label>
                                    <input class="form-control cate_required @error('name_en') is-invalid @enderror" type="text" id="name_en" name="name_en" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('lang.name_kh') <span class="text-danger">*</span></label>
                                    <input class="form-control @error('name_kh') is-invalid @enderror" type="text" id="name_kh" name="name_kh" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>@lang('lang.admin_dashboard')</label>
                        {{-- Block dashboad --}}
                        <div class="dashboard_action_admin" style="display: none">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="container-checkbox">Attendance & Leaves
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_leave" name="is_leave"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.resigned_staff')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_total_resigned_staff" name="is_total_resigned_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.promoted_staff')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_promoted_staff" name="is_promoted_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.transferred_staff')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_transferred_staff" name="is_transferred_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.training')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_training" name="is_training"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">@lang('lang.employee')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_employee" name="is_employee"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.age_of_employee')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_age_of_employee" name="is_age_of_employee"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.birthday_reminder')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_birthday_reminder" name="is_birthday_reminder"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.total_number_of_staff')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_total_number_of_staff" name="is_total_number_of_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.total_inactive_staff')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_total_inactive_staff" name="is_total_inactive_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.resigned_staff')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_resigned_staff" name="is_resigned_staff"> <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="container-checkbox">% @lang("lang.reasons_of_staff’s_exit")
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_reasons_of_staff’s_exit" name="is_reasons_of_staff"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">% @lang('lang.staff_ratio')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_staff_ratio" name="is_staff_ratio"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_taking_leave')
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_staff_taking_leave" name="is_staff_taking_leave"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_training_by_branch') (Internal)
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_staff_training_by_branch_internal" name="is_staff_training_internal"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">@lang('lang.staff_training_by_branch') (External)
                                        <input type="checkbox" class="dashboad_all_admin" id="dashboad_staff_training_by_branch_external" name="is_staff_training_external"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row action_all">
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input value="" type="checkbox" class="dashboad_all_admin"  data-name="is_view" name="is_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="dashboad_all_admin" data-name="is_create" name="is_create"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="dashboad_all_admin" data-name="is_update" name="is_update"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="dashboad_all_admin" id="employee_delete" name="is_delete" > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_cancel"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_approve"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.reject')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_reject"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="dashboad_all_admin" data-name="is_import" name="is_import"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.view_salary')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_view_salary"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.view_salary_staff')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_view_salary_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.view_all_staff')
                                    <input type="checkbox" class="dashboad_all_admin" name="is_access" > <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="button" class="btn btn-primary submit-btn">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                    @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.submit')</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit category --}}
    <div id="edit_category" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('lang.edit_category_permission')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('category-permission/store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" id="cat_id" class="cat_id" value="">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('lang.menu') <span class="text-danger">*</span></label>
                                    <select class="form-control e_category_menu e_cate_required" name="menu_id" id="e_menu_id" required>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('lang.url') <span class="text-danger">*</span></label>
                                    <input class="form-control e_cate_required @error('name_en') is-invalid @enderror" type="text" id="e_per_url" name="url" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('lang.name_en') <span class="text-danger">*</span></label>
                                    <input class="form-control e_cate_required @error('name_en') is-invalid @enderror" type="text" id="e_name_en" name="name_en" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('lang.name_kh') <span class="text-danger">*</span></label>
                                    <input class="form-control @error('name_kh') is-invalid @enderror" type="text" id="e_name_kh" name="name_kh" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>@lang('lang.admin_dashboard')</label>
                        {{-- Block dashboad --}}
                        <div class="row check_dashboad_all_admin">
                            <div class="col-md-4">
                                <label class="container-checkbox">Attendance & Leaves
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_leave" name="is_leave"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.resigned_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_total_resigned_staff" name="is_total_resigned_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.promoted_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_promoted_staff" name="is_promoted_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.transferred_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_transferred_staff" name="is_transferred_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.training')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_training" name="is_training"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.employee')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_employee" name="is_employee"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.age_of_employee')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_age_of_employee" name="is_age_of_employee"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.birthday_reminder')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_birthday_reminder" name="is_birthday_reminder"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.total_number_of_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_total_number_of_staff" name="is_total_number_of_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.total_inactive_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_total_inactive_staff" name="is_total_inactive_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.resigned_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_resigned_staff" name="is_resigned_staff"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">% @lang("lang.reasons_of_staff’s_exit")
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_reasons_of_staff’s_exit" name="is_reasons_of_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">% @lang('lang.staff_ratio')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_staff_ratio" name="is_staff_ratio"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_taking_leave')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_staff_taking_leave" name="is_staff_taking_leave"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (Internal)
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_staff_training_by_branch_internal" name="is_staff_training_internal"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.staff_training_by_branch') (External)
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_dashboad_staff_training_by_branch_external" name="is_staff_training_external"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="row check_all_action">
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.view')
                                    <input value="" type="checkbox" class="e_dashboad_all_admin"  data-name="is_view" name="is_view"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.add')
                                    <input type="checkbox" class="e_dashboad_all_admin" data-name="is_create" name="is_create"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.edit')
                                    <input type="checkbox" class="e_dashboad_all_admin" data-name="is_update" name="is_update"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.delete')
                                    <input type="checkbox" class="e_dashboad_all_admin" id="e_employee_delete" name="is_delete" > <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.cancel')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_cancel"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.approve')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_approve"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.reject')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_reject"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.import')
                                    <input type="checkbox" class="e_dashboad_all_admin" data-name="is_import" name="is_import"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.export')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_export"> <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="container-checkbox">@lang('lang.print')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_print"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.view_salary')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_view_salary"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.view_salary_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_view_salary_staff"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.view_all_staff')
                                    <input type="checkbox" class="e_dashboad_all_admin" name="is_access" > <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="button" class="btn btn-primary btn-edit">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                                    @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.submit')</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- delete category --}}
    <div class="modal custom-modal fade" id="delete_role" role="dialog">
        <div class="modal-dialog modal-sm  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>@lang('lang.delete')</h3>
                        <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ url('category-permission/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
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
@endsection
@include('includs.script')
<script>
    $(function() {
        let data = [];

        $(".category_menu").on("change", function() {
            let selectedOption = $(".category_menu").find(":selected");
            let menuName = selectedOption.data("menu_name");
            if (menuName == "lang.dashboards") {
                $(".dashboard_action_admin").css("display","block");
            }else{
                $(".dashboard_action_admin").css("display","none");
            }
        });
        $(document).on('click','.submit-btn', function(){
            let selectedOption = $(".category_menu").find(":selected");
            let menuName = selectedOption.data("menu_name");
            let icon = selectedOption.data("icon");
            let sub_menu_id  = $(".category_menu").val();
            let sub_name_en  = $("#name_en").val();

            let dataObj = {
                "name": sub_name_en,
                "sub_menu_id":sub_menu_id,
                "menu_id":"",
                "url":$("#per_url").val(),
            };
            $('.dashboad_all_admin').each(function() {
                let name = $(this).attr("name");
                if ($(this).prop("checked")) {
                    dataObj[name] = 1;
                }
            });
            let data = {
                name: menuName,
                permission: dataObj
            };
            var num_miss = 0;
            
            $(".cate_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545");
                }else{
                    $(this).css("border-color","#20c997");
                }
            });
            if (num_miss>0) {
                new Noty({
                    title: "",
                    text: 'Please input all required!")',
                    type: "error",
                    icon: true,
                    timeout: 3000,
                }).show();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ url('category-permission/store') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status ==400 ) {
                            new Noty({
                                title: "",
                                text: 'URL Category permission already  exit!")',
                                type: "error",
                                icon: true,
                                timeout: 3000,
                            }).show();
                            return false;
                        }
                        if (response.message) {
                            window.location.replace("{{ URL('category-permission') }}");
                            new Noty({
                                title: "",
                                text: '@lang("lang.create_successfully")',
                                type: "success",
                                icon: true
                            }).show();
                            $("#submit-btn").attr('disabled',false);
                        }
                    }
                });
            }
        });
        
        $(document).on('click','.btn-edit', function(){
            let selectedOption = $(".e_category_menu").find(":selected");
            let menuName = selectedOption.data("emenu_name");
            let icon = selectedOption.data("eicon");
            let sub_menu_id  = $(".e_category_menu").val();
            let sub_name_en  = $("#e_name_en").val();

            let dataObj = {
                "name": sub_name_en,
                "sub_menu_id":sub_menu_id,
                "menu_id":"",
                "url":$("#e_per_url").val(),
            };

            $('.e_dashboad_all_admin').each(function() {
                let name = $(this).attr("name");
                if ($(this).prop("checked")) {
                    dataObj[name] = 1;
                }else{
                    dataObj[name] = 0;
                }
            });
            let data = {
                id: $("#cat_id").val(),
                name: menuName,
                permission: dataObj
            };
            var num_miss = 0;
            
            $(".e_cate_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545");
                }else{
                    $(this).css("border-color","#20c997");
                }
            });
            if (num_miss>0) {
                new Noty({
                    title: "",
                    text: 'Please input all required!")',
                    type: "error",
                    icon: true,
                    timeout: 3000,
                }).show();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ url('category-permission/update') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status ==400 ) {
                            new Noty({
                                title: "",
                                text: 'Category permission already  exit!")',
                                type: "error",
                                icon: true,
                                timeout: 3000,
                            }).show();
                            return false;
                        }
                        window.location.replace("{{ URL('category-permission') }}");
                        new Noty({
                            title: "",
                            text: '@lang("lang.create_successfully")',
                            type: "success",
                            icon: true
                        }).show();
                        $("#submit-btn").attr('disabled',false);
                    }
                });
            }
        });

        $('.roleDelete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
        $('.roleEdit').on('click',function(){
            $(".e_dashboad_all_admin").val(0);
            $(".e_dashboad_all_admin").prop("checked", false);
            let id = $(this).data("id");
            showdata(id)
        });
    });
    function showdata(id) {
        $.ajax({
            type: "get",
            url: "{{ url('category-permission/show') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
            },
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    if (response.data.sub_menu_id != '') {
                        $('#e_menu_id').html('');
                        $.each(response.permissiontypes, function(i, item) {
                            $('#e_menu_id').append($('<option>', {
                                value: item.menu_id,
                                text: '@lang("'+(item.name)+'")',
                                selected: item.menu_id == response.data.sub_menu_id,
                                'data-emenu_name': item.name, 
                                'data-eicon': item.icon 
                            }));
                        });
                    }
                    $('#cat_id').val(response.data.id);
                    $('#e_per_url').val(response.data.url);
                    $('#e_name_en').val(response.data.name);
                    $('#e_name_kh').val();
                    if (response.data.is_dashboard) {
                        const isDashboard = typeof response.data.is_dashboard === "string" 
                            ? JSON.parse(response.data.is_dashboard) 
                            : response.data.is_dashboard;
                        Object.keys(isDashboard).forEach(key => {
                            if (isDashboard[key] === "1") {
                                const checkbox = $(`.check_dashboad_all_admin input[name='${key}']`);
                                if (checkbox.length) {
                                    checkbox.val(isDashboard[key]); 
                                    checkbox.prop("checked", true);
                                }
                            }
                        });
                    } 
                    
                    const targetKeys = [
                        'is_all',
                        'is_active',
                        'is_create',
                        'is_view',
                        'is_view_salary',
                        'is_view_salary_staff',
                        'is_update',
                        'is_delete',
                        'is_cancel',
                        'is_accept',
                        'is_approve',
                        'is_reject',
                        'is_print',
                        'is_import',
                        'is_export',
                        'is_access',
                        'is_view_report',
                    ];
                    Object.keys(response.data).forEach(key => {
                        if (targetKeys.includes(key)) {
                            if (response.data[key] == "1") {
                                const checkbox = $(`.check_all_action input[name='${key}']`);
                                if (checkbox.length) {
                                    checkbox.val(response.data[key]); 
                                    checkbox.prop("checked", true);
                                } 
                            }
                        }
                    });
                }

                $("#edit_category").modal("show");
            }
        });
    }
</script>