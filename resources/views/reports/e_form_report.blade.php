@extends('layouts.master')
<style>
    .filter-btn .btn {
        min-height: 38px !important;
        padding: 8px !important;
    }

    #filter_month {
        position: relative;
    }

    input[type="month"]::-webkit-calendar-picker-indicator {
        background-position: right;
        background-size: auto;
        cursor: pointer;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        height: auto;
        width: auto;
    }

</style>
@section('content')
<div class="">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.e_form_report')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.e_form_report')</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="">
        @if (permissionAccess("m7-s11","is_view")->value == "1")
            <form>
                {{-- @csrf --}}
                <div class="row filter-btn"> 
                    <div class="col-sm-2 col-md-2"> 
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="@lang('lang.employee_id')" value="{{old('number_employee')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group cls-research">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="@lang('lang.employee_name')" value="{{old('employee_name')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group cls-research">
                            <input class="form-control" type="month" id="filter_month">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="form-group" id="col-branch">
                            <select class="select form-control" id="position_id" data-select2-id="select2-data-2-c0n2" name="position_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">@lang('lang.all_position')</option>
                                @foreach ($positions as $item)
                                    <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->name_english : $item->name_khmer }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-sm-6 col-md-4">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn me-2">
                                <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                <span class="btn-txt">@lang('lang.search')</span>
                            </button>
                            @if (permissionAccess("m7-s11","is_export")->value == "1")
                                <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2">
                                    <span class="btn-text-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <label >@lang('lang.excel')</label></span>
                                    <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                                </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-secondary reset-btn">
                                <span class="btn-text-reset">@lang('lang.reload')</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading')</span>
                            </button>
                            
                        </div>
                    </div>
                </div>
            </form>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer tbl_e_form_salary"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="#: activate to sort column ascending">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Self.Enterprise: activate to sort column descending">@lang('lang.self_enterprise')</th>
                                                    <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID number. nssf: activate to sort column descending">@lang('lang.id_number_nssf')</th>
                                                    <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="People's ID: activate to sort column descending">@lang("lang.people's_id")</th>
                                                    <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name kh : activate to sort column descending">@lang('lang.last_name') @lang('lang.kh')</th>
                                                    <th class="sorting stuck-scroll-4" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name kh : activate to sort column descending">@lang('lang.first_name') @lang('lang.kh')</th>
                                                    <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name en: activate to sort column descending">@lang('lang.last_name') @lang('lang.en')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name en: activate to sort column descending">@lang('lang.first_name') @lang('lang.en')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">@lang('lang.gender')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Date Of Birth: activate to sort column ascending">@lang('lang.date_of_birth')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Nationality: activate to sort column ascending">@lang('lang.nationality')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">@lang('lang.join_date') </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Group: activate to sort column ascending">@lang('lang.group')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">@lang('lang.position') </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Type of worker: activate to sort column ascending">@lang('lang.type_of_employees')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">@lang('lang.status') </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">@lang('lang.salary')</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending">@lang('lang.payment_date')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($payroll)>0)
                                                    @foreach ($payroll as $key=>$item)
                                                        <tr class="odd">
                                                            <td >{{++$key}}</td>
                                                            <td class=""><a href="#">{{$item->users->number_employee}}</a></td>
                                                            <td class="stuck-scroll-4">{{$item->users->id_number_nssf ? $item->users->id_number_nssf : ""}}</td>
                                                            <td class="stuck-scroll-4">{{$item->users->id_card_number ? $item->users->id_card_number : ""}}</td>
                                                            <td class="stuck-scroll-4"><a href="#">{{$item->users->last_name_kh}}</a></td>
                                                            <td class="stuck-scroll-4"><a href="#">{{$item->users->first_name_kh}}</a></td>
                                                            <td ><a href="#">{{$item->users->last_name_en}}</a></td>
                                                            <td ><a href="#">{{$item->users->first_name_en}}</a></td>
                                                            <td >{{$item->users->EmployeeGender}}</td>
                                                            <td >{{$item->users->DOB}}</td>
                                                            <td >{{$item->users->EmployeeNationality}}</td>
                                                            <td >{{$item->users->joinOfDate}}</td>
                                                            <td> </td>
                                                            <td>{{ $item->users == null ? '' : $item->users->position->position_range}}</td>
                                                            <td>{{ $item->users->type_of_employees_nssf ? $item->users->type_of_employees_nssf == 1 ? 'និវាសនជន' : "អនិវាសនជន" : ""}}</td>
                                                            <td>{{ $item->users->status_nssf ? $item->users->status_nssf == 1 ? 'Working' : 'Not working' : ""}}</td>
                                                            <td>${{$item->total_gross}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->payment_date)->format('d-M-Y')}}</td>
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
    </div>
