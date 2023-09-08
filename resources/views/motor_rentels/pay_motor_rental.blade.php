@extends('layouts.master')
<style>
    .filter-row-btn .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
    .reset-btn{
        color: #fff !important
    }
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<link rel="stylesheet" href="{{ asset('admin/css/loarding-table.css') }}">
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.pay_motor_rentals')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.pay_motor_rentals')</li>
                    </ul>
                </div>
    
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_pay_motor_rentel" id="add_new"><i
                                class="fa fa-plus"></i>
                            @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
            <div class="row filter-row-btn">
                <div class="col-sm-2 col-md-2">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')"
                            value="{{ old('employee_id') }}">
                        {{-- <label class="focus-label">Filter</label> --}}
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_name" id="employee_name"
                            placeholder="@lang('lang.employee_name')" value="{{ old('employee_name') }}">
                        {{-- <label class="focus-label">Filter</label> --}}
                    </div>
                </div>
               
                <div class="col-sm-8 col-md-8">
                    <div style="display: flex" class="float-end">
                        <button class="btn btn-sm btn-success btn-search me-2" data-dismiss="modal" >
                            <span class="btn-text-search">@lang('lang.search')</span>
                            <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning reset-btn">
                            <span class="btn-text-reset">@lang('lang.reload')</span>
                            <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        <div class="content">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl-pay-motor"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Profle: activate to sort column descending"
                                                    style="width: 265.913px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                    colspan="1" aria-label="Employee ID: activate to sort column ascending"
                                                    style="width: 94.0625px;">@lang('lang.employee_id')</th>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
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
                                                    aria-label="Taplab Price: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.taplab_price')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Tax rate: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.tax_rate')</th>
                                                {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Taxes on fees: activate to sort column ascending"
                                                    style="width: 89.6px;">@lang('lang.taxes_on_fees')</th> --}}
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Amount: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.amount')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Last working day: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.last_working_day')</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Payment Date: activate to sort column ascending"
                                                    style="width: 51.475px;">@lang('lang.payment_date')</th>
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
                                                        <td class="ids">{{ ++$key }}</td>
                                                        <td class="number_employee_id">
                                                            <a href="{{ url('/motor-rentel/detail', $item->id) }}">{{ $item->MotorEmployee->number_employee }}</a>
                                                        </td>
                                                        <td>{{ Helper::getLang() == 'en' ?  $item->MotorEmployee->employee_name_en : $item->MotorEmployee->employee_name_kh }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeGender }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeBranch }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeePosition }}</td>
                                                        <td>{{ $item->MotorEmployee->EmployeeDepartment }}</td>
                                                        <td class="start_date">{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') : '' }}</td>
                                                        <td class="end_date">{{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d-M-Y') : '' }}</td>
                                                        <td class="product_year">{{ $item->product_year }}</td>
                                                        <td class="expired_year">{{ $item->expired_year }}</td>
                                                        <td class="shelt_life">{{ $item->shelt_life }}</td>
                                                        <td class="number_plate">{{ $item->number_plate }}</td>
                                                        <td class="total_gasoline">{{ $item->total_gasoline }} (L)</td>
                                                        <td class="total_work_day">{{ $item->total_work_day }}</td>
        
                                                        <td>{{ $item->total_gasoline * $item->total_work_day }}</td>
                                                        <td>{{ number_format($item->total_gasoline * $item->total_work_day * $item->gasoline_price_per_liter, 2) }} ៛
                                                        </td>
                                                        <td class="price_engine_oil">$ {{ $item->amount_price_engine_oil }}</td>
                                                        <td class="price_motor_rentel">$ {{ $item->amount_price_motor_rentel }}</td>
                                                        <td >$ {{ $item->amount_price_taplab_rentel ? $item->amount_price_taplab_rentel : "0.00" }}</td>
                                                        <td class="tax_rate">{{ $item->tax_rate }}%</td>
                                                        {{-- <td>$ {{ ($item->amount_price_motor_rentel * $item->tax_rate) / 100 }}</td> --}}
                                                        <td>$ {{ $item->amount_price_engine_oil + ($item->amount_price_motor_rentel - ($item->amount_price_motor_rentel * $item->tax_rate) / 100) + ($item->amount_price_taplab_rentel - ($item->amount_price_taplab_rentel * $item->tax_rate) / 100 )  }}
                                                        </td>
                                                        <td><span style="font-size: 13px" class="badge bg-inverse-danger">{{ $item->resigned_date ? \Carbon\Carbon::parse($item->resigned_date)->format('d-M-Y') :'' }}</span></td>
                                                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') : '' }}</td>
                                                        <td>
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="material-icons">more_vert</i></a>
                                                                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
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
    </div>
    @include('motor_rentels.modal_form_pay_motor')
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-reset-text-loading").css('display', 'block');
            window.location.replace("{{ URL('motor-rentel/pay') }}"); 
        });
        $(".btn-search").on("click", function() {
            var localeLanguage = '{{ config('app.locale') }}';
            $(this).prop('disabled', true);
            $(".btn-text-search").hide();
            $("#btn-text-loading").css('display', 'block');
            axios.post('{{ URL('motor-rentel/search') }}', {
                'employee_id': $("#employee_id").val(),
                'employee_name': $("#employee_name").val(),
            }).then(function(response) {
                var rows = response.data.data;
                if (rows.length > 0) {
                    var tr = "";
                    $(rows).each(function(e, row) {
                        let created_at = moment(row.created_at).format('D-MMM-YYYY')
                        let start_date = moment(row.start_date).format('D-MMM-YYYY')
                        let end_date = moment(row.end_date).format('D-MMM-YYYY')
                        let resigned_date = moment(row.resigned_date).format('D-MMM-YYYY')
                        let resigned ="";
                        if (row.resigned_date) {
                            resigned = "bg-inverse-danger"
                        }
                        tr += '<tr class="odd '+(resigned)+'">'+
                                    '<td class="ids">'+(e+1)+'</td>'+
                                    '<td class="number_employee_id"><a href="{{url("motor-rentel/detail")}}/'+row.id+'">' + (row.number_employee) + '</a></td>'+
                                    '<td>'+( localeLanguage == 'en' ? row.employee_name_en : row.employee_name_kh )+'</td>'+
                                    '<td>'+( row.user.gender == null ? "" : localeLanguage == 'en' ? row.user.gender.name_english : row.user.gender.name_khmer )+'</td>'+
                                    '<td>'+( localeLanguage == 'en' ? row.user.branch.branch_name_en : row.user.branch.branch_name_kh )+'</td>'+
                                    '<td>'+( row.user.position ? localeLanguage == 'en' ? row.user.position.name_english : row.user.position.name_khmer : "" )+'</td>'+
                                    '<td>'+( localeLanguage == 'en' ? row.user.department.name_english : row.user.department.name_khmer )+'</td>'+
                                    '<td class="start_date">'+( start_date )+'</td>'+
                                    '<td class="end_date">'+( end_date )+'</td>'+
                                    '<td class="product_year">'+( row.product_year )+'</td>'+
                                    '<td class="expired_year">'+( row.expired_year )+'</td>'+
                                    '<td class="shelt_life">'+( row.shelt_life )+'</td>'+
                                    '<td class="number_plate">'+( row.number_plate )+'</td>'+
                                    '<td class="total_gasoline">'+( row.total_gasoline )+' (L)</td>'+
                                    '<td class="total_work_day">'+( row.total_work_day )+'</td>'+
                                    '<td>'+( row.total_gasoline * row.total_work_day )+'</td>'+
                                    '<td>'+( (row.total_gasoline * row.total_work_day * row.gasoline_price_per_liter).toFixed(2))+'៛</td>'+
                                    '<td class="price_engine_oil">$ '+ ( row.amount_price_engine_oil )+'</td>'+
                                    '<td class="price_motor_rentel">$ '+ ( row.amount_price_motor_rentel )+'</td>'+
                                    '<td >$ '+ ( row.amount_price_taplab_rentel )+'</td>'+

                                    '<td class="tax_rate">'+( row.tax_rate )+'%</td>'+
                                    // '<td>$ '+ ( (row.amount_price_motor_rentel * row.tax_rate) / 100 )+'</td>'+
                                    '<td>$ '+( (row.amount_price_motor_rentel - (row.amount_price_motor_rentel * row.tax_rate) / 100 ) + (row.amount_price_taplab_rentel - (row.amount_price_taplab_rentel * row.tax_rate) / 100 ) + Number(row.amount_price_engine_oil))+'</td>'+
                                    '<td><span style="font-size: 13px" class="badge bg-inverse-danger">'+(resigned_date)+'</span></td>'+
                                    '<td>'+(created_at)+'</td>'+
                                    '<td>'+
                                        '<div class="dropdown dropdown-action">' +
                                        '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
                                        '<i class="material-icons">more_vert</i>' +
                                        '</a>' +
                                        '<div class="dropdown-menu dropdown-menu-right">' +
                                        '<a class="dropdown-item motor_detail" data-id="{{'(row.id)'}}" href="{{url("motor-rentel/detail")}}/'+row.id+'">' +
                                        '<i class="fa fa-eye m-r-5"></i> View' +
                                        '</a>' +
                                        '</div>' +
                                        '</div>' +
                                    '</td>'+
                                '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=25 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-pay-motor tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });
    });
</script>
