@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.performance')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.performance')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('performance/create')}}" class="btn add-btn me-2"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
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
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-4">#</th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.from_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.to_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.type')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.total_weight')</th>
                                            {{-- <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Total Percentage(%)</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Total Score</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Total Score achieved</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Overall Results</th> --}}
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr class="odd">
                                                <td class="ids stuck-scroll-4">{{$item->id}}</td>
                                                <td class="stuck-scroll-4"><a href="{{url("performance",$item->employee_id)}}">{{$item->number_employee}}</a></td>
                                                <td class="stuck-scroll-4"><a href="">{{$item->employee_name_en}}</a></td>
                                                <td>{{$item->branch_name_en}}</td>
                                                <td>{{$item->dep_name}}</td>
                                                <td>{{$item->positions_name}}</td>
                                                <td>{{$item->from_date}}</td>
                                                <td>{{$item->to_date}}</td>
                                                <td>{{$item->type}}</td>
                                                <td>{{$item->total_weight}}%</td>
                                                {{-- <td><span class="badge bg-inverse-success">40%</span></td>
                                                <td>{{$item->total_score}}</td>
                                                <td>{{$item->total_score_achieved}}</td>
                                                <td>{{$item->overall_results}}</td> --}}
                                                {{-- <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-warning"></i>
                                                            <span>{{ $item->status == 'prepare' ? 'Prepare' : 'Approved' }}</span>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-right" id="btnStatus">
                                                            <a class="dropdown-item" data-id="{{$item->id}}" href="#">
                                                                <i class="fa fa-dot-circle-o text-success"></i>                                                             
                                                                <span>{{ $item->status == 'prepare' ? 'Approve' : 'Prepared' }}</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td> --}}
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o {{ $item->status == 'prepare' ? 'text-warning' : 'text-success' }}"></i>
                                                            <span>{{ $item->status == 'prepare' ? 'Prepare' : 'Approved' }}</span>
                                                        </a>
                                                
                                                        @if($item->status == 'prepare')
                                                            <div class="dropdown-menu dropdown-menu-right" id="btnStatus">
                                                                <a class="dropdown-item" data-id="{{ $item->id }}" href="#">
                                                                    <i class="fa fa-dot-circle-o text-success"></i>
                                                                    <span>Approve</span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{url("performance",$item->id)}}"><i class="fa fa-regular fa-eye"></i> @lang("lang.preview")</a>
                                                            <a href="{{ url('performance', $item->id) }}/edit" class="dropdown-item" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                            <a class="dropdown-item performanceDelete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_performance"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Performane Modal -->
        <div class="modal custom-modal fade" id="delete_performance" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.deleted')!</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('performance/delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">

                                <div class="row">
                                    <div class="submit-section" style="text-align: center">
                                        <button type="submit" class="btn btn-primary submit-btn me-2">@lang('lang.delete')</button>
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">@lang('lang.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Performane Modal -->
    </div>
@endsection
@include('includs.script')
@section('script')
    <script>
        $(document).ready(function() {
            $('.performanceDelete').on('click',function(){
                let id = $(this).data("id");
                $('.e_id').val(id);
            });
            
            $('#btnStatus a').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.confirm({
                    title: '@lang("lang.approve")',
                    contentClass: 'text-center',
                    backgroundDismiss: 'cancel',
                    content: '@lang("lang.are_you_sure_want_to_approve")',
                    buttons: {
                        confirm: {
                            text: 'Ok',
                            type: 'blue',
                            btnClass: 'btn-green',
                            action: function() {
                                axios.post('{{ URL("performance/approve") }}/'+id).then(function(response) {
                                    if (response.data.success) {
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('performance') }}");
                                    } else if(response.data.message == 'weight_must_be_exactly'){
                                        new Noty({
                                            title: "",
                                            text: 'Total weight must be exactly 100% before approval.',
                                            type: "error",
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('performance') }}");
                                    }
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-secondary btn-sm',
                        },
                    },
                    onContentReady: function() {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function(e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });

                // $.ajax({
                //     url: "{{ url('performance/status') }}/" + id,
                //     type: 'GET',
                //     success: function(response) {
                //         if (response.success) {
                //             toastr.success(response.message);
                //             location.reload();
                //         } else {
                //             toastr.error(response.message);
                //         }
                //     },
                //     error: function(xhr) {
                //         toastr.error(xhr.responseJSON.message);
                //     }
                // });
            });
        });
    </script>