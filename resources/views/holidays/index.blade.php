@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Public Holidaies</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Holidaies</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}

        <div class="tab-pane show" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Days</th>
                                                <th>Title</th>
                                                <th>Amount Percent</th>
                                                <th>Period Month</th>
                                                <th>Created At</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data) > 0)
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td class="ids">{{$item->id}}</td>
                                                        <td class="title">{{$item->Day}}</td>
                                                        <td class="title">{{$item->title}}</td>
                                                        <td class="amount_percent"><a href="#">{{$item->amount_percent == null ? '0' : $item->amount_percent}}%</a></td>
                                                        <td class="period_month">{{$item->PeriodPayment}}</td>
                                                        <td>{{$item->created_at}}</td>
                                                        <td class="text-end">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_holiday"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" style="text-align: center">No record to display</td>
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
        </div>

        <div class="modal custom-modal fade" id="add_holiday" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Holiday</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('holidays/create')}}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label>Amount Percent (%)</label>
                                <input class="form-control" type="number" id="amount_percent" name="amount_percent">
                            </div>
                            <div class="form-group">
                                <label>Period Month</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="period_month" name="period_month">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="from" name="from" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="to" name="to">
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
                                    <span class="btn-txt">{{ __('Submit') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit_holiday" class="modal custom-modal fade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Holiday</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('holidays/update')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="e_title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label>Amount Percent (%)</label>
                                <input class="form-control" type="number" id="e_amount_percent" name="amount_percent">
                            </div>
                            <div class="form-group">
                                <label>Period Month</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="e_period_month" name="period_month">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="e_from" name="from" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="e_to" name="to">
                                </div>
                            </div>
                            <div class="submit-section">
                                <input type="hidden" name="id" id="e_id" class="e_id" value="">
                                <button class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> Loading </span>
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
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('.update').on('click',function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/holidays/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    $('#e_id').val(response.success.id);
                    $('#e_title').val(response.success.title);
                    $('#e_amount_percent').val(response.success.amount_percent);
                    $('#e_period_month').val(response.success.period_month);
                    $('#e_from').val(response.success.from);
                    $('#e_to').val(response.success.to);
                }
            });
        });

        $('.delete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
</script>