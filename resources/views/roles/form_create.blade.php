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
    <div class="content">
        {{-- new create role permission --}}
        <form  method="POST" enctype="multipart/form-data">
            <input type="text" hidden name="parent_id" id="parent_id" value="{{Auth::user()->role_id}}">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">@lang('lang.name') <span class="text-danger">*</span></label>
                        <input class="form-control role_required @error('name') is-invalid @enderror" type="text"
                            id="role_name" required name="role_name" value="{{ old('role_name') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group hr-form-group-select2">
                        <label class="">@lang('lang.type') <span class="text-danger">*</span></label>
                        <select class="form-control hr-select2-option role_required" id="role_type" name="role_type" required>
                            <option selected disabled value=""> -- @lang('lang.select') --</option>
                            <option value="admin">Admin</option>
                            <option value="developer">Developer</option>
                            <option value="BOD">Board of Director</option>
                            <option value="CEO">Chief Executive Officer</option>
                            <option value="HRAdmin">HR Admin</option>
                            <option value="HR">HR</option>
                            <option value="HOD">Head of Department</option>
                            <option value="DHOD">D-Head of Department</option>
                            <option value="BM">Branch Manager</option>
                            <option value="DBM">Deputy Branch Manager</option>
                            <option value="Employee">Employee</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="">@lang('lang.remark')</label>
                        <textarea style="height: 44px;" type="text" rows="3" class="form-control" name="remark" id="remark" value="{{ old('remark') }}"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <label for="">Permission</label>
            <div class="row">
                @foreach ($permission as $per)
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <div class="card border-success draggable" draggable="true">
                                <div class="card-header border-success">@lang($per->name)</div>
                                <div class="card-body">
                                    <div class="mb-1 permission_all" data-id="{{$per->id}}"
                                        data-name="{{$per->name}}"
                                        data-subid="{{$per->sub_menu_id}}"
                                        data-url="{{$per->url}}"
                                        data-menu="{{$per->menu_id}}"
                                        >
                                        @if ($per->url == "dashboad/admin")
                                            @php
                                                $dashboardData = json_decode($per->is_dashboard, true);
                                                $dashboardData = Arr::except($dashboardData, ['name', 'sub_menu_id', 'menu_id', 'url']);
                                            @endphp
                                            @foreach ($dashboardData as $key => $value)
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <label class="container-checkbox">
                                                        <input type="checkbox" class="dashboad_all_admin{{ $per->id }}" name="{{ $key }}" data-subid="{{$per->sub_menu_id}}">
                                                        <span class="checkmark"></span> {{ ucfirst(str_replace('is_', ' ', $key)) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            @php
                                                $pers = Arr::except($per, ['is_all', 'is_active']);
                                            @endphp
                                            @foreach ($pers->toArray() as $field => $value)
                                                @if ($value == 1 && Str::startsWith($field, 'is_'))
                                                    <label class="container-checkbox">
                                                        @if ($field == "is_create")
                                                            @lang('lang.' . $field)
                                                        @elseif($field == "is_access")
                                                            @lang('lang.view_all_staff')
                                                        @else
                                                            @lang('lang.' . str_replace('is_', '', $field))
                                                        @endif
                                                        <input type="checkbox" class="dashboad_all_admin{{ $per->id }}" name="{{ $field }}" data-subid="{{$per->sub_menu_id}}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                @endif
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>

            <div class="text-right" style="float: right">
                @if (Auth::user()->RolePermission == 'admin' || Auth::user()->RolePermission == 'developer')
                    <button type="button" class="btn btn-danger waves-effect waves-themed btn-submit">Submit</button>
                @endif
                <a class="btn btn-secondary waves-effect waves-themed"  href="{{url('role')}}"  type="button">Cancel</a>
            </div>
        </form>
    </div>
    

    {{-- ****** old create role permission  ***** --}}
    {{-- @include('roles.interface_create') --}}
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<link rel="stylesheet" href="{{ asset('admin/css/noty.css') }}">
<script src="{{ asset('/admin/component-js/role-checkbox.js') }}"></script>
<script src="{{ asset('/admin/component-js/role-create.js') }}"></script>
<script src="{{ asset('/admin/js/noty.js') }}"></script>
<script>
    $(document).ready(function() {
        // JavaScript for drag-and-drop functionality
        const draggables = document.querySelectorAll('.draggable');
        const containers = document.querySelectorAll('.col-md-3');

        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });

            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            });
        });

        containers.forEach(container => {
            container.addEventListener('dragover', e => {
                e.preventDefault();
                const draggingElement = document.querySelector('.dragging');
                container.appendChild(draggingElement);
            });
        });
    });
    $(function(){
        $(".btn-submit").on("click", function () {
           
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
                if(!$(this).val() || $(this).val() ==""){ 
                    num_miss++;
                    $(this).css("border-color","#dc3545");
                }else{
                    $(this).css("border-color","#198754");
                }
            });
            let data = [];
            $('.permission_all').each(function() {
                let id = $(this).data("id");
                let sub_name_en = $(this).data("name");
                let sub_menu_id = $(this).data("subid");
                let menu_id = $(this).data("menu");
                let url = $(this).data("url");
                let sub_class = `.dashboad_all_admin${id}`;
                let dataObj = { 
                    "name": sub_name_en,
                    "sub_menu_id":sub_menu_id,
                    "menu_id":menu_id,
                    "url":url,
                };
                let checkbox = false;
                $(sub_class).each(function() {
                    let name = $(this).attr("name");
                    if (url == "dashboad/admin" ) {
                        if ($(this).prop("checked")) {
                            checkbox = true;
                            dataObj[name] = 1;
                        }else{
                            dataObj[name] = 0;
                        }
                    }else{
                        if ($(this).prop("checked")) {
                            checkbox = true;
                            dataObj[name] = 1;
                        }
                    }
                });
                if (checkbox == true) {
                    data.push({
                        "name": sub_name_en,
                        "permission": [
                            dataObj
                        ]
                    });
                }
            });
            if (num_miss>0) {
                new Noty({
                    title: "",
                    text: 'Please input all require!',
                    type: "error",
                    timeout: 3000,
                    icon: true
                }).show();
                return false;
            }else{
                let url = "{{url('role/createPermission')}}";
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