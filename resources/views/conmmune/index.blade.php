@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.commune')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.commune')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    {{-- @if (permissionAccess("m6-s1","is_create")->value == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_trainer"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif --}}
                    @if (permissionAccess("m4-s2","is_import")->value == "1")
                        <a href="#" class="btn add-btn me-2" data-toggle="modal" id="importCommune"><i class="fa fa-plus"></i>@lang('lang.import')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("m6-s1","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="content">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="" class=" dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table mb-0 no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 30px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 772.237px;">@lang('lang.code')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Company Name: activate to sort column ascending" style="width: 772.237px;">@lang('lang.khum_name_km')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name (KH): activate to sort column ascending" style="width: 772.237px;">@lang('lang.khum_name_latin')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name (EN): activate to sort column ascending" style="width: 772.237px;">@lang('lang.khum_name_en')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Phone Numer: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name_kh')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name_latin')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" style="width: 772.237px;">@lang('lang.name_en')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 772.237px;">@lang('lang.full_name_km')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">@lang('lang.full_name_latin')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">@lang('lang.full_name_en')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">@lang('lang.districts')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">@lang('lang.province')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">@lang('lang.address_km')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">@lang('lang.address_latin')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Create at: activate to sort column ascending" style="width: 772.237px;">@lang('lang.address_en')</th>
                                                    <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($data)>0)
                                                    @foreach ($data as $key=>$item)
                                                        <tr class="odd">
                                                            <td class="sorting_1">{{++$key}}</td>
                                                            <td>{{$item->code}}</td>
                                                            <td>{{$item->khum_name_km}}</td>
                                                            <td>{{$item->khum_name_latin}}</td>
                                                            <td>{{$item->khum_name_en}}</td>
                                                            <td>{{$item->name_km}}</td>
                                                            <td>{{$item->name_latin}}</td>
                                                            <td>{{$item->name_en}}</td>
                                                            <td>{{$item->full_name_km}}</td>
                                                            <td>{{$item->full_name_latin}}</td>
                                                            <td>{{$item->full_name_en}}</td>
                                                            <td>{{$item->districts_name_en}}</td>
                                                            <td>{{$item->province_name_en}}</td>
                                                            <td>{{$item->address_km}}</td>
                                                            <td>{{$item->address_latin}}</td>
                                                            <td>{{$item->address_en}}</td>
                                                            <td class="text-end">
                                                                @if (permissionAccess("m6-s1","is_update")->value == "1" || permissionAccess("m6-s1","is_delete")->value == "1")
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            @if (permissionAccess("m6-s1","is_update")->value == "1")
                                                                                <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_trainer"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                            @endif
                                                                            @if (permissionAccess("m6-s1","is_delete")->value == "1")
                                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_trainer"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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
                                        <br>
                                        {!! $data->withQueryString()->links('pagination::bootstrap-5') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('conmmune.import')
@endsection
@include('includs.script')

<script>
    $(function(){
        $("#importCommune").on("click", function() {
            $(".thanLess").hide();
            $("#thanLess").text("");
            $('#importCommuneModal').modal('show');
        });
    });
</script>