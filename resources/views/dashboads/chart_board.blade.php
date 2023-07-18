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
                                <p>Total Current Active Staff</p>
                                <h3 id="total-staff-working"></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>Total Inactive Staff</p>
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
    {{-- <div class="col-md-6">
        <div class="card dash-widget">
            <div class="row">
                <div class="col-md-6 col-6 text-center">
                    <div class="stats-box mb-6">
                        <p>Total staff working</p>
                        <h3 id="total-staff">150</h3>
                    </div>
                </div>
                <div class="col-md-6 col-6 text-center">
                    <div class="stats-box mb-6">
                        <p>Total Resigned staff</p>
                        <h3 id="total-female">60</h3>
                    </div>
                </div>
            </div>
            <div style="position: relative; display: table-cell; width:100%; text-align: -webkit-center;">
                <canvas id="staff_resignation" style="max-width:400px; max-height: 270px;"></canvas>
            </div>
        </div>
    </div> --}}
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <div style="position: relative; display: table-cell; width:100%; text-align: -webkit-center;">
                    <canvas id="reasons_staff_resignation"
                        style="max-width:400px; max-height: 300px;"class="chartjs-render-monitor"></canvas>
                </div>
                {{-- <div style="position: relative; display: table-cell; width:40%; vertical-align:middle">
                    <div id="status-legend">
                        <div style="display:table">
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgba(0, 136, 204)">&nbsp;</span>&nbsp;មានការងារធ្វើថ្មី (Get now job)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgba(255, 102, 0)">&nbsp;</span>&nbsp;ធ្វើអាជីវកម្មផ្ទាល់ខ្លួន (Owner Business)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(128,128,128)">&nbsp;</span>&nbsp;ផ្លាស់ប្តូរទីតាំងរស់នៅ​ (Relocate Resident)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(255, 204, 0)">&nbsp;</span>&nbsp;បន្តការសិក្សា (Contiue stadies)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(0, 136, 204)">&nbsp;</span>&nbsp;បញ្ហាសុខភាព (Health Issue)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(83, 198, 83)">&nbsp;</span>&nbsp;គ្រួសារ (Fimaly)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(0, 51, 102)">&nbsp;</span>&nbsp;បណ្តេញចេញ​/បញ្ឈប់ពីការងារ​ (Misconducts)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(230, 115, 0)">&nbsp;</span>&nbsp;ការបន្លំលួច/ក្លែបន្លំ (Fraud)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(230, 115, 0)">&nbsp;</span>&nbsp;មរណះភាព (Death)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(230, 115, 0)">&nbsp;</span>&nbsp;ចូលនិវត្តន៏ (Retirement)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(230, 115, 0)">&nbsp;</span>&nbsp;ផ្សេងៗ (Others)</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
{{-- <div class="row">
    <div class="col-md-12 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Training Report</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap custom-table mb-0 table-training">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name Kh</th>
                                <th>Nane En</th>
                                <th>Gender</th>
                                <th>Position</th>
                                <th>Dept/Branch</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="#">View all</a>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="staff_Training_by_branch"></canvas>
            </div>
        </div>
    </div>
</div>