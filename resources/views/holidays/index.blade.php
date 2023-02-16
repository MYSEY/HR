@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Holidays</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Holidays</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_holiday"><i
                            class="fa fa-plus"></i> Add Holiday</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title </th>
                                <th>Holiday Date</th>
                                <th>Day</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="holiday-completed">
                                <td>1</td>
                                <td>New Year</td>
                                <td>1 Jan 2019</td>
                                <td>Sunday</td>
                                <td></td>
                            </tr>
                            <tr class="holiday-completed">
                                <td>2</td>
                                <td>Good Friday</td>
                                <td>14 Apr 2019</td>
                                <td>Friday</td>
                                <td></td>
                            </tr>
                            <tr class="holiday-completed">
                                <td>3</td>
                                <td>May Day</td>
                                <td>1 May 2019</td>
                                <td>Monday</td>
                                <td class="text-center">
                                </td>
                            </tr>
                            <tr class="holiday-completed">
                                <td>4</td>
                                <td>Memorial Day</td>
                                <td>28 May 2019</td>
                                <td>Monday</td>
                                <td class="text-center">
                                </td>
                            </tr>
                            <tr class="holiday-completed">
                                <td>5</td>
                                <td>Ramzon</td>
                                <td>26 Jun 2019</td>
                                <td>Monday</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal custom-modal fade" id="add_holiday" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Holiday</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Holiday Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>Holiday Date <span class="text-danger">*</span></label>
                                <div class="cal-icon"><input class="form-control datetimepicker" type="text">
                                </div>
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
