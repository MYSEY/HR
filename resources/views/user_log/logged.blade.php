@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .content-title {
        border-bottom: 1px solid #ccc;
        padding-top: 6px;
        padding-bottom: 5px;
        color: #983D3A;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .form-check-md .form-check-input {
        width: 1.15rem;
        height: 1.15rem;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.user_login')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.user_login')</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending">@lang('lang.employee_id')</th>
                                                    <th class=" stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending">@lang('lang.employee_name')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.position')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.department')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.login_date')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.status')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($data)>0)
                                                    @foreach ($data as $key=>$item)
                                                        <tr class="odd">
                                                            <td>{{$item->number_employee}}</td>
                                                            <td>{{Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh}}</td>
                                                            <td>{{Helper::getLang() == 'en' ? $item->position_name_en : $item->position_name_kh}}</td>
                                                            <td>{{Helper::getLang() == 'en' ? $item->depart_name_en : $item->depart_name_kh}}</td>
                                                            <td>{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</td>
                                                            <td>{{$item->date_of_commencement}}</td>
                                                            <td>{{$item->updated_at}}</td>
                                                            <td><span style="font-size: 13px" class="badge bg-inverse-success">Logged</span></td>
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
    </div>
@endsection