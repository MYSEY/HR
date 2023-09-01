<div class="tab-pane fade" id="transferred" role="tabpanel">
    <div class="col-md-12 d-flex">
        <div class="card profile-box flex-fill">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.transferred') <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#TransferrendModal"><i class="fa fa-pencil"></i></a></h3>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.branch_from')</th>
                                <th>@lang('lang.branch_to')</th>
                                <th>@lang('lang.position_from')</th>
                                <th>@lang('lang.position_to')</th>
                                <th>@lang('lang.trainsferend_date')</th>
                                <th>@lang('lang.remark')</th>
                                <th style="text-align: center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($transferred)>0)
                                @foreach ($transferred as $item)
                                    <tr>
                                        <td class="ids">{{$item->id}}</td>
                                        <td>{{$item->branch_id}}</td>
                                        <td style="color:#26AF49">{{$item->tranferend_branch_name}}</td>
                                        <td>{{$item->position_id}}</td>
                                        <td style="color:#26AF49">{{$item->tranferend_position_name}}</td>
                                        <td>{{$item->TransterDate}}</td>
                                        <td>{{$item->descrition}}</td>
                                        <td style="text-align: center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item update" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item transferrencDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_transferrend"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="10" style="text-align: center">@lang('lang.no_record_to_display')</td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Transferrend Modal -->
<div class="modal custom-modal fade" id="delete_transferrend" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('transferrend/delete')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" class="e_transferrend_id" value="">
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
<!-- /Delete Transferrend Modal -->
@include('employees.Transferreds.create')
@include('employees.Transferreds.update')

<script>
    $(function(){
        $('.update').on('click',function(){
            var localeLanguage = '{{ config('app.locale') }}';
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/transferred/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        if (response.branch != '') {
                            $('#e_tranferend_branch_name').html('<option selected disabled> -- @lang("lang.select") --</option>');
                            $.each(response.branch, function(i, item) {
                                $('#e_tranferend_branch_name').append($('<option>', {
                                    value: item.branch_name_en,
                                    text: localeLanguage == 'en' ? item.branch_name_en : item.branch_name_kh,
                                    selected: item.branch_name_en == response.success.tranferend_branch_name
                                }));
                            });
                        }
                        if (response.position != '') {
                            $('#e_tranferend_position_name').html('<option selected disabled> -- @lang("lang.select") --</option>');
                            $.each(response.position, function(i, item) {
                                $('#e_tranferend_position_name').append($('<option>', {
                                    value: item.name_english,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.name_english == response.success.tranferend_position_name
                                }));
                            });
                        }
                    
                        $('#e_transferrend_id').val(response.success.id);
                        $('#e_branch_id').val(response.success.branch_id);
                        $('#e_position_id').val(response.success.position_id);
                        $('#e_date').val(response.success.date);
                        $('#e_descrition').val(response.success.descrition);
                        $('#TransferrendModalUdate').modal('show');
                    }
                }
            });
        });
        $('.transferrencDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_transferrend_id').val(_this.find('.ids').text());
        });
    });
</script>