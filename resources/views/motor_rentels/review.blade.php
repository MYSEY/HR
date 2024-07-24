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
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.motor_rental_review')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.motor_rental_review')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("m5-s3","is_create")->value == "1")
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_pay_motor_rentel" id="add_new"><i
                                class="fa fa-plus"></i>
                            @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        {{-- @if (permissionAccess("m4-s1","is_view")->value == "1") --}}
            {{-- <form>
                <div class="row filter-row-btn">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group form-focus select-focus">
                            <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{ old('employee_id') }}">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group form-focus select-focus">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{ old('employee_name') }}">
                        </div>
                    </div>
                   
                    <div class="col-sm-8 col-md-8">
                        <div style="display: flex" class="float-end">
                            <button class="btn btn-sm btn-outline-secondary btn-search me-2" data-dismiss="modal" id="icon-search-download-reload">
                                <span class="btn-text-search"><i class="fa fa-search"></i></span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn" id="icon-search-download-reload">
                                <span class="btn-text-reset"><i class="fa fa-undo"></i></span>
                                <span id="btn-reset-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form> --}}
            {!! Toastr::message() !!}
            @if (permissionAccess("m5-s3","is_delete")->value == "1")
                <button type="button" class="btn btn-sm btn-danger delete_all">@lang('lang.delete_all')</button>
            @endif
            @if (permissionAccess("m5-s3","is_approve")->value == "1")
                <button type="button" class="btn btn-sm btn-success btn_approved" href="#" data-id=""> @lang('lang.approve')</button> 
            @endif

            <div class="content">
                <div class="page-menu">
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="table-responsive">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped custom-table datatable dataTable no-footer display tbl-pay-motor_review"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkAll"></th>
                                                        {{-- <th class="sorting sorting_asc stuck-scroll-3" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1" aria-sort="ascending"
                                                            aria-label="Profle: activate to sort column descending"
                                                            style="width: 265.913px;">#</th> --}}
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
                                                            aria-label="Taplab Price: activate to sort column ascending"
                                                            style="width: 89.6px;">@lang('lang.tablet_price')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Tax rate: activate to sort column ascending"
                                                            style="width: 89.6px;">@lang('lang.tax_rate')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Amount: activate to sort column ascending"
                                                            style="width: 51.475px;">@lang('lang.amount') (@lang('lang.riel'))</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Amount: activate to sort column ascending"
                                                            style="width: 51.475px;">@lang('lang.amount') (@lang('lang.usd'))</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Last working day: activate to sort column ascending"
                                                            style="width: 51.475px;">@lang('lang.last_working_day')</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Payment Date: activate to sort column ascending"
                                                            style="width: 51.475px;">@lang('lang.payment_date')</th>
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
                                                            <tr class="odd">
                                                                <td>
                                                                    <input type="checkbox" class="sub_chk" data-id="{{$item->id}}" data-date="{{$item->created_at}}">
                                                                </td>
                                                                {{-- <td class="ids stuck-scroll-3">{{ ++$key }}</td> --}}
                                                                <td class="number_employee_id stuck-scroll-3">
                                                                    {{ $item->MotorEmployee->number_employee }}
                                                                </td>
                                                                <td class="stuck-scroll-3">{{ Helper::getLang() == 'en' ?  $item->MotorEmployee->employee_name_en : $item->MotorEmployee->employee_name_kh }}</td>
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
                                                                @php
                                                                    $total_riels = ($item->total_gasoline * $item->total_work_day * $item->gasoline_price_per_liter);
                                                                    $amount_riels = round($total_riels,-2);
                                                                    $totalAmount = ($item->amount_price_engine_oil + ($item->amount_price_motor_rentel - ($item->amount_price_motor_rentel * $item->tax_rate) / 100) + ($item->amount_price_taplab_rentel - ($item->amount_price_taplab_rentel * $item->tax_rate) / 100 ));
                                                                @endphp
                                                                <td>{{ $item->total_gasoline * $item->total_work_day }}</td>
                                                                <td>{{ number_format($amount_riels) }} ៛</td>
                                                                <td class="price_engine_oil">{{ round($item->amount_price_engine_oil,2) }} $</td>
                                                                <td class="price_motor_rentel">{{ round($item->amount_price_motor_rentel,2) }} $</td>
                                                                <td >{{ $item->amount_price_taplab_rentel ? round($item->amount_price_taplab_rentel,2) : "0" }} $</td>
                                                                <td class="tax_rate">{{ $item->tax_rate }}%</td>
                                                                <td>{{ number_format($amount_riels) }} ៛</td>
                                                                <td>{{ round($totalAmount,2)}} $</td>
                                                                <td><span style="font-size: 13px" class="badge bg-inverse-danger">{{ $item->resigned_date ? \Carbon\Carbon::parse($item->resigned_date)->format('d-M-Y') :'' }}</span></td>
                                                                <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') : '' }}</td>
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
        {{-- @endif --}}
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
            window.location.replace("{{ URL('motor-rentel/pay-review') }}"); 
        });
        $('#checkAll').on('click', function(e) {
            if($(this).is(':checked',true)){
                $(".sub_chk").prop('checked', true);
            } else {  
                $(".sub_chk").prop('checked',false);
            }  
        });
        $('body').on('click','.btn_approved',function(){
            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });
            var id = allVals.join(",");
            if(allVals.length <=0)  
            {
                $.alert({
                    title: '@lang("lang.approve")!',
                    content: '@lang("lang.please_select_item_befor_approve").',
                    type: 'blue',
                });
            }  else {
                $(".loading-icon").css('display', 'block')
                $.confirm({
                    title: '@lang("lang.approve")',
                    content: "@lang('lang.are_you_sure_want_to_approve')?",
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'ok',
                            btnClass: 'btn-blue',
                            action: function(){
                                axios.post('{{ URL('motor-rentel/approved') }}',{
                                    'id': id,
                                }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                        $('.card-footer').remove();
                                        window.location.replace("{{ URL('motor-rentel/pay-review') }}");
                                    }).catch(function(error) {
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                            type: "error",
                                            icon: true
                                        }).show();
                                    });
                                }
                            },
                            close: function () {
                        }
                    }
                });
            }
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
                        let resigned_date = row.resigned_date ? moment(row.resigned_date).format('D-MMM-YYYY') : '';
                        let resigned ="";
                        if (row.resigned_date) {
                            resigned = "bg-inverse-danger"
                        }
                        tr += '<tr class="odd '+(resigned)+'">'+
                                    '<td>'+
                                        '<input type="checkbox" class="sub_chk" data-id="'+row.number_employee+'" data-date="'+row.created_at+'">'+
                                    '</td>'+
                                    '<td class="number_employee_id stuck-scroll-3">'+ (row.number_employee) +'</td>'+
                                    '<td class="stuck-scroll-3">'+( localeLanguage == 'en' ? row.employee_name_en : row.employee_name_kh )+'</td>'+
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
                                    '<td>'+((row.total_gasoline * row.total_work_day * row.gasoline_price_per_liter))+' ៛</td>'+
                                    '<td class="price_engine_oil">'+ ( Number(row.amount_price_engine_oil) )+' ៛</td>'+
                                    '<td class="price_motor_rentel">'+ ( Number(row.amount_price_motor_rentel) )+' ៛</td>'+
                                    '<td >'+ ( row.amount_price_taplab_rentel ? Number(row.amount_price_taplab_rentel) : "0000" )+' ៛</td>'+
                                    '<td class="tax_rate">'+( row.tax_rate )+'%</td>'+
                                    '<td>'+((row.total_gasoline * row.total_work_day * row.gasoline_price_per_liter) + (row.amount_price_motor_rentel - (row.amount_price_motor_rentel * row.tax_rate) / 100 ) + (row.amount_price_taplab_rentel - (row.amount_price_taplab_rentel * row.tax_rate) / 100 ) + Number(row.amount_price_engine_oil))+' ៛</td>'+
                                    '<td><span style="font-size: 13px" class="badge bg-inverse-danger">'+(resigned_date)+'</span></td>'+
                                    '<td>'+(created_at)+'</td>'+
                                '</tr>';
                    });
                } else {
                    var tr = '<tr><td colspan=25 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl-pay-motor_review tbody").html(tr);
                $("#btn-text-loading").hide();
                $(".btn-text-search").show();
                $(".btn-search").prop("disabled",false);
            })
        });

        $('.delete_all').on('click', function(e) {
            var allValNumberemployee = [];
            $(".sub_chk:checked").each(function() {  
                allValNumberemployee.push($(this).attr('data-id'));
            });
            var paay_id = allValNumberemployee.join(",");
            if(allValNumberemployee.length <=0){
                $.alert({
                    title: '@lang("lang.delete")!',
                    content: '@lang("lang.please_select_item_befor_delete").',
                    type: 'red',
                });
            }  else {
                $.confirm({
                    title: '@lang("lang.delete")!',
                    content: "@lang('lang.are_you_sure_want_to_delete')?",
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'ok',
                            btnClass: 'btn-red',
                            action: function(){
                                axios.post('{{ URL("motor-rentel/review/delete") }}', {
                                    id : paay_id,
                                }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: "@lang('lang.the_process_has_been_successfully').",
                                        type: "success",
                                        timeout: 3000,
                                        icon: true
                                    }).show();
                                    window.location.replace("{{ URL('motor-rentel/pay-review') }}");
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: "@lang('lang.something_went_wrong_please_try_again_later').",
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                            close: function () {
                        }
                    }
                }); 
            } 
        });
    });
</script>