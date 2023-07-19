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
    #e_plan_date {
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
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer tbl_plan"
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
                                        {{-- @if (count($data) > 0)
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
                                        @endif --}}
                                    </tbody>
                                </table>
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
                                        <input class="form-control" type="month" name="plan_date" id="e_plan_date" required>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label>Plan of Year <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_plan_date"
                                                name="plan_date" required>
                                            </div>
                                    </div> --}}
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
        var pathArray = window.location.pathname.split('/');
        let url = pathArray.slice(3);
        showDatas(url);
        $(document).on('click','.update', function(){
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
                        let plan_date = moment(response.success.plan_date).format('yyyy-M');
                        $('#e_plan_date').val(plan_date);
                        $('#e_total_staff').val(response.success.total_staff);
                        $('#e_remark').val(response.success.remark);
                    }
                }
            });

        });

        // $('.delete').on('click', function() {
        $(document).on('click','.delete', function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });


    function showDatas(params){
        let position_id = params[1] ? parseInt(params[1]) : null;
        let branch_id = params[0] ? parseInt(params[0]) : null;
        let filter_year = params[2] ? params[2] : null;
        $.ajax({
                type: "POST",
                url: "{{ url('recruitment/show') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    position_id,
                    branch_id,
                    filter_year,
                },
                dataType: "JSON",
                success: function(response) {
                    let data_postion = response.success;
                    var tr =  "";
                    if (data_postion.length) { 
                        data_postion.map((plan) => {
                            let plan_date = moment(plan.plan_date).format('MMM-yyyy');
                            let created_at = moment(plan.created_at).format('d-MMM-yyyy');
                            tr +='<tr>'+
                                    '<td class="ids">'+(plan.id)+'</td>'+
                                    '<td>'+(plan.position.name_english)+'</td>'+
                                    '<td>'+(plan.branch.branch_name_en)+'</td>'+
                                    '<td>'+(plan_date)+'</td>'+
                                    '<td>'+(plan.total_staff)+'</td>'+
                                    '<td>'+(plan.remark ? plan.remark : "")+'</td>'+
                                    '<td>'+(created_at)+'</td>'+
                                    '<td class="text-end">'+
                                        '<div class="dropdown dropdown-action">'+
                                            '<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>'+
                                            '<div class="dropdown-menu dropdown-menu-right">'+
                                                '<a class="dropdown-item update" data-toggle="modal" data-id="'+(plan.id)+'" data-target="#edit_plan"><i class="fa fa-pencil m-r-5"></i> Edit</a>'+
                                                '<a class="dropdown-item delete" href="#" data-toggle="modal" data-id="'+(plan.id)+'" data-target="#delete_plan"><i class="fa fa-trash-o m-r-5"></i> Delete</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                '</tr>';
                        });   
                    }else{
                        var tr = '<td colspan="7">No data available for display.</td>';
                    }
                    $(".tbl_plan tbody").html(tr);
                }
            });
    }

</script>
