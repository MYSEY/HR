{{--  block chart board type bar --}}
<div class="row">
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="HRMS_dashboards"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="achived_by_branches"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
        <div class="card flex-fill">
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>@lang("lang.total_current_active_staff")</p>
                                <h3 id="total-staff-working"></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>@lang("lang.total_inactive_staff")</p>
                                <h3 id="total-resign-staff-resume"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            <div style="position: relative; display: table-cell; width:100%; text-align: -webkit-center;">
                <canvas id="staff_resignation" style="max-width:400px; max-height: 240px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <div style="position: relative; display: table-cell; width:100%; text-align: -webkit-center;">
                    <canvas id="reasons_staff_resignation"
                        style="max-width:400px; max-height: 300px;"class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  block chart board type bar --}}
<div class="row">
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="type_of_staff"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="staff_take_leave"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="staff_Training_by_branch_internal"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="staff_Training_by_branch_external"></canvas>
            </div>
        </div>
    </div>
</div>