</div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script src="{{ asset('/admin/js/date-range-bicker.js') }}"></script>
<script>
    $(function() {
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('reports/e-form') }}");
        });
        $(".submit-btn").on("click", function(){
            $(".submit-btn").prop('disabled', true);
            $(".btn-txt").hide();
            $(".loading-icon").css('display', 'block')
            let params = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                position_id: $("#position_id").val(),
                filter_month: $("#filter_month").val(),
            };
            showdatas(params);
        });
        $(".btn_excel").on("click", function() {
            let query = {
                employee_id: $("#employee_id").val(),
                employee_name: $("#employee_name").val(),
                filter_month: $("#filter_month").val(),
                position_id: $("#position_id").val(),
            };
            var url = "{{URL::to('reports/e-form-export')}}?" + $.param(query)
            window.location = url;
        });
    });
    function showdatas(params) {
        $.ajax({
            type: "post",
            url: "{{ url('reports/e-form-filter') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                employee_id: params.employee_id ? params.employee_id : null,
                employee_name: params.employee_name ? params.employee_name : null,
                position_id: params.position_id ? params.position_id : null,
                filter_month: params.filter_month ? params.filter_month : null,
            },
            dataType: "JSON",
            success: function(response) {
                let data =  response.success;
                $(".submit-btn").prop('disabled', false);
                $(".btn-txt").show();
                $(".loading-icon").css('display', 'none')
                var tr = "";
                if (data.length > 0) {
                    let index = 0;
                    data.map((row) => {
                        index++;
                        let join_date = row.users.date_of_birth ? moment(row.users.date_of_birth).format('D-MMM-YYYY'): "";
                        let date_of_commencement = row.users.date_of_commencement ? moment(row.users.date_of_commencement).format('D-MMM-YYYY'): "";
                        let payment_date = moment(row.payment_date).format('D-MMM-YYYY');
                        tr +='<tr class="odd">'+
                                '<td >'+(index)+'</td>'+
                                '<td class=""><a href="#">'+(row.users.number_employee)+'</a></td>'+
                                '<td class="stuck-scroll-4">'+(row.users.id_number_nssf ? row.users.id_number_nssf : "")+'</td>'+
                                '<td class="stuck-scroll-4">'+(row.users.id_card_number ? row.users.id_card_number : "")+'</td>'+
                                '<td class="stuck-scroll-4"><a href="#">'+(row.users.last_name_kh)+'</a></td>'+
                                '<td class="stuck-scroll-4"><a href="#">'+(row.users.first_name_kh)+'</a></td>'+
                                '<td ><a href="#">'+(row.users.last_name_en)+'</a></td>'+
                                '<td ><a href="#">'+(row.users.first_name_en)+'</a></td>'+
                                '<td >'+(row.users.gender ? row.users.gender.name_english : "")+'</td>'+
                                '<td >'+(join_date)+'</td>'+
                                '<td >'+(row.users.nationality ? row.users.nationality : "")+'</td>'+
                                '<td >'+(date_of_commencement)+'</td>'+
                                '<td> </td>'+
                                '<td>'+(row.users.position ? row.users.position.name_english : "")+'</td>'+
                                '<td>'+(row.users.type_of_employees_nssf ? row.users.type_of_employees_nssf == 1 ? 'និវាសនជន' : "អនិវាសនជន" : "")+'</td>'+
                                '<td>'+(row.users.status_nssf ? row.users.status_nssf == 1 ? 'Working' : 'Not working' : "")+'</td>'+
                                '<td>៛ '+(row.base_salary_received_riel)+'</td>'+
                                '<td>'+(payment_date)+'</td>'+
                        '</tr>';
                    });
                }else{
                    var tr = '<tr><td colspan=20 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
                }
                $(".tbl_e_form_salary tbody").html(tr);
            }
        });
    }
</script>