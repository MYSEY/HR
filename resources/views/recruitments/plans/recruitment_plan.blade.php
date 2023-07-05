@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Recruitment Plans</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Recruitment Plans</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" id="add_new" data-bs-toggle="modal" data-bs-target="#add_plan"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
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
                                        @if (count($data)>0)
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="add_plan" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Plan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('recruitment/plan-store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Position<span class="text-danger">*</span></label>
                                        <select class="form-select " name="position_id" required>
                                            <option selected disabled value="">Choose...</option>
                                            @foreach ($positions as $item)
                                                <option value="{{$item->id}}">{{$item->name_english}}</option>
                                            @endforeach
                                        </select>
                                        {{-- <div class="invalid-feedback">
                                            Please select a valid Position.
                                        </div> --}}
                                        {{-- <label>Position<span class="text-danger">*</span></label>
                                        <select class="select form-control" name="position_id" required>
                                            <option value="">Select position name</option>
                                            @foreach ($positions as $item)
                                                <option value="{{$item->id}}">{{$item->name_english}}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Branch <span class="text-danger">*</span></label>
                                        <select class="form-select" name="branch_id" required>
                                            {{-- <option value="">Select branch name</option> --}}
                                            <option selected disabled value="">Choose...</option>
                                            @foreach ($branchs as $item)
                                                <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Plan of Year <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="plan_date" name="plan_date" required>
                                            {{-- <select id="plan_year" name="plan_year"  class="floating select select2-hidden-accessible" required>
                                            </select> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Total Staff <span class="text-danger">*</span></label>
                                        <input class="form-control @error('total_staff') is-invalid @enderror" type="number" name="total_staff" required>
                                    </div>
                                </div>
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">Remark</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="remark" value="{{old('remark')}}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                                    <span class="btn-txt">{{ __('Submit') }}</span>
                                </button>
                            </div>
                        </form>
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
                        <form action="{{url('recruitment/plan-update')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
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
                                            <input class="form-control datetimepicker" type="text" id="e_plan_date" name="plan_date" required>
                                            {{-- <input class="form-control @error('plan_year') is-invalid @enderror" type="number" id="e_plan_year" name="plan_year" required> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Total Staff <span class="text-danger">*</span></label>
                                        <input class="form-control @error('total_staff') is-invalid @enderror" type="number" id="e_total_staff" name="total_staff" required>
                                    </div>
                                </div>
                        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="">Remark</label>
                                        <textarea type="text" rows="3" class="form-control" name="remark" id="e_remark" value="{{old('remark')}}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
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
                            <form action="{{url('recruitment/plan-delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
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
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){

        // $("#add_new").on("click", function() {
        //     $('#plan_date').html('<option value=""> </option>');
        //     const currentY = moment(new Date()).format('YYYY');
        //     calculatorYear(currentY);
        // });

        $('.update').on('click',function(){
            let id = $(this).data("id");
            $(".e_id").val(id)
            $.ajax({
                type: "GET",
                url: "{{url('recruitment/plan-edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        if (response.positions != '') {
                            $('#e_position').html();
                            $.each(response.positions, function(i, item) {
                                $('#e_position').append($('<option>', {
                                    value: item.id,
                                    text: item.name_english,
                                    selected: item.id == response.success.position_id
                                }));
                            });
                        }
                        if (response.branch !='') {
                            $('#e_branch').html('');
                            $.each(response.branchs, function(i, item) {
                                $('#e_branch').append($('<option>', {
                                    value: item.id,
                                    text: item.branch_name_en,
                                    selected: item.id == response.success.branch_id
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

        $('.delete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
    function calculatorYear(currentYear) {
        const newYear = Number(currentYear) + 12;
        const expiredDiff = moment(new Date(`01/01/${newYear}`)).diff(new Date(`01/01/${currentYear}`), 'years');
        [...Array(expiredDiff >= 0 ? expiredDiff + 1 : 0).keys()].map((num) => {
            let year = Number(currentYear) + num;
            let option = {
                value: year,
                text: year,
                selected: false
            }
            $('#plan_year').append($('<option>', option));
            $('#e_plan_year').append($('<option>', option));
        });
    }
</script>
