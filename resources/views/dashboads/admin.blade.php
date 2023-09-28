@extends('layouts.master')
<style>
    .legend-indicator {
        font-size: 13px;
        font-family: Tahoma;
        padding-left: 12px;
        overflow: hidden;
        margin-right: 1px;
    }

    .table-transfer,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .card-detail {
        width: auto;
        height: 250px;
        overflow-y: scroll;
        display: flex;
    }


    /* block style birthday */
    .balloon {
        /* width: 738px; */
        margin-top: -50px;
        /* margin: 0 auto; */
        /* padding-top: 30px; */
        position: relative;
    }
    .balloon > div {
        width: 20px;
        height: 30px;
        background: rgba(182, 15, 97, 0.9);
        border-radius: 0;
        border-radius: 80% 80% 80% 80%;
        margin: 0 auto;
        position: absolute;
        padding: 10px;
        box-shadow: inset 17px 7px 10px rgba(182, 15, 97, 0.9);
        -webkit-transform-origin: bottom center;
    }
    .balloon > div:nth-child(1) {
        background: rgba(182, 15, 97, 0.9);
        left: 0;
        box-shadow: inset 10px 10px 10px rgba(135, 11, 72, 0.9);
        -webkit-animation: balloon1 6s ease-in-out infinite;
        -moz-animation: balloon1 6s ease-in-out infinite;
        -o-animation: balloon1 6s ease-in-out infinite;
        animation: balloon1 6s ease-in-out infinite;
    }
    .balloon > div:nth-child(1):before {
        color: rgba(182, 15, 97, 0.9);
    }
    .balloon > div:nth-child(2) {
        background: rgba(242, 112, 45, 0.9);
        left: 22px;
        box-shadow: inset 10px 10px 10px rgba(222, 85, 14, 0.9);
        -webkit-animation: balloon2 6s ease-in-out infinite;
        -moz-animation: balloon2 6s ease-in-out infinite;
        -o-animation: balloon2 6s ease-in-out infinite;
        animation: balloon2 6s ease-in-out infinite;
    }
    .balloon > div:nth-child(2):before {
        color: rgba(242, 112, 45, 0.9);
    }
    .balloon > div:nth-child(3) {
        background: rgba(45, 181, 167, 0.9);
        left: 45px;
        box-shadow: inset 10px 10px 10px rgba(35, 140, 129, 0.9);
        -webkit-animation: balloon4 6s ease-in-out infinite;
        -moz-animation: balloon4 6s ease-in-out infinite;
        -o-animation: balloon4 6s ease-in-out infinite;
        animation: balloon4 6s ease-in-out infinite;
    }
    .balloon > div:nth-child(3):before {
        color: rgba(45, 181, 167, 0.9);
    }
    .balloon > div:nth-child(4) {
        background: rgba(190, 61, 244, 0.9);
        left: 63px;
        box-shadow: inset 10px 10px 10px rgba(173, 14, 240, 0.9);
        -webkit-animation: balloon1 5s ease-in-out infinite;
        -moz-animation: balloon1 5s ease-in-out infinite;
        -o-animation: balloon1 5s ease-in-out infinite;
        animation: balloon1 5s ease-in-out infinite;
    }
    .balloon > div:nth-child(4):before {
        color: rgba(190, 61, 244, 0.9);
    }
    .balloon > div:nth-child(5) {
        background: rgba(180, 224, 67, 0.9);
        left: 90px;
        box-shadow: inset 10px 10px 10px rgba(158, 206, 34, 0.9);
        -webkit-animation: balloon3 5s ease-in-out infinite;
        -moz-animation: balloon3 5s ease-in-out infinite;
        -o-animation: balloon3 5s ease-in-out infinite;
        animation: balloon3 5s ease-in-out infinite;
    }
    .balloon > div:nth-child(5):before {
        color: rgba(180, 224, 67, 0.9);
    }
    .balloon > div:nth-child(6) {
        background: rgba(242, 194, 58, 0.9);
        left: 105px;
        box-shadow: inset 10px 10px 10px rgba(234, 177, 15, 0.9);
        /* -webkit-animation: balloon2 3s ease-in-out infinite;
        -moz-animation: balloon2 3s ease-in-out infinite;
        -o-animation: balloon2 3s ease-in-out infinite;
        animation: balloon2 3s ease-in-out infinite; */
        -webkit-animation: balloon2 6s ease-in-out infinite;
        -moz-animation: balloon2 6s ease-in-out infinite;
        -o-animation: balloon2 6s ease-in-out infinite;
        animation: balloon2 6s ease-in-out infinite;
    }
    .balloon > div:nth-child(6):before {
        color: rgba(242, 194, 58, 0.9);
    }
    .balloon > div:before {
        color: rgba(182, 15, 97, 0.9);
        position: absolute;
        bottom: -30px;
        left: -1px;
        content:"▲";
        font-size: 1em;
    }
    .color-span {
        /* font-size: 4.8em; */
        color: white;
        position: relative;
        top: -5px;
        left: -5px
    }
    /*BALLOON 1 4*/
    @-webkit-keyframes balloon1 {
        0%, 100% {
            -webkit-transform: translateY(0) rotate(-6deg);
        }
        50% {
            -webkit-transform: translateY(-20px) rotate(8deg);
        }
    }
    @-moz-keyframes balloon1 {
        0%, 100% {
            -moz-transform: translateY(0) rotate(-6deg);
        }
        50% {
            -moz-transform: translateY(-20px) rotate(8deg);
        }
    }
    @-o-keyframes balloon1 {
        0%, 100% {
            -o-transform: translateY(0) rotate(-6deg);
        }
        50% {
            -o-transform: translateY(-20px) rotate(8deg);
        }
    }
    @keyframes balloon1 {
        0%, 100% {
            transform: translateY(0) rotate(-6deg);
        }
        50% {
            transform: translateY(-20px) rotate(8deg);
        }
    }
    /* BAllOON 2 5*/
    @-webkit-keyframes balloon2 {
        0%, 100% {
            -webkit-transform: translateY(0) rotate(6eg);
        }
        50% {
            -webkit-transform: translateY(-30px) rotate(-8deg);
        }
    }
    @-moz-keyframes balloon2 {
        0%, 100% {
            -moz-transform: translateY(0) rotate(6deg);
        }
        50% {
            -moz-transform: translateY(-30px) rotate(-8deg);
        }
    }
    @-o-keyframes balloon2 {
        0%, 100% {
            -o-transform: translateY(0) rotate(6deg);
        }
        50% {
            -o-transform: translateY(-30px) rotate(-8deg);
        }
    }
    @keyframes balloon2 {
        0%, 100% {
            transform: translateY(0) rotate(6deg);
        }
        50% {
            transform: translateY(-30px) rotate(-8deg);
        }
    }
    /* BAllOON 0*/
    @-webkit-keyframes balloon3 {
        0%, 100% {
            -webkit-transform: translate(0, -10px) rotate(6eg);
        }
        50% {
            -webkit-transform: translate(-20px, 30px) rotate(-8deg);
        }
    }
    @-moz-keyframes balloon3 {
        0%, 100% {
            -moz-transform: translate(0, -10px) rotate(6eg);
        }
        50% {
            -moz-transform: translate(-20px, 30px) rotate(-8deg);
        }
    }
    @-o-keyframes balloon3 {
        0%, 100% {
            -o-transform: translate(0, -10px) rotate(6eg);
        }
        50% {
            -o-transform: translate(-20px, 30px) rotate(-8deg);
        }
    }
    @keyframes balloon3 {
        0%, 100% {
            transform: translate(0, -10px) rotate(6eg);
        }
        50% {
            transform: translate(-20px, 30px) rotate(-8deg);
        }
    }
    /* BAllOON 3*/
    @-webkit-keyframes balloon4 {
        0%, 100% {
            -webkit-transform: translate(10px, -10px) rotate(-8eg);
        }
        50% {
            -webkit-transform: translate(-15px, 20px) rotate(10deg);
        }
    }
    @-moz-keyframes balloon4 {
        0%, 100% {
            -moz-transform: translate(10px, -10px) rotate(-8eg);
        }
        50% {
            -moz-transform: translate(-15px, 10px) rotate(10deg);
        }
    }
    @-o-keyframes balloon4 {
        0%, 100% {
            -o-transform: translate(10px, -10px) rotate(-8eg);
        }
        50% {
            -o-transform: translate(-15px, 10px) rotate(10deg);
        }
    }
    @keyframes balloon4 {
        0%, 100% {
            transform: translate(10px, -10px) rotate(-8eg);
        }
        50% {
            transform: translate(-15px, 10px) rotate(10deg);
        }
    }
