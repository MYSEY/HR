<div class="tab-pane fade" id="transferred" role="tabpanel">
    <div class="col-md-12 d-flex">
        <div class="card profile-box flex-fill">
            <div class="card-body">
                <h3 class="card-title">Transferred <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#TransferrendModal"><i class="fa fa-pencil"></i></a></h3>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Branch</th>
                                <th>Date</th>
                                <th>Descrition</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($transferred)>0)
                                @foreach ($transferred as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->BranchName}}</td>
                                        <td>{{$item->TransterDate}}</td>
                                        <td>{{$item->descrition}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="4" style="text-align: center">No record to display</td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="TransferrendModal" class="modal custom-modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/employee/transferred')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label>Branch<span class="text-danger">*</span></label>
                            <select class="select" id="branch_id" name="branch_id" required>
                                <option value="">Please selecte branch</option>
                                @if (count($branch)>0)
                                    @foreach ($branch as $item)
                                        <option value="{{$item->id}}">{{$item->branch_name_en}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Position<span class="text-danger">*</span></label>
                            <select class="select" id="position_id" name="position_id" required>
                                <option value="">Please selecte position</option>
                                @if (count($position)>0)
                                    @foreach ($position as $item)
                                        <option value="{{$item->id}}">{{$item->name_english}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Transferred Date</label>
                            <div class="cal-icon">
                                <input type="text" id="date" name="date" class="form-control datetimepicker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Descrition</label>
                            <textarea class="form-control" rows="4" spellcheck="false" id="descrition" name="descrition" style="position: relative;"></textarea>
                        </div>
                        <div class="submit-section">
                            <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}">
                            <button type="submit" class="btn btn-primary" id="bntEmpPromote">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>