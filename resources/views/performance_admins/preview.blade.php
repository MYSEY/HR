@extends('layouts.master')
<style>
    .container-checkbox {
        /* display: block; */
        position: relative;
        padding-left: 25px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 1;
        left: 0;
        height: 20px;
        width: 20px;
        border: solid 1px #ccc;
        background-color: #fff;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 7px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.performance_review')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.performance_review')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('users/create') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <img src="{{ asset('/admin/img/logo/commalogo1.png') }}" class="inv-logo" alt="">
                    </div>
                    <div class="col-md-4">
                        <h4 class="payslip-title">ទម្រង់វាយតម្លៃការងាររបស់បុគ្គលិកសាកល្បង</h4>
                        <h5 class="payslip-title">ប្រចាំឆ្នាំ៖ {{ \App\Helpers\Helper::toKhmerNumber(\Carbon\Carbon::parse($data->to_date)->format('Y')) }}</h5>
                    </div>
                </div>
                <div class="row" style="text-align: center;justify-content: center;justify-items: center;">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>(ពីថ្ងៃខែឆ្នាំ៖ {{$data->from_date}}</strong></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>ដល់ថ្ងៃខែឆ្នាំ៖ {{$data->to_date}})</strong></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.employee_id')</label>
                            <input type="text" class="form-control" value="{{$data->number_employee}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.employee_name')</label>
                            <input type="text" class="form-control" value="{{$data->employee_name_kh}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.location')</label>
                            <input type="text" class="form-control" value="{{$data->branch_name_en}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('lang.department')</label>
                            <input type="text" class="form-control" value="{{$data->dep_name}}">
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 450px;">(KPI)</th>
                                        <th style="min-width: 500px;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
                                        <th style="min-width: 250px;">គោលដៅ (Goal)</th>
                                        <th>ទម្ងន់ (Weight %) <span id="total_weight"></span></th>
                                        <th style="min-width: 500px;">Comments</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_performance">
                                    @php
                                        $total_weight = 0;
                                    @endphp
                                    @foreach ($data->titles as $item)
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <input type="text" style="background: #efa781" class="form-control" value="{{ $item->title ?? '' }}" required>
                                            </td>
                                        </tr>

                                        @foreach ($item->purposes as $purposeItem)
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <input type="text" style="background: #f0cc9b" class="form-control" value="{{ $purposeItem->name ?? '' }}" required>
                                                </td>
                                            </tr>

                                            @foreach ($purposeItem->performanceDetail as $Detailitem)
                                                @php
                                                    $total_weight += $Detailitem->weight;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        <textarea rows="7" class="form-control" placeholder="Enter text here" required>{{$Detailitem->key_kpi}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="7" class="form-control" placeholder="Enter text here" required>{{$Detailitem->action_plan}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <select class="form-control goal-type-select mt-1" name="goal_type[]" {{ $Detailitem->is_lock == 1 ? 'disabled' : '' }}>
                                                            <option value="number_increment" {{ $Detailitem->goal_type == 'number_increment' ? 'selected' : '' }}>Number Increment</option>
                                                            <option value="number_decrement" {{ $Detailitem->goal_type == 'number_decrement' ? 'selected' : '' }}>Number Decrement</option>

                                                            <option value="percent_increment" {{ $Detailitem->goal_type == 'percent_increment' ? 'selected' : '' }}>Percent Increment</option>
                                                            <option value="percent_decrement" {{ $Detailitem->goal_type == 'percent_decrement' ? 'selected' : '' }}>Percent Decrement</option>

                                                            <option value="currency_increment" {{ $Detailitem->goal_type == 'currency_increment' ? 'selected' : '' }}>Currency Increment</option>
                                                            <option value="currency_decrement" {{ $Detailitem->goal_type == 'currency_decrement' ? 'selected' : '' }}>Currency Decrement</option>

                                                            <option value="date_increment" {{ $Detailitem->goal_type == 'date_increment' ? 'selected' : '' }}>Date Increment</option>
                                                            <option value="date_decrement" {{ $Detailitem->goal_type == 'date_decrement' ? 'selected' : '' }}>Date Decrement</option>
                                                        </select>

                                                        @foreach ($Detailitem->performanceGoals as $item)
                                                            <div class="goal-input-wrapper mt-1">
                                                                <div class="row mb-1">
                                                                    <div class="group d-flex align-items-center">
                                                                        <div class="col-md-5">
                                                                            <input type="text" step="any" class="form-control weight-from required" name="goal_from[]" placeholder="From" value="{{ $item->from }}" style="height: 35px;width: 100px;">
                                                                        </div>
                                                                        <div class="col-md-2 text-center">To</div>
                                                                        <div class="col-md-5">
                                                                            <input type="text" step="any" class="form-control weight-to required" name="goal_to[]" placeholder="To" value="{{ $item->to }}" style="height: 35px;width: 100px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" step="any" class="form-control weight" placeholder="%" min="0" value="{{$Detailitem->weight}}" id="weight" readonly>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="6" class="form-control" name="comment[]" placeholder="Enter text comment here" spellcheck="false"
                                                            >{{ $Detailitem->comment }}
                                                        </textarea>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    <input type="number" class="preview_total_weight" hidden value="{{$total_weight}}">
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <textarea rows="6" class="form-control" name="main_comment" id="main_comment" placeholder="Enter text comment here" spellcheck="false">{{$data->main_comment}}</textarea>
                                        </td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="submit-section mb-2">
                    @if ($permission)
                        @if (Auth::user()->id == $data->review_employee_id || $permission->is_access == 1 && ($data->status !="preparing" && $data->status != "approved"))
                            <a class="btn @if ($data->status == 4) btn-success @else btn-danger @endif btn-asign"
                                data-id="{{$data->id}}"
                                data-status="{{$data->status}}"
                                data-name="{{$data->review_employee_name_en}}"
                                data-employeeid="{{$data->employee_id}}"
                                href="#" aria-expanded="false">
                                    @if ($data->status == 4)
                                        <span>@lang('lang.approved')</span>
                                    @else
                                        <span>@lang('lang.asign_to')</span>
                                    @endif
                            </a>
                        @else
                            <a class="btn btn-danger" href="#">
                                <span>You can't asign</span>
                            </a>
                        @endif
                    @endif
                    @if ($url && $url == 1)
                        <a href="{{url('performance-admin/histories')}}/{{$data->performance_id}}/{{$urlpage}}" class="btn btn-secondary btn-cancel">@lang('lang.back')</a>
                    @else
                        <a href="{{ url($url)}}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#total_weight").text($(".preview_total_weight").val());
        document.querySelectorAll('.score_achieved').forEach(input => {
            input.addEventListener('input', function () {
                let val = parseFloat(this.value);
                if (val > 5) this.value = 5;
                if (val < 0) this.value = 0;
            });
        });
        // Trigger sum calculation when any score_achieved is changed
        $(document).on('input', '.score_achieved', function () {
            let $row = $(this).closest('tr');
            let weight = parseFloat($row.find('.weight').val()) || 0;
            let achieved = parseFloat($(this).val()) || 0;

            // Calculate and update scores
            let score = (weight * achieved) / 100;
            $row.find('.score').val(score.toFixed(2));
            $row.find('.personnel_score').val(score.toFixed(2));
            $row.find('.direct_chairman').val(score.toFixed(2));

            // Recalculate subtotals
            calculateSubtotals();
            calculateGrandTotals();
        });
        $(function(){
            $(document).on('click','.checkbox-group', function(){
                $(".checkbox-group").not(this).prop("checked", false);
            });
            $('.btn-asign').on('click', function() {
                var pa_id = $(this).data("id");
                var employee_old = $(this).data("name");
                var get_employee_id = $(this).data("employeeid");
                var status = $(this).data("status");
                var actionBtn = "";
                var titleText = "";
                var formContent = "";
                var columnClassText = 'col-md-4';
                if (status == 1 || status == 2 || status == 3 || status == "preparing" || status == 5) {
                    titleText = '@lang("lang.asign_to_employee")';
                    columnClassText = 'col-md-6'
                    formContent = ''+
                        '<form id="add-style" style="height: 25em;">'+
                            '<span class="text-danger">Old employee review: </span><span>'+employee_old+'</span><br>'+
                            '<div class="mt-2">'+
                                '<label class="container-checkbox">Review'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="1"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Accepted'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="2"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Verify'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="3"> <span class="checkmark"></span>'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="container-checkbox">Approve'+
                                    '<input type="checkbox" class="checkbox-group action-asign" name="selected_item" value="4"> <span class="checkmark"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>@lang("lang.employee")</label>'+
                                '<select class="form-control hr-select2-option-emp-role form-select asign_employee_id" id="asign_employee_id">'+

                                '</select>'+
                            '</div>'+
                            '<div class="form-group">' +
                                '<label>@lang("lang.remark")</label>' +
                                '<textarea class="form-control remark" rows="4" placeholder="Enter remark..."></textarea>' +
                            '</div>' +
                        '</form>';
                    actionBtn = {
                        text: 'Submit',
                        btnClass: 'btn-green',
                        action: function() {
                            this.$content.find('.remark').css("border-color","#e3e3e3");
                            var asign_employee_id = this.$content.find('.asign_employee_id').val();
                            let actionAsign = this.$content.find('.action-asign:checked').val();
                            let remark = this.$content.find('.remark').val();
                            if (!actionAsign) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Check action for asign!',
                                });
                                return false;
                            }
                            if (!asign_employee_id) {
                                $.alert({
                                    title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                    content: 'Please select employee for asign!',
                                });
                                return false;
                            }
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL('performance-admin/asign') }}', {
                                'id': pa_id,
                                'actionAsign': actionAsign,
                                'asign_employee_id': asign_employee_id,
                                'remark': remark,
                            }).then(function(response) {
                                $('#modal-loading').modal('hide');
                                if (response.data.success) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    window.location.replace("{{ URL('performance-admin') }}");
                                } else if(response.data.message == 'weight_must_be_exactly'){
                                    new Noty({
                                        title: "",
                                        text: 'Total weight must be exactly 100% before approval.',
                                        type: "error",
                                        icon: true,
                                        timeout: 3000,
                                    }).show();
                                }
                            }).catch(function(error) {
                                $('#modal-loading').modal('hide');
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                    type: "error",
                                    icon: true,
                                    timeout: 3000,
                                }).show();
                            });
                        }
                    }
                }
                if (status === 4) {
                    titleText = '@lang("lang.employee_pa")';
                    formContent = ''+
                        '<form>'+
                            '<span >Are you sure want to Approved or Return?</span>'+
                            '<div class="form-group">' +
                                '<label>@lang("lang.remark") <span class="text-danger">*</span></label>' +
                                '<textarea class="form-control remark" rows="4" placeholder="Enter remark..."></textarea>' +
                            '</div>' +
                        '</form>';
                    actionBtn =  {
                        text: 'Approve',
                        btnClass: 'btn-green',
                        action: function() {
                            let remark = this.$content.find('.remark').val();
                            $('#modal-loading').modal('show');
                            axios.post('{{ URL('performance-admin/approved') }}', {
                                'id': pa_id,
                                'actionAsign': "approved",
                                'remark': remark,
                            }).then(function(response) {
                                $('#modal-loading').modal('hide');
                                if (response.data.success) {
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.the_process_has_been_successfully")',
                                        type: "success",
                                        icon: true
                                    }).show();
                                    window.location.replace("{{ URL('performance-admin') }}");
                                } else if(response.data.message == 'weight_must_be_exactly'){
                                    new Noty({
                                        title: "",
                                        text: 'Total weight must be exactly 100% before approval.',
                                        type: "error",
                                        icon: true,
                                        timeout: 3000,
                                    }).show();
                                }
                            }).catch(function(error) {
                                $('#modal-loading').modal('hide');
                                new Noty({
                                    title: "",
                                    text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                    type: "error",
                                    icon: true,
                                    timeout: 3000,
                                }).show();
                            });
                        }
                    }
                }
                $.confirm({
                    title: titleText,
                    contentClass: 'text-center',
                    columnClass: columnClassText,
                    content: formContent,
                    buttons: {
                        confirm: actionBtn,
                        danger: {
                            text: 'Return',
                            btnClass: 'add-btn-status',
                            action: function() {
                                var asign_employee_id = this.$content.find('.asign_employee_id').val();
                                let remark = this.$content.find('.remark').val();
                                if (!remark) {
                                    this.$content.find('.remark').css("border-color","#dc3545");
                                    $.alert({
                                        title: '<span class="text-danger">@lang("lang.requiered")</span>',
                                        content: 'Please to remark!',
                                    });
                                    return false;
                                }
                                $('#modal-loading').modal('show');
                                axios.post('{{ URL('performance-admin/return') }}', {
                                    'id': pa_id,
                                    'actionAsign': 5,
                                    'asign_employee_id': asign_employee_id,
                                    'remark': remark,
                                }).then(function(response) {
                                    $('#modal-loading').modal('hide');
                                    if (response.data.success) {
                                        new Noty({
                                            title: "",
                                            text: '@lang("lang.the_process_has_been_successfully")',
                                            type: "success",
                                            icon: true
                                        }).show();
                                        window.location.replace("{{ URL('performance-admin') }}");
                                    } else if(response.data.message == 'weight_must_be_exactly'){
                                        new Noty({
                                            title: "",
                                            text: 'Total weight must be exactly 100% before approval.',
                                            type: "error",
                                            icon: true,
                                            timeout: 3000,
                                        }).show();
                                    }
                                }).catch(function(error) {
                                    $('#modal-loading').modal('hide');
                                    new Noty({
                                        title: "",
                                        text: '@lang("lang.something_went_wrong_please_try_again_later")',
                                        type: "error",
                                        icon: true,
                                        timeout: 3000,
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
                        var jc = this;
                        this.$content.find('form').on('submit', function(e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
                $(document).ready(function(){
                    $('.hr-select2-option-emp-role').each(function() {
                        $(this).select2({
                            width: '100%',
                            dropdownParent: $(this).parent(),
                        })
                    });
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/performance-admin/employees') }}",
                        data: {
                            'get_employee_id': get_employee_id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            let datas = response.datas;
                            $('#asign_employee_id').html('<option selected value=""> -- @lang("lang.select") --</option>');
                            if (datas != '') {
                                $.each(datas, function(i, item) {
                                    $('#asign_employee_id').append($('<option>', {
                                        value: item.id,
                                        html: item.employee_name_en + '&nbsp;&nbsp;' + '(' + '&nbsp;'+ item.department.name_english + '&nbsp;)'
                                    }));
                                });
                            }
                        }
                    });
                });
            });
        });
        function calculateSubtotals() {
            $('#tbl_performance').find('tr.total').each(function () {
                let $totalRow = $(this);
                let $rows = $totalRow.prevUntil('tr.total, tr:has(td[colspan="2"] input[type="text"])');

                let sumScore = 0, sumPersonnel = 0, sumChairman = 0;
                $rows.each(function () {
                    sumScore += parseFloat($(this).find('.score').val()) || 0;
                    sumPersonnel += parseFloat($(this).find('.personnel_score').val()) || 0;
                    sumChairman += parseFloat($(this).find('.direct_chairman').val()) || 0;
                });

                $totalRow.find('.tr_score').val(sumScore.toFixed(2));
                $totalRow.find('.tr_personnel_score').val(sumPersonnel.toFixed(2));
                $totalRow.find('.tr_direct_chairman').val(sumChairman.toFixed(2));
            });
        }

        function calculateGrandTotals() {
            let totalScore = 0, totalPersonnel = 0, totalChairman = 0, totalWeight = 0;

            $('.score').each(function () {
                totalScore += parseFloat($(this).val()) || 0;
            });
            $('.personnel_score').each(function () {
                totalPersonnel += parseFloat($(this).val()) || 0;
            });
            $('.direct_chairman').each(function () {
                totalChairman += parseFloat($(this).val()) || 0;
            });
            $('.weight').each(function () {
                totalWeight += parseFloat($(this).val()) || 0;
            });

            $('#total_score').val(totalScore.toFixed(2));
            $('#total_personnel_score').val(totalPersonnel.toFixed(2));
            $('#total_direct_chairman').val(totalChairman.toFixed(2));
            updateOverallResults(totalScore);
        }

        function updateOverallResults(totalScore) {
            var overallResults = '';
            var color = '';
            if (totalScore === 0) {
                overallResults = '';
            } else if (totalScore < 2) {
                overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
                color = 'red';
            } else if (totalScore <= 2.99) {
                overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
                color = 'orange';
            } else if (totalScore <= 3.99) {
                overallResults = 'ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
                color = 'info';
            } else if (totalScore <= 4.99) {
                overallResults = 'ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)';
                color = 'lightgreen';
            } else {
                overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
                color = 'green';
            }
            $('#overall_results').val(overallResults).css('color', color);
        }
    });
</script>
