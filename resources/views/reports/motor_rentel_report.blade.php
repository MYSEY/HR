@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }

    .ui-datepicker-calendar {
        display: none;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.motor_rental_reports')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.motor_rental_reports')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
                <div class="col-auto float-end ms-auto">
                </div>
            </div>
        </div>
    </div>
    @if (permissionAccess("m7-s12","is_view")->value == "1")
        <div class="row">
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{ old('employee_id') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{ old('employee_name') }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <select class="select form-control" id="branch_id" name="branch_id" value="{{old('branch_id')}}">
                        <option value="">@lang('lang.location')</option>
                        @foreach ($branchs as $item)
                            <option value="{{$item->id}}">{{Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group">
                    <select class="select form-control" id="department_id" name="department_id" value="{{old('department_id')}}">
                        <option value="">@lang('lang.department')</option>
                        @foreach ($departments as $item)
                            <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date" placeholder="@lang('lang.from_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2 col-12">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date" placeholder="@lang('lang.to_date')">
                    </div>
                </div>
            </div>
        </div>
        <div class="row filter-btn">
            <div class="col-md-6"></div>
            <div class="col-sm-6 col-md-6">
                <div style="display: flex" class="float-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('lang.search')">
                        <span class="btn-text-search"><i class="fa fa-search"></i></span>
                        <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                    @if (permissionAccess("m7-s12","is_export")->value == "1")
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-export me-2" id="icon-search-download-reload" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('lang.download')">
                            <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                            <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    @endif
                    <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('lang.reload')">
                        <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                        <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-motor-rport"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Profle: activate to sort column descending"
                                                    style="width: 265.913px;">#</th>
                                                <th class="sorting stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                                    style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                                <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Employee name: activate to sort column descending"
                                                    style="width: 178px;">@lang('lang.employee_name')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Gender: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.gender')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Branch name: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.location')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.position')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Department: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.department')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Start Date: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.start_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="End Date: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.end_date')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Year of manufature: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.year_of_manufature')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Expiretion year: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.expiretion_year')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Shelt life: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.shelt_life')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Number plate: activate to sort column ascending"
                                                    style="width: 125.15px;">@lang('lang.number_plate')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total gasoline: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.total_gasoline')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total working days: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.total_working_days')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total gasoline liters: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.total_gasoline_liters')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Total price gasoline: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.total_price_gasoline')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Price engine oil: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.price_engine_oil')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Price motor rentel: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.price_motor_rentel')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Taplab: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.tablet')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Taplab Price: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.tablet_price')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Tax rate: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.tax_rate')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Amount: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.amount')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Amount: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.last_working_day')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Payment Date: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.payment_date')</th>
                                                <th class="text-center sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Status: activate to sort column ascending"
                                                    style="width: 55.5625px;">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data) > 0)
                                                @foreach ($data as $key=>$item)
                                                    @php
                                                        $resigned_date = "";
                                                        if ($item->resigned_date) {
                                                            $resigned_date = "bg-inverse-danger";
                                                        }
                                                    @endphp
                                                    <tr class="odd {{$resigned_date}}">
                                                        <td class="ids stuck-scroll-3">{{++$key ?? ""}}</td>
                                                        <td class="number_employee_id stuck-scroll-3">
                                                            <a href="{{ url('/motor-rentel/detail', $item->id) }}">{{ $item->MotorEmployee->number_employee }}</a>
                                                        </td>
                                                        <td class="stuck-scroll-3">{{ Helper::getLang() == 'en' ? $item->MotorEmployee->employee_name_en : $item->MotorEmployee->employee_name_kh }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeGender }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeBranch }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeePosition }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeDepartment }}</td>
                                                        <td class="start_date">{{ \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') ?? '' }}</td>
                                                        <td class="end_date">{{  \Carbon\Carbon::parse($item->end_date)->format('d-M-Y') ?? '' }}</td>
                                                        <td class="product_year">{{ $item->product_year }}</td>
                                                        <td class="expired_year">{{ $item->expired_year }}</td>
                                                        <td class="shelt_life">{{ $item->shelt_life }}</td>
                                                        <td class="number_plate">{{ $item->number_plate }}</td>
                                                        <td class="total_gasoline">{{ $item->total_gasoline }} (L)</td>
                                                        <td class="total_work_day">{{ $item->total_work_day }}</td>

                                                        <td>{{ $item->total_gasoline * $item->total_work_day }}</td>
                                                        <td>{{ number_format($item->total_gasoline * $item->total_work_day * $item->gasoline_price_per_liter) }}៛
                                                        </td>
                                                        <td class="price_engine_oil">{{ number_format($item->amount_price_engine_oil) }} ៛</td>
                                                        <td class="price_motor_rentel">{{ number_format($item->amount_price_motor_rentel) }} ៛</td>
                                                        <td >{{ $item->taplab_rentel }}</td>
                                                        <td >{{ $item->amount_price_taplab_rentel ? number_format($item->amount_price_taplab_rentel) : "0000" }} ៛</td>
                                                        <td class="tax_rate">{{ $item->tax_rate }}%</td>
                                                        <td>{{ ($item->total_gasoline * $item->total_work_day * $item->gasoline_price_per_liter) + ($item->amount_price_engine_oil + ($item->amount_price_motor_rentel - ($item->amount_price_motor_rentel * $item->tax_rate) / 100) + ($item->amount_price_taplab_rentel - ($item->amount_price_taplab_rentel * $item->tax_rate) / 100 ))  }} ៛
                                                        </td>
                                                        <td><span style="font-size: 13px" class="badge bg-inverse-danger">{{ $item->resigned_date ? \Carbon\Carbon::parse($item->resigned_date)->format('d-M-Y') :'' }}</span></td>
                                                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') : '' }}</td>
                                                        <td>
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="material-icons">more_vert</i></a>
                                                                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'HR' || Auth::user()->RolePermission == 'developer')
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item motor_detail"
                                                                            data-id="{{ $item->id }}"
                                                                            href="{{ url('/motor-rentel/detail', $item->id) }}"><i
                                                                                class="fa fa-eye m-r-5"></i> @lang('lang.view')
                                                                        </a>
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
    @endif
@endsection

@include('includs.script')

<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/motor-rentel-report') }}");
        });
        $(".btn-export").on("click", function(){
            var query = {
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'branch_id': $("#branch_id").val(),
                'department_id': $("#department_id").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }
            var url = "{{URL::to('reports/export-motor-rentel-report')}}?" + $.param(query)
            window.location = url;
        });
        $(".btn-search").on("click", function() {
            var localeLanguage = '{{ config('app.locale') }}';
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('reports/motor-rentel-report') }}', {
                'research':true,
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
                'branch_id': $("#branch_id").val(),
                'department_id': $("#department_id").val(),
                'from_date': $("#from_date").val(),
                'to_date': $("#to_date").val(),
            }).then(function(response) {
                var rows = response.data.data;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let created_at = moment(row.created_at).format('D-MMM-YYYY')
                        let start_date = moment(row.start_date).format('D-MMM-YYYY')
                        let end_date = moment(row.end_date).format('D-MMM-YYYY')
                        let resigned_date = row.resigned_date ? moment(row.resigned_date).format('D-MMM-YYYY') : '';
                        let resigned ="";
                        if (row.resigned_date) {
                            resigned = "bg-inverse-danger"
                        }
                        tr += '<tr class="odd '+(resigned)+'">'+
                                    '<td class="ids stuck-scroll-3">'+(e+1)+'</td>'+
                                    '<td class="number_employee_id stuck-scroll-3"><a href="{{url("motor-rentel/detail")}}/'+row.id+'">' + (row.number_employee) + '</a></td>'+
                                    '<td class="stuck-scroll-3">'+( localeLanguage == 'en' ? row.employee_name_en : row.employee_name_kh )+'</td>'+
                                    '<td>'+( row.user.gender == null ? "" : localeLanguage == 'en' ? row.user.gender.name_english : row.user.gender.name_khmer )+'</td>'+
                                    '<td>'+( row.user.branch ? localeLanguage == 'en' ? row.user.branch.branch_name_en : row.user.branch.branch_name_kh :"" )+'</td>'+
                                    '<td>'+( row.user.position ? localeLanguage == 'en' ? row.user.position.name_english : row.user.position.name_khmer : "" )+'</td>'+
                                    '<td>'+( row.user.department ? localeLanguage == 'en' ? row.user.department.name_english : row.user.department.name_khmer : "" )+'</td>'+
                                    '<td class="start_date">'+( start_date )+'</td>'+
                                    '<td class="end_date">'+( end_date )+'</td>'+
                                    '<td class="product_year">'+( row.product_year )+'</td>'+
                                    '<td class="expired_year">'+( row.expired_year )+'</td>'+
                                    '<td class="shelt_life">'+( row.shelt_life )+'</td>'+
                                    '<td class="number_plate">'+( row.number_plate )+'</td>'+
                                    '<td class="total_gasoline">'+( row.total_gasoline )+' (L)</td>'+
                                    '<td class="total_work_day">'+( row.total_work_day )+'</td>'+
                                    '<td>'+( row.total_gasoline * row.total_work_day )+'</td>'+
                                    '<td>'+( (row.total_gasoline * row.total_work_day * row.gasoline_price_per_liter))+' ៛</td>'+
                                    '<td class="price_engine_oil">'+ (Number(row.amount_price_engine_oil) )+' ៛</td>'+
                                    '<td class="price_motor_rentel">'+ (Number(row.amount_price_motor_rentel))+' ៛</td>'+
                                    '<td >'+ ( row.taplab_rentel ? row.taplab_rentel : '' )+'</td>'+
                                    '<td >'+ ( row.amount_price_taplab_rentel ? Number(row.amount_price_taplab_rentel) : "0000" )+' ៛</td>'+
                                    '<td class="tax_rate">'+( row.tax_rate )+'%</td>'+
                                    '<td>'+((row.total_gasoline * row.total_work_day * row.gasoline_price_per_liter) + (row.amount_price_motor_rentel - (row.amount_price_motor_rentel * row.tax_rate) / 100 ) + (row.amount_price_taplab_rentel - (row.amount_price_taplab_rentel * row.tax_rate) / 100 ) + Number(row.amount_price_engine_oil))+' ៛</td>'+
                                    '<td><span style="font-size: 13px" class="badge bg-inverse-danger">'+(resigned_date)+'</span></td>'+
                                    '<td>'+( created_at )+'</td>'+
                                    '<td>'+
                                        '<div class="dropdown dropdown-action">' +
                                        '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
                                        '<i class="material-icons">more_vert</i>' +
                                        '</a>' +
                                        '<div class="dropdown-menu dropdown-menu-right">' +
                                        '<a class="dropdown-item motor_detail" data-id="{{'(row.id)'}}" href="{{url("motor-rentel/detail")}}/'+row.id+'">' +
                                        '<i class="fa fa-eye m-r-5"></i> @lang("lang.view")' +
                                        '</a>' +
                                        '</div>' +
                                        '</div>' +
                                    '</td>'+
                                '</tr>';
                    });
                } else {
                    var tr =
                        '<tr><td colspan=25 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-motor-rport tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
    });
</script>
