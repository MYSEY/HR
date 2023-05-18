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

{{-- block chart type pie --}}
<div class="row">
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <div style="position: relative; display: table-cell; width:100%; text-align: -webkit-center;">
                    <canvas id="staff_resignation" style="max-width:350px; max-height: 250px;"></canvas>
                </div>
                {{-- <div style="position: relative; display: table-cell; width:50%; vertical-align:middle">
                    <div id="status-legend" style="margin-left: 25%">
                        <div style="display:table">
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgba(0, 136, 204)">&nbsp;</span>&nbsp;HQ</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgba(255, 102, 0)">&nbsp;</span>&nbsp;HO</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(128,128,128)">&nbsp;</span>&nbsp;ANS</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(255, 204, 0)">&nbsp;</span>&nbsp;TKM</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(0, 136, 204)">&nbsp;</span>&nbsp;KPB</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(83, 198, 83)">&nbsp;</span>&nbsp;KPS</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(0, 51, 102)">&nbsp;</span>&nbsp;SAB</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(230, 115, 0)">&nbsp;</span>&nbsp;KTB</p>
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
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <div style="position: relative; display: table-cell; width:100%; text-align: -webkit-center;">
                    <canvas id="reasons_staff_resignation"
                        style="max-width:350px; max-height: 250px;"class="chartjs-render-monitor"></canvas>
                </div>
                {{-- <div style="position: relative; display: table-cell; width:50%; vertical-align:middle">
                    <div id="status-legend" style="margin-left: 25%">
                        <div style="display:table">
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgba(0, 136, 204)">&nbsp;</span>&nbsp;HQ</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgba(255, 102, 0)">&nbsp;</span>&nbsp;HO</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.0%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(128,128,128)">&nbsp;</span>&nbsp;ANS</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(255, 204, 0)">&nbsp;</span>&nbsp;TKM</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(0, 136, 204)">&nbsp;</span>&nbsp;KPB</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(83, 198, 83)">&nbsp;</span>&nbsp;KPS</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(0, 51, 102)">&nbsp;</span>&nbsp;SAB</p>
                                </div>
                                <div style="display: table-cell; padding-left:10px">
                                    <p class="legend-right legend-text">0 (0.00%)</p>
                                </div>
                            </div>
                            <div style="display: table-row" class="table_row">
                                <div style="display: table-cell">
                                    <p class="legend-left legend-text"><span class="legend-indicator"
                                            style="background-color:rgb(230, 115, 0)">&nbsp;</span>&nbsp;KTB</p>
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

<div class="row">
    <div class="col-md-6 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">New Staff</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap custom-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Card</th>
                                <th>Employee Name kh</th>
                                <th>Employee Name EN</th>
                                <th>Gender</th>
                                <th>Position</th>
                                <th>Dept/ Branch</th>
                                <th>Join Date</th>
                                <th>Rmark</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">230-0001</a>
                                </td>
                                <td>
                                    <h2><a href="#">Global</a></h2>
                                </td>
                                <td>Global Technologies</td>
                                <td>Male</td>
                                <td>ID DEVELOPER</td>
                                <td>11 Mar 2019</td>
                                <td>11 Mar 2019</td>
                                <td>ABC</td>
                                <td>
                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">230-0002</a>
                                </td>
                                <td>
                                    <h2><a href="#">Global</a></h2>
                                </td>
                                <td>Global Technologies</td>
                                <td>Male</td>
                                <td>ID DEVELOPER</td>
                                <td>11 Mar 2019</td>
                                <td>11 Mar 2019</td>
                                <td>ABC</td>
                                <td>
                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">230-0003</a>
                                </td>
                                <td>
                                    <h2><a href="#">Global</a></h2>
                                </td>
                                <td>Global Technologies</td>
                                <td>Male</td>
                                <td>ID DEVELOPER</td>
                                <td>11 Mar 2019</td>
                                <td>11 Mar 2019</td>
                                <td>ABC</td>
                                <td>
                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="https://smarthr.dreamguystech.com/laravel/template/public/invoices">View all invoices</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Resigned Staff</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table custom-table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Card</th>
                                <th>Employee Name kh</th>
                                <th>Employee Name EN</th>
                                <th>Gender</th>
                                <th>Position</th>
                                <th>Dept/ Branch</th>
                                <th>Join Date</th>
                                <th>Rmark</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">230-0001</a>
                                </td>
                                <td>
                                    <h2><a href="#">Global</a></h2>
                                </td>
                                <td>Global Technologies</td>
                                <td>Male</td>
                                <td>ID DEVELOPER</td>
                                <td>11 Mar 2019</td>
                                <td>11 Mar 2019</td>
                                <td>ABC</td>
                                <td>
                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">230-0002</a>
                                </td>
                                <td>
                                    <h2><a href="#">Global</a></h2>
                                </td>
                                <td>Global Technologies</td>
                                <td>Male</td>
                                <td>ID DEVELOPER</td>
                                <td>11 Mar 2019</td>
                                <td>11 Mar 2019</td>
                                <td>ABC</td>
                                <td>
                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">230-0003</a>
                                </td>
                                <td>
                                    <h2><a href="#">Global</a></h2>
                                </td>
                                <td>Global Technologies</td>
                                <td>Male</td>
                                <td>ID DEVELOPER</td>
                                <td>11 Mar 2019</td>
                                <td>11 Mar 2019</td>
                                <td>ABC</td>
                                <td>
                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="payments">View all payments</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Promoted Staff </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap custom-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Prev. Position</th>
                                <th>Curr. Position</th>
                                <th>Effective Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Global Technologies</td>
                                <td>TKM</td>
                                <td>Credit Officer</td>
                                <td>Senior Credit Officer</td>
                                <td>01-02-23</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Mrs. Keo Dany</td>
                                <td>KPB</td>
                                <td>Cleaner</td>
                                <td>Junior Credit Officer</td>
                                <td>01-03-23</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="https://smarthr.dreamguystech.com/laravel/template/public/invoices">View all invoices</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Transferred Staff</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table custom-table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th colspan="2" style="text-align: center">Location</th>
                                <th colspan="2" style="text-align: center">Position</th>
                                <th>Effective Date</th>
                              </tr>
                              <tr>
                                <th></th>
                                <th></th>
                                <th>Previous</th>
                                <th>Current</th>
                                <th>Previous</th>
                                <th>Current</th>
                                <th></th>
                              </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Global Technologies</td>
                                <td>KPS</td>
                                <td>HQ</td>
                                <td>Senior Credit Officer</td>
                                <td>Loan Recovery Officer</td>
                                <td>01-02-23</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Global Technologies</td>
                                <td>KPS</td>
                                <td>HQ</td>
                                <td>Senior Credit Officer</td>
                                <td>Loan Recovery Officer</td>
                                <td>01-02-23</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="payments">View all payments</a>
            </div>
        </div>
    </div>
</div>

{{--  block chart board type bar --}}
<div class="row">
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="staff_take_leave"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card dash-widget">
            <div class="card-body">
                <canvas id="staff_Training_by_branch"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h3 class="card-title mb-0">Training Report</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Client</th>
                                <th>Due Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0001</a>
                                </td>
                                <td>
                                    <h2><a href="#">Global Technologies</a></h2>
                                </td>
                                <td>11 Mar 2019</td>
                                <td>$380</td>
                                <td>
                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0002</a>
                                </td>
                                <td>
                                    <h2><a href="#">Delta Infotech</a></h2>
                                </td>
                                <td>8 Feb 2019</td>
                                <td>$500</td>
                                <td>
                                    <span class="badge bg-inverse-success">Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td><a
                                        href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0003</a>
                                </td>
                                <td>
                                    <h2><a href="#">Cream Inc</a></h2>
                                </td>
                                <td>23 Jan 2019</td>
                                <td>$60</td>
                                <td>
                                    <span class="badge bg-inverse-danger">Unpaid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="https://smarthr.dreamguystech.com/laravel/template/public/invoices">View all invoices</a>
            </div>
        </div>
    </div>
</div>