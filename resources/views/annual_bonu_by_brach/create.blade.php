@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.annual_bonus_by_branch')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.annual_bonus_by_branch')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('confige/annual/bonus/branch')}}" data-dismiss="modal" class="btn btn-secondary">@lang('lang.back')</a>
                </div>
            </div>
        </div>
        @if (permissionAccess("m8-s1","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <form action="{{url('confige/annual/bonus/branch')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <table class="table table-bordered review-table mb-0" id="tbl_confige_annual_bonus">
                                <thead>
                                    <tr>
                                        <th class="sorting">@lang('lang.branch')</th>
                                        <th class="sorting">គិតជាភាគរយ</th>
                                        <th class="sorting">Year</th>
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
                                            <select class="form-control hr-select2-option requered" id="branch_id[]" name="branch_id[]" value="{{old('branch_id')}}" required>
                                                <option selected disabled value=""> --@lang('lang.select')--</option>
                                                @foreach ($branches as $item)
                                                    <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage[]" name="percentage[]" required>
                                        </td>
                                        <td>
                                            <select name="year[]" id="year[]" class="form-control">
                                                @for ($year = $startYear; $year <= $endYear; $year++)
                                                    <option value="{{ $year }}"  {{ old('year', date('Y')) == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="javascript:void(0);" class="btn btn-success addRecord" id="btnAdd"><i class="fa fa-plus m-r-5"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-end">
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
            $("#tbl_confige_annual_bonus tbody tr:last").after(addRecord());
        });
    });

    function addRecord() {
        var row = `<tr>
                <td>
                    <select class="form-control hr-select2-option requered" id="branch_id[]" name="branch_id[]" value="{{old('branch_id')}}" required>
                        <option selected disabled value=""> --@lang('lang.select')--</option>
                        @foreach ($branches as $item)
                            <option value="{{$item->id}}">{{ Helper::getLang() == 'en' ? $item->branch_name_en : $item->branch_name_kh}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" id="percentage[]" name="percentage[]" required>
                </td>
                <td>
                    <select name="year[]" id="year[]" class="form-control">
                        @for ($year = $startYear; $year <= $endYear; $year++)
                            <option value="{{ $year }}"  {{ old('year', date('Y')) == $year ? 'selected' : '' }}>
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
