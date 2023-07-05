@extends('layouts.master')
<style>
    .legend-indicator {
        font-size: 13px;
        font-family: Tahoma;
        padding-left: 12px;
        overflow: hidden;
        margin-right: 1px;
    }

    .table-transfer,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .card-detail {
        width: auto;
        height: 250px;
        overflow-y: scroll;
        display: flex;
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
            {{-- <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-new-staff"></h3>
                            <span>New Employees</span><a href="{{ url('/reports/new_staff-report') }}">View Detail</a>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-resigned-staff"></h3>
                           <a href="{{ url('/reports/staff-resigned-report') }}"> <span>Resigned Staff</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-promoted-staff"></h3>
                            <a href="{{ url('/reports/promoted-staff-report') }}"><span>Promoted Staff</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-transferred-staff"></h3>
                            <a href="{{ url('/reports/transferred-staff-report') }}"> <span>Transferred Staff</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-edit"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-training"></h3>
                            <a href="{{ url('/training/list') }}"><span>Training</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Employees</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Employee</p>
                                        <h3 id="total-staff"></h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Female</p>
                                        <h3 id="total-female"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100"><span id="percentage-interview"></span></div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 22%" aria-valuenow="18"
                                aria-valuemin="0" aria-valuemax="100"><span id="percantage-probation"></span></div>
                            <div class="progress-bar bg-text-info" role="progressbar" style="width: 24%" aria-valuenow="12"
                                aria-valuemin="0" aria-valuemax="100"><span id="percantage-fdc"></span></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14"
                                aria-valuemin="0" aria-valuemax="100"><span id="percantage-udc"></span></div>
                        </div>
                        <div>
                            <p><i class="fa fa-dot-circle-o text-purple me-2"></i>Up-Coming <span
                                    id="total-interview" class="float-end">0</span></p>
                            <p><i class="fa fa-dot-circle-o text-success me-2"></i>Probation <span
                                    id="total-probation" class="float-end">0</span></p>
                            <p><i class="fa fa-dot-circle-o text-info me-2"></i>FDC <span
                                    id="total-fdc" class="float-end">0</span></p>
                            <p><i class="fa fa-dot-circle-o text-danger me-2"></i>UDC <span
                                    id="total-udc" class="float-end">0</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill dash-statistics">
                    <div class="card-body">
                        <h5 class="card-title">Staff Age Range</h5>
                        <p><i class="fa fa-dot-circle-o text-info"></i> <span class="me-2">Age</span></p>
                        <div class="stats-list">
                            <div class="stats-info">
                                <p>18 - 24 <strong><small id="total-age-18"></small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" id="progressbar-18" aria-valuemin="0"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>25 - 44 <strong id="total-age-25">0</strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" id="progressbar-25" aria-valuemin="0"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>45 - 60 <strong id="total-age-45">0</strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                    id="progressbar-45" aria-valuemin="0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Birthday Reminder <span class="badge bg-inverse-danger ms-2" id="total-date-birthday">0</span></h4>
                        <div class="card-detail">
                            <div id="birthday-staff" style="width: -webkit-fill-available"></div>
                        </div>
                        <div class="load-more text-center" id="btn-more">
                            <a class="text-dark" href="{{ url('/users/birthday') }}">More</a>
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
                "to_date": $("#to_date").val() ? $("#to_date").val() : null,
            },
            dataType: "JSON",
            success: function(response) {
                let totalStaff = response.totalStaff;
                if (totalStaff.length > 0 ) {
                    let total_female = 0;
                    let total_probatio = 0;
                    let total_fdc = 0;
                    let total_udc = 0;
                    let total_age_18 = 0;
                    let total_age_25 = 0;
                    let total_age_45 = 0;
                    let total_date_birthday = 0;
                    let start_date = moment().format("MM-DD");
                    let ent_date = moment().add(14, "days").format("MM-DD");
                    let data_birthday =  [];
                    totalStaff.map((emp) =>{
                        if (emp.gender && emp.gender.name_english == "Female") {
                            total_female++;
                        } 
                        if (emp.emp_status == "Probation") {
                            total_probatio ++;
                        } 
                        if (emp.emp_status == "1") {
                            total_fdc++;
                        } 
                        if (emp.emp_status == "2") {
                            total_udc++;
                        }

                        let date = moment().diff(emp.date_of_birth, 'years',false);
                        if (date >= 18 && date <= 24) {
                            total_age_18++;
                        }
                        if (date >= 25 && date <= 44) {
                            total_age_25++;
                        }
                        if (date >= 45 && date <= 60) {
                            total_age_45++;
                        }

                        let date_birthday =  moment(emp.date_of_birth).format("MM-DD");
                        if (date_birthday >= start_date && date_birthday <= ent_date) {
                            data_birthday.push(emp);
                            total_date_birthday++;
                        }
                    });
                    if (total_date_birthday == 0) {
                        $("#btn-more").hide();
                    }
                    const sortedAsc = data_birthday.sort(
                        (objA, objB) => Number(moment(objA.date_of_birth).format("DD")) - Number(moment(objB.date_of_birth).format("DD")),
                    );
                    var div = ""; 
                    // var film = sortedAsc.filter((emp, idx) => idx < 3).map(emp => {
                    var film = sortedAsc.map(emp => {
                        let date_of_daymonth = moment(emp.date_of_birth).format("MM-DD");
                        let current_year = moment().format("YYYY");
                        let date_of_birth = moment(date_of_daymonth+'-'+current_year).format("D-MMM-YYYY");
                        div += '<div class="leave-info-box">'+
                                    '<div class="media d-flex align-items-center">'+
                                        '<a href="#" class="avatar">'+
                                            '<img alt="" id="profile-imge" src="{{asset("/uploads/images")}}/'+(emp.profile)+'">'+
                                        '</a>'+
                                        '<div class="media-body flex-grow-1">'+
                                            '<div class="text-sm my-0" >'+(emp.employee_name_en)+'</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row align-items-center mt-3">'+
                                        '<div class="col-6">'+
                                            '<h6 class="mb-0">'+(date_of_birth)+'</h6>'+
                                            '<span class="text-sm text-muted">Birthday</span>'+
                                        '</div>'+
                                        '<div class="col-6 text-end">'+
                                            '<span class="badge bg-inverse-danger">Happy Birthday</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                    });
                    
                    $("#birthday-staff").append(div);

                    $("#total-female").text(total_female);
                    $("#total-probation").text(total_probatio);
                    $("#total-fdc").text(total_fdc);
                    $("#total-udc").text(total_udc);
                    $("#percantage-probation").text(Math.round((total_probatio / totalStaff.length)*100)+"%");
                    $("#percantage-fdc").text(Math.round((total_fdc / totalStaff.length)*100)+"%");
                    $("#percantage-udc").text(Math.round((total_udc / totalStaff.length)*100)+"%");

                    $("#total-age-18").text(total_age_18);
                    $('#progressbar-18').attr('aria-valuenow', total_age_18).css('width', total_age_18+'%');
                    $('#progressbar-18').attr('aria-valuemax', totalStaff.length);

                    $("#total-age-25").text(total_age_25);
                    $('#progressbar-25').attr('aria-valuenow', total_age_25).css('width', total_age_25+'%');
                    $('#progressbar-25').attr('aria-valuemax', totalStaff.length);

                    $("#total-age-45").text(total_age_45);
                    $('#progressbar-45').attr('aria-valuenow', total_age_45).css('width', total_age_45+'%');
                    $('#progressbar-45').attr('aria-valuemax', totalStaff.length);

                    $('#total-date-birthday').text(total_date_birthday);
                }

                $("#total-staff").text(response.totalStaff.length);
                $("#total-resigned-staff").text(response.staffResignations.length);
                $("#total-promoted-staff").text(response.staffPromotes);
                $("#total-transferred-staff").text(response.transferred);
                
                $("#total-training").text(response.dataTrainings.length);

                let totalCandidateSignedContract = 0;
                if (response.candidateResumes.length > 0) {
                    response.candidateResumes.map((candi) =>{
                        if (candi.status == 4) {
                            totalCandidateSignedContract ++;
                        }
                    });
                }
                $("#total-interview").text(totalCandidateSignedContract);
                $("#percentage-interview").text(Math.round((totalCandidateSignedContract / response.candidateResumes.length) * 100, 2)+ "%");

                let dataHRMS = {
                    branches: response.branches,
                    employees: response.data,

                };
                let dataAchieve = {
                    branches: response.branches,
                    recruitmentPlans: response.recruitmentPlans,
                    achieveBranchs: response.achieveBranchs,
                }
                let datas = {
                    branches: response.branches,
                    employees: response.data,
                    staffResignations: response.staffResignations,
                }
                let dataStaffResign = {
                    branches: response.branches,
                    staffResignations: response.staffResignations,
                    employees: response.data,
                }
                let dataReasonStaff = {
                    options: response.options,
                    staffResignations: response.staffResignations,
                    totalEmployee: response.data.length,
                }
                let typeOfStaff = {
                    employee_position_type: response.totalStaff
                };

                let dataTraining = {
                    employeeTrainings: response.dataEmployeeTrainings.flat(1),
                    branches: response.branches,
                }
                showDashboard(datas);
                dashbaordHRMS(dataHRMS);
                dashboadAchieveBranch(dataAchieve);
                dashboardStaffResign(dataStaffResign);
                dascboardReasonOffStaff(dataReasonStaff);
                dashboardTypeOfStaff(typeOfStaff);
                dashboardTraining(dataTraining);
            }
        });
    });

    // Staff Take Leave
    function showDashboard(data) {
        var deshboard = [{
                "name": "staff_take_leave"
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

        $.each(deshboard, function(i, db) {
            let text = "";
            let data = {};
            let type = "";
            let option = {};
            if (db.name == "staff_take_leave") {
                type = "bar";
                data = db.name == "staff_take_leave" ? dataStaffTakeLeave : dataStaffTraining;
                text = 'Staff take leave';
                option = {
                    plugins: {
                        legend: {
                            display: false,
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

    function dashbaordHRMS(datas) {
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
                        if (em.branch_id == br.id && em.gender.type == "gender" && em.gender
                            .name_english == "Female") {
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

    function dashboadAchieveBranch(datas) {
        let dataAchive = {
            datasets: [{
                    label: 'Total Staff',
                    data: [],
                    backgroundColor: [
                        "green"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: 'Current & Recruited 2023',
                    data: [],
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
                if (ach.branch.abbreviations != "HQ") {
                    totalCurrentStaff++;
                }
            })
        }
        if (datas.recruitmentPlans.length > 0) {
            datas.recruitmentPlans.map((plan) => {
                if (plan.branch.abbreviations != "HQ") {
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
                dataValuePlanPercentage.push((totalValueAchieve / totalValuePlanAchieveBybranch) * 100)
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
            } else {
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
                    formatter: (value, context) => {
                        if (context.chart.$datalabels._datasets[2]) {
                            return `${Math.round(value)}%`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: '% Current number of Staff'
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

    function dashboardStaffResign(datas) {
        let branches = datas.branches;
        let staffResignations = datas.staffResignations;
        const dataStaffResignation = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    "rgba(0, 136, 204)",
                    "rgba(255, 102, 0)",
                    "rgb(128,128,128)",
                    "rgb(255, 204, 0)",
                    "#B22222",
                    "rgb(83, 198, 83)",
                    "rgb(0, 51, 102)",
                    "rgb(230, 115, 0)",
                ],
            }, ]
        };
        let labelStaffResignation = [];
        let staffResignationData = [];
        // let date = new Date();
        // let year = date.getFullYear();
        // let month = date.getMonth();
        // let totalMonth = monthDiff(new Date(year, 01), new Date(year, month + 1))
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
            let totalEmployee = 0;
            if(datas.employees.length > 0){
                datas.employees.map((emp)=>{
                    if(emp.branch_id == br.id){
                        totalEmployee += 1;
                    }
                });
            }
            labelStaffResignation.push(br.abbreviations);
            staffResignationData.push(totalValueStaffResignation == 0 ? 0 : (totalValueStaffResignation / totalEmployee) * 100);
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
                    formatter: (value, context) => {
                        return `${Math.round(value)}%`;
                    }
                },
                title: {
                    display: true,
                    text: '% Resign Staff Resume'
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

    function dascboardReasonOffStaff(datas) {
        let dataReasonStaffResignation = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    "rgba(0, 136, 204)",
                    "#9368e9",
                    "rgb(128,128,128)",
                    "rgb(255, 204, 0)",
                    "#B22222",
                    "rgb(83, 198, 83)",
                    "rgb(0, 51, 102)",
                    "rgb(230, 115, 0)",
                    "#FFA07A",
                    "#556B2F",
                    "#FF0000",
                ],
            }, ]
        };

        let options = datas.options;
        let staffResignations = datas.staffResignations;
        let totalStaffResign = datas.staffResignations.length;
        let labelStaffResignation = [];
        let staffResignationData = [];
        options.map((reason) => {
            let totalValueStaffResignation = 0;
            if (totalStaffResign > 0) {
                staffResignations.map((sta) => {
                    if (reason.id == sta.resign_reason) {
                        totalValueStaffResignation += 1;
                    }
                });
            }
            labelStaffResignation.push(reason.name_english);
            staffResignationData.push((totalValueStaffResignation / datas.totalEmployee) * 100);
        });
        if (totalStaffResign > 0) {
            let dataSumTermination = 0;
            let dataSumDeath = 0;
            let dataSumLayoff = 0;
            let dataSumSuspension = 0;
            let dataSumFallProbation = 0;
            staffResignations.map((sta) => {
                if (sta.emp_status == 4) {
                    dataSumTermination += 1;
                }
                if (sta.emp_status == 5) {
                    dataSumDeath += 1;
                }
                if (sta.emp_status == 7) {
                    dataSumLayoff += 1;
                }
                if (sta.emp_status == 8) {
                    dataSumSuspension += 1;
                }
                if (sta.emp_status == 9) {
                    dataSumFallProbation += 1;
                }
            });
            staffResignationData.push(dataSumTermination, dataSumDeath, dataSumLayoff, dataSumSuspension, dataSumFallProbation);
        }
        labelStaffResignation.push("Termination","Death","Lay off", "Suspension", "Fall Probation");
        dataReasonStaffResignation.labels = labelStaffResignation;
        dataReasonStaffResignation.datasets[0].data = staffResignationData;
        let data = dataReasonStaffResignation;
        let text = '% Reasons of Staff Resignation';
        let option = {
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
                    formatter: (value, context) => {
                        return `${Math.round(value)}%`;
                    }
                },
                title: {
                    display: true,
                    text
                },
            },
        }
        let dataChart = {
            type: "pie",
            data,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart("reasons_staff_resignation", dataChart);
    }

    function dashboardTypeOfStaff(datas) {
        let dataTypeStaff = {
            datasets: [
                {
                    label: '% Male',
                    data: [],
                    backgroundColor: [
                        "green"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: '% Female',
                    data: [],
                    backgroundColor: [
                        "LightGray"
                    ],
                    stack: 'Stack 1',
                },
            ]
        };

        let supporting = {
            male:0,
            female:0,
            total:0
        };
        let fieldStaff = {
            male:0,
            female:0,
            total:0
        };
        if (datas.employee_position_type.length > 0) {
            datas.employee_position_type.map((emp) => {
                if (emp.position_type == 1) {
                    if (emp.gender) {
                        if (emp.gender.name_english === "Male") {
                            supporting.male ++;
                        }
                        if (emp.gender.name_english =="Female") {
                            supporting.female ++;
                        }
                    }
                    supporting.total ++;
                }
                if (emp.position_type == 2) {
                    if (emp.gender) {
                        if (emp.gender.name_english === "Male") {
                            fieldStaff.male ++;
                        }
                        if (emp.gender.name_english =="Female") {
                            fieldStaff.female ++;
                        }
                    }
                    fieldStaff.total ++;
                }
            })
        }
        dataTypeStaff.labels = ['Supporting Staff','Field Staff','total'];
        dataTypeStaff.datasets[0].data = [
            (supporting.male / datas.employee_position_type.length)*100,
            ((fieldStaff.male / datas.employee_position_type.length)*100),
            (supporting.total / datas.employee_position_type.length)*100,
        ];
        dataTypeStaff.datasets[1].data = [
            (supporting.femal / datas.employee_position_type.length)*100,
            ((fieldStaff.female / datas.employee_position_type.length)*100),
            ((fieldStaff.total / datas.employee_position_type.length)*100),
        ];

        let dataTypeStaffRed = [
            (supporting.total / datas.employee_position_type.length)*100,
            (fieldStaff.total / datas.employee_position_type.length)*100,
            ((supporting.total + fieldStaff.total) / datas.employee_position_type.length)*100,
        ];
        dataTypeStaff.datasets.push(
            {
                label: 'Total',
                data: dataTypeStaffRed,
                backgroundColor: [
                    "red"
                ],
                stack: 'Stack 2',
            }
        )
        let option = {
            plugins: {
                legend: {
                    // display: true,
                    // position: 'bottom',
                    // rtl: true,
                },
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
                    formatter: (value, context) => {
                        return `${parseFloat(value).toFixed(2)}%`;
                    }
                },
                title: {
                    display: true,
                    text: '% Type of Staff'
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
            data: dataTypeStaff,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('type_of_staff', dataChart);
    }

    function dashboardTraining(datas){
        let dataStaffTraining = {
            labels: [],
            datasets: [{
                label: 'Total Staff',
                data: [],
                backgroundColor: [
                    "green"
                ],
                stack: 'Stack 0',
            }, ]
        };
        if (datas.branches.length > 0) {
            datas.branches.map((br) => {
                let totalValue = 0;
                if (datas.employeeTrainings.length > 0) {
                    datas.employeeTrainings.map((emp) => {
                        if (emp.branch_id == br.id) {
                            totalValue++;
                        }
                    })
                }
                dataStaffTraining.labels.push(br.abbreviations);
                dataStaffTraining.datasets[0].data.push(totalValue);
            });
        } 
        dataStaffTraining.labels.push("Total");
        dataStaffTraining.datasets[0].data.push(datas.employeeTrainings.length);
        let type = "bar";
        let data = dataStaffTraining;
        let text = 'Staff Training by Branch';
        let option = {
            plugins: {
                legend: {
                    display: false,
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
        let dataChart = {
            type,
            data,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('staff_Training_by_branch', dataChart);
    }

    function monthDiff(dateFrom, dateTo) {
        return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
    }
</script>
