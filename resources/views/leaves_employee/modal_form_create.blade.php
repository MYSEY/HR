<div id="add_leave" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new leave request</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group hr-form-group-select2">
                                <label>Leave Type<span class="text-danger">*</span></label>
                                <select class="hr-select2-option requered leave_required" id="leave_type_id" name="leave_type_id" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($dataLeaveType as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker leave_required" name="start_date" id="start_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker leave_required" name="end_date" id="end_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Half Day --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="container-checkbox">Half day?
                                        <input type="checkbox" class="check_half_day"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row half_day" style="display: none">
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label class="container-checkbox me-4">AM
                                        <input type="checkbox" class="half_day_checkbox_am half_clear_checkbox"> <span class="checkmark"></span>
                                    </label>
                                    <label class="container-checkbox">PM
                                        <input type="checkbox" class="half_day_checkbox_pm half_clear_checkbox"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                    </div>
                    {{-- Half start date and Half end Date --}}
                    <div class="half_start_end_day" style="display: none">
                        <div class="row" >
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Start day?</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="container-checkbox me-4">AM
                                            <input type="checkbox" class="half_start_day_checkbox_am half_clear_checkbox isCheckboxx start_half_check"> <span class="checkmark"></span>
                                        </label>
                                        <label class="container-checkbox">PM
                                            <input type="checkbox" class="half_start_day_checkbox_pm half_clear_checkbox isCheckboxx start_half_check" > <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>End day?</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="container-checkbox me-4">AM
                                            <input type="checkbox" class="half_end_day_checkbox_am half_clear_checkbox isCheckboxx end_half_check" > <span class="checkmark"></span>
                                        </label>
                                        <label class="container-checkbox">PM
                                            <input type="checkbox" class="half_end_day_checkbox_pm half_clear_checkbox isCheckboxx end_half_check" > <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Number of days <span class="text-danger">*</span></label>
                                <input type="number" disabled class="form-control" name="number_of_day" id="number_of_day">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group hr-form-group-select2">
                                <label>Handover Staff <span class="text-danger">*</span></label>
                                <select class="hr-select2-option requered leave_required" name="handover_staff_id" id="handover_staff_id" required>
                                    <option selected disabled value=""> --@lang('lang.select')--</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->employee_name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Leave Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control requered leave_required" id="reason" name="reason" placeholder="Write down why you want to relax" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn btn-apply">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">Apply</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('includs.script')
<script src="{{asset('/admin/js/validation-field.js')}}"></script>
<script src="{{asset('/admin/js/countWeekday.js')}}"></script>
<script>
    $(function(){
        var total_day = 0;
        $("#start_date").on("dp.change", function(e) {
            let startDates = e.date;
            $('#end_date').data('DateTimePicker').minDate(startDates);
            let startDate = new Date($(this).val());
            let endDate = new Date($('#end_date').val());
            let weekdayCount = countWeekdays(startDate,  endDate);
            $(".half_clear_checkbox").val("");
            $(".half_clear_checkbox").prop('checked', false);
            $(".check_half_day").prop('checked', false);
            $(".half_start_end_day").css("display","none");
            $(".half_day").css("display","none");
            axios.post('{{ URL('holidays/search') }}', {
                "from_date": $(this).val(),
                "to_date": $('#end_date').val()
            }).then(function(response) {
                let holiday = response.data.datas;
                let nextWorkigDay = 0;
                if (holiday != '') {
                    $.each(holiday, function(i, holi) {
                        nextWorkigDay += countWeekdays(holi.from,  holi.to);
                    });
                }
                total_day = weekdayCount - nextWorkigDay;
                $("#number_of_day").val(total_day);
            });
        });

        // function end date
        $("#end_date").on("dp.change", function(e) {
            let startDate = $('#start_date').data('DateTimePicker').date();
            let endDate = e.date;
            if (startDate > endDate) {
                $('#end_date').data('DateTimePicker').date(startDate);
            }
            let startDates = new Date($("#start_date").val());
            let endDates = new Date($(this).val()); 
            let weekdayCount = countWeekdays(startDates,  endDates);

            $(".half_clear_checkbox").val("");
            $(".half_clear_checkbox").prop('checked', false);
            $(".check_half_day").prop('checked', false);
            $(".half_start_end_day").css("display","none");
            $(".half_day").css("display","none");
            axios.post('{{ URL('holidays/search') }}', {
                "from_date": $("#start_date").val(),
                "to_date": $(this).val()
            }).then(function(response) {
                let holiday = response.data.datas;
                let nextWorkigDay = 0;
                if (holiday != '') {
                    $.each(holiday, function(i, holi) {
                        nextWorkigDay += countWeekdays(holi.from,  holi.to);
                    });
                }
                total_day = weekdayCount - nextWorkigDay;
                $("#number_of_day").val(total_day);
            });
        });

        $(".check_half_day").on("click", function() {
           if (document.getElementsByClassName('check_half_day')[0].checked == true) {
                if ($("#end_date").val() > $("#start_date").val()) {
                    $(".half_start_end_day").css("display","block");
                }else if ($("#end_date").val() == $("#start_date").val()) {
                    $(".half_day").css("display","block");
                }
            } else {
                $(".half_clear_checkbox").val("");
                $(".half_clear_checkbox").prop('checked', false);

                $(".half_day").css("display","none");
                $(".half_start_end_day").css("display","none");
            }
            $("#number_of_day").val(total_day);
        });

        $(".half_day_checkbox_am").on("click", function() {
            if (document.getElementsByClassName('half_day_checkbox_am')[0].checked == true) {
                $(".half_day_checkbox_am").val("pm");
                $("#number_of_day").val(total_day - 0.5);
            }else{
                $(".half_day_checkbox_am").val("");
                $("#number_of_day").val(total_day);
            }
            $(".half_day_checkbox_pm").prop('checked', false);
            $(".half_day_checkbox_pm").val('');
        });

        $(".half_day_checkbox_pm").on("click", function() {
            if (document.getElementsByClassName('half_day_checkbox_pm')[0].checked == true) {
                $(".half_day_checkbox_pm").val("pm");
                $("#number_of_day").val(total_day - 0.5);
            }else{
                $(".half_day_checkbox_pm").val("");
                $("#number_of_day").val(total_day);
            }
            $(".half_day_checkbox_am").val('');
            $(".half_day_checkbox_am").prop('checked', false);
        });

        $(".half_start_day_checkbox_am").on("click", function() {
            if ($('.half_start_day_checkbox_am').is(':checked') == true) {
                $(".half_start_day_checkbox_am").val("am");
            } else {
                $(".half_start_day_checkbox_am").val("");
            }
            $(".half_start_day_checkbox_pm").val('');
            $(".half_start_day_checkbox_pm").prop('checked', false);
        });

        $(".half_start_day_checkbox_pm").on("click", function() {
            if ($('.half_start_day_checkbox_pm').is(':checked') == true) {
                $(".half_start_day_checkbox_pm").val("pm");
            } else {
                $(".half_start_day_checkbox_pm").val("");
            }
            $(".half_start_day_checkbox_am").val('');
            $(".half_start_day_checkbox_am").prop('checked', false);
        });

        $(".half_end_day_checkbox_am").on("click", function() {
            if ($('.half_end_day_checkbox_am').is(':checked') == true) {
                $(".half_end_day_checkbox_am").val("am");
            } else {
                $(".half_end_day_checkbox_am").val("");
            }
            $(".half_end_day_checkbox_pm").val('');
            $(".half_end_day_checkbox_pm").prop('checked', false);
        });

        $(".half_end_day_checkbox_pm").on("click", function() {
            if ($('.half_end_day_checkbox_pm').is(':checked') == true) {
                $(".half_end_day_checkbox_pm").val("pm");
            } else {
                $(".half_end_day_checkbox_pm").val("");
            }
            $(".half_end_day_checkbox_am").val('');
            $(".half_end_day_checkbox_am").prop('checked', false);
        });

        $(".isCheckboxx").on("click", function() {
            var countChecked = 0;
            $('.isCheckboxx[type=checkbox]').each(function () {
                if (this.checked) {
                    countChecked++;
                }
            });
            if (countChecked == 2) {
                $("#number_of_day").val(total_day - 1);
            }else if (countChecked == 1) {
                $("#number_of_day").val(total_day - 0.5);
            }else{
                $("#number_of_day").val(total_day);
            }
        });
        
        $(".btn-apply").on("click", function() {
            var num_miss = 0;
            $(".leave_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                }
            });
            if (num_miss>0 || $("#number_of_day").val() == 0) {
                let text_mesange = "";
                if (num_miss>0) {
                    text_mesange ="Please check input required";
                }else{
                    let totalChecked = $('.isCheckboxx').filter(':checked').length;
                    text_mesange = totalChecked ? "Please check out the number of days" : "Please check out the holidays";
                    new Noty({
                        title: "",
                        text: text_mesange,
                        type: "error",
                        timeout: 3000,
                        icon: true
                    }).show();
                    return false;
                }
            }else{
                let start_half_day = "";
                let end_half_day = "";
                if ($('.half_day_checkbox_am').is(':checked') == true) {
                    start_half_day = "am";
                }else if ($('.half_day_checkbox_pm').is(':checked') == true) {
                    end_half_day = "pm";
                }
                if ($('.start_half_check').is(':checked') == true) {
                    start_half_day = $(".start_half_check").val() == "am" ? "am": "pm";
                } 
                if ($('.end_half_check').is(':checked') == true) {
                    end_half_day = $(".end_half_check").val() == "am" ? "am" : "pm";
                }
                $.ajax({
                    type: "POST",
                    url: "{{url('leaves/employee/store')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "leave_type_id": $("#leave_type_id").val(),
                        "start_date": $("#start_date").val(),
                        "end_date": $("#end_date").val(),
                        "start_half_day": start_half_day,
                        "end_half_day": end_half_day,
                        "number_of_day": $("#number_of_day").val(),
                        "handover_staff_id": $("#handover_staff_id").val(),
                        "reason": $("#reason").val(),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        new Noty({
                            title: "",
                            text: '@lang("lang.leave_request_created_successfully")',
                            type: "success",
                            timeout: 3000,
                            icon: true
                        }).show();
                    }
                });
            }
        });
    });
</script>