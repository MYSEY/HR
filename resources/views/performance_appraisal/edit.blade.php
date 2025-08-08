@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.performance_appraisal')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.performance_appraisal')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.employee_id')</label>
                        <input class="form-control" type="text" id="" name="" value="{{$data->number_employee}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.name_kh')</label>
                        <input class="form-control" type="text" id="" name="" value="{{$data->employee_name_kh}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.name_en')</label>
                        <input class="form-control" type="text" id="" name="" value="{{$data->employee_name_en}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.position')</label>
                        <input class="form-control" type="text" id="" name="" value="{{$data->positions_name}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.department')</label>
                        <input class="form-control" type="text" id="" name="" value="{{$data->dep_name}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.branch')</label>
                        <input class="form-control" type="text" id="" name="" value="{{$data->branch_name_en}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.from_date')</label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker required" type="text" id="from_date" name="from_date" value="{{$data->from_date}}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>@lang('lang.to_date')</label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker required" type="text" id="to_date" name="to_date" value="{{$data->to_date}}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>ពិន្ទុ (Score)</label>
                        <input class="form-control" type="text" id="total_score" name="total_score" value="{{$data->total_score}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>បុគ្គលិកផ្ទាល់</label>
                        <input class="form-control" type="text" id="total_score_live_staff" name="total_score_live_staff" value="{{$data->total_score_live_staff}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>ប្រធានផ្ទាល់</label>
                        <input class="form-control" type="text" id="total_score_direct_chairman" name="total_score_direct_chairman" value="{{$data->total_score_direct_chairman}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Noted</label>
                        <textarea rows="7" class="form-control" id="noted" name="noted" placeholder="Enter text here"></textarea>
                    </div>
                </div>
            </div>
            <div class="submit-section mb-2">
                <input type="text" name="id" id="id" value="{{ $data->id }}" hidden>
                <input type="text" name="employee_id" id="employee_id" value="{{ $data->employee_id }}" hidden>
                <button type="submit" class="btn btn-primary" id="btnCreatePerformance">
                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                        @lang('lang.loading') </span>
                    <span class="btn-txt">@lang('lang.submit')</span>
                </button>
                <a href="{{ url('performance-appraisal') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        $(document).on('click', '#btnCreatePerformance', function(e) {
            e.preventDefault(); // Prevent the form from submitting the traditional way
            let numRequired = 0;
            $(".required").each(function(e){
                if($(this).val()==""){ numRequired++;}
            });

            if (numRequired>0) {
                toastr.error("@lang('lang.input_required')", "@lang('lang.message_title')");
                $(".required").each(function(){
                    if($(this).val()==""){
                        $(this).css("border-color","red");
                    }
                });
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ url('performance/appraisal/update/score') }}",
                    data: {
                        id : $("#id").val(),
                        employee_id : $("#employee_id").val(),
                        total_score_direct_chairman : $("#total_score_direct_chairman").val(),
                        noted : $("#noted").val(),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.message == 'successfully') {
                            toastr.success(response.message, 'Success');
                            setTimeout(function() {
                                window.location.href = "{{ url('performance-appraisal') }}";
                            }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred. Please try again.', 'Error');
                    }
                });
            }
        });
    });
</script>
