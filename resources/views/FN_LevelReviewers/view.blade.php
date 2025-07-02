@extends('layouts.master')
<style>
    .tooltip-inner {
        white-space: normal !important;
        text-align: left !important;
        max-width: 300px !important; 
        word-wrap: break-word !important;
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.fn_level_reviewer')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.fn_level_reviewer')</li>
                    </ul>
                </div>
            </div>
        </div>

        <form>
            <div class="row filter-btn"> 
                <div class="col-sm-12 col-md-12">
                    <div style="display: flex" class="float-end">
                        <a href="{{ url('fn/level-reviewer') }}" type="button" class="btn btn-icon btn-soft-success me-1">
                            <i class="fa fa-angle-double-left"></i> @lang('lang.back')
                        </a>
                        <button type="button" class="btn btn-icon btn-soft-success btn_excel">
                            <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> @lang('lang.export')</span>
                            <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <br>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <input type="text" hidden value="{{$datas[0]->group_id}}" name="" id="group_id">
                <div class="table-responsive">
                    @if (method_exists($datas, 'total') && $datas->total() > 9)
                        <form method="GET" class="mb-3">
                            <label>Show 
                                <select name="per_page" onchange="this.form.submit()" class="per_page">
                                    <?php
                                        for ($i = 10; $i <= $datas->total(); $i *= 2) {
                                            echo '<option value="'.$i.'" '.(request('per_page') == $i ? 'selected' : '').'>'.$i.'</option>';
                                        }
                                        if ($datas->total() > $i / 2) {
                                            echo '<option value="'.$datas->total().'" '.(request('per_page') == $datas->total() ? 'selected' : '').'>'.$datas->total().'</option>';
                                        }
                                    ?>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All</option>
                                </select> entries
                            </label>
                        </form>
                    @endif
                    <table class="table table-striped custom-table mb-0 no-footer tbl-level-review" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th>@lang('lang.from_amount')</th>
                                <th>@lang('lang.to_amount')</th>
                                <th>@lang('lang.request_type')</th>
                                <th>@lang('lang.reference') @lang('lang.type')</th>
                                <th>@lang('lang.review') @lang('lang.type')</th>
                                <th>@lang('lang.from_location')</th>
                                <th>@lang('lang.model_review')</th>
                                <th>@lang('lang.department_review')</th>
                                <th>@lang('lang.position_review')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas)>0)
                                @php
                                    $requestType = [
                                        "1"=>__("lang.review"),
                                        "2"=>__("lang.review"),
                                        "3"=>__("lang.review"),
                                        "4"=>__("lang.review"),
                                        "5"=>__("lang.review"),
                                        "6"=>__("lang.review"),
                                        "7"=>__("lang.review"),
                                        "8"=>__("lang.review"),
                                        "9"=>__("lang.review"),
                                        "10"=>__("lang.review"),
                                    ];
                                    $type = [
                                        "0" => __("lang.general_expense"),
                                        "2" => __("lang.tax_expense"),
                                        "1" => __("lang.special_expense"),
                                    ];
                                @endphp
                                @foreach ($datas as $key=>$item)
                                    @php
                                        $positionViews = "";
                                        $num = 1;
                                        foreach ($item->positionReview as $value) {
                                            $positionViews .= $num . ". " . $value->name_english . "\n";
                                            $num++;
                                        }
                                    @endphp
                                    <tr class="odd">
                                        <td>{{$item->from_amount}}</td>
                                        <td>{{$item->to_amount}}</td>
                                        <td>{{ $type[$item->request_type]}}</td>
                                        <td>
                                            @if ($item->reference_type == 1)
                                                @lang('lang.regular_expense')
                                            @endif
                                            @if ($item->reference_type == 2)
                                                @lang('lang.irregular_expense')
                                            @endif
                                        </td>
                                        <td>{{ $requestType[$item->type]." ".$item->type}}</td>
                                        <td>{{$item->from_location =="1" ? "Branch" : "Department"}}</td>
                                        <td>{{$item->modelReview ? $item->modelReview->name_english : ""}}</td>
                                        <td>{{$item->departmentView ? $item->departmentView->name_english : ""}}</td>
                                        <td data-toggle="tooltip" data-html="true" title="{!! $positionViews !!}">{{$item->positionReview[0]->name_english}}...</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($datas instanceof \Illuminate\Contracts\Pagination\Paginator)
                        {!! $datas->withQueryString()->links('pagination::bootstrap-5') !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includs.script')
<script src="{{ asset('/admin/js/validation-field.js') }}"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({ 
            html: true,
            container: 'tr' 
        });
    });
    $(function() {
        $(".btn_excel").on("click", function () {
            let query = {
                "_token": "{{ csrf_token() }}",
                group_id:         $("#group_id").val(),
                request_type:     $(".request_type").val(),
            };
            var url = "{{URL::to('fn/level-reviewer/export/details')}}?" + $.param(query)
            window.location = url;
        });
    });

</script>