</style>
@section('content')
    <div class="">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">@lang("lang.welcome") {{ Auth::user()->employee_name_en }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">@lang('lang.dashboard')</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-resigned-staff"></h3>
                           <a href="{{ url('/reports/staff-resigned-report') }}"> <span>@lang('lang.resigned_staff')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-promoted-staff"></h3>
                            <a href="{{ url('/reports/promoted-staff-report') }}"><span>@lang('lang.promoted_staff')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-transferred-staff"></h3>
                            <a href="{{ url('/reports/transferred-staff-report') }}"> <span>@lang('lang.transferred_staff')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-edit"></i></span>
                        <div class="dash-widget-info">
                            <h3 id="total-training"></h3>
                            <a href="{{ url('/training/list') }}"><span>@lang('lang.training')</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">@lang('lang.employee')</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>@lang('lang.total_employee')</p>
                                        <h3 id="total-staff"></h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>@lang('lang.total_female')</p>
                                        <h3 id="total-female"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100"><span id="percentage-interview"></span></div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 22%" aria-valuenow="18"
                                aria-valuemin="0" aria-valuemax="100"><span id="percantage-probation"></span></div>
                            <div class="progress-bar bg-text-info" role="progressbar" style="width: 24%" aria-valuenow="12"
                                aria-valuemin="0" aria-valuemax="100"><span id="percantage-fdc"></span></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14"
                                aria-valuemin="0" aria-valuemax="100"><span id="percantage-udc"></span></div>
                        </div>
                        <div>
                            <p><i class="fa fa-dot-circle-o text-purple me-2"></i>@lang('lang.up-coming')<span
                                    id="total-interview" class="float-end">0</span></p>
                            <p><i class="fa fa-dot-circle-o text-success me-2"></i>@lang('lang.probation')<span
                                    id="total-probation" class="float-end">0</span></p>
                            <p><i class="fa fa-dot-circle-o text-info me-2"></i>@lang('lang.fdc')<span
                                    id="total-fdc" class="float-end">0</span></p>
                            <p><i class="fa fa-dot-circle-o text-danger me-2"></i>@lang('lang.udc') <span
                                    id="total-udc" class="float-end">0</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill dash-statistics">
                    <div class="card-body">
                        <h5 class="card-title">@lang('lang.age_of_employee')</h5>
                        <p><i class="fa fa-dot-circle-o text-info"></i> <span class="me-2">@lang('lang.age')</span></p>
                        <div class="stats-list">
                            <div class="stats-info">
                                <p>18 - 24 <strong><small id="total-age-18"></small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" id="progressbar-18" aria-valuemin="0"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>25 - 44 <strong id="total-age-25">0</strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" id="progressbar-25" aria-valuemin="0"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>45 - 60 <strong id="total-age-45">0</strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                    id="progressbar-45" aria-valuemin="0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">@lang('lang.birthday_reminder') <span class="badge bg-inverse-danger ms-2" id="total-date-birthday">0</span></h4>
                        <div class="card-detail">
                            <div id="birthday-staff" style="width: -webkit-fill-available"></div>
                        </div>
                        <div class="load-more text-center" id="btn-more">
                            <a class="text-dark" href="{{ url('/users/birthday') }}">@lang('lang.more')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboads.chart_board')
        <?php 
            $userUpComming = Session::get('dataUpComming');
            $userProbation = Session::get('dataProbation');
            $ShortList = Session::get('dataShortList');
            $SignContract = Session::get('dataContract');
        ?>
        @if ($userUpComming || $userProbation || $ShortList || $SignContract)
            <div id="showNotyfication" class="modal custom-modal fade" style="display: none;" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                                    <section class="dash-section">
                                        <h1 class="dash-sec-title">TASK FOR TODAY</h1>
                                        <div class="dash-sec-content">
                                            @if ($ShortList)
                                                <div class="form-group">
                                                    <label for="" class="text-danger">Candidate CVs</label>
                                                    <div class="dash-info-list">
                                                        <div class="dash-card">
                                                            <div class="dash-card-container">
                                                                <div class="dash-card-icon">
                                                                    <i class="fa fa-user-plus"></i>
                                                                </div>
                                                                <div class="dash-card-content">
                                                                    <p>{{$ShortList}} People will be check short list <a href="{{url('/recruitment/candidate-resume/list')}}" target="_blank">link>></a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($SignContract)
                                                <div class="form-group">
                                                    <label for="" class="text-danger">Signature Contract</label>
                                                    <div class="dash-info-list">
                                                        <div class="dash-card">
                                                            <div class="dash-card-container">
                                                                <div class="dash-card-icon">
                                                                    <i class="fa fa-user-plus"></i>
                                                                </div>
                                                                <div class="dash-card-content">
                                                                    <p>{{$SignContract}} People will be signature contract today <a href="{{url('/recruitment/candidate-resume/list')}}" target="_blank">link>></a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($userUpComming)
                                                <div class="form-group">
                                                    <label for="" class="text-danger">Pleas change status upComing to probation</label>
                                                    <div class="dash-info-list">
                                                        <div class="dash-card">
                                                            <div class="dash-card-container">
                                                                <div class="dash-card-icon">
                                                                    <i class="fa fa-user-plus"></i>
                                                                </div>
                                                                <div class="dash-card-content">
                                                                    <p>{{$userUpComming}} People will be change to pass probation <a href="{{url('users')}}" target="_blank">link>></a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($userProbation)
                                               <div class="form-group">
                                                    <label for="" class="text-danger">Pleas change status probation to fdc</label>
                                                    <div class="dash-info-list">
                                                        <div class="dash-card">
                                                            <div class="dash-card-container">
                                                                <div class="dash-card-icon">
                                                                    <i class="fa fa-user-plus"></i>
                                                                </div>
                                                                <div class="dash-card-content">
                                                                    <p>{{$userProbation}} People will be change to employee <a href="{{url('users')}}" target="_blank">link>></a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                               </div>
                                            @endif
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <input type="hidden" id="" class="hidden" value="{{$userUpComming}}">
                            <input type="hidden" id="" class="hidden" value="{{$userProbation}}">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@include('includs.script')
