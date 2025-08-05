@extends('layouts.master')
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.performance_appraisal')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.performance_appraisal')</li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc stuck-scroll-4">#</th>
                                            <th class="sorting stuck-scroll-4">@lang('lang.employee_id')</th>
                                            <th class="sorting sorting_asc stuck-scroll-4">@lang('lang.employee_name')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.location')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.department')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.position')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.from_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.to_date')</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 218.762px;">@lang('lang.type')</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">ពិន្ទុ</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">បុគ្គលិកផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">ប្រធានផ្ទាល់</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">Overall Results</th>
                                            <th class="text-nowrap sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" style="width: 87.1125px;">@lang('lang.status')</th>
                                            <th class="text-end no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 50.825px;">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr class="odd">
                                                <td class="ids stuck-scroll-4">{{$item->id}}</td>
                                                <td class="stuck-scroll-4"><a href="{{url("performance",$item->employee_id)}}">{{$item->number_employee}}</a></td>
                                                <td class="stuck-scroll-4"><a href="">{{$item->employee_name_en}}</a></td>
                                                <td>{{$item->branch_name_en}}</td>
                                                <td>{{$item->dep_name}}</td>
                                                <td>{{$item->positions_name}}</td>
                                                <td>{{$item->from_date}}</td>
                                                <td>{{$item->to_date}}</td>
                                                <td>{{$item->type}}</td>
                                                <td id="overall_results"><span class="badge bg-inverse-success">{{$item->total_score}}</span></td>
                                                <td><span class="badge bg-inverse-success">{{$item->total_score_live_staff}}</span></td>
                                                <td><span class="badge bg-inverse-success">{{$item->total_score_direct_chairman}}</span></td>
                                                <td>{{$item->overall_results}}</td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-success"></i>
                                                            <span>{{ $item->status == 'prepare' ? 'Prepare' : 'Approved' }}</span>
                                                        </a>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i  class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{url("performance-appraisal",$item->id)}}"><i class="fa fa-regular fa-eye"></i> @lang("lang.preview")</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')

<script>
    $(document).ready(function () {
        var overall_results = $("#overall_results").val();
        console.log(overall_results); 
    });

    // function updateOverallResults(totalScore) {
    //     var overallResults = '';
    //     var color = '';
    //     if (totalScore === 0) {
    //         overallResults = '';
    //     } else if (totalScore < 2) {
    //         overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
    //         color = 'red';
    //     } else if (totalScore <= 2.99) {
    //         overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
    //         color = 'orange';
    //     } else if (totalScore <= 3.99) {
    //         overallResults = 'ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
    //         color = 'info';
    //     } else if (totalScore <= 4.99) {
    //         overallResults = 'ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)';
    //         color = 'lightgreen';
    //     } else {
    //         overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
    //         color = 'green';
    //     }
    //     $('#overall_results').val(overallResults).css('color', color);
    // }
</script>