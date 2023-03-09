@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">

                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add New</a>
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
                                <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 291.163px;">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 227px;"> Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 227px;"> Phone</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 202.6px;">Position</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" style="width: 202.6px;">Departement</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Role</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Created Date: activate to sort column ascending" style="width: 114.95px;">Created Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 80.8125px;">Status</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 60.675px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td class="ids">{{ $item->id }}</td>
                                                    <td class="sorting_1">
                                                        <span hidden class="image">{{ $item->profile}}</span>
                                                        <h2 class="table-avatar">
                                                            @if ($item->profile != null)
                                                                <a href=""  class="avatar">
                                                                    <img alt="avatar" src="{{asset('/uploads/images/'.$item->profile)}}">
                                                                </a>
                                                                <a href="" class="name">{{$item->name}}</a>
                                                            @else
                                                                <a href="" class="avatar">
                                                                    <img alt="avatar" src="{{asset('admin/img/defuals/default-user-icon.png')}}">
                                                                </a>
                                                                <a href="" class="name">{{$item->name}}</a>
                                                            @endif
                                                        </h2>
                                                    </td>
                                                    <td class="email">{{$item->email}}</td>
                                                    <td class="phone_number">{{ $item->phone }}</td>
                                                    <td class="position">{{$item->position_id}}</td>
                                                    <td class="department">{{$item->department_id}}</td>
                                                    <td>
                                                        <span class="badge bg-inverse-success role_name">{{ $item->role_id }}</span>
                                                    </td>
                                                    <td>{{$item->created_at}}</td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            @if ($item->status=='Active')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span class="statuss">{{ $item->status }}</span>
                                                                </a>
                                                            @elseif ($item->status=='Inactive')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-info"></i>
                                                                    <span class="statuss">{{ $item->status }}</span>
                                                                </a>
                                                            @elseif ($item->status=='Disable')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i>
                                                                    <span class="statuss">{{ $item->status }}</span>
                                                                </a>
                                                            @elseif ($item->status=='')
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-dot-circle-o text-dark"></i>
                                                                    <span class="statuss">N/A</span>
                                                                </a>
                                                            @endif
                                                            
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-dot-circle-o text-success"></i> Active
                                                                </a>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-dot-circle-o text-warning"></i> Inactive
                                                                </a>
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fa fa-dot-circle-o text-danger"></i> Disable
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item userUpdate" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item userDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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


        <!-- Add User Modal -->
        <div id="add_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('users/store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Emaill <span class="text-danger">*</span></label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="" name="email"  placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <label>Role Name <span class="text-danger">*</span></label>
                                    <select class="select form-control @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($role as $itme )
                                            <option value="{{ $itme->name }}">{{ $itme->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Position <span class="text-danger">*</span></label>
                                    <select class="select form-control @error('position_id') is-invalid @enderror" name="position_id" id="position_id">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($position as $positions )
                                            <option value="{{ $positions->name_khmer }}">{{ $positions->name_khmer }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input class="form-control @error('phone') is-invalid @enderror" type="tel" id="" name="phone" placeholder="Enter Phone">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select class="select form-control @error('department_id') is-invalid @enderror" name="department_id" id="department_id">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($department as $item )
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <label>Status</label>
                                    <select class="select form-control" name="status" id="status">
                                        <option selected disabled> --Select --</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Disable">Disable</option>
                                    </select>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Photo</label>
                                    <input class="form-control" type="file" id="image" name="image">
                                </div>
                            </div>
                            <br>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
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
        <!-- /Add User Modal -->

        <!-- Edit User Modal -->
        <div id="edit_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{url('users/update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" class="e_id" value="">
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="e_name" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Emaill <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" id="e_email" name="email"  placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <label>Role Name <span class="text-danger">*</span></label>
                                    <select class="select form-control" name="role_id" id="e_role_name">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($role as $itme )
                                            <option value="{{ $itme->name }}">{{ $itme->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Position <span class="text-danger">*</span></label>
                                    <select class="select form-control" name="position_id" id="e_position">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($position as $item )
                                            <option value="{{ $item->name_khmer }}">{{ $item->name_khmer }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input class="form-control" type="tel" id="e_phone_number" name="phone" placeholder="Enter Phone">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select class="select form-control" name="department_id" id="e_department">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($department as $item )
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <label>Status</label>
                                    <select class="select form-control" name="status" id="e_status">
                                        <option selected disabled> --Select --</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Disable">Disable</option>
                                    </select>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Profile</label>
                                    <input class="form-control" type="file" id="image" name="image">
                                    <input type="hidden" name="hidden_image" id="e_image" value="">
                                </div>
                            </div>
                            <br>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
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
        <!-- /Edit Salary Modal -->

        <!-- Delete User Modal -->
        <div class="modal custom-modal fade" id="delete_user" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('users/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <input type="hidden" name="hidden_image" id="e_image" value="">
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
        <!-- /Delete User Modal -->
    </div>
@endsection
@include('includs.script')

<script>
    $(function(){
        $('.userUpdate').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
            $('#e_name').val(_this.find('.name').text());
            $('#e_email').val(_this.find('.email').text());
            $('#e_phone_number').val(_this.find('.phone_number').text());
            $('#e_image').val(_this.find('.image').text());

            var name_role = (_this.find(".role_name").text());
            var _option = '<option selected value="' + name_role+ '">' + _this.find('.role_name').text() + '</option>'
            $( _option).appendTo("#e_role_name");

            var position = (_this.find(".position").text());
            var _option = '<option selected value="' +position+ '">' + _this.find('.position').text() + '</option>'
            $( _option).appendTo("#e_position");

            var department = (_this.find(".department").text());
            var _option = '<option selected value="' +department+ '">' + _this.find('.department').text() + '</option>'
            $( _option).appendTo("#e_department");

            var statuss = (_this.find(".statuss").text());
            var _option = '<option selected value="' +statuss+ '">' + _this.find('.statuss').text() + '</option>'
            $( _option).appendTo("#e_status");
        });
        $('.userDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.ids').text());
            $('.e_image').val(_this.find('.image').text());
        });
    });
</script>
