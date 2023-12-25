{{--  block chart board type bar --}}
<div class="row">
    <input type="text" hidden id="access_HRMS_dashboards" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_total_number_of_staff"]}}">
    <input type="text" hidden id="access_achived_by_branches" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_total_inactive_staff"]}}">
    <input type="text" hidden id="access_staff_resignation" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_resigned_staff"]}}">
    <input type="text" hidden id="access_reasons_staff_resignation" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_reasons_of_staff"]}}">
    <input type="text" hidden id="access_type_of_staff" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_ratio"]}}">
    <input type="text" hidden id="access_staff_take_leave" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_taking_leave"]}}">
    <input type="text" hidden id="access_staff_Training_by_branch_external" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_training_internal"]}}">
    <input type="text" hidden id="access_staff_Training_by_branch_internal" value="{{permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_training_external"]}}">
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_total_number_of_staff"] == "1")
        <div class="col-md-6">
            <div class="card dash-widget">
                <div class="card-body">
                    <canvas id="HRMS_dashboards"></canvas>
                </div>
            </div>
        </div>
    @endif
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_total_inactive_staff"] == "1")
        <div class="col-md-6">
            <div class="card dash-widget">
                <div class="card-body">
                    <canvas id="achived_by_branches"></canvas>
                </div>
            </div>
        </div>
    @endif
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_resigned_staff"] == "1")
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
    @endif
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_reasons_of_staff"] == "1")
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
    @endif
{{--  block chart board type bar --}}
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_ratio"] == "1")
        <div class="col-md-6">
            <div class="card dash-widget">
                <div class="card-body">
                    <canvas id="type_of_staff"></canvas>
                </div>
            </div>
        </div>
    @endif
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_taking_leave"] == "1")
        <div class="col-md-6">
            <div class="card dash-widget">
                <div class="card-body">
                    <canvas id="staff_take_leave"></canvas>
                </div>
            </div>
        </div>
    @endif
    
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_training_internal"] == "1")
        <div class="col-md-6">
            <div class="card dash-widget">
                <div class="card-body">
                    <canvas id="staff_Training_by_branch_external"></canvas>
                </div>
            </div>
        </div>
    @endif
    @if (permissionAccess("m1-s1","is_dashboard")->is_dashboard["is_staff_training_external"] == "1")
        <div class="col-md-6">
            <div class="card dash-widget">
                <div class="card-body">
                    <canvas id="staff_Training_by_branch_internal"></canvas>
                </div>
            </div>
        </div>
    @endif
</div>