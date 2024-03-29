@extends('layouts.master')

@section('content')
    <div class="">
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
                                <li class="{{ $loop->first ? 'active' : '' }}" at="{{$item->id ?? 0}}" value="{{$item->id ?? 0}}">
                                    <span hidden class="id">{{ $item->id }}</span>
                                    <a href="javascript:void(0);" at="{{$item->id ?? 0}}" value="{{$item->id ?? 0}}">
                                        <span class="roleNmae">{{$item->name ?? ''}}</span>
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
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th>Permission</th>
                                        <th>Read</th>
                                        <th>Write</th>
                                        <th>Create</th>
                                        <th>Delete</th>
                                        <th>Import</th>
                                        <th>Export</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                    <form action="{{url('role/store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('roleName') is-invalid @enderror" id="roleName" name="roleName" value="{{ old('roleName') }}" placeholder="Enter role name">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div id="edit_role" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('role/update') }}" method="POST" enctype="multipart/form-data"> 
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" id="e_id" value="">
                            <label>Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="e_roleNmae" name="roleNmae" value="">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Role Modal -->

    <div class="modal custom-modal fade" id="delete_role" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Role</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ url('role/delete') }}" method="POST">
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
@endsection
@include('includs.script')

<script>
    $(function(){
        role_click_change(role_active_id());
        
        $('.roles-menu ul li').on('click',function(){
            $('.roles-menu ul li').removeClass('active');
            $(this).addClass('active');
            role_click_change($(this).attr('at'));
        });
        $('.rolesUpdate').on('click',function(){
            var _this = $(this).closest("li");
            $('#e_id').val(_this.find('.id').text());
            $('#e_roleNmae').val(_this.find('.roleNmae').text());
        });
        $('.rolesDelete').on('click',function(){
            var _this = $(this).closest("li");
            $('.e_id').val(_this.find('.id').text());
        });
    });

    function role_active_id(){
        var role_active_id=0;
        $('.roles-menu ul li').each(function(){
            if($(this).hasClass('active')){
                role_active_id=$(this).attr('at');
            }
        })
        return role_active_id;
    }

    function role_click_change(role_id){
        $.ajax({
            type: "GET",
            url: "{{url('permission')}}",
            data: {
                role_id:role_id
            },
            dataType: "JSON",
            success: function (response) {
                $('table tbody').empty();
               $.each(response.success,function(index,value){
                    var view_check="";
                    var add_check="";
                    var update_check="";
                    var delete_check="";
                    var import_check="";
                    var export_check="";
                    if(value._view>0){
                        view_check="checked";
                    }

                    if(value._add>0){
                        add_check="checked";
                    }

                    if(value._update>0){
                        update_check="checked";
                    }
                    if(value._delete>0){
                        delete_check="checked";
                    }
                    if(value._import>0){
                        import_check="checked";
                    }
                    if(value._import>0){
                        export_check="checked";
                    }
                    var tr='<tr>'+
                            '<td>'+value.name+'</td>'+
                            '<td><input type="checkbox" name="view" id="" onclick="PermissionAndRole(this,'+value.id+',1);" '+view_check+'></td>'+
                            '<td><input type="checkbox" name="view" id="" onclick="PermissionAndRole(this,'+value.id+',2);" '+add_check+'></td>'+
                            '<td><input type="checkbox" name="view" id="" onclick="PermissionAndRole(this,'+value.id+',3);" '+update_check+'></td>'+
                            '<td><input type="checkbox" name="view" id="" onclick="PermissionAndRole(this,'+value.id+',4);" '+delete_check+'></td>'+
                            '<td><input type="checkbox" name="view" id="" onclick="PermissionAndRole(this,'+value.id+',5);" '+import_check+'></td>'+
                            '<td><input type="checkbox" name="view" id="" onclick="PermissionAndRole(this,'+value.id+',6);" '+export_check+'></td>'+
                        '</tr>';
                    $('table').append(tr);
               });
            }
        });
    }
    function PermissionAndRole(e,table_id,permission_type){
        var role_id=role_active_id();
        if(e.checked){
            insert_update=1;
        }else{
            insert_update=0;
        }
        $.ajax({
            type:'POST',
            url:"{{url('permission')}}",
            data:{
                "_token": "{{ csrf_token() }}",
                table_id:table_id,
                permission_type_id:permission_type,
                role_id:role_id,
                checked:insert_update
            },
            success:function(data){
                console.log(data);
            }
        });
    }
</script>
