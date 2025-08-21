@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.annual_salary_increasement')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.annual_salary_increasement')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn me-2" data-bs-toggle="modal" data-bs-target="#add_annual_salary_increasement"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
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
                                <table id="DataTables_Table_0" class="table table-striped custom-table mb-0 datatable dataTable no-footer" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-4">#</th>
                                            <th class="sorting stuck-scroll-4">ចំណាត់ថ្នាក់លទ្ទផលការងារ</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">ពិន្ទុសរុប</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">គិតជាភាគរយ</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">Increasement Year</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->ranking_work_result}}</td>
                                                <td>{{$item->total_score}}</td>
                                                <td>{{$item->percentage}}%</td>
                                                <td>{{$item->increasement_year}}</td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            @if(permissionAccess("m9-s4","is_update")->value == "1")
                                                                <a class="dropdown-item btn_edit" data-toggle="modal" data-id="{{$item->id}}"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                            @endif
                                                            @if(permissionAccess("m9-s4","is_delete")->value == "1")
                                                                <a class="dropdown-item delete" href="#" data-toggle="modal" data-id="{{$item->id}}" data-target="#delete_department"><i class="fa fa-trash-o m-r-5"></i> @lang('lang.delete')</a>
                                                            @endif
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

        <div id="add_annual_salary_increasement" class="modal custom-modal fade" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.annual_salary_increasement')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('annual/salary/increasement')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>ចំណាត់ថ្នាក់លទ្ទផលការងារ <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('ranking_work_result') is-invalid @enderror" name="ranking_work_result" id="ranking_work_result" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Total Score <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('total_score') is-invalid @enderror" id="total_score" name="total_score" required>
                            </div>
                            <div class="form-group">
                                <label>Percentage <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage" name="percentage" required>
                            </div>
                            @php
                                $startYear = 2020;
                                $endYear   = now()->year + 1; // current year + 1
                            @endphp
                            <div class="form-group">
                                <label>Year <span class="text-danger">*</span></label>
                                <select name="increasement_year" id="increasement_year" class="form-control">
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }}"  {{ old('increasement_year', date('Y')) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit_annual_salary_increasement" class="modal custom-modal fade" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.annual_salary_increasement')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('annual/salary/increasement')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="e_id" class="e_id" value="">
                            <div class="form-group">
                                <label>ចំណាត់ថ្នាក់លទ្ទផលការងារ <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('ranking_work_result') is-invalid @enderror" name="ranking_work_result" id="e_ranking_work_result" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Total Score <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('total_score') is-invalid @enderror" id="e_total_score" name="total_score" required>
                            </div>
                            <div class="form-group">
                                <label>Percentage <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="e_percentage" name="percentage" required>
                            </div>
                            @php
                                $startYear = 2020;
                                $endYear   = now()->year + 1; // current year + 1
                            @endphp
                            <div class="form-group">
                                <label>Year <span class="text-danger">*</span></label>
                                <select name="increasement_year" class="form-control" id="e_increasement_year">
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }}"  {{ old('increasement_year', date('Y')) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Department Modal -->
        <div class="modal custom-modal fade" id="delete_department" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>@lang('lang.delete')</h3>
                            <p>@lang('lang.are_you_sure_want_to_delete')?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{url('annual/salary/increasement/delete')}}" method="POST">
                                @csrf
                                @method('DELETE')
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
        <!-- /Delete Department Modal -->
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>

<script>
    $(function(){
        $('.btn_edit').on('click',function(){
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{ url('annual/salary/increasement') }}/" + id + "/edit",
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        $('#e_id').val(response.success.id);
                        $('#e_ranking_work_result').val(response.success.ranking_work_result);
                        $('#e_total_score').val(response.success.total_score);
                        $('#e_percentage').val(response.success.percentage);
                        $('#e_increasement_year').val(response.success.increasement_year);
                        // dynamically set action URL for PUT request
                        $('#edit_annual_salary_increasement form').attr('action', "{{ url('annual/salary/increasement') }}/" + id);
                        $('#edit_annual_salary_increasement').modal('show');
                    }
                }
            });
        });

        $('.delete').on('click',function(){
            let id = $(this).data("id");
            $('#delete_department form').attr('action', "{{ url('annual/salary/increasement') }}/" + id);

            $('.e_id').val(id);
        });
    });
</script>