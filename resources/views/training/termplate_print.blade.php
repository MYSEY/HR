<div id="print_purchase" hidden>
    <div class="card-header">
        {{-- logo company --}}
        <div style="margin-top: 10px">
            <img style="width:auto;height: 80px;"alt='White' id="image_logo_print"
                src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">&nbsp;&nbsp;
        </div>
        <div style="margin-top:-90px; text-align: center">
            <h3>@lang('lang.camma_microfinance_limited')</h3>
            <h3 class="payslip-title-center">{{$training->training_type == 1 ? "Internal" : "External" }} @lang('lang.training_report')</h3>
            <p class="payslip-title-center">@lang('lang.for')  &nbsp;
                <strong>
                    {{ \Carbon\Carbon::parse()->format('M-d-Y') ?? '' }}
                </strong>
            </p>
        </div>
        @if ($training->training_type == 1 )
            <div style="width: 35%">
                <label>@lang('lang.camma_microfinance_limited')</label>
                <span>#101A, St. 289, Sangkat Boeung Kak 1, Khan Toul Kork, Phnom Penh, Cambodia</span>
            </div><br>
        @endif
        <div style="display:flex;">
            <div style="width: 350%">
                <span><strong>@lang('lang.course_name'):</strong> {{$training->course_name}}</span><br>
                <span><strong>@lang('lang.start_date'):</strong>
                    {{ \Carbon\Carbon::parse($training->start_date)->format('d-M-Y') ?? '' }}
                </span><br>
                <span><strong>@lang('lang.end_date'):</strong>
                    {{ \Carbon\Carbon::parse($training->end_date)->format('d-M-Y') ?? '' }}
                </span>
            </div>
        </div>
        <span>
            @if ($training->training_type == 1 )
                <h4>@lang('lang.trainer_information')</h4>
                <table class="table-print">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('lang.type')</th>
                            <th>@lang('lang.name_kh')</th>
                            <th>@lang('lang.name_en')</th>
                            <th>@lang('lang.contact_number')</th>
                            <th>@lang('lang.email')</th>
                            <th>@lang('lang.created_at')</th>
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
            @else
                <br>
                <span><strong>@lang('lang.trainer_name'):</strong> {{count($trainer) > 0 ? $trainer[0]->name_en : ""}}</span><br>
                <span><strong>@lang('lang.company_name'):</strong> {{count($trainer) > 0 ? $trainer[0]->company_name : ""}} </span><br>
                <span><strong>@lang('lang.contact_number'):</strong> {{count($trainer) > 0 ? $trainer[0]->number_phone : ""}} </span><br>
                <span><strong>@lang('lang.email'):</strong> {{count($trainer) > 0 ? $trainer[0]->email : ""}}</span>
            @endif
        </span>
        <h4> @lang('lang.employees_information')</h4>
        <table class="table-print">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.id_card')</th>
                    <th>@lang('lang.name_kh')</th>
                    <th>@lang('lang.name_en')</th>
                    <th>@lang('lang.gender')</th>
                    <th>@lang('lang.position')</th>
                    <th>@lang('lang.location')</th>
                    <th>@lang('lang.date_of_employment')</th>
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