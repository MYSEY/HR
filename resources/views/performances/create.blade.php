@extends('layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">@lang('lang.add_new_performance')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active">@lang('lang.add_new_performance')</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('users/create') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-4 hr-form-group-select2">
                        <div class="form-group">
                            <label>@lang('lang.employee')</label>
                            <select class="form-control hr-select2-option" id="employee" name="employee"
                                value="{{ old('employee') }}">
                                <option selected value=""> -- @lang('lang.select')--</option>
                                @foreach ($employee as $item)
                                    <option data-id="{{ $item->id }}" value="{{ $item->id }}">
                                        {{ Helper::getLang() == 'en' ? $item->employee_name_en : $item->employee_name_kh }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tbl_performance" class="table table-bordered review-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 350px;">(KPI)</th>
                                        <th style="min-width: 350px;">Action Plan</th>
                                        <th style="min-width: 350px;">Goal</th>
                                        <th style="min-width: 150px;">% Weight</th>
                                        <th>@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">
                                    <div>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <input type="text" class="form-control" placeholder="ក. កត្តាប្រតិបត្តិការ (%)" value="" required>
                                            </td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                            <td colspan="1" class="text-center"></td>
                                        </tr>
                                        <div>
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    <input type="text" class="form-control" placeholder="គោលបំណង" value="" required>
                                                </td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center"></td>
                                                <td colspan="1" class="text-center">
                                                    <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i> Add Purpose</button>
                                                </td>
                                            </tr>
                                            <div>
                                                <tr>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="number" step="any" class="form-control weight" id="weight" placeholder="%" required>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center"></td>
                                        <td colspan="1" class="text-center">
                                            <div class="add-more">
                                                <a class="add-repeatable-element-button addMore"><i class="fa fa-plus-circle"></i> Add More</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="submit-section mb-2">
                    <button type="submit" class="btn btn-primary submit-btn">
                        <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i>
                            @lang('lang.loading') </span>
                        <span class="btn-txt">@lang('lang.submit')</span>
                    </button>
                    <a href="{{ url('performance') }}" class="btn btn-secondary btn-cancel">@lang('lang.cancel')</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        // Event to add a new purpose
        $(document).on('click',".addNewPurpose",function() {
            // $("#tbody1").append(addPurposeRow());
            $(this).closest('tr').before(addPurposeRow());
        });
        $(document).on('click',".addMore", function() {
            $("#tbody1").append(addMoreRow());
        });

        // Event to add a new record
        $(document).on('click', '.addRecord', function() {
            // Append a new record row to the last purpose section
            $(this).closest('tr').before(addNewRecord());
        });
        // Event delegation for dynamically added Remove buttons in records
        $(document).on('click', '.removeRecord', function() {
            $(this).closest('tr').remove(); // Remove the clicked row
        });

        // Event delegation for dynamically added Remove buttons in purposes
        $(document).on('click', '.btnRemovePurpose', function() {
           // Remove the current tr and all subsequent tr elements
            $(this).closest('tr').next().addBack().remove();
            // $(this).closest('tr').nextAll().remove();
        });
        $(document).on('click', '.btnRemoveMore', function() {
           // Remove the current tr and all subsequent tr elements
            $(this).closest('tr').nextAll().remove();
            $(this).closest('tr').remove(); // Remove the current tr as well
        });
        $(document).ready(function() {
            // Attach event listeners to inputs with class .weight and .score_achieved
            $('#tbl_performance').on('input', '.weight', function () {
                var row = $(this).closest('tr');
                var weightInput = row.find('.weight');
                // Validate weight input
                var weightValue = parseFloat(weightInput.val());
                // Check if weightValue is NaN or out of range
                if (isNaN(weightValue) || weightValue < 0 || weightValue > 100) {
                    weightInput.val(0); // Reset to a default value or keep it empty
                    $('.weight').css("border-color","red");
                    // toastr.error('Please enter a weight between 0 and 100.', 'Error');
                }
            });
        });
        
        $(".weight").on('focus',function(){
            $(this).css("border-color","#1e9ff2");
        });
        $(".weight").on('focusout',function(){
            $(this).css("border-color","#d8d2d2");
        });
    });

    // Function to create a new purpose row
    function addPurposeRow() {
        return `<tr class='' style='text-align: center'>
            <td colspan="2" class="text-center">
                <input type="text" class="form-control" placeholder="គោលបំណង" required>
            </td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center">
                <button type="button" class="btn btn-danger btn-sm btnRemovePurpose">Remove Purpose</button>
            </td>
        </tr>
        <tr class='section-row' style='text-align: center'>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center"><input type="number" step="any" class="form-control weight" id="weight" placeholder="%" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
            </td>
        </tr>`;
    }
    // Function to create a new record row
    function addNewRecord() {
        return `<tr class='section-row' style='text-align: center'>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center"><input type="number" step="any" class="form-control" placeholder="%" min="0" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger me-1 btn-sm removeRecord"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>`;
    }
    function addMoreRow() {
        return `<tr class=''>
            <td colspan="2" class="text-center">
                <input type="text" class="form-control" placeholder="ក. កត្តាប្រតិបត្តិការ (%)" value="" required>
            </td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center">
                <a class="btn btn-danger btn-sm btnRemoveMore"><i class="fa fa-plus-circle"></i>Remove More</a>
            </td>
        </tr>
        <tr class='' style='text-align: center'>
            <td colspan="2" class="text-center">
                <input type="text" class="form-control" placeholder="គោលបំណង" required>
            </td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center"></td>
            <td colspan="1" class="text-center">
                <button type="button" class="btn btn-success btn-sm addNewPurpose"><i class="fa fa-plus"></i>Add Purpose</button>
            </td>
        </tr>
        <tr class='' style='text-align: center'>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center">
                <textarea rows="3" class="form-control" placeholder="Enter text here" spellcheck="false" required></textarea>
            </td>
            <td class="text-center"><input type="number" step="any" class="form-control" placeholder="%" min="0" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-sm addRecord"><i class="fa fa-plus"></i></button>
            </td>
        </tr>`;
    }
</script>
