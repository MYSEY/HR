<div id="print_purchase" hidden>
    <div class="card-header">
        {{-- logo company --}}
        <div style="margin-top: 10px">
            <img style="width:auto;height: 80px;"alt='White' id="image_logo_print"
                src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
        </div>

        <div style="margin-top:-75px; margin-left:243px">
            <h3 class="payslip-title-center">TRAINING DETAIL</h3>
            <p class="payslip-title-center">For monthly &nbsp;
                <strong>
                    {{ \Carbon\Carbon::parse()->format('M-Y') ?? '' }}
                </strong>
            </p>
        </div>
        <div style="width: 35%">
            <label>Camma Microfinance Limited</label>
            <span>#101A, St. 289, Sangkat Boeung Kak 1, Khan Toul Kork, Phnom Penh, Cambodia</span>
        </div><br>
        <div style="display:flex;">
            <div style="width: 350%">
                <span><strong>Training Type:</strong> {{$training->training_type == 1 ? "Internal" : "External" }}</span><br>
                <span><strong>Course name:</strong> {{$training->course_name}}</span><br>
                <span><strong>Time Duration:</strong>
                    {{ \Carbon\Carbon::parse($training->start_date)->format('d-M-Y') ?? '' }}
                    -
                    {{ \Carbon\Carbon::parse($training->end_date)->format('d-M-Y') ?? '' }}
                </span>
            </div>
        </div>
        <br>
        <span>
            <h3>Trainer</h3>
            <table class="print_table_training">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Name kh</th>
                        <th>Name EN</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($trainer) > 0)
                        @foreach ($trainer as $item)
                            <tr>
                                <td style="width: 5%">{{$item->id}}</td>
                                <td >{{$item->type == 1 ? "Internal" : "External"}}</td>
                                <td >{{$item->type == 1 ? $item->EmployeeIn->employee_name_kh : $item->name_kh}}</td>
                                <td >{{$item->type == 1 ? $item->EmployeeIn->employee_name_en : $item->name_en}}</td>
                                <td >{{$item->type == 1 ? $item->EmployeeIn->personal_phone_number : $item->number_phone}}</td>
                                <td >{{$item->type == 1 ? $item->EmployeeIn->email : $item->email}}</td>
                                <td >{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </span><br>
        <h3> Employees</h3>
        <table class="print_table_training">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Card</th>
                    <th>Name kh</th>
                    <th>Name EN</th>
                    <th>Gender</th>
                    <th>Position</th>
                    <th>Dept/ Branch</th>
                    <th>Join Date</th>
                </tr>
            </thead>
            <tbody>
                @if (count($employees) > 0)
                    @foreach ($employees as $item)
                        <tr>
                            <td style="width: 5%">{{$item->id}}</td>
                            <td >{{$item->number_employee}}</td>
                            <td >{{$item->employee_name_kh}}</td>
                            <td >{{$item->employee_name_en}}</td>
                            <td >{{$item->EmployeeGender}}</td>
                            <td >{{$item->EmployeePosition}}</td>
                            <td >{{$item->EmployeeBranch}}</td>
                            <td >{{ \Carbon\Carbon::parse($item->date_of_commencement)->format('d-M-Y') ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br>
        {{-- <div style="display: flex">
            <div class="payslip-title-center">
                <p style="text-align: center"><strong>Employer Signature</strong></p><br><br><br>
                <p>......... /............. /..........</p>
            </div>
            <div class="payslip-title-center" style="margin-left: 58%">
                <p style="text-align: center"><strong>Employee Signature</strong></p><br><br><br>
                <p>......... /............ /..........</p>
            </div>
        </div> --}}
    </div>
</div>