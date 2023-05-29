@extends('layouts.master')
<style>
    .legend-indicator {
        font-size: 13px;
        font-family: Tahoma;
        padding-left: 12px;
        overflow: hidden;
        margin-right: 1px;
    }
    .table-transfer, th, td {
        border: 1px solid black;
        border-collapse: collapse;
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

        {{-- <div class="row filter-row">
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
        </div> --}}
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
        $.ajax({
            type: "GET",
            url: "{{ url('dashboad/show') }}",
            data: {
                "from_date": $("#from_date").val() ? $("#from_date").val() : null,
                "to_date":  $("#to_date").val() ?  $("#to_date").val() : null,
            },
            dataType: "JSON",
            success: function(response) {
                let dataHRMS = {
                    branches : response.branches,
                    employees : response.data,

                };
                let dataAchieve = {
                    branches : response.branches,
                    recruitmentPlans : response.recruitmentPlans,
                    achieveBranchs : response.achieveBranchs,
                }
                let datas ={
                    branches : response.branches,
                    employees : response.data,
                    staffResignations : response.staffResignations,
                }
                let dataStaffResign ={
                    branches: response.branches,
                    staffResignations: response.staffResignations,
                }
                let dataTable ={
                    employees: response.data,
                    transferred: response.transferred,
                    staffPromotes: response.staffPromotes,
                    dataTrainings: response.dataTrainings,
                }
                
                showDashboard(datas);
                dashbaordHRMS(dataHRMS);
                dashboadAchieveBranch(dataAchieve);
                dashboardStaffResign(dataStaffResign);
                dataTables(dataTable);
            }
        });
      

        // $("#btn-reseach").on("click", function() {
        //     let researchs = {
        //         "from_date": $("#from_date").val(),
        //         "to_date": $("#to_date").val()
        //     }
        //     showDashboard(researchs)
        // });

    });

    function dataTables(datas){
        if (datas.employees.length > 0) {
            var trNewStaff = "";
            var trResignStaff = "";
            let ns = 0;
            let rs = 0;
            $(datas.employees).each(function(e, row) {
                if (row.emp_status == "Probation") {
                    ns++;
                    if (ns <=5) {
                        let date_of_commencement = moment(row.date_of_commencement).format('D-MMM-YYYY')
                        trNewStaff += '<tr class="odd">' +
                            '<td>'+ (row.id) + '</td>' +
                            '<td class="number_employee_id">' + (row.number_employee) + '</a></td>' +
                            '<td>' + (row.employee_name_kh) + '</td>' +
                            '<td>' + (row.employee_name_en) + '</td>' +
                            '<td>' + (row.gender == null ? "" : row.gender.name_english) + '</td>' +
                            '<td>' + (row.position ? row.position.name_khmer : "") + '</td>' +
                            '<td>' + (row.branch ? row.branch.branch_name_en: "") + '</td>' +
                            '<td>' + (date_of_commencement) + '</td>' +
                            '<td>' + (row.remark ? row.remark : "") + '</td>' +
                            '</tr>';
                    }
                }else if (row.emp_status != "Probation" && row.emp_status != "1" && row.emp_status != "2") {
                    rs++;
                    if (rs <=5) {
                        let date_of_commencement = moment(row.date_of_commencement).format('D-MMM-YYYY')
                        let resign_date = moment(row.resign_date).format('D-MMM-YYYY')
                        trResignStaff += '<tr class="odd">' +
                            '<td>' + (row.id) + '</td>' +
                            '<td>' + (row.number_employee) + '</a></td>' +
                            '<td>' + (row.employee_name_kh) + '</td>' +
                            '<td>' + (row.employee_name_en) + '</td>' +
                            '<td>' + (row.gender == null ? "" : row.gender.name_english) + '</td>' +
                            '<td>' + (row.position ? row.position.name_khmer : "") + '</td>' +
                            '<td>' + (row.branch ? row.branch.branch_name_en: "") + '</td>' +
                            '<td>' + (date_of_commencement) + '</td>' +
                            '<td>' + (resign_date) + '</td>' +
                            '<td>' + (row.remark ? row.remark : "") + '</td>' +
                            '</tr>';
                    }
                }
            });
        } else {
            var trNewStaff = '<tr><td colspan=9 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
            var trResignStaff = '<tr><td colspan=9 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
        };
       
        if (datas.staffPromotes.length > 0) {
            var trSP = "";
            $(datas.staffPromotes).each(function(e, row) {
                let date = moment(row.date).format('D-MMM-YYYY')
                trSP += '<tr class="odd">' +
                    '<td>'+ (row.id) + '</td>' +
                    '<td>' + (row.employee.employee_name_en) + '</a></td>' +
                    '<td>' +(row.employee.branch.abbreviations)+ '</td>' +
                    '<td>' + (row.posit_id) + '</td>' +
                    '<td>' + (row.position_promoted_to) + '</td>' +
                    '<td>' + (date) + '</td>' +
                    '</tr>';
            });
        }else{
            var trSP = '<tr><td colspan=6 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
        }

        if (datas.transferred.length > 0) {
            var trST = "";
            let branch_name = "";
            let position_name = "";
            $(datas.transferred).each(function(e, row) {
                let date = moment(row.date).format('D-MMM-YYYY')
                trST += '<tr class="odd">' +
                    '<td>' + (row.employee.employee_name_en) + '</a></td>' +
                    '<td>' +(e == 0 ? row.employee.branch.abbreviations: branch_name)+ '</td>' +
                    '<td>' +(row.branch.abbreviations)+ '</td>' +
                    '<td>' +(e == 0 ? row.employee.position.name_khmer : position_name)+ '</td>' +
                    '<td>' +(row.position.name_khmer)+ '</td>' +
                    '<td>' + (date) + '</td>' +
                    '</tr>';
                branch_name = row.branch.abbreviations;
                position_name = row.position.name_khmer;
            });
        }else{
            var trST = '<tr><td colspan=6 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
        }

        if (datas.dataTrainings.length > 0) {
            var trT = "";
            $(datas.dataTrainings).each(function(e, row) {
              
                let start_date = moment(row.start_date).format('D-MMM-YYYY')
                let ent_date = moment(row.ent_date).format('D-MMM-YYYY')
                row.employees.map((em)=>{
                    console.log(em[0]);
                    trT += '<tr class="odd">' +
                        '<td>' + (em[0].id) + '</td>' +
                        '<td>' + (em[0].employee_name_kh) + '</td>' +
                        '<td>' + (em[0].employee_name_en) + '</td>' +
                        '<td>' + (em[0].gender ? em[0].gender.name_english: "") + '</td>' +
                        '<td>' +(em[0].position ? em[0].position.name_khmer: "")+ '</td>' +
                        '<td>' +(em[0].branch ? em[0].branch.abbreviations: "")+ '</td>' +
                        '<td>' +(row.training_type.type_name)+ '</td>' +
                        '<td>' + (start_date) + '</td>' +
                        '<td>' + (ent_date) + '</td>' +
                        '<td>' + (row.description) + '</td>' +
                        '</tr>';
                });
            });
        }else{
            var trT = '<tr><td colspan=10 align="center">ពុំមានទិន្នន័យសម្រាប់បង្ហាញ</td></tr>';
        }

        $(".table-new-staff tbody").html(trNewStaff);
        $(".table-resigned-staff tbody").html(trResignStaff);
        $(".table-staff-promote tbody").html(trSP);
        $(".table-staff-transferred tbody").html(trST);
        $(".table-training tbody").html(trT);
    }

    function showDashboard(data) {
        var deshboard = [
            // {
            //     "name": "staff_resignation"
            // },
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
        let dataEmployee = data.employees;
        let branches = data.branches;
        let totalEmployees = dataEmployee.length;
        let staffResignations = data.staffResignations;
        
        let labelStaffResignation = [];
        let staffResignationData = [];

        branches.map((br) => {
            let totalValue = 0;
            let totalFemale = 0;
            let totalValueStaffResignation = 0;
            let female = 0;

            // For block chart board Staff Resignation
            if (staffResignations.length > 0) {
                staffResignations.map((sta) => {
                    if (sta.branch_id == br.id) {
                        totalValueStaffResignation++;
                    }
                });
            }
            labelStaffResignation.push(br.abbreviations);
            staffResignationData.push(totalValueStaffResignation);
            
        });
        $.each(deshboard, function(i, db) {
            let text = "";
            let data = {};
            let type = "";
            let option = {};
            if (db.name == "reasons_staff_resignation") {
                type = "pie";
                // if (db.name == "staff_resignation") {
                //     dataStaffResignation.labels = labelStaffResignation;
                //     dataStaffResignation.datasets[0].data = staffResignationData;
                //     data = dataStaffResignation;
                //     text = '% Staff Resignation';
                // } else {
                    data = dataReasonStaffResignation;
                    text = '% Reasons of Staff Resignation';
                // }
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
            new Chart(db.name, dataChart);
        });
    }

    function dashbaordHRMS(datas){
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
        let dataEmployee = datas.employees;
        let branches = datas.branches;
        let totalEmployees = dataEmployee.length;
        let totalEmployeeFemale = 0;
        let labelsHRMS = [];
        let totalHRMSData = [];
        let totalHRMSFemale = [];
        
        branches.map((br) => {
            let totalValue = 0;
            let totalFemale = 0;
            let female = 0;
            if (dataEmployee.length > 0) {
                dataEmployee.map((em) => {
                    if (em.gender) {
                        if (em.gender.type == "gender" && em.gender.name_english == "Female") {
                            female++
                        }
                    }
                    if (em.branch_id == br.id) {
                        totalValue++;
                    }
                    if (em.gender) {
                        if (em.branch_id == br.id && em.gender.type == "gender" && em.gender.name_english == "Female") {
                            totalFemale++;
                        }
                    }
                })
            }
            totalEmployeeFemale = female;
            totalHRMSData.push(totalValue);
            totalHRMSFemale.push(totalFemale);
            labelsHRMS.push(br.abbreviations);
            
        });
        labelsHRMS.push('total');
        totalHRMSData.push(totalEmployees);
        totalHRMSFemale.push(totalEmployeeFemale);
        dataHRMSdashboards.labels = labelsHRMS;
        dataHRMSdashboards.datasets[0].data = totalHRMSData;
        dataHRMSdashboards.datasets[1].data = totalHRMSFemale;
        let option = {
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
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    align: 'center',
                },
                title: {
                    display: true,
                    text: "HRMS Dashboards"
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
        let dataChart = {
            type: 'bar',
            data: dataHRMSdashboards,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('HRMS_dashboards', dataChart);
    }

    function dashboadAchieveBranch(datas){
        let dataAchive = {
            datasets: [{
                    label: 'Total Staff',
                    data:[],
                    backgroundColor: [
                        "green"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: 'Current & Recruited 2023',
                    data:[],
                    backgroundColor: [
                        "yellow"
                    ],
                    stack: 'Stack 1',
                },
            ]
        };
        let branches = datas.branches;
        let labelAchive = [];
        let dataValueAchive = [];
        let dataValuePlanAchive = [];
        let dataValuePlanPercentage = [];
        let totalPlan = 0;
        let totalCurrentStaff = 0;
        if (datas.achieveBranchs.length > 0) {
            datas.achieveBranchs.map((ach) => {
                if (ach.branch.abbreviations !="HQ") {
                    totalCurrentStaff++;
                }
            })
        }
        if (datas.recruitmentPlans.length > 0) {
            datas.recruitmentPlans.map((plan) => {
                if (plan.branch.abbreviations !="HQ") {
                    totalPlan += plan.total_staff;
                }
            })
        }
        branches.map((br) => {
            if (br.abbreviations != "HQ") {
                let totalValueAchieve = 0;
                if (datas.achieveBranchs.length > 0) {
                    datas.achieveBranchs.map((ach) => {
                        if (ach.branch_id == br.id) {
                            totalValueAchieve++;
                        }
                    })
                }
                let totalValuePlanAchieveBybranch = 0;
                if (datas.recruitmentPlans.length > 0) {
                    datas.recruitmentPlans.map((plan) => {
                        if (plan.branch_id == br.id) {
                            totalValuePlanAchieveBybranch += plan.total_staff;
                        }
                    })
                }
                labelAchive.push(br.abbreviations);
                dataValueAchive.push(totalValueAchieve);
                dataValuePlanAchive.push(totalValuePlanAchieveBybranch);
                dataValuePlanPercentage.push((totalValueAchieve / totalValuePlanAchieveBybranch) *100)
            }
        });
        labelAchive.push('total');
        dataAchive.labels = labelAchive;
        dataValuePlanAchive.push(totalPlan);
        dataValueAchive.push(totalCurrentStaff)
        dataAchive.datasets[0].data = dataValuePlanAchive;
        dataAchive.datasets[1].data = dataValueAchive;

        let dataAchRed = [];
        dataAchive.datasets[0].data.map((da, index) => {
            if (da == 0) {
                dataAchRed.push(
                    0
                )
            }else{
                dataAchRed.push(
                    Math.round((dataAchive.datasets[1].data[index] / da) * 100)
                )
            }
           
        });
       
        dataAchive.datasets.push({
            label: '% Achivement',
            data: dataAchRed,
            backgroundColor: [
                "red"
            ],
            stack: 'Stack 2',
        })
        
        let option = {
            plugins: {
                // tooltip: {
                //             enabled: false
                //         },
                datalabels: {
                    events: [],
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    align: 'center',
                    _actives: false,
                    formatter: (value, context)=>{ 
                        if (context.chart.$datalabels._datasets[2]) {
                            return `${Math.round(value)}%`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: '% ACHIEVED BY BRANCHES'
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
        let dataChart = {
            type: 'bar',
            data: dataAchive,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('achived_by_branches', dataChart);
    }

    function dashboardStaffResign(datas){
        let branches = datas.branches;
        let staffResignations = datas.staffResignations;
        const dataStaffResignation = {
            labels:[],
            datasets: [{
                data: [],
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
        let labelStaffResignation = [];
        let staffResignationData = [];
        let date =  new Date();
        let year =  date.getFullYear();
        let month = date.getMonth();
        let totalMonth = monthDiff(new Date(year, 01), new Date(year, month+1))
        branches.map((br) => {
            let totalValue = 0;
            let totalFemale = 0;
            let totalValueStaffResignation = 0;
            let female = 0;
            if (staffResignations.length > 0) {
                staffResignations.map((sta) => {
                    if (sta.branch_id == br.id) {
                        totalValueStaffResignation++;
                    }
                });
            }
            labelStaffResignation.push(br.abbreviations);
            staffResignationData.push((totalValueStaffResignation / totalMonth) *100 );
        });
        let data = {};
        dataStaffResignation.labels = labelStaffResignation;
        dataStaffResignation.datasets[0].data = staffResignationData;
        data = dataStaffResignation;
        let option = {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    rtl: true,
                },
                datalabels: {
                    font: {
                        size: 10
                    },
                    align: 'center',
                    formatter: (value, context)=>{
                        return `${Math.round(value)}%`;
                    }
                },
                title: {
                    display: true,
                    text: '% Staff Resignation'
                },
            },
        }
        var myChart = null;
        let dataChart = {
            type: 'pie',
            data,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('staff_resignation', dataChart);
    }
    function monthDiff(dateFrom, dateTo) {
        return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
    }

</script>
