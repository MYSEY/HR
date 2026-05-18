@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.config_annual_salary_increasement')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.config_annual_salary_increasement')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('annual/salary/increasement')}}" data-dismiss="modal" class="btn btn-secondary">@lang('lang.back')</a>
                </div>
            </div>
        </div>
        @if (permissionAccess("m8-s1","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <form action="{{url('annual/salary/increasement')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <table class="table table-bordered review-table mb-0" id="tbl_annual_salary_increasement">
                                <thead>
                                    <tr>
                                        <th class="sorting" style="width: 30%">ចំណាត់ថ្នាក់លទ្ទផលការងារ</th>
                                        <th class="sorting" style="width: 15%">ពិន្ទុសរុប</th>
                                        <th class="sorting" style="width: 15%">គិតជាភាគរយ</th>
                                        <th class="sorting" style="width: 15%">Increasement Year</th>
                                        <th style="width: 5%">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                @php
                                    $startYear = 2020;
                                    $endYear   = now()->year + 3; // current year + 1
                                @endphp
                                <tbody>
                                    <tr>
                                        <td>
                                            <textarea class="form-control" name="ranking_work_result[]" rows="3" required></textarea>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="total_score[]" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="percentage[]" required>
                                        </td>
                                        <td>
                                            <select name="increasement_year[]" class="form-control">
                                                @for ($year = $startYear; $year <= $endYear; $year++)
                                                    <option value="{{ $year }}" {{ old('increasement_year', date('Y')) == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="javascript:void(0);" class="btn btn-success addRecord"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(function() {
        $(document).on('click', '#btnRemove', function(){
            $(this).closest("tr").remove();
        });
        $(document).on('click', '.addRecord', function(e) {
            e.preventDefault();
            // Insert the new record row BEFORE the grand total row
            $("#tbl_annual_salary_increasement tbody tr:last").after(addRecord());
        });
    });

    function addRecord() {
        var row = `<tr>
                <td>
                    <textarea class="form-control" name="ranking_work_result[]" id="ranking_work_result[]" rows="3" required></textarea>
                </td>
                <td>
                    <input type="text" class="form-control" id="total_score[]" name="total_score[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" id="percentage[]" name="percentage[]" required>
                </td>
                <td>
                    <select name="increasement_year[]" id="increasement_year[]" class="form-control">
                        @for ($year = $startYear; $year <= $endYear; $year++)
                            <option value="{{ $year }}"  {{ old('increasement_year', date('Y')) == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </td>
                <td style="text-align: center;">
                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger" id="btnRemove"><i class="fa fa-trash-o m-r-5"></i></a>
                </td>
            </tr>`;
        return row;
    }
</script>
