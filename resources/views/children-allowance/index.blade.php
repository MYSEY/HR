@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Children Allowance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Children Allowance</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered review-table mb-0">
                        <thead>
                            <tr>
                                <th>Children Allowance</th>
                                <th>Reduced Burden Children</th>
                                <th>Reduced Burden Spouse</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $item)
                                    <tr>
                                        <td hidden class="ids">{{$item->id}}</td>
                                        <td><div class="input-group"><span class="input-group-text">$</span><input type="text" class="form-control" value="{{$item->total_children_allowance}}"></td>
                                        <td><div class="input-group"><span class="input-group-text">៛</span><input type="number" class="form-control" value="{{$item->reduced_burden_children}}"></div></td>
                                        <td><div class="input-group"><span class="input-group-text">៛</span><input type="number" class="form-control" value="{{$item->spouse_allowance}}"></div></td>
                                        <td style="text-align: center;">
                                            <a class="btn btn-success update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_children_allowance"><i class="fa fa-pencil m-r-5"></i></a>
                                            {{-- <a class="btn btn-danger delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_taxes"><i class="fa fa-trash-o m-r-5"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="edit_children_allowance" class="modal custom-modal fade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Children Allowance</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('children/update') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Children Allowance <span class="text-danger">*</span></label>
                                        <input class="form-control @error('total_children_allowance') is-invalid @enderror" type="text" id="e_children_allowance" name="total_children_allowance">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reduced Burden Children</label>
                                        <input class="form-control" type="text" id="e_reduced_burden_children" name="reduced_burden_children">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reduced Burden Spouse</label>
                                        <input class="form-control" type="text" id="e_spouse_allowance" name="spouse_allowance">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <input type="hidden" class="ids" name="id" id="e_id">
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

        <!-- Delete Taxes Modal -->
        <div class="modal custom-modal fade" id="delete_taxes" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ url('children/delete') }}" method="POST">
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
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        $('.update').on('click', function() {
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/children/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_children_allowance').val(response.success.total_children_allowance);
                        $('#e_spouse_allowance').val(response.success.spouse_allowance);
                        $('#e_reduced_burden_children').val(response.success.reduced_burden_children);
                    }
                }
            });
        });
        $('.delete').on('click', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
        });
    });
</script>
