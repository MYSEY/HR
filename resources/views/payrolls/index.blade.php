@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 9px !important;
    }
    .reset-btn{
        color: #fff !important
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.employee_salary')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.salary')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
            <form>
                {{-- @csrf --}}
                <div class="row filter-btn"> 
                    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group ">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group">
                            <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_location')</option>
                                @foreach ($branch as $item)
                                    <option value="{{$item->id}}">{{session()->get('locale') == 'en' ? $item->branch_name_en : $item->branch_name_kh }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group ">
                            <input class="form-control" type="month" id="filter_month">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 ">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success btn-search me-2" data-dismiss="modal">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.search')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> @lang('lang.excel')</span>
                                <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">@lang('lang.reload')</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            
                        </div>
                    </div>
                </div>
            </form>
        @endif
        {!! Toastr::message() !!}
        <div class="content">
            <div class="page-menu">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer display tbl_payment_salary"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"  cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee: activate to sort column descending">@lang('lang.profile')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1">@lang('lang.employee_id')</th>
                                                    <th class="sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Employee: activate to sort column descending">@lang('lang.name')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Email: activate to sort column ascending">@lang('lang.position')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Email: activate to sort column ascending">@lang('lang.department')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Email: activate to sort column ascending">@lang('lang.location')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.basic_salary')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.child_allowance')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.phone_allowance')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.KNY_/_pchum_ben')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.included_tax'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.pension_fund')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')(@lang('lang.usd'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.gross_salary')(@lang('lang.rile'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.salary_charges_reduced')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.tax_base')(@lang('lang.rile'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.tax_rate')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.personal_tax')(@lang('lang.usd'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.personal_tax')(@lang('lang.rile'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.seniority_pay') (@lang('lang.excluded_tax'))
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Join Date: activate to sort column ascending">@lang('lang.severance_pay')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">@lang('lang.net_salary')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">@lang('lang.payment_date')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending">@lang('lang.created_at')
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Payslip: activate to sort column ascending">@lang('lang.payslip')
                                                    </th>
                                                    {{-- <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($data) > 0)
                                                    @foreach ($data as $item)
                                                        <tr class="odd">
                                                            <td class="ids" hidden>{{$item->id}}</td>
                                                            <td class="sorting_1">
                                                                <h2 class="table-avatar">
                                                                    @if ($item->users->profile !=null)
                                                                        <a href="{{asset('/uploads/images/'.$item->users->profile)}}"  class="avatar">
                                                                            <img alt="" src="{{asset('/uploads/images/'.$item->users->profile)}}">
                                                                        </a>
                                                                    @else
                                                                        <a href="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                            <img alt="" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                        </a>
                                                                    @endif
                                                                </h2>
                                                            </td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->number_employee }}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->employee_name_en }}</span></a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeePosition }}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeDepartment }}</a></td>
                                                            <td><a href="#">{{ $item->users == null ? '' : $item->users->EmployeeBranch }}</a></td>
                                                            <td>{{ $item->users == null ? '' : $item->users->joinOfDate }}</td>
                                                            <td>$<a href="#">{{ $item->basic_salary }}</a></td>
                                                            <td>$<a href="#">{{ $item->total_child_allowance }}</a></td>
                                                            <td>$<a href="#">{{ $item->phone_allowance == null ? '0.00' : $item->phone_allowance}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_kny_phcumben}}</a></td>
                                                            <td>$<a href="#">{{ $item->seniority_pay_included_tax}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_pension_fund}}</a></td>
                                                            <td>$<a href="#">{{ $item->base_salary_received_usd}}</a></td>
                                                            <td><span>៛</span><a href="#">{{ number_format((int)$item->base_salary_received_riel) }}</a></td>
                                                            <td><span>៛</span><a href="#">{{ number_format((int)$item->total_charges_reduced) }}</a></td>
                                                            <td><span>៛</span><a href="#">{{ number_format((int)$item->total_tax_base_riel) }}</a></td>
                                                            <td><a href="#">{{ $item->total_rate}}%</a></td>
                                                            <td>$<a href="#">{{ $item->total_salary_tax_usd}}</a></td>
                                                            <td><span>៛</span><a href="#">{{ number_format((int)$item->total_salary_tax_riel)}}</a></td>
                                                            <td>$<a href="#">{{ $item->seniority_pay_excluded_tax}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_severance_pay}}</a></td>
                                                            <td>$<a href="#">{{ $item->total_salary }}</a></td>
                                                            <td>{{ $item->PayrollPaymentDate }}</td>
                                                            <td>{{ $item->Created }}</td>
                                                            <td><a class="btn btn-sm btn-primary" href="{{ url('payslip', $item->employee_id) }}">@lang('lang.generate_payslip')</a></td>
                                                            {{-- <td class="text-end">
                                                                <div class="dropdown dropdown-action">
                                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                                    @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item payrollDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_payroll"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </td> --}}
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
    
        <div id="add_salary" class="modal custom-modal fade" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_staff_salary')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
    
                    <div class="modal-body">
                        <form action="{{ url('payroll/create') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <h5>@lang('lang.exchange_rate')</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.us_dollar')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="" name="" placeholder="" value="1.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.rile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">៛</span>
                                            <input type="number" class="form-control" id="exchange_rate" disabled name="exchange_rate" placeholder="" value="{{$exChangeRate == null ? "" : $exChangeRate->amount_riel }}">
                                            <input type="hidden" class="form-control" id="exchange_rate" name="exchange_rate" placeholder="" value="{{ $exChangeRate == null ? "" : $exChangeRate->amount_riel }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.payment_date') <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="payment_date" name="payment_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">@lang('lang.submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Payroll Modal -->
        <div class="modal custom-modal fade" id="delete_payroll" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.deleted')!</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('payroll/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Payroll Modal -->
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('.payrollDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('payroll') }}");
        });
        $(".btn-search").on("click", function(){
            $(".btn-search").prop('disabled', true);
                $(".btn-txt").hide();
                $(".loading-icon").css('display', 'block')
            let params = {
                branch_id: $("#branch_id").val(),
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
            };
            showdatas(params);
        });
        $(".btn_excel").on("click", function() {
            let query = {
                branch_id: $("#branch_id").val(),
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
            };
            var url = "{{URL::to('payroll-export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function showdatas(params) {
        $.ajax({
            type: "post",
            url: "{{ url('payroll-search') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                branch_id: params.branch_id ? params.branch_id : null,
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name: params.employee_name ? params.employee_name : null,
                filter_month: params.filter_month ? params.filter_month : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".btn-search").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                if (data.length > 0) {
                    data.map((row) => {
                        let join_date = moment(row.users.date_of_commencement).format('D-MMM-YYYY');
                        let payment_date = moment(row.payment_date).format('D-MMM-YYYY');
                        let created_at = moment(row.created_at).format('D-MMM-YYYY');
                        let profile = '<a href="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                        '<img alt="" src="{{asset("admin/img/defuals/default-user-icon.png")}}">'+
                                    '</a>';
                        if (row.users.profile != null) {
                            profile ='<a href="{{asset("/uploads/images")}}/'+(row.users.profile)+'" class="avatar">'+
                                        '<img alt="" src="{{asset("/uploads/images")}}/'+(row.users.profile)+'">'+
                                    '</a>';
                        }
                        tr +='<tr class="odd">'+
                            '<td class="sorting_1">'+
                                '<h2 class="table-avatar">'+
                                    (profile)+
                                '</h2>'+
                            '</td>'+
                            '<td><a href="#">'+(row.users == null ? '' : row.users.number_employee )+'</a></td>'+
                            '<td> <a href="#">'+(row.users == null ? '' : row.users.employee_name_en )+'</span></a></td>'+
                            '<td><a href="#">'+(row.users == null ? '' : row.users.position.name_english )+'</a></td>'+
                            '<td><a href="#">'+(row.users == null ? '' : row.users.department.name_english )+'</a></td>'+
                            '<td><a href="#">'+(row.users == null ? '' : row.users.branch.branch_name_en )+'</a></td>'+
                            '<td>'+(join_date)+'</td>'+
                            '<td>$<a href="#">'+(row.basic_salary )+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_child_allowance )+'</a></td>'+
                            '<td>$<a href="#">'+(row.phone_allowance == null ? '0.00' : row.phone_allowance)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_kny_phcumben)+'</a></td>'+
                            '<td>$<a href="#">'+(row.seniority_pay_excluded_tax)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_pension_fund)+'</a></td>'+
                            '<td>$<a href="#">'+(row.base_salary_received_usd)+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.base_salary_received_riel))+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_charges_reduced))+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_tax_base_riel))+'</a></td>'+
                            '<td><a href="#">'+(row.total_rate)+'%</a></td>'+
                            '<td>$<a href="#">'+(row.total_salary_tax_usd)+'</a></td>'+
                            '<td><span>៛</span><a href="#">'+(formatCurrencyKH(row.total_salary_tax_riel))+'</a></td>'+
                            '<td>$<a href="#">'+(row.seniority_pay_excluded_tax)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_severance_pay)+'</a></td>'+
                            '<td>$<a href="#">'+(row.total_salary )+'</a></td>'+
                            '<td>'+(payment_date)+'</td>'+
                            '<td>'+(created_at)+'</td>'+
                            '<td><a class="btn btn-sm btn-primary" href="{{url("payslip")}}/'+(row.employee_id)+'">Generate Slip</a></td>'+
                        '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=22 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl_payment_salary tbody").html(tr);
            }
        });
    }

    function formatCurrencyKH(currency) {
        return parseInt(currency).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>