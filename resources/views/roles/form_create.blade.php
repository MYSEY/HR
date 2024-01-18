@extends('layouts.master')
<style>
    .card_background_color {
        background-color: #f8f9fa !important;
    }
    /* The container checkbox */
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
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
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">@lang('lang.add_roles')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/role') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.add_roles')</li>
                </ul>
            </div>
        </div>
    </div>
    @include('roles.interface_create')
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/component-js/role-checkbox.js') }}"></script>
<script src="{{ asset('/admin/component-js/role-create.js') }}"></script>
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script>
    $(function(){
        $("#role_type").on("change", function () {
            if ($(this).val() == "Employee") {
                $('.hidden_leaves_employee').css('display', 'block');
                $('.hidden_leaves_admin').css('display', 'none');
                $('.leaves_admin_checkbox').val('');
                $('.leaves_employee_checkbox').val('');
            }else{
                $('.hidden_leaves_employee').css('display', 'none');
                $('.hidden_leaves_admin').css('display', 'block');
                $('.leaves_admin_checkbox').val('');
                $('.leaves_employee_checkbox').val('');
            }
        });
        $(".btn_save").on("click", function() {
            $("#btn-save-loading").css('display', 'block');
            $("#btn_save").prop('disabled', true);
            $(".btn-text-save").css("display", "none");
            let data = dataPermission();
            $(".hr-form-group-select2").each(function(){
                let formGroup = $(this);
                let value = formGroup.attr("data-select2-id");
                let requeredField = formGroup.find(".hr-select2-option").val();
                let requered = formGroup.find(".role_required").val();
                if(!value && requered == "" || !requered){ 
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }else if (!requeredField && requered == "") {
                    formGroup.find(".select2-selection--single").css("border-color","#dc3545");
                }
            });
            var num_miss = 0;
            $(".role_required").each(function(){
                if(!$(this).val() || $(this).val() ==""){ num_miss++;}
            });
            if (num_miss>0) {
                setTimeout(function () {
                    $("#btn_save").attr('disabled',false);
                    $("#btn-save-loading").css('display', 'none');
                    $(".btn-text-save").css("display", 'block');
                }, 500);
                return false;
            }else{
                let url = "{{url('role/create')}}";
                $.ajax({
                    type: "POST",
                    url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "role_name": $("#role_name").val(),
                        "role_type": $("#role_type").val(),
                        "role_permission": data,
                        "parent_id": $("#parent_id").val(),
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.message) {
                            window.location.replace("{{ URL('role') }}");
                            new Noty({
                                title: "",
                                text: '@lang("lang.create_new_role_successfully")',
                                type: "success",
                                icon: true
                            }).show();
                            $("#btn_save").attr('disabled',false);
                            $("#btn-save-loading").css('display', 'none');
                            $(".btn-text-save").css("display", 'block');
                        }
                    }
                });
            }
        }); 
    });
</script>