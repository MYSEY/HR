@extends('layouts.master')
<style>
    .tr-cursor{
        cursor: pointer;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.departments')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.departments')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m9-s4","is_create")->value == "1")
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_department_sub"><i class="fa fa-plus"></i> @lang('lang.add_new_sub')</a> --}}
                        <a href="#" class="btn add-btn me-2" data-bs-toggle="modal" data-bs-target="#add_department"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                     @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("m9-s4","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped  no-footer">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                                <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending"></th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name kh: activate to sort column ascending">@lang('lang.name')(@lang('lang.kh'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name en: activate to sort column ascending">@lang('lang.name')(@lang('lang.en'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Head of Department: activate to sort column ascending">Head of Department</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="created_at: activate to sort column ascending">@lang('lang.created_at')</th>
                                                <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data)>0)
                                                @foreach ($data as $key=>$item)
                                                    <tr class="odd clickable <?php if (count($item->child) > 0 ){echo "tr-cursor";}?>" data-toggle="collapse" data-target="#group-of-rows-{{$item->id}}" aria-expanded="false" aria-controls="group-of-rows-2">
                                                        <td class="sorting_1 ids">{{++$key}}</td>
                                                        <td>
                                                            @if (count($item->child) > 0)
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            @endif
                                                        </td>
                                                        <td class="name_khmer">{{$item->name_khmer}}</td>
                                                        <td class="name_english">{{$item->name_english}}</td>
                                                        <td> {{$item->headDepartment ? $item->headDepartment->employee_name_en : ""}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                        <td class="text-end">
                                                            @if (permissionAccess("m9-s4","is_update")->value == "1" || permissionAccess("m9-s4","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if(permissionAccess("m9-s4","is_update")->value == "1")
                                                                    <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-department="{{$item->direct_manager_id}}" data-target="#edit_department"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if(permissionAccess("m9-s4","is_delete")->value == "1")
                                                                    <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if (count($item->child) > 0)
                                                        @foreach ($item->child as $subKey=>$sub)
                                                            <tr class="sub-table collapse" id="group-of-rows-{{$sub->parent_id}}">
                                                                <td ></td>
                                                                <td ></td>
                                                                <td class="name_khmer">{{$sub->name_khmer}}</td>
                                                                <td class="name_english">{{$sub->name_english}}</td>
                                                                <td ></td>
                                                                <td>{{ \Carbon\Carbon::parse($sub->created_at)->format('d-M-Y') ?? '' }}</td>
                                                                <td class="text-end">
                                                                    @if (permissionAccess("m9-s4","is_update")->value == "1" || permissionAccess("m9-s4","is_delete")->value == "1")
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            @if(permissionAccess("m9-s4","is_update")->value == "1")
                                                                                <a class="dropdown-item update" data-toggle="modal" data-parent={{$sub->parent_id}} data-department="{{$sub->direct_manager_id}}" data-id="{{$sub->id}}" data-target="#edit_department"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                            @endif
                                                                            @if(permissionAccess("m9-s4","is_delete")->value == "1")
                                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$sub->id}}" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
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
        @endif
        <div id="add_department" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_department')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('department/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group hr-form-group-select2">
                                <label>Head of Department</label>
                                <select class="form-control hr-select2-option" name="direct_manager_id" id="direct_manager_id">
                                    <option selected value=""> --@lang('lang.select')--</option>
                                    @foreach ($employee as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->employee_name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.parent')</label>
                                <select class="form-control hr-select2-option" name="parent_id" id="parent_id">
                                    <option selected value=""> --@lang('lang.select')--</option>
                                    @foreach ($data as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->name_english }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name')(@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name_khmer') is-invalid @enderror" id="name_khmer" name="name_khmer" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name')(@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name_english') is-invalid @enderror" id="name_english" name="name_english" required>
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

        <div id="edit_department" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_department')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('department/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
                            <div class="form-group hr-form-group-select2">
                                <label>Head of Department</label>
                                <select class="form-control hr-select2-option" name="direct_manager_id" id="e_direct_manager_id">
                                    <option selected value=""> --@lang('lang.select')--</option>
                                    @foreach ($employee as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->employee_name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.parent')</label>
                                <select class="form-control hr-select2-option" name="parent_id" id="e_sub_parent_id">
                                    <option selected value=""> --@lang('lang.select')--</option>
                                    @foreach ($data as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->name_english }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name')(@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name_khmer') is-invalid @enderror" id="e_name_khmer" name="name_khmer">
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name')(@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name_english') is-invalid @enderror" id="e_name_english" name="name_english">
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

        <!-- Delete Department Modal -->
        <div class="modal custom-modal fade" id="delete_department" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('department/delete')}}" method="POST">
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
        <!-- /Delete Department Modal -->
    </div>
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('.update').on('click',function(){
            var _this = $(this).parents('tr');
            let id = $(this).data("id");
            $('.e_id').val(id);
            $('#e_name_khmer').val(_this.find('.name_khmer').text());
            $('#e_name_english').val(_this.find('.name_english').text());
            let parent_id = $(this).data("parent");
            let directmanager = $(this).data("department");
            // alert(directmanager);
            if (parent_id) {
                $('#e_sub_parent_id option').each(function() {
                    if($(this).val() == parent_id) {
                        $('#e_sub_parent_id').append($('<option>', {
                            value: parent_id,
                            text: $(this).text(),
                            selected: true
                        }));
                        $(this).remove();
                    }
                });
            }else{
                $('#e_sub_parent_id option').each(function() {
                    if($(this).val() == "") {
                        $(this).remove();
                        $('#e_sub_parent_id').append('<option selected value=""> --@lang("lang.select") --</option>');
                        
                    }
                });
            }
            if (directmanager) {
                $('#e_direct_manager_id option').each(function() {
                    if($(this).val() == directmanager) {
                        $('#e_direct_manager_id').append($('<option>', {
                            value: directmanager,
                            text: $(this).text(),
                            selected: true
                        }));
                        $(this).remove();
                    }
                });
            }else{
                $('#e_direct_manager_id option').each(function() {
                    if($(this).val() == "") {
                        $(this).remove();
                        $('#e_direct_manager_id').append('<option selected value=""> --@lang("lang.select") --</option>');
                        
                    }
                });
            }
        });

        $('.delete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    });
</script>
