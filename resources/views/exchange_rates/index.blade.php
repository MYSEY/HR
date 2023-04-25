@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Exchange Rate</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Exchange Rate</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_exchange_rate"><i class="fa fa-plus"></i> Add New</a>
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
                                            <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Currency</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Amount</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Description</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Create at</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td class="sorting_1 ids">{{$item->id}}</td>
                                                    <td class="text-danger">
                                                        <input type="hidden" class="currency" value="{{$item->currency}}">
                                                        @if ($item->currency=='1')
                                                            <span>Riel</span>
                                                        @elseif ($item->currency=='2')
                                                            <span>Dollar</span>
                                                        @endif
                                                    </td>
                                                    <td class="amount">{{$item->amount}}</td>
                                                    <td class="description">{{$item->description}}</td>
                                                    <td>{{$item->created_at}}</td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_exchange_rate"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_exchange_rate"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" style="text-align: center">No record to display</td>
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

        <div id="add_exchange_rate" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Exchange Rate</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('exchange-rate/store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Currency <span class="text-danger">*</span></label>
                                <select class="select form-control" id="currency" name="currency" value="{{old('currency')}}" required>
                                    <option value="1">Riel</option>
                                    <option value="2">dollar</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Amount <span class="text-danger">*</span></label>
                                <input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount" required>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Description</label>
                                    <textarea type="text" rows="3" class="form-control" name="description" id="description" value="{{old('description')}}"></textarea>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit_exchange_rate" class="modal custom-modal fade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Exchange Rate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('exchange-rate/update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" class="e_id">
                            <div class="form-group">
                                <label>Currency <span class="text-danger">*</span></label>
                                <select class="select form-control" id="e_currency" name="currency" value="{{old('currency')}}" required>
                                    <option value="1">Riel</option>
                                    <option value="2">dollar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Amount<span class="text-danger">*</span></label>
                                <input class="form-control @error('amount') is-invalid @enderror" type="number" id="e_amount" name="amount" required>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">Description</label>
                                    <textarea type="text" rows="3" class="form-control" name="description" id="e_description" value="{{old('description')}}"></textarea>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Exchange Rate Modal -->
        <div class="modal custom-modal fade" id="delete_exchange_rate" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('exchange-rate/delete')}}" method="POST">
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

<script>
    $(function(){
        $('.update').on('click',function(){
            $('#e_currency').html('<option value=""></option>');
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
            $('#e_amount').val(_this.find('.amount').text());
            $('#e_description').val(_this.find('.description').text());
            let currency = _this.find('.currency').val();
            if (currency == "1") {
                $('#e_currency').append('<option selected value="1">Riel</option> <option value="2">Dollar</option>');
            }else if(currency == "2"){
                $('#e_currency').append('<option selected value="2">Dollar</option> <option value="1">Riel</option>');
            }
        });
        $('.delete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
</script>
