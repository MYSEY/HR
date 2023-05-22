@extends('layouts.master')
<style>
    .legend-indicator {
        font-size: 13px;
        font-family: Tahoma;
        padding-left: 12px;
        overflow: hidden;
        margin-right: 1px;
    }
</style>
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome {{ Auth::user()->employee_name_en }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus focused">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="from_date">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" id="to_date">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success w-100" id="btn-reseach"> Search </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{ count($employee) }}</h3>
                            <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">New Employees</span>
                                </div>
                                <div>
                                    <span class="text-success">+10%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">{{ count($employee) }}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Overall Employees 218</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Earnings</span>
                                </div>
                                <div>
                                    <span class="text-success">+12.5%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,42,300</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Expenses</span>
                                </div>
                                <div>
                                    <span class="text-danger">-2.8%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$8,500</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Profit</span>
                                </div>
                                <div>
                                    <span class="text-danger">-75%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,12,000</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('dashboads.chart_board')
    </div>
@endsection
@include('includs.script')
<script>
    $(function() {
        showDashboard()
        $("#btn-reseach").on("click", function() {
            let researchs = {
                "from_date": $("#from_date").val(),
                "to_date": $("#to_date").val()
            }
            showDashboard(researchs)
        });

    });

    function showDashboard(researchs) {
        
        var deshboard = [{
                "name": "HRMS_dashboards"
            },
            {
                "name": "achived_by_branches"
            },
            {
                "name": "staff_resignation"
            },
            {
                "name": "reasons_staff_resignation"
            },
            {
                "name": "staff_take_leave"
            },
            {
                "name": "staff_Training_by_branch"
            },
        ];
        // for HRMS Dashboard
        const dataHRMSdashboards = {
            // labels: [],
            datasets: [{
                    label: 'Total',
                    data: [],
                    backgroundColor: [
                        "red"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: 'Female',
                    data: [],
                    backgroundColor: [
                        "green"
                    ],
                    stack: 'Stack 1',
                },
            ]
        };
        // for achived by branches
        let dataAchive = {
            // labels: ['HO','ANS','TKM','KPB','KPS','SAB','KTB','Total',],
            datasets: [{
                    label: 'Total Staff',
                    data: [31, 17, 17, 15, 15, 10, 10, 80],
                    backgroundColor: [
                        "green"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: 'Current & Recruited 2023',
                    data: [4, 3, 4, 4, 4, 3, 2, 63],
                    backgroundColor: [
                        "yellow"
                    ],
                    stack: 'Stack 1',
                },
                // {
                //     label: '% Achivement',
                //     // data: [3, 2, 3, 3, 3, 2, 2, 40],
                //     data: [],
                //     data: [],
                //     backgroundColor: [
                //         "red"
                //     ],
                //     stack: 'Stack 2',
                // },
            ]
        };

        let dataAchRed = [];
        dataAchive.datasets[0].data.map((da, index) => {
            dataAchRed.push(
                Math.round((dataAchive.datasets[1].data[index] / da) * 100)
            )
        });
        dataAchive.datasets.push({
            label: '% Achivement',
            data: dataAchRed,
            backgroundColor: [
                "red"
            ],
            stack: 'Stack 2',
        })

        // for staff take leave
        const dataStaffTakeLeave = {
            labels: [
                'HO',
                'ANS',
                'TKM',
                'KPB',
                'KPS',
                'SAB',
                'KTB',
                'Total',
            ],
            datasets: [{
                label: 'Total Staff',
                data: [31, 17, 17, 15, 15, 10, 10, 80],
                backgroundColor: [
                    "red"
                ],
                stack: 'Stack 0',
            }, ]
        };

        // for staff training
        const dataStaffTraining = {
            labels: [
                'HO',
                'ANS',
                'TKM',
                'KPB',
                'KPS',
                'SAB',
                'KTB',
                'Total',
            ],
            datasets: [{
                label: 'Total Staff',
                data: [31, 17, 17, 15, 15, 10, 10, 80],
                backgroundColor: [
                    "green"
                ],
                stack: 'Stack 0',
            }, ]
        };

        // for staff resignation
        const dataStaffResignation = {
            datasets: [{
                // data: [70, 31, 17, 17, 15, 15, 10, 10],
                backgroundColor: [
                    "rgba(0, 136, 204)",
                    "rgba(255, 102, 0)",
                    "rgb(128,128,128)",
                    "rgb(255, 204, 0)",
                    "rgb(0, 136, 204)",
                    "rgb(83, 198, 83)",
                    "rgb(0, 51, 102)",
                    "rgb(230, 115, 0)",
                ],
            }, ]
        };
        // Reasons of Staff Resignation
        const dataReasonStaffResignation = {
            labels: [
                'Get now job',
                'Owner Business',
                'Relocate Resident',
                'Contiue stadies',
                'Health Issue',
                'Fimaly',
                'Misconducts',
                'Fraud',
                'Death',
                'Retirement',
                'Others',
            ],
            datasets: [{
                data: [70, 31, 17, 17, 15, 15, 10, 10, 0, 0, 0],
                backgroundColor: [
                    "rgba(0, 136, 204)",
                    "rgba(255, 102, 0)",
                    "rgb(128,128,128)",
                    "rgb(255, 204, 0)",
                    "rgb(0, 136, 204)",
                    "rgb(83, 198, 83)",
                    "rgb(0, 51, 102)",
                    "rgb(230, 115, 0)",
                ],
            }, ]
        };
        $.ajax({
            type: "GET",
            url: "{{ url('dashboad/show') }}",
            data: {
                "from_date": researchs ? researchs.from_date : null,
                "to_date": researchs ? researchs.to_date : null,
            },
            dataType: "JSON",
            success: function(response) {
                let dataEmployee = response.data;
                let branches = response.branches;
                let totalEmployees = dataEmployee.length;
                let totalEmployeeFemale = 0;
                let labelsHRMS = [];
                let totalHRMSData = [];
                let totalHRMSFemale = [];
                let labelAchive = [];

                let labelStaffResignation = [];
                let staffResignationData = [];
                branches.map((br) => {
                    let totalValue = 0;
                    let totalFemale = 0;
                    let totalValueStaffResignation = 0;
                    let female = 0;
                     // for all data employee
                   if (dataEmployee.length > 0) {
                        dataEmployee.map((em) => {
                            if (em.gender) {
                                if (em.gender.type == "gender" && em.gender
                                    .name_english == "Female") {
                                    female++
                                }
                            }
                            if (em.branch_id == br.id) {
                                totalValue++;
                            }
                            if (em.gender) {
                                if (em.branch_id == br.id && em.gender.type ==
                                    "gender" && em.gender.name_english == "Female") {
                                    totalFemale++;
                                }
                            }
                        })
                   }
                   if (response.staffResignations.length > 0) {
                        response.staffResignations.map((sta) => {
                            if (sta.branch_id == br.id) {
                                totalValueStaffResignation++;
                            }
                        });
                   }

                    totalEmployeeFemale = female;
                    totalHRMSData.push(totalValue);
                    totalHRMSFemale.push(totalFemale);
                    labelsHRMS.push(br.abbreviations);

                    labelStaffResignation.push(br.abbreviations);
                    staffResignationData.push(totalValueStaffResignation);
                    if (br.abbreviations != "HQ") {
                        labelAchive.push(br.abbreviations);
                    }
                });

                labelsHRMS.push('total');
                labelAchive.push('total');
                totalHRMSData.push(totalEmployees);
                totalHRMSFemale.push(totalEmployeeFemale);
                dataHRMSdashboards.labels = labelsHRMS;
                dataHRMSdashboards.datasets[0].data = totalHRMSData;
                dataHRMSdashboards.datasets[1].data = totalHRMSFemale;

                //for achived by branch
                dataAchive.labels = labelAchive;
                
                $.each(deshboard, function(i, db) {
                    let text = "";
                    let data = {};
                    let type = "";
                    let option = {};
                   
                    if (db.name == "HRMS_dashboards" || db.name == "achived_by_branches") {
                        type = "bar";
                        data = db.name == "HRMS_dashboards" ? dataHRMSdashboards :
                            dataAchive;
                        text = db.name == "HRMS_dashboards" ? "HRMS Dashboards" :
                            '% ACHIEVED BY BRANCHES';
                        option = {
                            plugins: {
                                legend: {
                                    labels: {
                                        render: 'percentage',
                                        precision: 2,
                                    }
                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    // formatter: Math.round,
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    },
                                    align: 'center',
                                },
                                title: {
                                    display: true,
                                    text
                                },

                            },
                            responsive: true,
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                    beginAtZero: true,
                                    stacked: true
                                }
                            }
                        }
                    } else if (db.name == "staff_resignation" || db.name ==
                        "reasons_staff_resignation") {
                        type = "pie";
                        if (db.name == "staff_resignation") {
                            dataStaffResignation.labels = labelStaffResignation;
                            dataStaffResignation.datasets[0].data = staffResignationData;
                            data = dataStaffResignation;
                            text = '% Staff Resignation';
                        } else {
                            data = dataReasonStaffResignation;
                            text = '% Reasons of Staff Resignation';
                        }
                        option = {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                    rtl: true,
                                },
                                // tooltip: {
                                //     enabled: false
                                // },
                                datalabels: {
                                    font: {
                                        size: 10
                                    },
                                    align: 'center',
                                    // formatter: (value, context)=>{ 
                                    //     // console.log("data: ",context.chart.data.datasets[0].data);
                                    //     const datapoints = context.chart.data.datasets[0].data;
                                    //     function totalSum(total, datapoints){
                                    //         return total + datapoints;
                                    //     }
                                    //     const totalvalue = datapoints.reduce(totalSum, 0);
                                    //     const percentageValue = (value / totalvalue * 100)
                                    //     if (db.name == "staff_resignation" ) {
                                    //         return `${Math.round(percentageValue)}%`;

                                    //     }else{
                                    //         return `${percentageValue.toFixed(2)}%`;
                                    //     }
                                    // }
                                },
                                title: {
                                    display: true,
                                    text
                                },
                            },
                        }
                    } else if (db.name == "staff_take_leave" || db.name ==
                        "staff_Training_by_branch") {
                        type = "bar";
                        data = db.name == "staff_take_leave" ? dataStaffTakeLeave :
                            dataStaffTraining;
                        text = db.name == "staff_take_leave" ? 'Staff Take Leave' :
                            'Staff Training by Branch';
                        option = {
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: true,
                                    text
                                },
                            },
                            responsive: true,
                            interaction: {
                                intersect: false,
                            },
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                    stacked: true
                                }
                            }
                        }
                    }
                    var myChart = null;
                    let dataChart = {
                        type,
                        data,
                        options: option,
                        plugins: [ChartDataLabels]
                    }
                    
                    // if (myChart !=null) {
                    //     myChart.destroy();
                    // } else {
                        myChart = new Chart(db.name, dataChart);
                    // }
                    // }
                    // showChart(db.name,dataChart);
                });
            }
        });
    }
</script>
