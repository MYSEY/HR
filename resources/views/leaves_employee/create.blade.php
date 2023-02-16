@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add Leave</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Leave</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="modal-content">
                    <div class="modal-body">
                        <form data-select2-id="select2-data-9-q2z8">
                            <div class="form-group" data-select2-id="select2-data-8-dsze">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select select2-hidden-accessible" data-select2-id="select2-data-1-llfk"
                                    tabindex="-1" aria-hidden="true">
                                    <option data-select2-id="select2-data-3-4kcu">Select Leave Type</option>
                                    <option data-select2-id="select2-data-10-dwsr">Casual Leave 12 Days</option>
                                    <option data-select2-id="select2-data-11-d85z">Medical Leave</option>
                                    <option data-select2-id="select2-data-12-swid">Loss of Pay</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Number of days <span class="text-danger">*</span></label>
                                <input class="form-control" readonly="" type="text">
                            </div>
                            <div class="form-group">
                                <label>Remaining Leaves <span class="text-danger">*</span></label>
                                <input class="form-control" readonly="" value="12" type="text">
                            </div>
                            <div class="form-group">
                                <label>Leave Reason</label>
                                <textarea rows="4" class="form-control"></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
