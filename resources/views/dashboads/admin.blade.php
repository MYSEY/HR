@extends('layouts.master')
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
        <div class="row">
            <div class="col-md-6">
                <canvas id="myChart"  ></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="dddddd"  ></canvas>
            </div>
        </div>
    </div>
@endsection
@include('includs.script')
<script>
     $(function() {

        // const DATA_COUNT = 10;
        // const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

        const data = {
            labels: [
                'HQ',
                'HO',
                'ANS',
                'TKM',
                'KPB',
                'KPS',
                'SAB',
                'KTB',
                'Total',
            ],
            datasets: [
                {
                    label: 'Total',
                    data: [70, 31, 17, 17, 15, 15, 10, 10, 185],
                    backgroundColor:[
                        "rgba(255,0,0,0.6)"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: 'Female',
                    data: [30, 4, 3, 4, 4, 4, 3, 2, 54],
                    backgroundColor: [
                        "rgba(0, 153, 51)"
                    ],
                    stack: 'Stack 1',
                },
            ]
        };
        const dataAchive = {
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
            datasets: [
                {
                    label: 'Total Staff',
                    data: [31, 17, 17, 15, 15, 10, 10, 80],
                    backgroundColor:[
                        "rgba(255,0,0,0.6)"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: 'Current & Recruited 2023',
                    data: [4, 3, 4, 4, 4, 3, 2, 63],
                    backgroundColor: [
                        "rgb(255, 255, 0)"
                    ],
                    stack: 'Stack 1',
                },
            ]
        };
        new Chart("myChart", {
            type: 'bar',
            data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'HRMS Dashboards '
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
        });
        new Chart("dddddd", {
            type: 'bar',
            data: dataAchive,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: '% ACHIEVED BY BRANCHES '
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
        });
     });
</script>