<script>
    $(function() {
        $(".hidden").each(function(){
            if($(this).val()){ 
                $('#showNotyfication').modal('show');
            }
        });
        $.ajax({
            type: "GET",
            url: "{{ url('dashboad/show') }}",
            data: {
                "from_date": $("#from_date").val() ? $("#from_date").val() : null,
                "to_date": $("#to_date").val() ? $("#to_date").val() : null,
            },
            dataType: "JSON",
            success: function(response) {
                let totalStaff = response.totalStaff;
                if (totalStaff.length > 0 ) {
                    let total_female = 0;
                    let total_probatio = 0;
                    let total_fdc = 0;
                    let total_udc = 0;
                    let total_age_18 = 0;
                    let total_age_25 = 0;
                    let total_age_45 = 0;
                    let total_date_birthday = 0;
                    let start_date = moment().format("MM-DD");
                    let ent_date = moment().add(14, "days").format("MM-DD");
                    let data_birthday =  [];
                    totalStaff.map((emp) =>{
                        if (emp.gender && emp.gender.name_english == "Female") {
                            total_female++;
                        } 
                        if (emp.emp_status == "Probation") {
                            total_probatio ++;
                        } 
                        if (emp.emp_status == "1" || emp.emp_status == "10") {
                            total_fdc++;
                        }
                         
                        if (emp.emp_status == "2") {
                            total_udc++;
                        }

                        let date = moment().diff(emp.date_of_birth, 'years',false);
                        if (date >= 18 && date <= 24) {
                            total_age_18++;
                        }
                        if (date >= 25 && date <= 44) {
                            total_age_25++;
                        }
                        if (date >= 45 && date <= 60) {
                            total_age_45++;
                        }

                        let date_birthday =  moment(emp.date_of_birth).format("MM-DD");
                        if (date_birthday >= start_date && date_birthday <= ent_date) {
                            data_birthday.push(emp);
                            total_date_birthday++;
                        }
                    });
                    if (total_date_birthday == 0) {
                        $("#btn-more").hide();
                    }
                    const sortedAsc = data_birthday.sort(
                        (objA, objB) => Number(moment(objA.date_of_birth).format("DD")) - Number(moment(objB.date_of_birth).format("DD")),
                    );
                    var div = ""; 
                    // var film = sortedAsc.filter((emp, idx) => idx < 3).map(emp => {
                    var film = sortedAsc.map(emp => {
                        let date_of_daymonth = moment(emp.date_of_birth).format("MM-DD");
                        let current_year = moment().format("YYYY");
                        let date_of_birth = moment(date_of_daymonth+'-'+current_year).format("D-MMM-YYYY");
                        div += '<div class="leave-info-box">'+
                                    '<div class="media d-flex align-items-center">'+
                                        '<a href="#" class="avatar">'+
                                            '<img alt="" id="profile-imge" src="{{asset("/uploads/images")}}/'+(emp.profile)+'">'+
                                        '</a>'+
                                        '<div class="media-body flex-grow-1">'+
                                            '<div class="text-sm my-0" >'+(emp.employee_name_en)+'</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="row align-items-center mt-3">'+
                                        '<div class="col-6">'+
                                            '<h6 class="mb-0">'+(date_of_birth)+'</h6>'+
                                            '<span class="text-sm text-muted">@lang("lang.birthday")</span>'+
                                        '</div>'+
                                        '<div class="col-6 text-end">'+
                                            '<div>'+
                                                '<div class="balloon">'+
                                                    '<div><span class="color-span">☺</span> </div>'+
                                                    '<div><span class="color-span">B</span> </div>'+
                                                    '<div><span class="color-span">D</span> </div>'+
                                                    '<div><span class="color-span">A</span> </div>'+
                                                    '<div><span class="color-span">Y</span> </div>'+
                                                    '<div><span class="color-span">!</span> </div>'+
                                                '</div>'+
                                            '</div>'+
                                            // '<span class="badge bg-inverse-danger">Happy Birthday <i style="font-size: 25px" class="fa fa-birthday-cake" aria-hidden="true"></i></span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                    });
                    
                    $("#birthday-staff").append(div);

                    $("#total-female").text(total_female);
                    $("#total-probation").text(total_probatio);
                    $("#total-fdc").text(total_fdc);
                    $("#total-udc").text(total_udc);
                    $("#percantage-probation").text(Math.round((total_probatio / totalStaff.length)*100)+"%");
                    $("#percantage-fdc").text(Math.round((total_fdc / totalStaff.length)*100)+"%");
                    $("#percantage-udc").text(Math.round((total_udc / totalStaff.length)*100)+"%");

                    $("#total-age-18").text(total_age_18);
                    $('#progressbar-18').attr('aria-valuenow', total_age_18).css('width', total_age_18+'%');
                    $('#progressbar-18').attr('aria-valuemax', totalStaff.length);

                    $("#total-age-25").text(total_age_25);
                    $('#progressbar-25').attr('aria-valuenow', total_age_25).css('width', total_age_25+'%');
                    $('#progressbar-25').attr('aria-valuemax', totalStaff.length);

                    $("#total-age-45").text(total_age_45);
                    $('#progressbar-45').attr('aria-valuenow', total_age_45).css('width', total_age_45+'%');
                    $('#progressbar-45').attr('aria-valuemax', totalStaff.length);

                    $('#total-date-birthday').text(total_date_birthday);
                }

                $("#total-staff").text(response.totalStaff.length);
                $("#total-resigned-staff").text(response.staffResignations.length);
                $("#total-promoted-staff").text(response.staffPromotes);
                $("#total-transferred-staff").text(response.transferred);
                $("#total-staff-working").text(response.totalStaff.length);
                $("#total-resign-staff-resume").text(response.staffResignations.length);
                
                $("#total-training").text(response.dataTrainings.length);
                
                $("#total-interview").text(response.empUpcoming);
                $("#percentage-interview").text(Math.round((response.empUpcoming / (response.empUpcoming + response.candidateResumes)) * 100, 2)+ "%");

                let dataHRMS = {
                    branches: response.branches,
                    employees: response.data,

                };
                let dataAchieve = {
                    branches: response.branches,
                    recruitmentPlans: response.recruitmentPlans,
                    achieveBranchs: response.achieveBranchs,
                }
                let datas = {
                    branches: response.branches,
                    employees: response.data,
                    staffResignations: response.staffResignations,
                }
                let dataStaffResign = {
                    branches: response.branches,
                    staffResignations: response.staffResignations,
                    employees: response.data,
                }
                let dataReasonStaff = {
                    options: response.options,
                    staffResignations: response.staffResignations,
                    totalEmployee: response.data.length,
                }
                let typeOfStaff = {
                    employee_position_type: response.totalStaff,
                    position_type: response.position_type
                };

                const groupedTraining = response.dataEmployeeTrainings.reduce((train, training) => {
                const group = train[training.training_type] || [];
                    group.push(training);
                    train[training.training_type] = group;
                    return train;
                }, {});
                let dataTrainingInternal = {
                    employeeTrainings: groupedTraining[1] ? groupedTraining[1] : [],
                    branches: response.branches,
                }
                let dataTrainingExternal = {
                    // employeeTrainings: response.dataEmployeeTrainings.flat(1),
                    employeeTrainings: groupedTraining[2] ? groupedTraining[2] : [],
                    branches: response.branches,
                }
                showDashboard(datas);
                dashbaordHRMS(dataHRMS);
                dashboadAchieveBranch(dataAchieve);
                dashboardStaffResign(dataStaffResign);
                dascboardReasonOffStaff(dataReasonStaff);
                dashboardTypeOfStaff(typeOfStaff);
                dashboardTrainingInternal(dataTrainingInternal);
                dashboardTrainingExternal(dataTrainingExternal);
            }
        });
    });

    // Staff Take Leave
    function showDashboard(data) {
        var deshboard = [{
                "name": "staff_take_leave"
            },
        ];
        // for staff take leave
        const dataStaffTakeLeave = {
            labels: [
                'HO',
                'ANS',
                'TKM',
                'KPB',
                'KPS',
                'SAB',
                'KTB',
                'Total',
            ],
            datasets: [{
                label: 'Total Staff',
                data: [0, 0, 0, 0, 0, 0, 0, 0],
                backgroundColor: [
                    "red"
                ],
                stack: 'Stack 0',
            }, ]
        };

        // for staff training
        const dataStaffTraining = {
            labels: [
                'HO',
                'ANS',
                'TKM',
                'KPB',
                'KPS',
                'SAB',
                'KTB',
                'Total',
            ],
            datasets: [{
                label: 'Total Staff',
                data: [31, 17, 17, 15, 15, 10, 10, 80],
                backgroundColor: [
                    "green"
                ],
                stack: 'Stack 0',
            }, ]
        };

        $.each(deshboard, function(i, db) {
            let text = "@lang('lang.staff_taking_leave')";
            let data = {};
            let type = "";
            let option = {};
            if (db.name == "staff_take_leave") {
                type = "bar";
                data = db.name == "staff_take_leave" ? dataStaffTakeLeave : dataStaffTraining;
                option = {
                    plugins: {
                        legend: {
                            display: false,
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            font: {
                                weight: 'bold',
                                size: 10
                            },
                            align: 'center',
                        },
                        title: {
                            display: true,
                            text
                        },
                    },
                    responsive: true,
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            }
            var myChart = null;
            let dataChart = {
                type,
                data,
                options: option,
                plugins: [ChartDataLabels]
            }
            new Chart(db.name, dataChart);
        });
    }

    function dashbaordHRMS(datas) {
        const dataHRMSdashboards = {
            // labels: [],
            datasets: [{
                    label: '@lang("lang.total")',
                    data: [],
                    backgroundColor: [
                        "red"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: '@lang("lang.female")',
                    data: [],
                    backgroundColor: [
                        "green"
                    ],
                    stack: 'Stack 1',
                },
            ]
        };
        let dataEmployee = datas.employees;
        let branches = datas.branches;
        let totalEmployees = dataEmployee.length;
        let totalEmployeeFemale = 0;
        let labelsHRMS = [];
        let totalHRMSData = [];
        let totalHRMSFemale = [];

        branches.map((br) => {
            let totalValue = 0;
            let totalFemale = 0;
            let female = 0;
            if (dataEmployee.length > 0) {
                dataEmployee.map((em) => {
                    if (em.gender) {
                        if (em.gender.type == "gender" && em.gender.name_english == "Female") {
                            female++
                        }
                    }
                    if (em.branch_id == br.id) {
                        totalValue++;
                    }
                    if (em.gender) {
                        if (em.branch_id == br.id && em.gender.type == "gender" && em.gender
                            .name_english == "Female") {
                            totalFemale++;
                        }
                    }
                })
            }
            totalEmployeeFemale = female;
            totalHRMSData.push(totalValue);
            totalHRMSFemale.push(totalFemale);
            labelsHRMS.push(br.abbreviations);

        });
        labelsHRMS.push('total');
        totalHRMSData.push(totalEmployees);
        totalHRMSFemale.push(totalEmployeeFemale);
        dataHRMSdashboards.labels = labelsHRMS;
        dataHRMSdashboards.datasets[0].data = totalHRMSData;
        dataHRMSdashboards.datasets[1].data = totalHRMSFemale;
        let option = {
            plugins: {
                legend: {
                    labels: {
                        render: 'percentage',
                        precision: 2,
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    align: 'center',
                },
                title: {
                    display: true,
                    text: "@lang('lang.total_number_of_staff')"
                },

            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    beginAtZero: true,
                    stacked: true
                }
            }
        }
        let dataChart = {
            type: 'bar',
            data: dataHRMSdashboards,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('HRMS_dashboards', dataChart);
    }

    function dashboadAchieveBranch(datas) {
        var date = new Date();
        let currenYear = date.getFullYear();
        let dataAchive = {
            datasets: [{
                    label: '@lang("lang.total_staff")',
                    data: [],
                    backgroundColor: [
                        "green"
                    ],
                    stack: 'Stack 0',
                },
                {
                    label: '@lang("lang.current") @lang("lang.&") @lang("lang.recruited") ' + currenYear,
                    data: [],
                    backgroundColor: [
                        "yellow"
                    ],
                    stack: 'Stack 1',
                },
            ]
        };
        let branches = datas.branches;
        let labelAchive = [];
        let dataValueAchive = [];
        let dataValuePlanAchive = [];
        let dataValuePlanPercentage = [];
        let totalPlan = 0;
        let totalCurrentStaff = 0;
        if (datas.achieveBranchs.length > 0) {
            datas.achieveBranchs.map((ach) => {
                if (ach.branch.abbreviations != "HQ") {
                    totalCurrentStaff++;
                }
            })
        }
        if (datas.recruitmentPlans.length > 0) {
            datas.recruitmentPlans.map((plan) => {
                if (plan.branch.abbreviations != "HQ") {
                    totalPlan += plan.total_staff;
                }
            })
        }
        branches.map((br) => {
            if (br.abbreviations != "HQ") {
                let totalValueAchieve = 0;
                if (datas.achieveBranchs.length > 0) {
                    datas.achieveBranchs.map((ach) => {
                        if (ach.branch_id == br.id) {
                            totalValueAchieve++;
                        }
                    })
                }
                let totalValuePlanAchieveBybranch = 0;
                if (datas.recruitmentPlans.length > 0) {
                    datas.recruitmentPlans.map((plan) => {
                        if (plan.branch_id == br.id) {
                            totalValuePlanAchieveBybranch += plan.total_staff;
                        }
                    })
                }
                labelAchive.push(br.abbreviations);
                dataValueAchive.push(totalValueAchieve);
                dataValuePlanAchive.push(totalValuePlanAchieveBybranch);
                dataValuePlanPercentage.push((totalValueAchieve / totalValuePlanAchieveBybranch) * 100)
            }
        });
        labelAchive.push('total');
        dataAchive.labels = labelAchive;
        dataValuePlanAchive.push(totalPlan);
        dataValueAchive.push(totalCurrentStaff)
        dataAchive.datasets[0].data = dataValuePlanAchive;
        dataAchive.datasets[1].data = dataValueAchive;

        let dataAchRed = [];
        dataAchive.datasets[0].data.map((da, index) => {
            if (da == 0) {
                dataAchRed.push(
                    0
                )
            } else {
                dataAchRed.push(
                    Math.round((dataAchive.datasets[1].data[index] / da) * 100)
                )
            }

        });

        dataAchive.datasets.push({
            label: '% @lang("lang.achivement")',
            data: dataAchRed,
            backgroundColor: [
                "red"
            ],
            stack: 'Stack 2',
        })

        let option = {
            plugins: {
                // tooltip: {
                //             enabled: false
                //         },
                datalabels: {
                    events: [],
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    align: 'center',
                    _actives: false,
                    formatter: (value, context) => {
                        if (context.chart.$datalabels._datasets[2]) {
                            return `${Math.round(value)}%`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: '% @lang("lang.total_inactive_staff")'
                },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    beginAtZero: true,
                    stacked: true
                }
            }
        }
        let dataChart = {
            type: 'bar',
            data: dataAchive,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('achived_by_branches', dataChart);
    }

    function dashboardStaffResign(datas) {
        let branches = datas.branches;
        let staffResignations = datas.staffResignations;
        const dataStaffResignation = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    "rgba(0, 136, 204)",
                    "rgba(255, 102, 0)",
                    "rgb(128,128,128)",
                    "rgb(255, 204, 0)",
                    "#B22222",
                    "rgb(83, 198, 83)",
                    "rgb(0, 51, 102)",
                    "rgb(230, 115, 0)",
                ],
            }, ]
        };
        let labelStaffResignation = [];
        let staffResignationData = [];
        // let date = new Date();
        // let year = date.getFullYear();
        // let month = date.getMonth();
        // let totalMonth = monthDiff(new Date(year, 01), new Date(year, month + 1))
        branches.map((br) => {
            let totalValue = 0;
            let totalFemale = 0;
            let totalValueStaffResignation = 0;
            let female = 0;
            if (staffResignations.length > 0) {
                staffResignations.map((sta) => {
                    if (sta.branch_id == br.id) {
                        totalValueStaffResignation++;
                    }
                });
            }
            let totalEmployee = 0;
            if(datas.employees.length > 0){
                datas.employees.map((emp)=>{
                    if(emp.branch_id == br.id){
                        totalEmployee += 1;
                    }
                });
            }
            labelStaffResignation.push(br.abbreviations);
            staffResignationData.push(totalValueStaffResignation == 0 ? 0 : (totalValueStaffResignation / totalEmployee) * 100);
        });
        let data = {};
        dataStaffResignation.labels = labelStaffResignation;
        dataStaffResignation.datasets[0].data = staffResignationData;
        data = dataStaffResignation;
        let option = {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    rtl: true,
                },
                datalabels: {
                    font: {
                        size: 10
                    },
                    align: 'center',
                    formatter: (value, context) => {
                        return `${Math.round(value)}%`;
                    }
                },
                title: {
                    display: true,
                    text: '% @lang("lang.resigned_staff")'
                },
            },
        }
        var myChart = null;
        let dataChart = {
            type: 'pie',
            data,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('staff_resignation', dataChart);
    }

    function dascboardReasonOffStaff(datas) {
        let dataReasonStaffResignation = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    "rgba(0, 136, 204)",
                    "#9368e9",
                    "rgb(128,128,128)",
                    "rgb(255, 204, 0)",
                    "#B22222",
                    "rgb(83, 198, 83)",
                    "rgb(0, 51, 102)",
                    "rgb(230, 115, 0)",
                    "#FFA07A",
                    "#556B2F",
                    "#FF0000",
                ],
            }, ]
        };

        let options = datas.options;
        let staffResignations = datas.staffResignations;
        let totalStaffResign = datas.staffResignations.length;
        let labelStaffResignation = [];
        let staffResignationData = [];
        options.map((reason) => {
            let totalValueStaffResignation = 0;
            if (totalStaffResign > 0) {
                staffResignations.map((sta) => {
                    if (reason.id == sta.resign_reason) {
                        totalValueStaffResignation += 1;
                    }
                });
            }
            var localeLanguage = '{{ config('app.locale') }}';
            if (localeLanguage == 'en') {
                labelStaffResignation.push(reason.name_english);
            } else {
                labelStaffResignation.push(reason.name_khmer);
            }
            staffResignationData.push((totalValueStaffResignation / datas.totalEmployee) * 100);
        });
        if (totalStaffResign > 0) {
            let dataSumTermination = 0;
            let dataSumDeath = 0;
            let dataSumLayoff = 0;
            let dataSumSuspension = 0;
            let dataSumFallProbation = 0;
            staffResignations.map((sta) => {
                if (sta.emp_status == 4) {
                    dataSumTermination += 1;
                }
                if (sta.emp_status == 5) {
                    dataSumDeath += 1;
                }
                if (sta.emp_status == 7) {
                    dataSumLayoff += 1;
                }
                if (sta.emp_status == 8) {
                    dataSumSuspension += 1;
                }
                if (sta.emp_status == 9) {
                    dataSumFallProbation += 1;
                }
            });
            staffResignationData.push(dataSumTermination, dataSumDeath, dataSumLayoff, dataSumSuspension, dataSumFallProbation);
        }
        // labelStaffResignation.push("Termination","Death","Lay Off", "No need to input", "Failed Probation");
        dataReasonStaffResignation.labels = labelStaffResignation;
        dataReasonStaffResignation.datasets[0].data = staffResignationData;
        let data = dataReasonStaffResignation;
        let text = "% @lang('lang.reasons_of_staff’s_exit')";
        let option = {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    rtl: true,
                },
                // tooltip: {
                //     enabled: false
                // },
                datalabels: {
                    font: {
                        size: 10
                    },
                    align: 'center',
                    formatter: (value, context) => {
                        return `${Math.round(value)}%`;
                    }
                },
                title: {
                    display: true,
                    text
                },
            },
        }
        let dataChart = {
            type: "pie",
            data,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart("reasons_staff_resignation", dataChart);
    }

    function dashboardTypeOfStaff(datas) {
        var localeLanguage = '{{ config('app.locale') }}';
        let dataTypeStaff = {
            datasets: [
            ]
        };

        let type_labels = [];
        let datasets = [];
        let data_value = [];
        datas.position_type.map((position, index) => {
            if (position.type ==  "position_type") {
                let male = 0;
                let female = 0;
                let total = 0;
                if (datas.employee_position_type.length > 0) {
                    datas.employee_position_type.map((emp) => {
                        if (position.id == emp.position_type) {
                            if (emp.gender) {
                                if (emp.gender.name_english === "Male") {
                                    male ++;
                                }
                                if (emp.gender.name_english =="Female") {
                                    female ++;
                                }
                            }
                            total ++;
                        }
                    })
                }
                
                data_value.push({
                    male,
                    female,
                    total,
                    name_english: position.name_english
                });
                if (localeLanguage == 'en') {
                    type_labels.push(position.name_english);
                } else {
                    type_labels.push(position.name_khmer);
                }
            }
            if (position.type ==  "gender") {
                if (localeLanguage == 'en') {
                    dataTypeStaff.datasets.push(
                        {
                            label: '% '+position.name_english,
                        },
                    )
                } else {
                    dataTypeStaff.datasets.push(
                        {
                            label: '% '+position.name_khmer,
                        },
                    )
                }
            }  
        });
        dataTypeStaff.datasets[0].backgroundColor = ["green"];
        dataTypeStaff.datasets[0].stack = 'Stack 0';
        dataTypeStaff.datasets[0].data = [];
        dataTypeStaff.datasets[1].backgroundColor = ["LightGray"];
        dataTypeStaff.datasets[1].stack = 'Stack 1';
        dataTypeStaff.datasets[1].data = [];
    
        if (localeLanguage == 'en') {
            type_labels.push('total')
        } else {
            type_labels.push('សរុប')
        }
        dataTypeStaff.labels = type_labels;
        dataTypeStaff.datasets[0].data = [
            (data_value[0].male / datas.employee_position_type.length) * 100,
            (data_value[1].male / datas.employee_position_type.length) * 100,
            ((data_value[0].male + data_value[1].male) / datas.employee_position_type.length) * 100,
        ];
        dataTypeStaff.datasets[1].data= [
            (data_value[0].female / datas.employee_position_type.length) * 100,
            (data_value[1].female / datas.employee_position_type.length) * 100,
            ((data_value[0].female + data_value[1].female) / datas.employee_position_type.length) * 100,
        ];
        let dataTypeStaffRed = [
            (data_value[0].total / datas.employee_position_type.length) * 100,
            (data_value[1].total / datas.employee_position_type.length) * 100,
            ((data_value[0].total + data_value[1].total) / datas.employee_position_type.length) * 100,
        ];
        dataTypeStaff.datasets.push(
            {
                label: '@lang("lang.total")',
                data: dataTypeStaffRed,
                backgroundColor: [
                    "red"
                ],
                stack: 'Stack 2',
            }
        )
        let option = {
            plugins: {
                legend: {
                    // display: true,
                    // position: 'bottom',
                    // rtl: true,
                },
                datalabels: {
                    events: [],
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    align: 'center',
                    _actives: false,
                    formatter: (value, context) => {
                        return `${parseFloat(value).toFixed(2)}%`;
                    }
                },
                title: {
                    display: true,
                    text: '% @lang("lang.staff_ratio")'
                },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    beginAtZero: true,
                    stacked: true
                }
            }
        }
        let dataChart = {
            type: 'bar',
            data: dataTypeStaff,
            options: option,
            plugins: [ChartDataLabels]
        }
        new Chart('type_of_staff', dataChart);
    }

    function dashboardTrainingInternal(datas){
        let dataStaffTraining = {
            labels: [],
            datasets: [{
                label: '@lang("lang.total_staff")',
                data: [],
                backgroundColor: [
                    "green"
                ],
                stack: 'Stack 0',
            }, ]
        };
        if (datas.branches.length > 0) {
            let trainingInternal = [];
            if (datas.employeeTrainings.length > 0) {
                trainingInternal = mergeEmployeeArrays(datas.employeeTrainings);
            }
            datas.branches.map((br) => {
                let  totalValueInternal = 0;
                if (datas.employeeTrainings.length > 0) {
                    trainingInternal.map((emp) => {
                        if (emp.branch_id == br.id) {
                            totalValueInternal++;
                        }
                    });

                }
                dataStaffTraining.labels.push(br.abbreviations);
                dataStaffTraining.datasets[0].data.push(totalValueInternal);
            });
            dataStaffTraining.labels.push("Total");
            dataStaffTraining.datasets[0].data.push(trainingInternal.length);
        } 
       
        let optionInternal = {
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    align: 'center',
                },
                title: {
                    display: true,
                    text: "@lang('lang.staff_training_by_branch_internal')"
                },
            },
            responsive: true,
            interaction: {
                intersect: false,
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        }
        let dataChartInternal = {
            type: "bar",
            data: dataStaffTraining,
            options: optionInternal,
            plugins: [ChartDataLabels]
        }
        new Chart('staff_Training_by_branch_internal', dataChartInternal);
    }

    function dashboardTrainingExternal(datas){
        let dataStaffTraining = {
            labels: [],
            datasets: [{
                label: '@lang("lang.total_staff")',
                data: [],
                backgroundColor: [
                    "green"
                ],
                stack: 'Stack 0',
            }, ]
        };
        if (datas.branches.length > 0) {
            let dataTypeExternal = [];
            if (datas.employeeTrainings.length > 0) {
                dataTypeExternal = mergeEmployeeArrays(datas.employeeTrainings);
            }
            datas.branches.map((br) => {
                let totalValueExternal = 0;
                let  totalValueInternal = 0;
                if (datas.employeeTrainings.length > 0) {
                    dataTypeExternal.map((emp) => {
                        if (emp.branch_id == br.id) {
                            totalValueExternal++;
                        }
                    });
                }
                dataStaffTraining.labels.push(br.abbreviations);
                dataStaffTraining.datasets[0].data.push(totalValueExternal);
            });
            dataStaffTraining.labels.push("Total");
            dataStaffTraining.datasets[0].data.push(dataTypeExternal.length);
        } 
        let optionExternal = {
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    font: {
                        weight: 'bold',
                        size: 10
                    },
                    align: 'center',
                },
                title: {
                    display: true,
                    text: "@lang('lang.staff_training_by_branch_external')"
                },
            },
            responsive: true,
            interaction: {
                intersect: false,
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        }
        
        let dataChartExternal = {
            type: "bar",
            data: dataStaffTraining,
            options: optionExternal,
            plugins: [ChartDataLabels]
        }
        new Chart('staff_Training_by_branch_external', dataChartExternal);
    }
    function mergeEmployeeArrays(data) {
        let mergedEmployeeArray = [];
        for (const dictionary of data) {
            mergedEmployeeArray = mergedEmployeeArray.concat(dictionary.employee);
        }
        let training = mergedEmployeeArray.filter(
                (value, index, self) =>
                    index === self.findIndex((t) => t.number_employee === value.number_employee && t.branch_id === value.branch_id)
            );
        return training;
    }
    function monthDiff(dateFrom, dateTo) {
        return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
    }
</script>
