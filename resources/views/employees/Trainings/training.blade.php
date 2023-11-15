<div class="tab-pane fade" id="training" role="tabpanel">
    <div class="col-md-12 d-flex">
        <div class="card profile-box flex-fill">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.training') 
                    @if (permissionAccess("5","is_update")->value == "1")
                    <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#TrainingModal"><i class="fa fa-pencil"></i></a>
                    @endif
                </h3>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.course_name')</th>
                                <th>@lang('lang.start_date')</th>
                                <th>@lang('lang.end_date')</th>
                                <th>@lang('lang.remark')</th>
                                <th>@lang('lang.created_at')</th>
                                <th style="text-align: center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($training)>0)
                                @foreach ($training as $item)
                                    <tr>
                                        <td class="ids">{{$item->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->TrainingStartDate}}</td>
                                        <td>{{$item->TrainingStartEndDate}}</td>
                                        <td>{{$item->descrition}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td style="text-align: center">
                                            @if (permissionAccess("5","is_update")->value == "1" || permissionAccess("5","is_delete")->value == "1")
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if (permissionAccess("5","is_update")->value == "1")
                                                        <a class="dropdown-item trainingUpdate" data-id="{{$item->id}}" data-bs-target="#promote_edit"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                        @endif
                                                        @if (permissionAccess("5","is_delte")->value == "1")
                                                        <a class="dropdown-item trainingDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_training"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="7" style="text-align: center">@lang('lang.no_record_to_display')</td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('employees.Trainings.create')
@include('employees.Trainings.edit')
<!-- Delete Promote Modal -->
<div class="modal custom-modal fade" id="delete_training" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('employee/training/delete')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" class="e_train_id" value="">
                        <div class="row">
                            <div class="submit-section" style="text-align: center">
                                <button type="submit" class="btn btn-primary submit-btn me-2">Delete</button>
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Promote Modal -->

<script>
    $(function(){
        $('.trainingDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_train_id').val(_this.find('.ids').text());
        });
        $('.trainingUpdate').on('click',function(){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/employee/training/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_train_id').val(response.success.id);
                        $('#e_title').val(response.success.title);
                        $('#e_start_date').val(response.success.start_date);
                        $('#e_end_date').val(response.success.end_date);
                        $('#e_descritions').val(response.success.descrition);
                        $('#TrainingModalUpdate').modal('show');
                    }
                }
            });
        });
    });
</script>