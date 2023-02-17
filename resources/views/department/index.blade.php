@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Department</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Department</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('/department/create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif 

        <div class="row">
            <div class="col-md-12">
                <div>
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;" class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 772.237px;">Create By</th>
                                            <th class="text-end sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 300.962px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                                <tr class="odd">
                                                    <td class="sorting_1">{{$item->id}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->FullName}}</td>
                                                    <td class="text-end">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="{{route('department.edit',$item->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="#" data-id="{{$item->id}}" id="delete_department"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" style="text-align: center">data not to display</td>
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
@endsection

@include('includs.index')
<script>
    $(function(){
        $("#DataTables_Table_0 tbody").delegate("#delete_department", "click", function(){
            let delId = $(this).data("id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YES',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: "/department/delete",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id   : delId
                        },
                        success: function (response) {
                            if(response.status==1){
                                Swal.fire('Deleted!','Your file has been deleted.','success')
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
    });
</script>
