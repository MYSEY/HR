@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.holidays') {{Helper::getCurrenYear()}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.public_holidays')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if (permissionAccess("42","is_create")->value == "1")
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="fa fa-plus"></i> @lang('lang.add_new')</a>
                    @endif
                </div>
            </div>
        </div>
        @if (permissionAccess("42","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="tab-pane show" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped custom-table datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('lang.date')</th>
                                                    <th>@lang('lang.title')</th>
                                                    <th>@lang('lang.amount_percent')(%)</th>
                                                    <th>@lang('lang.period_month')</th>
                                                    <th>@lang('lang.created_at')</th>
                                                    <th class="text-end">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($data) > 0)
                                                    @foreach ($data as $key=>$item)
                                                        <tr>
                                                            <td class="ids">{{++$key}}</td>
                                                            <td class="title">{{$item->Day}}</td>
                                                            <td class="title">{{Helper::getLang() == 'en' ? $item->title_en  :$item->title_kh}}</td>
                                                            <td style="text-align: center;" class="amount_percent"><a href="#">{{$item->amount_percent}}</a></td>
                                                            <td class="period_month">{{$item->PeriodPayment}}</td>
                                                            <td>{{Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                                                            <td class="text-end">
                                                                @if (permissionAccess("42","is_update")->value == "1")
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item update" data-toggle="modal" data-id="{{$item->id}}" data-target="#edit_holiday"><i class="fa fa-pencil m-r-5"></i> @lang('lang.edit')</a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" style="text-align: center">@lang('lang.no_record_to_display')</td>
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
        @endif
        <div class="modal custom-modal fade" id="add_holiday" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.add_holiday')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('holidays/create')}}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.title_en') <span class="text-danger">*</span></label>
                                        <textarea type="text" rows="2" class="form-control" name="title_en" id="title_en" required value="{{old('title_en')}}"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.title_kh') <span class="text-danger">*</span></label>
                                        <textarea type="text" rows="2" class="form-control" name="title_kh" id="title_kh" required value="{{old('title_kh')}}"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.amount_percent') (%)</label>
                                        <input class="form-control" type="number" id="amount_percent" name="amount_percent">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.period_month')</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="period_month" name="period_month">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.from') <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="from" name="from" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.to')</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="to" name="to">
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit_holiday" class="modal custom-modal fade" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('lang.edit_holiday')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('holidays/update')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.title_en') <span class="text-danger">*</span></label>
                                        <textarea type="text" rows="2" class="form-control" name="title_en" id="e_title_en" required value=""></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.title_kh') <span class="text-danger">*</span></label>
                                        <textarea type="text" rows="2" class="form-control" name="title_kh" id="e_title_kh" required value=""></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.amount_percent') (%)</label>
                                        <input class="form-control" type="number" id="e_amount_percent" name="amount_percent">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.period_month')</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_period_month" name="period_month">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.from') <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_from" name="from" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('lang.to')</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_to" name="to">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <input type="hidden" name="id" id="e_id" class="e_id" value="">
                                <button class="btn btn-primary submit-btn">
                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                    <span class="btn-txt">@lang('lang.submit')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script>
    $(function(){
        $('.update').on('click',function(){
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/holidays/edit')}}",
                data: {
                    id : id
                },
                dataType: "JSON",
                success: function (response) {
                    $('#e_id').val(response.success.id);
                    $('#e_title_en').val(response.success.title_en);
                    $('#e_title_kh').val(response.success.title_kh);
                    $('#e_amount_percent').val(response.success.amount_percent);
                    $('#e_period_month').val(response.success.period_month);
                    $('#e_from').val(response.success.from);
                    $('#e_to').val(response.success.to);
                }
            });
        });

        $('.delete').on('click',function(){
            var id = $(this).data('id');
            $('.e_id').val(id);
        });
    });
</script>