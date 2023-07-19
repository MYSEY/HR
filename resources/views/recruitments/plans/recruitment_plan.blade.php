@extends('layouts.master')
<style>
    .filter-row .btn {
        min-height: 38px !important;
        padding: 10px !important;
    }
    .reset-btn{
        color: #fff !important
    }
    .wrapper {
        width: 100%;
        height: auto;
        overflow: auto;
        position: relative;
        padding-left: 0 !important;
    }
    thead,
    tr>th {
        position: sticky;
        background: #fff !important;
    }

    thead {
        top: 0;
        z-index: 2;
    }

    tr>th {
        left: 0;
        z-index: 1;
    }

    thead tr>th:first-child {
        z-index: 3;
    }
    #plan_date {
        position: relative;
    }

    input[type="month"]::-webkit-calendar-picker-indicator {
        background-position: right;
        background-size: auto;
        cursor: pointer;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 10;
        top: 0;
        height: auto;
        width: auto;
    }
</style>
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Recruitment Plans</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Recruitment Plans</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" id="add_new" data-bs-toggle="modal"
                        data-bs-target="#add_plan"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        @if (Auth::user()->RolePermission == 'Administrator')
            <form class="needs-validation" novalidate>
                @csrf
                <div class="row filter-row">
                     <div class="col-sm-6 col-md-2"> 
                        <div class="form-group">
                            <select class="select form-control floating select2-hidden-accessible" data-select2-id="select2-data-1-cyfe" id="position_id" name="position_id" tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="select2-data-3-c0n2">All Position</option>
                                @foreach ($positions as $position )
                                    <option value="{{ $position->id }}">{{ $position->name_english }}</option>
                                @endforeach
                            </select>
                            {{-- <label class="focus-label">Position</label> --}}
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="form-group">
                            <select class="select form-control" id="branch_id" data-select2-id="select2-data-2-c0n2" name="branch_id">
                                <option value="" data-select2-id="select2-data-2-c0n2">All Location</option>
                                @foreach ($branchs as $item)
                                    <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                @endforeach
                            </select>
                            {{-- <label class="focus-label">Location</label> --}}
                        </div>
                    </div>
                    <div class=".col-sm-6  col-md-2">
                        <div class="form-group">
                            <select class="select form-control" id="filter_year">
                                <option value="">All Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div style="display: flex" class="float-end">
                            <button type="button" class="btn btn-sm btn-success btn-search me-2">
                                <span class="search-loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                                <span class="btn-search-txt">{{ __('Search') }}</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning reset-btn">
                                <span class="btn-text-reset">Reset</span>
                                <span id="btn-text-loading" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        {!! Toastr::message() !!}
        <div id="card_by_branch"></div>

        <div id="add_plan" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Plan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('recruitment/plan-store') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Position<span class="text-danger">*</span></label>
                                        <select class="form-select " name="position_id" required>
                                            <option selected disabled value="">Choose...</option>
                                            @foreach ($positions as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_english }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Branch <span class="text-danger">*</span></label>
                                        <select class="form-select" name="branch_id" required>
                                            <option selected disabled value="">Choose...</option>
                                            @foreach ($branchs as $item)
                                                <option value="{{ $item->id }}">{{ $item->branch_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Plan of Year <span class="text-danger">*</span></label>
                                        <input class="form-control" type="month" name="plan_date" id="plan_date" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Total Staff <span class="text-danger">*</span></label>
                                        <input class="form-control @error('total_staff') is-invalid @enderror"
                                            type="number" name="total_staff" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">Remark</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="remark"
                                            value="{{ old('remark') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i
                                            class="fa fa-spinner fa-spin"></i> Loading </span>
                                    <span class="btn-txt">{{ __('Submit') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        showDatas();
        var currentYear = 2010;
        var currentDiff = moment(new Date()).format('y');
        let newYear = Number(currentDiff) + 10;
        filterYear(currentYear,newYear)
        $(".reset-btn").on("click", function() {
            $(this).prop('disabled', true);
            $(".btn-text-reset").hide();
            $("#btn-text-loading").css('display', 'block');
            window.location.replace("{{ URL('recruitment/plan-list') }}"); 
        });
        $(".btn-search").on("click", function(){
            $(this).prop('disabled', true);
            $(".btn-search-txt").hide();
            $(".search-loading-icon").css('display', 'block');
            let filter = {
                position_id: $("#position_id").val(),
                branch_id: $("#branch_id").val(),
                filter_year: $("#filter_year").val(),
            };
            showDatas(filter);
        });
    });

    function filterYear(currentYear, expiretedYear) {
        const expiredDiff = moment(new Date(`01/01/${expiretedYear}`)).diff(new Date(`01/01/${currentYear}`), 'years');
        let seletedYear = 0;
        [...Array(expiredDiff >= 0 ? expiredDiff + 1 : 0).keys()].map((num) => {
            seletedYear++;
            let year = Number(currentYear) + num;
            let option = {
                value: year,
                text: year,
                selected: false
            }
            $('#filter_year').append($('<option>', option));
        });
    }

    function showDatas(params){
        $.ajax({
            type: "POST",
            url: "{{ url('recruitment/show') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                position_id: params ? params.position_id ? params.position_id : null : null,
                branch_id: params ? params.branch_id ? params.branch_id : null : null,
                filter_year: params ? params.filter_year ? params.filter_year : null : null,
            },
            dataType: "JSON",
            success: function(response) {
                $(".btn-search").prop('disabled', false);
                $(".btn-search-txt").show();
                $(".search-loading-icon").css('display', 'none');
                let data_postion = response.success;

                branchs = Object.values(data_postion.reduce((r,o) => {
                    let year = moment(o.plan_date).format('y');
                    const key = `${o.branch_id}_${year}`;
                    r[key] = r[key] || {branch_id: o.branch_id, year: o.plan_date,  branch: ""};
                    r[key].branch_name_en = o.branch.branch_name_en;
                    r[key].position_id = o.position_id;
                    return r;
                }, {}));

                positions = Object.values(data_postion.reduce((r,o) => {
                    const key = `${o.branch_id}_${o.position_id}`;
                    r[key] = r[key] || {branch_id: o.branch_id, position_id: o.position_id, position: "", total_staff: 0};
                    r[key].position = o.position.name_english;
                    r[key].plan_date = o.plan_date;
                    r[key].total_staff += +o.total_staff;
                    return r;
                }, {}));

                let bydate = Object.values(data_postion.reduce((r,o) => {
                    const key = `${o.branch_id}_${o.position_id}_${o.plan_date}`;
                    r[key] = r[key] || {branch_id: o.branch_id, position_id: o.position_id, plan_date: o.plan_date, position: "", total_staff: 0};
                    r[key].position = o.position.name_english;
                    r[key].total_staff += +o.total_staff;
                    return r;
                }, {}));

                var div = "";
                if (branchs.length) { 
                    branchs.map((br) => {
                        let tbd = "";
                        let tfoot = "";
                        let br_year = moment(br.year).format('y');
                        positions.map((pos) => {
                            let td = ""
                            let tf = "";
                            for (x = 1; x <= 12; x++) {
                                let number_staff = 0;
                                let total_staff_by_month = 0;

                                let year = moment(pos.plan_date).format('y');
                                let x_month = year+'-'+x;
                                bydate.map((date) =>{
                                    let total_staff = 0;
                                    let year_month = moment(date.plan_date).format('y-M');
                                    if (date.branch_id == pos.branch_id && date.position_id == pos.position_id && year_month == x_month) {
                                        number_staff = date.total_staff;
                                    };
                                    if (date.branch_id == pos.branch_id  && year_month == x_month) {
                                        total_staff = date.total_staff;
                                        total_staff_by_month += total_staff++;
                                    }
                                });
                                td +='<td>'+(number_staff)+'</td>';
                                tf +='<td>'+(total_staff_by_month)+'</td>';
                            }
                            
                            
                            let pos_year = moment(pos.plan_date).format('y');
                            if (pos.branch_id == br.branch_id && pos_year == br_year) {
                                tbd += '<tbody>'+
                                        '<tr class="odd">'+
                                            '<th>'+(pos.position)+'</th>'+
                                            (td)+
                                            // '<td>'+(pos.total_staff)+'</td>'+
                                            '<td class="text-end">'+
                                                '<div class="dropdown dropdown-action">'+
                                                    '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>'+
                                                    '<div class="dropdown-menu dropdown-menu-right">'+
                                                        '<a class="dropdown-item detail" href="{{url("/recruitment/detail")}}/'+(pos.branch_id)+'/'+(pos.position_id)+'/'+(br_year)+'">'+
                                                        '<i class="fa fa-eye m-r-5"></i> View Details</a>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</td>'+
                                        '</tr>'+
                                '</tbody>';
                                tfoot = '<tfoot>'+
                                        '<tr>'+
                                            '<th style="text-align: center">Total</th>'+
                                            (tf)+
                                            '<td></td>'+
                                    ' </tr>'+
                                '</tfoot>';
                            }
                        });
                        
                        if (tbd) {
                            let plan_year = moment(br.year).format('y');
                            div +='<div class="card">'+
                                '<div class="card-header">'+
                                    '<h4><strong>Location:</strong> '+(br.branch_name_en)+'</h4>'+
                                    '<h4 style="text-align: center"><strong>PROJECTED STAFF:</strong> '+(plan_year)+'</h4>'+
                                '</div>'+
                                '<div class="wrapper">'+
                                    '<table class="table table-responsive table-striped custom-table mb-0 no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Position: activate to sort column descending" style="width: 30px;">Position</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="January: activate to sort column ascending" style="width: 772.237px;">January</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="February: activate to sort column ascending" style="width: 772.237px;">February</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="March: activate to sort column ascending" style="width: 772.237px;">March</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="April: activate to sort column ascending" style="width: 772.237px;">April</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="May: activate to sort column ascending" style="width: 772.237px;">May</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="June: activate to sort column ascending" style="width: 772.237px;">June</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="July: activate to sort column ascending" style="width: 300.962px;">July</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="August: activate to sort column ascending" style="width: 300.962px;">August</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="September: activate to sort column ascending" style="width: 300.962px;">September</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="October: activate to sort column ascending" style="width: 300.962px;">October</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="November: activate to sort column ascending" style="width: 300.962px;">November</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="December: activate to sort column ascending" style="width: 300.962px;">December</th>'+
                                                // '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending" style="width: 300.962px;">Total</th>'+
                                                '<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">Action</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                                (tbd)+
                                                (tfoot)+
                                ' </table>'+
                                '</div>'+
                            '</div>';
                        }
                    });   
                }else{
                    var div ='<div class="card text-center">'+
                        '<div class="card-body">'+
                            '<h5 class="card-title">Recruitment Plans</h5>'+
                            '<p class="card-text">No data available for display.</p>'+
                            // '<a href="#"  data-bs-target="#add_plan" class="btn btn-primary">Add New</a>'+
                        '</div>'+
                    '</div>';
                }
                $("#card_by_branch").html(div);
            }
        });
    }
</script>
