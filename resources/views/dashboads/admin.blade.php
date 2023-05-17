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
        var deshboard = [
            {"name": "HRMS_dashboards"},
            {"name": "achived_by_branches"},
            {"name": "staff_resignation"},
            {"name": "reasons_staff_resignation"},
            {"name": "staff_take_leave"},
            {"name": "staff_Training_by_branch"},
        ];

        // for HRMS Dashboard
        const dataHRMSdashboards = {
            // labels: [],
            datasets: [
                {
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
        const dataAchive = {
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
                {
                    label: '% Achivement',
                    data: [3, 2, 3, 3, 3, 2, 2, 40],
                    backgroundColor: [
                        "red"
                    ],
                    stack: 'Stack 2',
                },
            ]
        };

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
                },
            ]
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
                },
            ]
        };

        // for staff resignation
        const dataStaffResignation = {
            labels: [
                'HQ',
                'HO',
                'ANS',
                'TKM',
                'KPB',
                'KPS',
                'SAB',
                'KTB',
            ],
            datasets: [{
                data: [70, 31, 17, 17, 15, 15, 10, 10],
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
            url: "{{url('dashboad/show')}}",
            data: {},
            dataType: "JSON",
            success: function (response) {
                let dataEmployee = response.data;
                let branches = response.branches;
                let totalEmployees = dataEmployee.length;
                let totalEmployeeFemale = 0;
                let labelsHRMS = [];
                let totalHRMSData = [];
                let totalHRMSFemale = [];
                let labelAchive = [];
                branches.map((br) => {
                    let totalValue = 0;
                    let totalFemale = 0;
                    let female = 0;
                    dataEmployee.map((em) => {
                        if (em.gender) {
                            if (em.gender.type == "gender" &&  em.gender.name_english == "Female") { female ++ } 
                        }
                        if (em.branch_id == br.id) {
                            totalValue ++;
                        }
                        if (em.gender) {
                            if (em.branch_id == br.id && em.gender.type == "gender" &&  em.gender.name_english == "Female") {
                                totalFemale++;
                            } 
                        } 
                    })
                    totalEmployeeFemale = female;
                    totalHRMSData.push(totalValue);
                    totalHRMSFemale.push(totalFemale);
                    labelsHRMS.push(br.abbreviations);
                    if (br.abbreviations !="HQ") {
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
                // let data = (8 / 16) * 100;
                // alert(Math.round(data));
                dataAchive.labels = labelAchive;
                
                $.each(deshboard, function(i, db) {
                    let text = "";
                    let data = {};
                    let type = "";
                    let option = {};
                    if (db.name == "HRMS_dashboards" || db.name == "achived_by_branches") {
                        type = "bar";
                        data = db.name == "HRMS_dashboards" ? dataHRMSdashboards : dataAchive;
                        text = db.name == "HRMS_dashboards" ? "HRMS Dashboards" : '% ACHIEVED BY BRANCHES';
                        option = {
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    formatter: Math.round,
                                    font: {
                                        weight: 'bold',
                                        size: 16
                                    }
                                },
                                title: {
                                    display: true,
                                    text
                                },
                               
                            },
                            responsive: true,
                            // interaction: {
                            //     intersect: false,
                            // },
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
                    } else if (db.name == "staff_resignation" || db.name == "reasons_staff_resignation") {
                        type = "pie";
                        data = db.name == "staff_resignation" ? dataStaffResignation : dataStaffResignation;
                        text = db.name == "staff_resignation" ? '% Staff Resignation' :
                            '% Reasons of Staff Resignation';
                        option = {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right',
                                    rtl : true,
                                    labels: {
                                        legend: {
                                            pointStyle: 'circle',
                                            generateLabels(chart) {
                                                const dataset = chart.data.datasets[0];
                                                const meta = chart.getDatasetMeta(0);
                                                const total = meta.total;
                                                const legendItems = Chart.controllers.doughnut.overrides.plugins.legend.labels.generateLabels(chart);
                                                for (const item of legendItems) {
                                                    const value = dataset.data[item.index];
                                                    const percentage = value / total * 100
                                                    item.text = item.text + ': ' + value + ' / ' + percentage.toFixed(0) + '%';
                                                }
                                                return legendItems;
                                            }
                                        },
                                    }
                                },
                                title: {
                                    display: true,
                                    text
                                },
                            },
                        }
                    }else if (db.name == "staff_take_leave" || db.name == "staff_Training_by_branch") {
                        type = "bar";
                        data = db.name == "staff_take_leave" ? dataStaffTakeLeave : dataStaffTraining;
                        text = db.name == "staff_take_leave" ? 'Staff Take Leave' : 'Staff Training by Branch';
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

                    new Chart(db.name, {
                        type,
                        data,
                        options: option,
                        // plugins:[ChartDataLabels]
                    });
                });
            }
        });
    });
</script>
