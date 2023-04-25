@extends('layouts.master')
<style>
    .filter-row .btn {
        min-height: 44px !important;
        padding: 9px !important;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Payroll Report</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payroll Report</li>
                </ul>
            </div>
        </div>
    </div>
    @if (Auth::user()->RolePermission == 'Administrator')
        <form action="{{url('report/search')}}" method="POST">
            @csrf
            <div class="row filter-row"> 
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Employee name" value="{{old('employee_name')}}">
                        <label class="focus-label">Filter</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                            <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <button type="submit" class="btn btn-success w-100" data-dismiss="modal">Search</button>
                </div>
            </div>
        </form>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Profle: activate to sort column descending" style="width: 265.913px;">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Employee ID: activate to sort column ascending" style="width: 94.0625px;">Employee ID</th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Employee Name: activate to sort column descending" style="width: 178px;">Employee Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Department</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 125.15px;">Position</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending" style="width: 89.6px;">Start Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Joining Date: activate to sort column ascending" style="width: 89.6px;">End Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 51.475px;">Salary</th>
                                        <th class="text-center sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 55.5625px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if (count($users)>0)
                                        @foreach ($users as $item)
                                            <tr class="odd">
                                            </tr>
                                        @endforeach
                                    @endif --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
