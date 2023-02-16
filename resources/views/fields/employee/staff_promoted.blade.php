<?php 
    $dataPosition = App\Models\Position::all();
    $dataDepartment = App\Models\Department::all();
    $data = App\Models\StaffPromoted::where('employee_id',$entry->id)->orderByDesc('id')->first();
?>
<div class="col-sm-12">
    <div class="row">
        <div class="col-md-12">
            <h1 class="navbar-brand custom-navbar-brand mb-0 text-uppercase rounded-top">
                <strong>Employee Promoted</strong>
            </h1>
            <div class="shadow-sm border p-3">
                <div class="row">
                    <input type="hidden" name="employee_id" value="{{$entry->id}}">
                    <input type="hidden" name="promotede" value="promotede">
                    @if ($data != null)
                        <div class="col-sm-4 col-md-4 mb-3">
                            <label>Posistion</label>
                            <select name="posit_id" class="form-control">
                                <option value="" selected>select position</option>
                                @foreach ($dataPosition as $item)
                                    <option value="{{$item->id}}" @if ($data->posit_id == $item->id) selected @endif>{{ $item->name_khmer }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="col-sm-4 col-md-4 mb-3">
                            <label>Posistion</label>
                            <select name="posit_id" class="form-control">
                                <option value="" selected>select position</option>
                                @foreach ($dataPosition as $item)
                                    <option value="{{$item->id}}" @if ($entry->position_id == $item->id) selected @endif>{{ $item->name_khmer }}</option>
                                @endforeach
                            </select>
                        </div> 
                    @endif

                    @if ($data != null)
                        <div class="col-sm-4 col-md-4 mb-3">
                            <label>Department</label>
                            <select name="depart_id" class="form-control">
                                <option value="" selected>select department</option>
                                @foreach ($dataDepartment as $item)
                                    <option value="{{$item->id}}" @if ($data->depart_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="col-sm-4 col-md-4 mb-3">
                            <label>Department</label>
                            <select name="depart_id" class="form-control">
                                <option value="" selected>select department</option>
                                @foreach ($dataDepartment as $item)
                                    <option value="{{$item->id}}" @if ($entry->department_id == $item->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if ($data != null)
                        <div class="col-sm-4 col-md-4 mb-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{$data->date}}">
                        </div>
                    @else
                        <div class="col-sm-4 col-md-4 mb-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{$data->date ?? ''}}">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>