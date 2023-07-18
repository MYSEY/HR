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
                    <h3 class="page-title">Recruitment Plan Deatail</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Recruitment Plan Detail</li>
                    </ul>
                </div>
            </div>
        </div>
        
        {!! Toastr::message() !!}
        <div id="card_by_branch"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                {{-- <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 30px;">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position Name: activate to sort column ascending" style="width: 772.237px;">Position Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Branch Name: activate to sort column ascending" style="width: 772.237px;">Branch Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Year: activate to sort column ascending" style="width: 772.237px;">Plan of Year</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Created at: activate to sort column ascending" style="width: 772.237px;">Total Staff</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending" style="width: 772.237px;">Remark</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Created at: activate to sort column ascending" style="width: 772.237px;">Create At</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data) > 0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td class="ids">{{$item->id}}</td>
                                                    <td >{{$item->position ? $item->position->name_english: "" }}</td>
                                                    <td >{{$item->branch ? $item->branch->branch_name_en: ""}}</td>
                                                    <td >{{ \Carbon\Carbon::parse($item->plan_date)->format('M-Y') ?? '' }}</td>
                                                    <td >{{$item->total_staff}}</td>
                                                    <td >{{$item->remark}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-M-Y') ?? '' }}</td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_plan"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_plan"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" style="text-align: center">No record to display</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit_plan" class="modal custom-modal fade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('recruitment/plan-update') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id" class="e_id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Position<span class="text-danger">*</span></label>
                                        <select class="form-select" id="e_position" name="position_id" required>
                                            {{-- <option value="">Select type</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Branch<span class="text-danger">*</span></label>
                                        <select class="form-select" id="e_branch" name="branch_id" required>
                                            {{-- <option value="">Select type</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Plan of Year <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_plan_date"
                                                name="plan_date" required>
                                            {{-- <input class="form-control @error('plan_year') is-invalid @enderror" type="number" id="e_plan_year" name="plan_year" required> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Total Staff <span class="text-danger">*</span></label>
                                        <input class="form-control @error('total_staff') is-invalid @enderror"
                                            type="number" id="e_total_staff" name="total_staff" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">Remark</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="e_remark"
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

        <!-- Delete training type Modal -->
        <div class="modal custom-modal fade" id="delete_plan" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ url('recruitment/plan-delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit"
                                            class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal"
                                            class="btn btn-primary cancel-btn">Cancel</a>
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
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        $('.update').on('click', function() {
            let id = $(this).data("id");
            $(".e_id").val(id)
            $.ajax({
                type: "GET",
                url: "{{ url('recruitment/plan-edit') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        if (response.positions != '') {
                            $('#e_position').html();
                            $.each(response.positions, function(i, item) {
                                $('#e_position').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response
                                        .success.position_id
                                }));
                            });
                        }
                        if (response.branch != '') {
                            $('#e_branch').html('');
                            $.each(response.branchs, function(i, item) {
                                $('#e_branch').append($('<option>', {
                                    value: item.id,
                                    text: item.branch_name_en,
                                    selected: item.id == response
                                        .success.branch_id
                                }));
                            });
                        }

                        $('#e_plan_date').val(response.success.plan_date);
                        $('#e_total_staff').val(response.success.total_staff);
                        $('#e_remark').val(response.success.remark);
                    }
                }
            });

        });

        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });


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
                                                '<td></td>'+
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
