<div class="tab-pane fade" id="promote" role="tabpanel">
    <div class="col-md-12 d-flex">
        <div class="card profile-box flex-fill">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.promoted') 
                    @if (permissionAccess("5","is_create")->value == "1")
                    <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#PromotionModal"><i class="fa fa-pencil"></i></a>
                    @endif
                </h3>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.department_from')</th>
                                <th>@lang('lang.department_to')</th>
                                <th>@lang('lang.position_from')</th>
                                <th>@lang('lang.position_to')</th>
                                <th>@lang('lang.promoted_date')</th>
                                <th style="text-align: center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($empPromoted)>0)
                                @foreach ($empPromoted as $item)   
                                    <tr>
                                        <td class="ids">{{$item->id}}</td>
                                        <td>{{$item->depart_id}}</td>
                                        <td style="color:#26AF49">
                                            {{$item->department_promoted_to}}
                                        </td>
                                        <td>{{$item->posit_id}}</td>
                                        <td style="color:#26AF49">{{$item->position_promoted_to}}</td>
                                        <td>{{$item->PormotDate}}</td>
                                        <td style="text-align: center">
                                            @if (permissionAccess("5","is_update")->value == "1" || permissionAccess("5","is_delete")->value == "1")
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if (permissionAccess("5","is_update")->value == "1")
                                                        <a class="dropdown-item promoteUpdate" data-id="{{$item->id}}" data-bs-target="#promote_edit"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                        @endif
                                                        @if (permissionAccess("5","is_delete")->value == "1")
                                                        <a class="dropdown-item promoteDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_promote"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
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
<!-- Delete Promote Modal -->
<div class="modal custom-modal fade" id="delete_promote" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{url('promote/delete')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" class="e_pro_id" value="">
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
@include('employees.promotes.create')
@include('employees.promotes.edit')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>

<script>
    $(function(){
        $('.promoteDelete').on('click',function(){
            var _this = $(this).parents('tr');
            $('.e_pro_id').val(_this.find('.ids').text());
        });
        $('.promoteUpdate').on('click',function(){
            var localeLanguage = '{{ config('app.locale') }}';

            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{url('/promote/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        if (response.position != '') {
                            $('#e_position_promoted_to').html('<option selected disabled> -- @lang("lang.select") --</option>');
                            $.each(response.position, function(i, item) {
                                $('#e_position_promoted_to').append($('<option>', {
                                    value: item.name_english,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.name_english == response.success.position_promoted_to
                                }));
                            });
                        }
                        if (response.department != '') {
                            $('#e_department_promoted_to').html('<option selected disabled> -- @lang("lang.select") --</option>');
                            $.each(response.department, function(i, item) {
                                $('#e_department_promoted_to').append($('<option>', {
                                    value: item.name_english,
                                    text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                    selected: item.name_english == response.success.department_promoted_to
                                }));
                            });
                        }

                        $('#e_promote_id').val(response.success.id);
                        $('#e_posit_id').val(response.success.posit_id);
                        $('#e_depart_id').val(response.success.depart_id);
                        $('#e_promote_date').val(response.success.date);
                        $('#promotionModalEdit').modal('show');
                    }
                }
            });
        });
    });
</script>