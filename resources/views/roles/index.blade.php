@extends('layouts.master')

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Roles &amp; Permissions</h3>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#add_role"><i class="fa fa-plus"></i> Add Roles</a>
                <div class="roles-menu">
                    <ul>
                        @if (count($role)>0)
                           @foreach ($role as $item)
                                <li class="{{ $loop->first ? 'active' : '' }}">
                                    <a href="javascript:void(0);">{{$item->name}}
                                        <span class="role-action">
                                            <span class="action-circle large rolesUpdate" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_role">
                                                <i class="material-icons">edit</i>
                                            </span>
                                            <span class="action-circle large delete-btn rolesDelete" data-toggle="modal"  data-id="{{$item->id}}" data-target="#delete_role">
                                                <i class="material-icons">delete</i>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                           @endforeach
                       @endif
                    </ul>
                </div>
            </div>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
                <h6 class="card-title m-b-20">Module Access</h6>
                <div class="m-b-30">
                    <ul class="list-group notification-list">
                        <li class="list-group-item">
                            Employee
                            <div class="status-toggle">
                                <input type="checkbox" id="staff_module" class="check">
                                <label for="staff_module" class="checktoggle">checkbox</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            Holidays
                            <div class="status-toggle">
                                <input type="checkbox" id="holidays_module" class="check" checked="">
                                <label for="holidays_module" class="checktoggle">checkbox</label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                <th class="text-center">Read</th>
                                <th class="text-center">Write</th>
                                <th class="text-center">Create</th>
                                <th class="text-center">Delete</th>
                                <th class="text-center">Import</th>
                                <th class="text-center">Export</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($permision)>0)
                                @foreach ($permision as $itme)
                                    <tr>
                                        <td>{{$itme->permission_name}}</td>
                                        <td class="text-center">
                                            <input type="checkbox" @if ($itme->read== 'Y') checked @endif>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" @if ($itme->write== 'Y') checked @endif>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" @if ($itme->create== 'Y') checked @endif>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" @if ($itme->delete== 'Y') checked @endif>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" @if ($itme->import== 'Y') checked @endif>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" @if ($itme->export== 'Y') checked @endif>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="add_role" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('role-permission')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter role name">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_role" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('role-permission/update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" name="id" id="e_id" value="">
                            <label>Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="e_roleNmae" name="name" value="">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade" id="delete_role" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Role</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ url('role-permission') }}" method="POST">
                            @csrf
                            @method("delete")
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
@endsection
@include('includs.script')

<script>
    $(document).on('click','.rolesUpdate',function()
    {
        var _this = $(this).closest("li");
        $('#e_id').val(_this.find('.id').text());
        $('#e_roleNmae').val(_this.find('.name').text());
    });
</script>

<script>
    $(document).on('click','.rolesDelete',function()
    {
        var _this = $(this).closest("li");
        $('.e_id').val(_this.find('.id').text());
    });
</script>
