$(document).ready(function() {
    $('#loading-overlay').show();
    $("#import_new_cvs").on("click", function() {
        $(".thanLess").hide();
        $("#thanLess").text("");
        $('#import_motor_cv').modal('show');
    });
    $(document).on('click','.upcomingDelete', function(){
        let id = $(this).data("id");
        $('.d_id').val(id);
    });
    $("#position_applied, #e_position_applied").on("change", function() {
        let position_type = $("#position_applied option:checked").attr('data-id');
        let e_position_type = $("#e_position_applied option:checked").attr('data-id');
        if (position_type == 1 || e_position_type == 1) {
            $('#position_type').find('option').each(function(){
                if ($(this).attr('data-id') == "Supporting Staff") {
                    $("#position_type").val($(this).val());
                }
            }); 
            $('#e_position_type').find('option').each(function(){
                if ($(this).attr('data-id') == "Supporting Staff") {
                    $("#e_position_type").val($(this).val());
                }
            }); 
        }else{
            $('#position_type').find('option').each(function(){
                if ($(this).attr('data-id') == "Field Staff") {
                    $("#position_type").val($(this).val());
                }
            });
            $('#e_position_type').find('option').each(function(){
                if ($(this).attr('data-id') == "Field Staff") {
                    $("#e_position_type").val($(this).val());
                }
            });
        }
    });
    $(document).on('click','.btn_approve', function(){
        let id = $(this).data("id");
        let id_card = $(this).attr("data-id-card");
        let description = Lang.are_you_sure_want_to_approve +'?';
        let text_label = "";
        let button_ok = {
            text: Lang.ok,
            btnClass: 'add-btn-status',
            action: function () {
                var jc = this;
                var okBtn  = this.buttons.button_ok; 
                var cancelBtn = this.buttons.cancel;
                okBtn.setText(Lang.loading+'...');

                okBtn.disable();
                cancelBtn.disable();

                var id = this.$content.find('.id').val();

                axios.post(appUrls.status, {
                    'id': id,
                    'status': "Upcoming",
                }).then(function(response) {

                    new Noty({
                        title: "",
                        text: Lang.the_process_has_been_successfully+'.',
                        type: "success",
                        timeout: 3000,
                        icon: true
                    }).show();

                    window.location.replace(appUrls.currentPage);

                    // okBtn.enable();    // Enable button
                    cancelBtn.enable();
                    okBtn.setText(Lang.ok);
                    jc.close();                    // Close popup

                }).catch(function(error) {

                    new Noty({
                        title: "",
                        text: Lang.something_went_wrong_please_try_again_later,
                        type: "error",
                        icon: true
                    }).show();

                    okBtn.enable();   // Enable on error
                    cancelBtn.enable();
                    okBtn.setText(Lang.ok);
                });
                return false;
            }
        };

        if (id_card == "false") {
            text_label = '<label>'+Lang.you_cannot_aprove+'.</label>';
            description = Lang.please_enter_all_requried_information;
            button_ok = "";
        }

        $.confirm({
            icon: 'fa fa-warning',
            title: Lang.approve,
            titleClass: 'text-center',
            type: 'blue',
            content: '' +
            '<form action="" class="formName">' +
                '<div class="form-group" style="text-align: center">' +
                    (text_label)+
                    '<label>'+ (description) +'</label>' +
                    '<input type="hidden" class="form-control id" value="'+id+'">'+
                '</div>' +
            '</form>',
            onOpenBefore: function () {
                $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
            },
            buttons: {
                button_ok,
                cancel: {
                    text: Lang.cancel,
                    btnClass: 'btn-secondary btn-sm',
                },
            },
            onContentReady: function () {
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });
    });

    $(document).on('click','.btn_cancel', function(){
        let id = $(this).data("id");
        $.confirm({
            title: Lang.cancel,
            icon: 'fa fa-warning',
            titleClass: 'text-center',
            type: 'red',
            typeAnimated: true,
            content: '' +
            '<form action="" class="formName">' +
                '<div class="form-group" style="text-align: center">' +
                    '<label>'+Lang.are_you_sure_want_to_cancel+'?</label>' +
                    '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                '</div>' +
            '</form>',
            onOpenBefore: function () {
                $(".jconfirm-buttons").addClass("jconfirm-buttons-center");
            },
            buttons: {
                formSubmit: {
                    text: Lang.ok,
                    btnClass: 'add-btn-status',
                    action: function () {
                        var id = this.$content.find('.id').val();
                        axios.post(appUrls.status, {
                            'id': id,
                            'status': "Cancel",
                        }).then(function(response) {
                            new Noty({
                                title: "",
                                text: Lang.the_process_has_been_successfully,
                                type: "success",
                                timeout: 3000,
                                icon: true
                            }).show();
                            window.location.replace(appUrls.currentPage);
                        }).catch(function(error) {
                            new Noty({
                                title: "",
                                text: Lang.something_went_wrong_please_try_again_later,
                                type: "error",
                                icon: true
                            }).show();
                        });
                    }
                },
                cancel: {
                    text: Lang.cancel,
                    btnClass: 'btn-secondary btn-sm',
                },
            },
            onContentReady: function () {
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });
    });
    $(document).on('click','.delete', function() {
        let id = $(this).data('id');
        $('.e_id').val(id);
    });
    $(document).on('click','.update', function(){
        var localeLanguage = '{{ config("app.locale") }}';
        let id = $(this).data("id");
        $("#e_id").val(id);
        $.ajax({
            type: "GET",
            url: appUrls.getdata,
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    if (response.position != '') {
                        $('#e_position_applied').html('');
                        $.each(response.position, function(i, item) {
                            $('#e_position_applied').append($('<option>', {
                                "data-id" : item.position_type_number,
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.position_applied
                            }));
                        });
                    }
                    if (response.branch != '') {
                        $('#e_location_applied').html('');
                        $.each(response.branch, function(i, item) {
                            $('#e_location_applied').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.branch_name_en : item.branch_name_kh,
                                selected: item.id == response.success.location_applied
                            }));
                        });
                    }
                    if (response.optionPositionType != '') {
                    $.each(response.optionPositionType, function(i, item) {
                        $('#e_position_type').append($('<option>', {
                            "data-id" : item.name_english,
                            value: item.id,
                            text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                            selected: item.id == response.success.position_type
                        }));
                    });
                }
                    if (response.gender != '') {
                        $('#e_gender').html('');
                        $.each(response.gender, function(i, item) {
                            $('#e_gender').append($('<option>', {
                                value: item.id,
                                text: localeLanguage == 'en' ? item.name_english : item.name_khmer,
                                selected: item.id == response.success.gender
                            }));
                        });
                    }
                    $('#e_last_name_kh').val(response.success.last_name_kh);
                    $('#e_first_name_kh').val(response.success.first_name_kh);
                    $('#e_last_name_en').val(response.success.last_name_en);
                    $('#e_first_name_en').val(response.success.first_name_en);
                    $('#e_current_position').val(response.success.current_position);
                    $('#e_companey_name').val(response.success.companey_name);
                    $('#e_current_address').val(response.success.current_address);
                    $('#e_received_date').val(response.success.received_date);
                    $('#e_recruitment_channel').val(response.success.recruitment_channel);
                    $('#e_contact_number').val(response.success.contact_number);
                    $('#hidden_cv').val(response.success.cv);
                    // $('#e_remark').val(response.success.remark);
                    $('#status').val(response.success.status);
                }
                $('#edit_staff').modal('show');
            }
        });
    });
        
    $(document).on('click', 'body #btn-status a', function() {
        let id = $(this).attr('data-emp-id');
        let status = $(this).data('id');
        let nonShort = $(this).data('id-short');
        if(status==2){
            $.confirm({
                title: Lang.candidate_resume_status+'!',
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                    '<form class="needs-validation" novalidate>'+
                        '<div class="form-group">'+
                            '<label><a href="#">'+Lang.shortlisted+'</a></label>'+
                        '</div>'+
                        '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                        '<div class="form-group">'+
                            '<label>'+Lang.shortlist+'</label>'+
                            '<select class="form-control form-select showtList" name="short_list">'+
                                '<option selected value="1"> '+Lang.yes+'</option>'+
                                '<option value="2"> '+Lang.no+'</option>'+
                                '<option value="7"> '+Lang.black_list+'</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="form-group interviewed_date">'+
                            '<label>'+Lang.interviewed_date+' <span class="text-danger">*</span></label>'+
                            '<input type="datetime-local" class="form-control interviewed_dates">'+
                        '</div>'+
                        '<div class="form-group interview_channel">'+
                            '<label>'+Lang.interviewed_channel+'</label>'+
                            '<select class="form-control form-select interviewed_channel">'+
                                '<option selected value="Online"> Online</option>'+
                                '<option value="Face to face"> '+Lang.face_to_face+'</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="form-group committee_interviewed">'+
                            '<label>'+Lang.interview_committee+' <span class="text-danger">*</span></label>'+
                            '<select class="form-control hr-select2-option-emp form-select committee_interview" id="committeeinterview" name="states[]" multiple >'+
                                
                            '</select>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>'+Lang.remark+'</label>'+
                            '<textarea type="text" rows="3" class="form-control remark"></textarea>'+
                        '</div>'+
                    '</form>',
                onOpen: function(){
                        this.$content.find('.showtList').change(function(){
                            let value = $('.showtList').val();
                            if (value == "2" || value == "7") {
                                $(".interviewed_date").hide();
                                $(".interview_channel").hide();
                                $(".committee_interviewed").hide();
                            }else{
                                $(".interviewed_date").show();
                                $(".interview_channel").show();
                                $(".committee_interviewed").show();
                            }
                        });
                    },
                buttons: {
                    confirm: {
                        text: Lang.submit,
                        btnClass: 'add-btn-status',
                        action: function() {
                            var c_status = this.$content.find('.status').val();
                            var short_list = this.$content.find('.showtList').val();
                            var interviewed_date = this.$content.find('.interviewed_dates').val();
                            var interviewed_channel = this.$content.find('.interviewed_channel').val();
                            var committee_interview = this.$content.find('.committee_interview').val();
                            var id = this.$content.find('.id').val();
                            var remark = this.$content.find('.remark').val();
                            if (short_list == "1") {
                                if ($(".interviewed_dates").val() ==""){
                                    $(".interviewed_dates").css("border","solid 1px red");
                                    return false;
                                }
                                if (!committee_interview.length){
                                    $(".committee_interviewed").each(function(){
                                        let formGroup = $(this);
                                        let value = formGroup.attr("data-select2-id");
                                        let requeredField = formGroup.find(".hr-select2-option").val();
                                        if(!value){ 
                                            formGroup.find(".select2-selection").css("border-color","#dc3545");
                                        }else if (!requeredField) {
                                            formGroup.find(".select2-selection").css("border-color","#dc3545");
                                        }
                                    });
                                    return false;
                                }
                            }
                            if (short_list == "7") {
                                $.confirm({
                                    title: Lang.candidate_resume_status+'!',
                                    content: 'Are you sure you want to change to <span class="text-danger">'+Lang.black_list+'</span>?',
                                    icon: 'fa fa-warning',
                                    animation: 'scale',
                                    closeAnimation: 'zoom',
                                    buttons: {
                                        confirm: {
                                            text: 'Yes, sure!',
                                            btnClass: 'add-btn-status',
                                            action: function(){
                                                axios.post(appUrls.status, {
                                                        'id': id,
                                                        'status': c_status,
                                                        'short_list': short_list,
                                                        'interviewed_date': interviewed_date,
                                                        'interviewed_channel': interviewed_channel,
                                                        'committee_interview': committee_interview.toString(),
                                                        'remark': remark,
                                                    }).then(function(response) {
                                                        new Noty({
                                                            title: "",
                                                            text: Lang.the_process_has_been_successfully,
                                                            type: "success",
                                                            timeout: 3000,
                                                            icon: true
                                                        }).show();
                                                        window.location.replace(appUrls.currentPage);
                                                }).catch(function(error) {
                                                    new Noty({
                                                        title: "",
                                                        text: Lang.something_went_wrong_please_try_again_later,
                                                        type: "error",
                                                        icon: true
                                                    }).show();
                                                });
                                            }
                                        },
                                        cancel: function(){}
                                    }
                                });
                            }else{
                                axios.post(appUrls.status, {
                                        'id': id,
                                        'status': c_status,
                                        'short_list': short_list,
                                        'interviewed_date': interviewed_date,
                                        'interviewed_channel': interviewed_channel,
                                        'committee_interview': committee_interview.toString(),
                                        'remark': remark,
                                    }).then(function(response) {
                                        new Noty({
                                            title: "",
                                            text: Lang.the_process_has_been_successfully,
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                        window.location.replace(appUrls.currentPage);
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: Lang.something_went_wrong_please_try_again_later,
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        }
                    },
                    cancel: {
                        text: Lang.cancel,
                        btnClass: 'btn-secondary btn-sm',
                    },
                }
            }); 
            $(document).ready(function(){
                $('.hr-select2-option-emp').each(function() {
                    $(this).select2({
                        width: '100%',
                        dropdownParent: $(this).parent(),
                    })
                });
                axios.get(window.appUrls.employee).then(function(response) {
                    if (response.data.employees != '') {
                        $('#committeeinterview').html('');
                        $.each(response.data.employees, function(i, item) {
                            $('#committeeinterview').append($('<option>', {
                                value: item.employee_name_en,
                                text: item.employee_name_en,
                                // selected: item.id == response.success.location_applied
                            }));
                        });
                    }
                })
            });
        }else if(status == 3 || status == 6){
            let data_status = $(this).attr('data-status');
            let select_joined_interview  = ""; 
            if (data_status == 3 ) {
                select_joined_interview = '<select class="form-control form-select joined_interview" >'+
                    '<option selected value="1"> '+Lang.yes+'</option>'+
                '</select>';
            }else{
                select_joined_interview = '<select class="form-control form-select joined_interview" >'+
                    '<option selected value="1"> '+Lang.yes+'</option>'+
                    '<option value="2"> '+Lang.no+'</option>'+
                    '<option value="3"> '+Lang.delay+'</option>'+
                '</select>';
            }
            $.confirm({
                title: Lang.candidate_resume_status+'!',
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                    '<form class="needs-validation" novalidate>'+
                        '<div class="form-group">'+
                            '<label><a href="#">'+Lang.interviewed+'</a></label>'+
                        '</div>'+
                        '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                        '<div class="form-group">'+
                            '<label>'+Lang.joined_interview+'</label>'+
                            select_joined_interview+
                        '</div>'+
                        '<div class="form-group interviewed_date" style="display: none">'+
                            '<label>'+Lang.interviewed_date+' <span class="text-danger">*</span></label>'+
                            '<input type="datetime-local" class="form-control interviewed_dates">'+
                        '</div>'+
                        '<div class="form-group interviewed_results">'+
                            '<label>'+Lang.interviewed_result+'</label>'+
                            '<select class="form-control form-select interviewed_result" >'+
                                '<option selected value="1"> '+Lang.passed+'</option>'+
                                '<option value="2">'+Lang.failed+'</option>'+
                                '<option value="3">'+Lang.waiting+'</option>'+
                                '<option value="4">'+Lang.pending+'</option>'+
                                '<option value="5">'+Lang.high_exected_salary+'</option>'+
                                '<option value="6">'+Lang.rejected_offered+'</option>'+
                                '<option value="7">'+Lang.black_list+'</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="form-group interviewed_results_non" style="display:none">'+
                            '<label>'+Lang.interviewed_result+'</label>'+
                            '<select class="form-control form-select non_interviewed_result" >'+
                                '<option selected value="8"> '+Lang.non_black_list+'</option>'+
                                '<option value="7">'+Lang.black_list+'</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>'+Lang.remark+'</label>'+
                            '<textarea type="text" rows="3" class="form-control remark"></textarea>'+
                        '</div>'+
                    '</form>',
                onOpen: function(){
                        this.$content.find('.joined_interview').change(function(){
                            let value = $('.joined_interview').val();
                            if (value == "2") {
                                $(".interviewed_results").hide();
                                $(".interviewed_results_non").show();
                                $(".interviewed_date").hide();
                                $(".interviewed_dates").val("");
                            }else if(value == 3){
                                $(".interviewed_date").show();
                                $(".interviewed_results").hide();
                                $(".interviewed_results_non").hide();
                            }else{
                                $(".interviewed_results_non").hide();
                                $(".interviewed_results").show();
                                $(".interviewed_date").hide();
                                $(".interviewed_dates").val("");
                                $('.status').val(3)
                            }
                        });
                    },
                buttons: {
                    confirm: {
                        text: Lang.submit,
                        btnClass: 'add-btn-status',
                        action: function() {
                            var status = this.$content.find('.status').val();
                            var joined_interview = this.$content.find('.joined_interview').val();
                            var interviewed_result = "";
                            var id = this.$content.find('.id').val();
                            var interviewed_dates = this.$content.find('.interviewed_dates').val();
                            var remark = this.$content.find('.remark').val();
                            if (joined_interview == "1") {
                                if ($(".interviewed_result").val() ==""){
                                    $(".interviewed_result").css("border","solid 1px red");
                                    return false;
                                }
                                interviewed_result = this.$content.find('.interviewed_result').val();
                            }else if(joined_interview == "2"){
                                if ($(".non_interviewed_result").val() ==""){
                                    $(".non_interviewed_result").css("border","solid 1px red");
                                    return false;
                                }
                                interviewed_result = this.$content.find('.non_interviewed_result').val();
                            }else if (joined_interview == 3) {
                                if ($(".interviewed_dates").val() ==""){
                                    $(".interviewed_dates").css("border","solid 1px red");
                                    return false;
                                }
                            };
                            if (interviewed_result == "7" || interviewed_result == "8") {
                                let content_text = 'Are you sure you want to change to <span class="text-danger">'+Lang.black_list+'</span>?';
                                if (interviewed_result == "8") {
                                    content_text = 'Are you sure you want to change to <span class="text-danger">'+Lang.non_black_list+'</span>?';
                                }
                                $.confirm({
                                    title: Lang.candidate_resume_status+'!',
                                    content: content_text,
                                    icon: 'fa fa-warning',
                                    animation: 'scale',
                                    closeAnimation: 'zoom',
                                    buttons: {
                                        confirm: {
                                            text: 'Yes, sure!',
                                            btnClass: 'add-btn-status',
                                            action: function(){
                                                    axios.post(appUrls.status, {
                                                        'id': id,
                                                        'status': status,
                                                        'joined_interview': joined_interview,
                                                        'interviewed_result': interviewed_result,
                                                        'interviewed_date': interviewed_dates,
                                                        'remark': remark,
                                                    }).then(function(response) {
                                                        new Noty({
                                                            title: "",
                                                            text: Lang.the_process_has_been_successfully,
                                                            type: "success",
                                                            timeout: 3000,
                                                            icon: true
                                                        }).show();
                                                        window.location.replace(appUrls.currentPage);
                                                }).catch(function(error) {
                                                    new Noty({
                                                        title: "",
                                                        text: Lang.something_went_wrong_please_try_again_later,
                                                        type: "error",
                                                        icon: true
                                                    }).show();
                                                });
                                            }
                                        },
                                        cancel: function(){}
                                    }
                                });
                            }else{
                                axios.post(appUrls.status, {
                                        'id': id,
                                        'status': status,
                                        'joined_interview': joined_interview,
                                        'interviewed_result': interviewed_result,
                                        'interviewed_date': interviewed_dates,
                                        'remark': remark,
                                    }).then(function(response) {
                                        new Noty({
                                            title: "",
                                            text: Lang.the_process_has_been_successfully,
                                            type: "success",
                                            timeout: 3000,
                                            icon: true
                                        }).show();
                                        window.location.replace(appUrls.currentPage);
                                }).catch(function(error) {
                                    new Noty({
                                        title: "",
                                        text: Lang.something_went_wrong_please_try_again_later,
                                        type: "error",
                                        icon: true
                                    }).show();
                                });
                            }
                        }
                    },
                    cancel: {
                        text: Lang.cancel,
                        btnClass: 'btn-secondary btn-sm',
                    },
                }
            }); 
        }else if(status == 4) {
            $.confirm({
                title: Lang.candidate_resume_status+'!',
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                    '<form class="needs-validation" novalidate>'+
                        '<div class="form-group">'+
                            '<label><a href="#">'+Lang.signed_contract+'</a></label>'+
                        '</div>'+
                        '<input type="hidden" class="form-control status" id="" name="" value="'+status+'">'+
                        '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                        '<div class="form-group">'+
                            '<label>'+Lang.signed_contract_date+' <span class="text-danger">*</span></label>'+
                            '<input type="date" class="form-control contract_date" value="">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>'+Lang.join_date+' <span class="text-danger">*</span></label>'+
                            '<input type="date" class="form-control join_date" value="">'+
                        '</div>'+
                    '</form>',
                buttons: {
                    confirm: {
                        text: Lang.submit,
                        btnClass: 'add-btn-status',
                        action: function() {
                            var status = this.$content.find('.status').val();
                            var contract_date = this.$content.find('.contract_date').val();
                            var join_date = this.$content.find('.join_date').val();
                            var id = this.$content.find('.id').val();
                            if (status == "4") {
                                if ($(".contract_date").val() ==""){
                                    $(".contract_date").css("border","solid 1px red");
                                    return false;
                                }
                                if ($(".join_date").val() ==""){
                                    $(".join_date").css("border","solid 1px red");
                                    return false;
                                }
                                
                            }
                            axios.post(appUrls.status, {
                                    'id': id,
                                    'status': status,
                                    'contract_date': contract_date,
                                    'join_date': join_date,
                                }).then(function(response) {
                                    new Noty({
                                        title: "",
                                        text: Lang.the_process_has_been_successfully,
                                        type: "success",
                                        timeout: 3000,
                                        icon: true
                                    }).show();
                                    window.location.replace(appUrls.currentPage);
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: Lang.something_went_wrong_please_try_again_later,
                                    type: "error",
                                    icon: true
                                }).show();
                            });
                        },
                    },
                    cancel: {
                        text: Lang.cancel,
                        btnClass: 'btn-secondary btn-sm',
                    },
                },
                onContentReady: function () {
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click');
                    });
                }
            }); 
        }
    });
        
    $('body').on('click', '#btn-emp-status a', function() {
        let id = $(this).attr('data-emp-id');
        let status = $(this).data('id');
        var emp_status = status;
        let join_date = $(this).attr('data-join-date');
        let start_date = $(this).attr('data-start-date');
        let end_date = $(this).attr('data-end-date');
        if (status == "Probation") {
            $.confirm({
                title: Lang.employee_status,
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                    '<form method="post">'+
                        '<div class="form-group">'+
                            '<label><a href="#">'+emp_status+'</a></label>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<div class="form-group">'+
                                '<label>'+Lang.join_date+' <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control start_date" value="'+join_date+'" disabled>'+
                                '<input type="hidden" class="form-control emp_status" value="'+status+'">'+
                                '<input type="hidden" class="form-control id" value="'+id+'">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>'+Lang.pass_date+' <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control end_dete" value="'+start_date+'" disabled>'+
                            '</div>'+
                            '<label>'+Lang.reason+'</label>'+
                            '<textarea class="form-control resign_reason"></textarea>'+
                        '</div>'+
                    '</form>',
                buttons: {
                    confirm: {
                        text: 'Submit',
                        btnClass: 'add-btn-status',
                        action: function() {
                            var emp_status = this.$content.find('.emp_status').val();
                            var id = this.$content.find('.id').val();
                            var resign_reason = this.$content.find('.resign_reason').val();
                            axios.post(appUrls.status, {
                                    'id': id,
                                    'emp_status': emp_status,
                                    'resign_reason': resign_reason
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: Lang.the_process_has_been_successfully,
                                    type: "success",
                                    timeout: 3000,
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace(appUrls.currentPage);
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: Lang.something_went_wrong_please_try_again_later,
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
                }
            });
        }else{
            emp_status = Lang.cancel_signed_contract;
            $.confirm({
                title: Lang.employee_status,
                contentClass: 'text-center',
                // backgroundDismiss: 'cancel',
                content: ''+
                    '<form method="post">'+
                        '<div class="form-group">'+
                            '<label><a href="#">'+emp_status+'</a></label>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<div class="form-group">'+
                                '<label>'+Lang.date+' <span class="text-danger">*</span></label>'+
                                '<input type="date" class="form-control resign_date">'+
                                '<input type="hidden" class="form-control emp_status" id="" name="" value="'+status+'">'+
                                '<input type="hidden" class="form-control id" id="" name="" value="'+id+'">'+
                            '</div>'+
                            '<div class="form-group assign_line_manager" style="display:none">'+
                                '<label>'+Lang.assign_new_line_manager+'</label>'+
                                '<select class="form-control hr-select2-option-emp form-select line_manager" id="line_manager" name="line_manager" >'+
                                
                                '</select>'+
                            '</div>'+
                            '<label>'+Lang.reason+'</label>'+
                            '<textarea class="form-control resign_reason"></textarea>'+
                        '</div>'+
                    '</form>',
                buttons: {
                    confirm: {
                        text: 'Submit',
                        btnClass: 'add-btn-status',
                        action: function() {
                            var emp_status = this.$content.find('.emp_status').val();
                            var id = this.$content.find('.id').val();
                            var resign_date = this.$content.find('.resign_date').val();
                            var resign_reason = this.$content.find('.resign_reason').val();
                            var line_manager = this.$content.find('.line_manager').val();

                            if (!resign_date) {
                                $.alert({
                                    title: '<span class="text-danger">'+Lang.requiered+'</span>',
                                    content: 'Please input date.',
                                });
                                return false;
                            }
                            
                            axios.post(appUrls.status, {
                                    'id': id,
                                    'emp_status': emp_status,
                                    'resign_date': resign_date,
                                    'resign_reason': resign_reason,
                                    'line_manager': line_manager
                                }).then(function(response) {
                                new Noty({
                                    title: "",
                                    text: Lang.the_process_has_been_successfully,
                                    type: "success",
                                    timeout: 3000,
                                    icon: true
                                }).show();
                                $('.card-footer').remove();
                                window.location.replace(appUrls.currentPage);
                            }).catch(function(error) {
                                new Noty({
                                    title: "",
                                    text: Lang.something_went_wrong_please_try_again_later,
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
        }
    }); 
});