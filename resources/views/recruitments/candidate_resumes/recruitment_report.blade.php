@extends('layouts.master')
<style>
    .jconfirm-buttons-center{
        float: none !important;
        text-align: center !important;
    }
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 30px;
        /* margin-bottom: 5px; */
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
    .container-checkbox:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked~.checkmark:after {
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
    <div class="">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">@lang('lang.recruitment_report')</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('lang.recruitment_report')</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row filter-btn">
            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-2">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date" name="from_date" placeholder="@lang('lang.from_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-2">
                <div class="form-group">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date" name="to_date" placeholder="@lang('lang.to_date')">
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-md-8">
                <div style="display: flex" class="float-end">
                    @if ($permission->is_export == "1")
                        <button type="button" class="btn btn-sm btn-outline-secondary btn_excel me-2" id="icon-search-download-reload">
                            <span class="btn-text-excel"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
                            <span id="btn-text-loading-excel" style="display: none"><i class="fa fa-spinner fa-spin"></i></span>
                        </button>
                    @endif
                </div>
            </div>
        </div><br>
        {!! Toastr::message() !!}
        @if (permissionAccess("m3-s1","is_view")->value == "1")
        <div class="">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped custom-table" id="tbl-recruitment-report">
                        <thead>
                            <tr>
                                <th class="sorting stuck-scroll-3" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="#: activate to sort column descending">#</th>
                                <th class="sorting stuck-scroll-3" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.en'))</th>
                                <th class="sorting stuck-scroll-3" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">@lang('lang.name') (@lang('lang.kh'))</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending">@lang('lang.gender')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Current Position at: activate to sort column ascending">@lang('lang.current_position')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Company Name: activate to sort column ascending" >@lang('lang.company_name')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Current Address: activate to sort column ascending" >@lang('lang.current_address')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Position Applied: activate to sort column ascending" >@lang('lang.position_applied')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Location Applied: activate to sort column ascending" >@lang('lang.location_applied')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Received Date: activate to sort column ascending" >@lang('lang.received_date')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Month Date: activate to sort column ascending" >@lang('lang.month')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Recruitment Channel: activate to sort column ascending" >@lang('lang.applied_channel')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Referral Name: activate to sort column ascending" >@lang('lang.referral_name')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Contact Number: activate to sort column ascending" >@lang('lang.contact_number')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Phone Interview: activate to sort column ascending" >@lang('lang.phone_interview')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Short List: activate to sort column ascending" >@lang('lang.short_list')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Interviewed Date: activate to sort column ascending" >@lang('lang.interviewed_date')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Month: activate to sort column ascending" >@lang('lang.month')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Interviewed Channel: activate to sort column ascending" >@lang('lang.interviewed_channel')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Committee Interview: activate to sort column ascending" >@lang('lang.committee_interview')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Joined Interview: activate to sort column ascending" >@lang('lang.joined_interview')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Interviewed Result: activate to sort column ascending" >@lang('lang.interviewed_result')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Job Offer: activate to sort column ascending" >@lang('lang.job_offer')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Contract Date: activate to sort column ascending" >@lang('lang.contract_date')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Month: activate to sort column ascending" >@lang('lang.month')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending" >@lang('lang.join_date')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="Remark: activate to sort column ascending" >@lang('lang.remark')</th>
                                <th class="sorting" aria-controls="Candidate_CVs" rowspan="1" colspan="1" aria-label="CV: activate to sort column ascending" >@lang('lang.cv')</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        <div id="loading-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading Data...</p>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script src="{{asset('admin/js/export_xlsx.bundle.js')}}"></script>
@section('script')
    <script>
        $(function(){
            dataTables();
            $('.datetimepicker').on('dp.change changeDate change', function (e) {
                dataTables();
            });
            $(".btn_excel").on("click", function() {
                let query = {
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val()
                };
                var url = "{{URL::to('/recruitment/candidate-resume/download')}}?" + $.param(query)
                window.location = url;
            });
        });
        function dataTables() {
            $('#loading-overlay').show();
            var dynamicHeight = $(window).height() - 350;
            if (dynamicHeight < 200) dynamicHeight = 200;
            if ($.fn.DataTable.isDataTable('#tbl-recruitment-report')) {
                $('#tbl-recruitment-report').DataTable().clear().destroy();
            }
            $('#tbl-recruitment-report').DataTable({
                pageLength: 20,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true,
                scrollY: dynamicHeight + 'px',
                scroller: false,
                order: [[1, 'asc']],
                lengthMenu: [ 
                    [20, 25, 50, 100, -1],
                    [20, 25, 50, 100, "All"]
                ],
                ajax: {
                    url: '{{ URL("/recruitment/candidate-resume/report") }}',
                    type: 'GET',
                    data: function (d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    },
                    dataSrc: function (json) {
                        return json.data;
                    }
                },
                columns: [
                    { data: null, name: 'num', className: 'ids stuck-scroll-3', orderable: false, searchable: false, render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, 
                    { data: 'name_en', className: 'stuck-scroll-3' }, 
                    { data: 'name_kh', className: 'stuck-scroll-3' },
                    { data: 'CandidateGender' },  
                    { data: 'current_position' }, 
                    { data: 'companey_name' },    
                    { data: 'current_address' },  
                    { data: 'CandidatePosition' },
                    { data: 'CandidateBranch' },  
                    { data: 'received_date', render: function (data) { return data ? moment(data).format('DD-MMM-YYYY') : ''; } },
                    { data: 'received_date', render: function (data) { return data ? moment(data).format('MMMM') : ''; } },       
                    { data: 'recruitment_channel' }, 
                    { data: "referral_name"},
                    { data: 'contact_number' },                            
                    
                    { data: null, render: function () { return "N/A"; } },
                    { 
                        data: 'short_list', 
                        defaultContent: '',
                        render: function (data, type, row) {
                            if(row.short_list== '1' && row.status =="2"){
                                return "Short List";
                            }else{
                                return " ";
                            }
                        }
                    },   
                    
                    { data: 'interviewed_date', render: function (data) { return data ? moment(data).format('DD-MMM-YYYY') : ''; } }, // 17. Interviewed_Date
                    { data: 'interviewed_date', render: function (data) { return data ? moment(data).format('MMMM') : ''; } },        // 18. Month (ទាញពី Interviewed_Date)
                    { data: 'interviewed_channel' },
                    
                    { data: 'committee_interview'},

                    // --- ផ្នែក Candidate Result & Signed Contract ---
                    { 
                        data: 'joined_interview', 
                        defaultContent: '',
                        render: function (data, type, row) {
                            var result = data ? data.toString() : ''; 
                            switch (result) {
                                case '1': return "Yes";
                                case '2': return "No";
                                case '3': return "Delay";
                                default: return "";
                            }
                        }
                    },   
                    { 
                        data: 'interviewed_result', 
                        defaultContent: '',
                        render: function (data, type, row) {
                          var result = data ? data.toString() : ''; 
                            switch (result) {
                                case '1': return "Passed";
                                case '2': return "Failed";
                                case '3': return "Waiting";
                                case '4': return "Pending";
                                case '5': return "High Expected Salary";
                                case '6': return "Rejected Offered";
                                case '7': return "Blacklist";
                                default: return "";
                            }
                        }
                    }, 
                    { 
                        data: 'status', 
                        defaultContent: '',
                        render: function (data, type, row) {
                            var statusVal = data ? data.toString() : '';
                            var resultVal = row.interviewed_result ? row.interviewed_result.toString() : '';
                            if(row.emp_status =="Cancel"){
                                return "Canceled Contract";
                            }else{
                                if (statusVal === '4') {
                                    return "On going process";
                                } 
                                else if (statusVal === 'Cancel') {
                                    return "Rejected Job Offered";
                                } 
                                // 🔥 ឆែកលក្ខខណ្ឌ status ស្មើ 5 និង interviewed_result ស្មើ 1
                                else if (statusVal === '5' && resultVal === '1') {
                                    return "Signed Contract";
                                } 
                                else {
                                    return "";
                                }
                            }
                            
                        }
                    },
                    
                    { data: 'contract_date', render: function (data) { return data ? moment(data).format('DD-MMM-YYYY') : ''; } },    // 26. Contract_Date
                    { data: 'contract_date', render: function (data) { return data ? moment(data).format('MMMM') : ''; } },           // 27. Month (ទាញពី Contract_Date)
                    { data: 'join_date', render: function (data) { return data ? moment(data).format('DD-MMM-YYYY') : ''; } },        // 28. Join_Date
                    
                    // --- ផ្នែក Remarks ---
                    { 
                        data: 'remark', 
                        defaultContent: '',
                        render: function (data) {
                            if (!data) return '';
                            return `<span data-toggle="tooltip" data-html="true" title="${data}">${data.substring(0, 30)}...</span>`;
                        }
                    },                                                             // 29. Remarks
                    
                    // --- ផ្នែក CV Preview (មិនបាច់បញ្ជូនទៅ Excel ទេ ទុកមើលលើ Web) ---
                    {
                        data: 'cv',
                        orderable: false,
                        searchable: false,
                        render: function (cv) {
                            return cv ? `<small><a href="{{asset('/uploads/images')}}/${cv}" target="_blank">Preview</a></small>` : 'No CV';
                        }
                    }                                                              // 30. CV Action
                ],
                initComplete: function () {
                    $('#loading-overlay').hide();
                }
                
            });

            // $('#tbl-recruitment-report').on('processing.dt', function (e, settings, processing) {
            //     if (processing) {
            //         $('#loading-overlay').show();
            //     } else {
            //         $('#loading-overlay').hide();
            //     }
            // });
        }
        function strLimit(str, limit = 30, end = '...') {
            return str.length > limit ? str.substring(0, limit) + end : str;
        }
    </script>
@endsection