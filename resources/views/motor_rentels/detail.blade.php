@extends('layouts.master')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Detail Motor rentel</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboad/employee') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Detail motor rentel</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    {{-- <button id="tast_print" type="button" class="btn btn-light btn-sm mb-0 border">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </button>&nbsp; --}}
                </div>
                <div class="col-auto float-end ms-auto">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-white" id="test-export"><a class="btn btn-info" href="{{ url('motor-rentel/export') }}">Export Excel File</a></button>
                        <button class="btn btn-white">PDF</button>
                        <button class="btn btn-white" id="tast_print"><i class="fa fa-print fa-lg"></i> Print</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        @if ($data->MotorEmployee->profile != null)
                                            <img alt="profile" src="{{ asset('/uploads/images/' .$data->MotorEmployee->profile) }}">
                                        @else
                                            <img alt="profile" src="{{ asset('admin/img/defuals/default-user-icon.png') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $data->MotorEmployee->employee_name_en }}</h3>
                                                <h6 class="text-muted">{{ $data->MotorEmployee->EmployeeDepartment }}</h6>
                                                <small class="text-muted">{{ $data->MotorEmployee->EmployeePosition }}</small>
                                                <div class="staff-id">Employee ID : {{ $data->MotorEmployee->number_employee }}</div>
                                                <div class="small doj text-muted">Date of Join : {{ $data->MotorEmployee->joinOfDate }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <label class="text">{{ $data->MotorEmployee->personal_phone_number }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <label class="text">{{ $data->MotorEmployee->email }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Birthday:</div>
                                                    <label class="text">{{ \Carbon\Carbon::parse($data->MotorEmployee->date_of_birth)->format('d-M-Y') ?? '' }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Gender:</div>
                                                    <label class="text">{{ $data->MotorEmployee->gender == 1 ? 'Male' : 'Female' }}</label>
                                                </li>
                                                <li>
                                                    <div class="title">Address:</div>
                                                    <label style="display: block;overflow: hidden;color: #888888;">{{ $data->MotorEmployee->FullCurrentAddress ?? '' }}</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Start Data</th>
                                        <th class="d-none d-sm-table-cell">End Date</th>
                                        <th>Year of manufature</th>
                                        <th>Expiretion year</th>
                                        <th class="text-end">Shelt life</th>
                                        <th class="text-end">Number plate</th>
                                        <th class="text-end">Total gasoline</th>
                                        <th class="text-end">Total working days</th>
                                        <th class="text-end">Total gasoline liters</th>
                                        <th class="text-end">Total price gasoline</th>
                                        <th class="text-end">Price engine oil</th>
                                        <th class="text-end">Price motor rentel</th>
                                        <th class="text-end">Tax Rate</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="start_date">{{$data->start_date}}</td>
                                        <td class="end_date">{{$data->end_date}}</td>
                                        <td class="product_year">{{$data->product_year}}</td>
                                        <td class="expired_year">{{$data->expired_year}}</td>
                                        <td class="shelt_life">{{$data->shelt_life}}</td>
                                        <td class="number_plate">{{$data->number_plate}}</td>
                                        <td class="total_gasoline">{{$data->total_gasoline}}</td>
                                        <td class="total_work_day">{{$data->total_work_day}}</td>

                                        <td >{{$data->total_gasoline * $data->total_work_day}}</td>
                                        <td >{{($data->total_gasoline * $data->total_work_day) * $data->gasoline_price_per_liter}} ៛</td>
                                        <td class="price_engine_oil">$ {{$data->price_engine_oil}}</td>
                                        <td class="price_motor_rentel">$ {{$data->price_motor_rentel}}</td>
                                        <td class="tax_rate">{{$data->tax_rate}}%</td>

                                        <td >$ {{$data->price_motor_rentel-(($data->price_motor_rentel * $data->tax_rate)/100)}}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="print_purchase" hidden>
        <div  class="card-header" style="color: #4747d1;">

            {{-- logo company --}}
            <div style="margin-top: 10px">
                <img style="width:auto;height: 80px;"alt='White' id="image_logo_print" src="{{ asset('/admin/img/logo/cammalogo.png') }}">&nbsp;&nbsp;
            </div>

            <div style="margin-top:-50px; margin-left:90px">
                <span style="font-size: 22px" class="print_company_name_kh" ></span><br>
                <span style="font-size: 22px" class="print_company_name_en"></span>
            </div>

            <div style="margin-left:75%" >
                <div style="margin-top:0px;">
                    <span id="">សក្ខីប័ណ្ណ / VOUCHER</span>
                </div>
            </div><br>
            <table class="table-a">
                <thead>
                    <tr>
                        <th colspan="3">
                            <span>បង់ទៅ/ទទួលពី</span><br>
                            <span style="font-size: 13px">Paid To / Received Form</span>
                        </th>
                    </tr>
                    <tr >
                        <th style="padding: 14px" colspan="3" class="print_received_one"></th>
                    </tr>
                    <tr>
                        <th style="padding: 5px" colspan="3">
                            <span>គោលបំណង់ប្រតិបត្តិការ</span><br>
                            <span style="font-size: 12px; font-family: 'Nunito','Nokora', sans-serif, serif;">Purpose of the Transaction</span>
                        </th>
                    </tr>
                </thead>
            </table>
            <div class="table-aaww" >
                <div class="dddd">
                    <span  class="print_mome_one sssss"></span>
                </div>
                
            </div>
            <span>
                <div class="one-font" style="border: 1px solid #0a0ab3; width:30%;
                     height: 190px; margin: auto; margin-top: -192px">
                    <div style="text-align: center; margin-top: 1%" class="mt-2">
                        <span><b> ប្រភេទសក្ខីប័ណ្ណ </b></span><br>
                        <span style="font-size: 13px">Voucher Type</span><br>
                    </div><br>
                    <div style=" font-size: 12px;" class="ml-3">
                        <div class="mt-2" style=" margin-left: 2%">
                            <input class="print_check_a" type="checkbox">&nbsp;<span>ទទួលប្រាក់ / Cash Receipt</span>
                        </div>
                        <div  class="mt-2" style=" margin-left: 2%">
                            <input class="print_check_b" type="checkbox">&nbsp;<span>ចេញប្រាក់ / Cash Disbursement</span>
                        </div>
                        <div class="mt-2" style=" margin-left: 2%">
                            <input class="print_check_c" type="checkbox">&nbsp;<span>ប្រាក់បើកមុន​ / Cash Advance</span>
                        </div>
                        <div class="mt-2" style=" margin-left: 2%">
                            <input class="print_check_d" type="checkbox">&nbsp;<span>កែតម្រូវ / Journal Entry / Adjustment</span>
                        </div>
                    </div>
                    
                </div>
            </span>

            <span>
                <table class="table_print">
                    <thead>
                        <tr>
                            <th style="padding: 1px !important" colspan="3">
                                <span>លេខរៀង</span><br>
                                <span style="font-size: 13px">Voucher No </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody_print">
                        <tr>
                            <td style="text-align: center; padding: 15px" colspan="3" class="in_number"> </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table_c">
                    <thead>
                        <tr>
                            <th style="padding: 6px" colspan="3">កាលបរិច្ឆេទ / Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:center; padding: 3px;">ថ្ងៃទី / Date</td>
                            <td style="text-align:center; padding: 3px; ">ខែ /​ Month</td>
                            <td style="text-align:center; padding: 3px;">ឆ្នាំ / Year</td>
                        </tr>
                        <tr>
                            <td style="text-align:center; padding: 0px;" class="day_one"></td>
                            <td style="text-align:center; padding: 0px;" class="month_one"></td>
                            <td style="text-align:center; padding: 0px;" class="year_one"></td>
                        </tr>
                    </tbody>
                </table>
            </span>
            
            <span>
                <table  style="margin-top: 14px" class="table-d print_table_one">
                    <thead >
                        <tr style="background: #4747d1; color:#ffffff">
                            <th>
                                <span>ឈ្មោះគណនី</span><br>
                                <span>Account Name</span> 
                            </th>
                            <th>
                                <span>ឈ្មោះគណនី</span><br>
                                <span>Account Code</span> 
                            </th>
                            <th>
                                <span>យោ</span><br>
                                <span>Reference</span>
                            </th>
                            <th>
                                <span>ឥណពន្ធ</span><br>
                                <span>Debit</span>
                            </th>
                            <th>
                                <span>ឥណទាន​</span><br>
                                <span>Credit</span>
                                 
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </span>
            <div style="margin-top:16px !important">
                <table class="table_dd">
                    <thead>
                        <tr>
                            <th class="remove_border_botton_print">រៀបចំដោយ / Perpared by:</th>
                            <th class="remove_border_botton_print">ត្រួតពិនិត្យដោយ / Reviewed by:</th>
                            <th class="remove_border_botton_print">អនុម័តដោយ /​ Approved by:</th>   
                            <th class="remove_border_botton_print">បញ្ជូលទិន្នន័យដោយ / Posted by:</th>   
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="remove_border_top_print" style="padding:60px"></td>
                            <td class="remove_border_top_print" ></td>
                            <td class="remove_border_top_print" ></td>
                            <td class="remove_border_top_print" ></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr style="border-top: 2px solid rgba(0,0,0,.1); ">
            <div style="margin-top:5px">
                <label for="">ព៌ណស / White : ផ្នែកហិរញ្ញវត្ថុ និង គណនេយ្យ / Finance and Accounting Record</label><br>
                <label for="">ព៌ណលឿង /​ Yellow : អ្នកបង់ប្រាក់ / Payee </label><br>
                <label for="">ព៌ណផ្កាឈូក / Pink : របាយការណ៍៍តាមផ្នែក / Department's Record </label>
            </div>
            
        </div>
    </div>

@endsection

@include('includs.script')

<script type="text/javascript" src="{{ asset('/admin/js/printThis.js')}}"></script>

<script type="text/javascript">
    $(function(){
        $("#tast_print").on("click", function(){
            print_pdf();
        });

        $("#test-export").on("click", function(){

        });
    });

    function print_pdf(type){
        $("#print_purchase").show();
        window.setTimeout(function() {
            $("#print_purchase").hide();
        },2000);
        $("#print_purchase").printThis(
            {     
            importCSS: false,            
            importStyle: true,         
            loadCSS: "/admin/css/style_table.css",     
            header:"",
            printDelay: 1000,               
            formValues: false,          
            canvas: false,              
            doctypeString: "",
        });
    }

</script>