@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.annual_bonus')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.annual_bonus')</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{url('annual/bonus')}}" data-dismiss="modal" class="btn btn-secondary">@lang('lang.back')</a>
                </div>
            </div>
        </div>
        @if (permissionAccess("m8-s1","is_view")->value == "1")
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered review-table mb-0" id="tbl_annual_bonus">
                            <thead>
                                <tr>
                                    <th class="sorting" style="width: 20%">Criteria</th>
                                    <th class="sorting" style="width: 30%">Discription</th>
                                    <th class="sorting">Total Score</th>
                                    <th class="sorting">គិតជាភាគរយ</th>
                                    <th class="sorting">Increasement Year</th>
                                    <th style="width: 5%">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            @php
                                $startYear = 2020;
                                $endYear   = now()->year + 3; // current year + 1
                            @endphp
                            <tbody>
                                <form action="{{url('annual/bonus')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    @csrf
                                    @for ($i = 0; $i < 5; $i++)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control @error('criteria') is-invalid @enderror" id="criteria[]" name="criteria[]" required>
                                            </td>
                                            <td>
                                                <textarea class="form-control @error('discription') is-invalid @enderror" name="discription[]" id="discription[]" rows="3" required></textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control @error('total_score') is-invalid @enderror" id="total_score[]" name="total_score[]" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage[]" name="percentage[]" required>
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
                                                @if($i == 4)
                                                    <a href="javascript:void(0);" class="btn btn-success addRecord" id="btnAdd"><i class="fa fa-plus m-r-5"></i></a>
                                                @else
                                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger" id="btnRemove"><i class="fa fa-trash-o m-r-5"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endfor

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-primary submit-btn">
                                                    <span class="loading-icon" style="display: none"><i class="fa fa-spinner fa-spin"></i> @lang('lang.loading') </span>
                                                    <span class="btn-txt">@lang('lang.submit')</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
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
            $("#tbl_annual_bonus tbody tr:first").before(addRecord());
        });
    });

    function addRecord() {
        var row = `<tr>
                <td>
                    <input type="text" class="form-control @error('criteria') is-invalid @enderror" id="criteria[]" name="criteria[]" required>
                </td>
                <td>
                    <textarea class="form-control @error('discription') is-invalid @enderror" name="discription[]" id="discription[]" rows="3" required></textarea>
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
