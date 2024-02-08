@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.branchs')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.branchs')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m9-s3","is_create")->value == "1")
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_branch"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("m9-s3","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name') (@lang('lang.kh'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name') (@lang('lang.en'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Branch holder</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.location') (@lang('lang.en'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.location') (@lang('lang.kh'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.created_at')</th>
                                                <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data)>0)
                                                @foreach ($data as $key=>$item)
                                                    <tr class="odd">
                                                        <td class="sorting_1 ids">{{++$key}}</td>
                                                        <td>{{$item->branch_name_kh}}</td>
                                                        <td>{{$item->branch_name_en}}</td>
                                                        <td>{{$item->branchholder ? $item->branchholder->employee_name_en : ""}}</td>
                                                        <td>{{$item->address}}</td>
                                                        <td>{{$item->address_kh}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                        <td class="text-end">
                                                            @if (permissionAccess("m9-s3","is_update")->value == "1" || permissionAccess("m9-s3","is_delete")->value == "1")
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @if (permissionAccess("m9-s3","is_update")->value == "1")
                                                                    <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-branch="{{$item->direct_manager_id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                    @endif
                                                                    @if (permissionAccess("m9-s3","is_delete")->value == "1")
                                                                    <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_branch"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" style="text-align: center">@lang('lang.no_record_to_display')</td>
                                                </tr>
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
        <div id="add_branch" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_branch')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('branch/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('branch_name_kh') is-invalid @enderror" type="text" name="branch_name_kh" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('branch_name_en') is-invalid @enderror" type="text" name="branch_name_en" required>
                            </div>
                            <div class="form-group">
                                <label>Branch Holder</label>
                                <select class="form-control hr-select2-option" name="direct_manager_id" id="direct_manager_id">
                                    <option selected value=""> --@lang('lang.select')--</option>
                                    @foreach ($employee as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->employee_name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.location') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <textarea class="form-control  @error('address') is-invalid @enderror" rows="3" type="text" name="address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.location') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address_kh') is-invalid @enderror" rows="3" type="text" name="address_kh" required></textarea>
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


        <div id="edit_branch" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_branch')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('branch/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id" id="e_id" class="e_id" value="">
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('branch_name_kh') is-invalid @enderror" type="text" id="e_branch_name_kh" name="branch_name_kh">
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('branch_name_en') is-invalid @enderror" type="text" id="e_branch_name_en" name="branch_name_en">
                            </div>

                            <div class="form-group hr-form-group-select2">
                                <label>Branch Holder</label>
                                <select class="form-control hr-select2-option" name="direct_manager_id" id="e_direct_manager_id">
                                    <option selected value=""> --@lang('lang.select')--</option>
                                    @foreach ($employee as $itme )
                                        <option value="{{ $itme->id }}"> {{ $itme->employee_name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>@lang('lang.location') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <textarea class="form-control  @error('address') is-invalid @enderror" rows="3" type="text" id="e_address" name="address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.location') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address_kh') is-invalid @enderror" rows="3" type="text" id="e_address_kh" name="address_kh" required></textarea>
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

        <div class="modal custom-modal fade" id="delete_branch" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('branch/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="e_id" class="e_id" value="">
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
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('.update').on('click',function(){
            let id = $(this).data("id");
            let branch = $(this).data("branch");
            if (branch) {
                $('#e_direct_manager_id option').each(function() {
                    if($(this).val() == branch) {
                        $('#e_direct_manager_id').append($('<option>', {
                            value: branch,
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

            $.ajax({
                type: "GET",
                url: "{{url('branch/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_branch_name_kh').val(response.success.branch_name_kh);
                        $('#e_branch_name_en').val(response.success.branch_name_en);
                        $('#e_address').val(response.success.address);
                        $('#e_address_kh').val(response.success.address_kh);
                        $('#edit_branch').modal('show');
                    }
                }
            });
        });

        $('.delete').on('click',function(){
            let id = $(this).data("id");
            $('.e_id').val(id);
        });
    });
</script>
