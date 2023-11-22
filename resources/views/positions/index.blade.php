@extends('layouts.master')
<style>
    .page-wrapper{
        min-height: 0px !important
    }
</style>
@section('content')
    {{-- <div class=""> --}}
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.positions')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.positions')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m9-s2","is_create")->value == "1")
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_postion"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("m9-s2","is_view")->value == "1")
        {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name') (@lang('lang.kh'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name') (@lang('lang.en'))</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.position_range')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.position_type')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.created_at')</th>
                                                <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data)>0)
                                                @foreach ($data as $key=>$item)
                                                    <tr class="odd">
                                                        <td class="sorting_1 ids">{{++$key}}</td>
                                                        <td class="name_khmer">{{$item->name_khmer}}</td>
                                                        <td class="name_english">{{$item->name_english}}</td>
                                                        <td class="position_range">{{$item->position_range}}</td>
                                                        <td class="position_type">{{$item->position_type}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                                                        <td class="text-end">
                                                            @if (permissionAccess("m9-s2","is_update")->value == "1" || permissionAccess("m9-s2","is_delete")->value == "1")
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        @if (permissionAccess("m9-s2","is_update")->value == "1")
                                                                        <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_position"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        @endif
                                                                        @if (permissionAccess("m9-s2","is_delete")->value == "1")
                                                                        <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_position"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
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
        @endif

        <div id="add_postion" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_new_postion')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('position/store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('name_khmer') is-invalid @enderror" type="text" name="name_khmer" required value="{{old('name_khmer')}}">
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('name_english') is-invalid @enderror" type="text" name="name_english" required value="{{old('name_english')}}">
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.position_range') <span class="text-danger">*</span></label>
                                <select class="form-control select floating" id="position_range" name="position_range" required value="{{old('position_range')}}">
                                    <option selected disabled> --@lang('lang.select')--</option>
                                    @foreach ($positionRange as $item)
                                        <option value="{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.position_type') <span class="text-danger">*</span></label>
                                <select class="form-control select floating" id="position_type" name="position_type" value="{{old('position_type')}}">
                                    <option selected disabled> --@lang('lang.select')--</option>
                                    @foreach ($positionType as $item)
                                        <option value="{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}">{{Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                                    @endforeach
                                </select>
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

        <div id="edit_position" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_postion')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('position/update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.kh')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('name_khmer') is-invalid @enderror" type="text" id="e_name_khmer" name="name_khmer">
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.name') (@lang('lang.en')) <span class="text-danger">*</span></label>
                                <input class="form-control @error('name_english') is-invalid @enderror" type="text" id="e_name_english" name="name_english">
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.position_range') <span class="text-danger">*</span></label>
                                <select class="form-control select" id="e_position_range" name="position_range" value="">
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('lang.position_type') <span class="text-danger">*</span></label>
                                <select class="form-control select" id="e_position_type" name="position_type" value="">
                                    
                                </select>
                            </div>
                            <input type="hidden" name="id" id="e_id" value="">

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
        <div class="modal custom-modal fade" id="delete_position" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('position/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="e_id" value="">
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
    {{-- </div> --}}
@endsection

@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('.update').on('click',function(){
            var localeLanguage = '{{ config('app.locale') }}';
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('position/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        console.log(response.success.id);
                        if (response.positionType != '') {
                            $.each(response.positionType, function(i, item) {
                                $('#e_position_type').append($('<option>', {
                                    value: item.name_english,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.name_english == response.success.position_type
                                }));
                            });
                        }
                        if (response.positionRange != '') {
                            $.each(response.positionRange, function(i, item) {
                                $('#e_position_range').append($('<option>', {
                                    value: item.name_english,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.name_english == response.success.position_range
                                }));
                            });
                        }
                        $('#e_id').val(response.success.id);
                        $('#e_name_khmer').val(response.success.name_khmer);
                        $('#e_name_english').val(response.success.name_english);
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
