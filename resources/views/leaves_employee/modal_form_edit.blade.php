<div id="edit_leave_request" class="modal custom-modal fade hr-modal-select2" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('lang.edit_leave_request')</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form enctype="multipart/form-data" class="needs-validation" novalidate>
                    <input hidden type="text" id="e_id_leave">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group hr-form-group-select2">
                                <label>@lang('lang.leave_type')<span class="text-danger">*</span></label>
                                <select class="hr-select2-option requered e_leave_required" id="e_leave_type_id" required>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label>@lang('lang.start_date') <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker e_leave_required" id="e_start_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label>@lang('lang.end_date') <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" class="form-control datetimepicker e_leave_required" id="e_end_date" required>
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
                                    <label class="container-checkbox">@lang('lang.half_day') ?
                                        <input type="checkbox" class="e_check_half_day"> <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row e_half_day" style="display: none">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="container-checkbox me-4">@lang('lang.am')
                                    <input type="checkbox" class="e_half_day_checkbox_am e_half_clear_checkbox"> <span class="checkmark"></span>
                                </label>
                                <label class="container-checkbox">@lang('lang.pm')
                                    <input type="checkbox" class="e_half_day_checkbox_pm e_half_clear_checkbox"> <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Half start date and Half end Date --}}
                    <div class="e_half_start_end_day" style="display: none">
                        <div class="row" >
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>@lang('lang.start_day') ?</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="container-checkbox me-4">@lang('lang.am')
                                            <input type="checkbox" class="e_half_start_day_checkbox_am e_half_clear_checkbox e_isCheckboxx start_half_check"> <span class="checkmark"></span>
                                        </label>
                                        <label class="container-checkbox">@lang('lang.pm')
                                            <input type="checkbox" class="e_half_start_day_checkbox_pm e_half_clear_checkbox e_isCheckboxx start_half_check" > <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>@lang('lang.end_day') ?</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="container-checkbox me-4">@lang('lang.am')
                                            <input type="checkbox" class="e_half_end_day_checkbox_am e_half_clear_checkbox e_isCheckboxx end_half_check" > <span class="checkmark"></span>
                                        </label>
                                        <label class="container-checkbox">@lang('lang.pm')
                                            <input type="checkbox" class="e_half_end_day_checkbox_pm e_half_clear_checkbox e_isCheckboxx end_half_check" > <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('lang.number_of_days') <span class="text-danger">*</span></label>
                                <input type="number" disabled class="form-control" id="e_number_of_day">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('lang.handover_staff') </label>
                                <select class="hr-select2-option " id="e_handover_staff_id">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >@lang('lang.leave_reason') <span class="text-danger">*</span></label>
                                <textarea class="form-control requered e_leave_required" id="e_reason" placeholder="Write down why you want to relax" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn btn-e-apply">
                            <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                            <span class="btn-txt">@lang('lang.apply')</span>
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
        var total_current_number_day = 0;
        $('.update').on('click',function(){
            $(".e_half_day").css("display","none");
            $(".e_half_start_end_day").css("display","none");
            $(".e_half_clear_checkbox").prop("checked", false);
            let id = $(this).data("id");
            $("#e_id_leave").val(id);
            let _id = id;
            $.ajax({
                type: "GET",
                url: "{{url('leaves/employee/edit')}}",
                data: {
                    id : _id
                },
                dataType: "JSON",
                success: function (response) {
                    let success = response.success;
                    $('#e_start_date').val(success.start_date);
                    $('#e_end_date').val(success.end_date);
                    $('#e_number_of_day').val(success.number_of_day);
                    total_day = success.number_of_day;
                    if (success.start_date == success.end_date) {
                        if (success.start_half_day || success.end_half_day) {
                            $(".e_check_half_day").prop("checked", true);
                            $(".e_half_day").css("display","block");
                            if (success.start_half_day == "am") {
                                $(".e_half_day_checkbox_am").prop("checked", true);
                            }
                            if (success.end_half_day == "pm") {
                                $(".e_half_day_checkbox_pm").prop("checked", true);
                            }
                        }
                    }
                    if (success.start_date < success.end_date) {
                        if (success.start_half_day || success.end_half_day) {
                            $(".e_check_half_day").prop("checked", true);
                            $(".e_half_start_end_day").css("display","block");
                            if (success.start_half_day == "am") {
                                $(".e_half_start_day_checkbox_am").prop("checked", true);
                            }else if (success.start_half_day == "pm") {
                                $(".e_half_start_day_checkbox_pm").prop("checked", true);
                            }
                            if (success.end_half_day == "am") {
                                $(".e_half_end_day_checkbox_am").prop("checked", true);
                            }else if (success.end_half_day == "pm") {
                                $(".e_half_end_day_checkbox_pm").prop("checked", true); 
                            }
                        }
                    }
                    $('#e_reason').text(success.reason);
                    $('#e_leave_type_id').html('<option value=""> -- @lang("lang.select") --</option>');
                    $('#e_handover_staff_id').html('<option value=""> -- @lang("lang.select") --</option>');
                    if (response.dataLeaveType != '') {
                        $.each(response.dataLeaveType, function(i, item) {
                            $('#e_leave_type_id').append($('<option>', {
                                value: item.id,
                                text: item.name,
                                selected: item.id == response.success.leave_type_id
                            }));
                        });
                    }
                    if (response.hondover_staff != '') {
                        $.each(response.hondover_staff, function(i, item) {
                            $('#e_handover_staff_id').append($('<option>', {
                                value: item.id,
                                text: item.employee_name_en,
                                selected: item.id == response.success.handover_staff_id
                            }));
                        });
                    }
                    $('#edit_leave_request').modal('show');

                    let startDate = new Date(success.start_date);
                    let endDate = new Date(success.end_date);
                    let weekdayCount = countWeekdays(startDate,  endDate);
                    axios.post('{{ URL('holidays/search') }}', {
                        "from_date": success.start_date,
                        "to_date": success.end_date
                    }).then(function(response) {
                        let holiday = response.data.datas;
                        let nextWorkigDay = 0;
                        if (holiday != '') {
                            $.each(holiday, function(i, holi) {
                                nextWorkigDay += countWeekdays(holi.from,  holi.to);
                            });
                        }
                        total_current_number_day = weekdayCount - nextWorkigDay;
                    });
                }
            });
        });

        $("#e_start_date").on("dp.change", function(e) {
            let startDates = e.date;
            $('#e_end_date').data('DateTimePicker').minDate(startDates);
            let startDate = new Date($(this).val());
            let endDate = new Date($('#e_end_date').val());
            let weekdayCount = countWeekdays(startDate,  endDate);
            $(".e_half_clear_checkbox").val("");
            $(".e_half_clear_checkbox").prop('checked', false);
            $(".e_check_half_day").prop('checked', false);
            $(".e_half_start_end_day").css("display","none");
            $(".e_half_day").css("display","none");
            $(".e_check_half_day").attr('disabled', false);
            $(".e_half_clear_checkbox").attr('disabled', false);
            axios.post('{{ URL('holidays/search') }}', {
                "from_date": $(this).val(),
                "to_date": $('#e_end_date').val()
            }).then(function(response) {
                let holiday = response.data.datas;
                let nextWorkigDay = 0;
                if (holiday != '') {
                    $.each(holiday, function(i, holi) {
                        nextWorkigDay += countWeekdays(holi.from,  holi.to);
                    });
                }
                total_day = weekdayCount - nextWorkigDay;
                total_current_number_day = total_day;
                $("#e_number_of_day").val(total_day);
            });
        });

        // function end date
        $("#e_end_date").on("dp.change", function(e) {
            let startDate = $('#e_start_date').data('DateTimePicker').date();
            let endDate = e.date;
            if (startDate > endDate) {
                $('#e_end_date').data('DateTimePicker').date(startDate);
            }
            let startDates = new Date($("#e_start_date").val());
            let endDates = new Date($(this).val()); 
            let weekdayCount = countWeekdays(startDates,  endDates);
            $(".e_half_clear_checkbox").val("");
            $(".e_half_clear_checkbox").prop('checked', false);
            $(".e_check_half_day").prop('checked', false);
            $(".e_half_start_end_day").css("display","none");
            $(".e_half_day").css("display","none");
            $(".e_check_half_day").attr('disabled', false);
            $(".e_half_clear_checkbox").attr('disabled', false);
            axios.post('{{ URL('holidays/search') }}', {
                "from_date": $("#e_start_date").val(),
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
                total_current_number_day = total_day;
                $("#e_number_of_day").val(total_day);
            });
        });
        
        $(".e_check_half_day").on("click", function() {
           if (document.getElementsByClassName('e_check_half_day')[0].checked == true) {
                if ($("#e_end_date").val() > $("#e_start_date").val()) {
                    $(".e_half_start_end_day").css("display","block");
                }else if ($("#e_end_date").val() == $("#e_start_date").val()) {
                    $(".e_half_day").css("display","block");
                }
            } else {
                $(".e_half_clear_checkbox").val("");
                $(".e_half_clear_checkbox").prop('checked', false);

                $(".e_half_day").css("display","none");
                $(".e_half_start_end_day").css("display","none");
            }
            $("#e_number_of_day").val(total_current_number_day);
        });

        $(".e_half_day_checkbox_am").on("click", function() {
            let numberDay = 0;
            if (document.getElementsByClassName('e_half_day_checkbox_am')[0].checked == true) {
                $(".e_half_day_checkbox_am").val("pm");
                numberDay = total_current_number_day ? (total_current_number_day -0.5) : (total_day - 0.5);
                $("#e_number_of_day").val(numberDay);
            }else{
                $(".e_half_day_checkbox_am").val("");
                numberDay = total_current_number_day ? total_current_number_day : total_day;
                $("#e_number_of_day").val(numberDay);
            }
            $(".e_half_day_checkbox_pm").prop('checked', false);
            $(".e_half_day_checkbox_pm").val('');
        });

        $(".e_half_day_checkbox_pm").on("click", function() {
            let numberDay = 0;
            if (document.getElementsByClassName('e_half_day_checkbox_pm')[0].checked == true) {
                $(".e_half_day_checkbox_pm").val("pm");
                numberDay = total_current_number_day ? (total_current_number_day -0.5) : (total_day - 0.5);
                $("#e_number_of_day").val(numberDay);
            }else{
                $(".e_half_day_checkbox_pm").val("");
                numberDay = total_current_number_day ? total_current_number_day : total_day;
                $("#e_number_of_day").val(numberDay);
            }
            $(".e_half_day_checkbox_am").val('');
            $(".e_half_day_checkbox_am").prop('checked', false);
        });

        $(".e_half_start_day_checkbox_am").on("click", function() {
            if ($('.e_half_start_day_checkbox_am').is(':checked') == true) {
                $(".e_half_start_day_checkbox_am").val("am");
            } else {
                $(".e_half_start_day_checkbox_am").val("");
            }
            $(".e_half_start_day_checkbox_pm").val('');
            $(".e_half_start_day_checkbox_pm").prop('checked', false);
        });

        $(".e_half_start_day_checkbox_pm").on("click", function() {
            if ($('.e_half_start_day_checkbox_pm').is(':checked') == true) {
                $(".e_half_start_day_checkbox_pm").val("pm");
            } else {
                $(".e_half_start_day_checkbox_pm").val("");
            }
            $(".e_half_start_day_checkbox_am").val('');
            $(".e_half_start_day_checkbox_am").prop('checked', false);
        });

        $(".e_half_end_day_checkbox_am").on("click", function() {
            if ($('.e_half_end_day_checkbox_am').is(':checked') == true) {
                $(".e_half_end_day_checkbox_am").val("am");
            } else {
                $(".e_half_end_day_checkbox_am").val("");
            }
            $(".e_half_end_day_checkbox_pm").val('');
            $(".e_half_end_day_checkbox_pm").prop('checked', false);
        });

        $(".e_half_end_day_checkbox_pm").on("click", function() {
            if ($('.e_half_end_day_checkbox_pm').is(':checked') == true) {
                $(".e_half_end_day_checkbox_pm").val("pm");
            } else {
                $(".e_half_end_day_checkbox_pm").val("");
            }
            $(".e_half_end_day_checkbox_am").val('');
            $(".e_half_end_day_checkbox_am").prop('checked', false);
        });

        $(".e_isCheckboxx").on("click", function() {
            var countChecked = 0;
            $('.e_isCheckboxx[type=checkbox]').each(function () {
                if (this.checked) {
                    countChecked++;
                }
            });
            let numberDay = 0;
            if (countChecked == 2) {
                numberDay = total_current_number_day ? (total_current_number_day - 1) : (total_day - 1);
                $("#e_number_of_day").val(numberDay);
            }else if (countChecked == 1) {
                numberDay = total_current_number_day ? (total_current_number_day - 0.5) : (total_day - 0.5);
                $("#e_number_of_day").val(numberDay);
            }else{
                numberDay = total_current_number_day ? total_current_number_day : total_day;
                $("#e_number_of_day").val(numberDay);
            }
        });
        
        $(".btn-e-apply").on("click", function() {
            var num_miss = 0;
            $(".e_leave_required").each(function(){
                if($(this).val()==""){ 
                    num_miss++;
                }
            });
            if (num_miss>0 || $("#e_number_of_day").val() == 0) {
                let text_mesange = "";
                if (num_miss>0) {
                    text_mesange ="Please check input required";
                }else{
                    let totalChecked = $('.e_isCheckboxx').filter(':checked').length;
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
                if ($('.e_half_day_checkbox_am').is(':checked') == true) {
                    start_half_day = "am";
                }else if ($('.e_half_day_checkbox_pm').is(':checked') == true) {
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
                    url: "{{url('leaves/employee/update')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id":  $("#e_id_leave").val(),
                        "leave_type_id": $("#e_leave_type_id").val(),
                        "start_date": $("#e_start_date").val(),
                        "end_date": $("#e_end_date").val(),
                        "start_half_day": start_half_day,
                        "end_half_day": end_half_day,
                        "number_of_day": $("#e_number_of_day").val(),
                        "handover_staff_id": $("#e_handover_staff_id").val(),
                        "reason": $("#e_reason").val(),
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
                        return false;
                    }
                });
            }
        });
    });
</script>