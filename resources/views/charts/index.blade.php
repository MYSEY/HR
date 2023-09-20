@extends('layouts.master')
<style>
     .card-detail {
        width: auto;
        height: 250px;
        overflow-y: scroll;
        /* display: flex; */
    }

</style>
@section('content')
    <section style="background-color: #CDC4F9;">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="chat3" style="border-radius: 15px;">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                                    <div class="p-3">

                                        <div class="input-group rounded mb-3">
                                            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                            <span class="input-group-text border-0" id="search-addon">
                                                <i class='fa fa-search'></i>
                                            </span>
                                        </div>

                                        <div class="card-detail" style="position: relative; height: 400px">
                                            <ul class="list-unstyled mb-0">
                                                <li class="p-2 border-bottom">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                                    alt="avatar" class="d-flex align-self-center me-3"
                                                                    width="60">
                                                                <span class="badge bg-success badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">Marie Horwitz</p>
                                                                <p class="small text-muted">Hello, Are you there?</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Just now</p>
                                                            <span class="badge bg-danger rounded-pill float-end">3</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="p-2 border-bottom">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp"
                                                                    alt="avatar" class="d-flex align-self-center me-3"
                                                                    width="60">
                                                                <span class="badge bg-warning badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">Alexa Chung</p>
                                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">5 mins ago</p>
                                                            <span class="badge bg-danger rounded-pill float-end">2</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="p-2 border-bottom">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                                                                    alt="avatar" class="d-flex align-self-center me-3"
                                                                    width="60">
                                                                <span class="badge bg-success badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">Danny McChain</p>
                                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="p-2 border-bottom">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                                                                    alt="avatar" class="d-flex align-self-center me-3"
                                                                    width="60">
                                                                <span class="badge bg-danger badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">Ashley Olsen</p>
                                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="p-2 border-bottom">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava5-bg.webp"
                                                                    alt="avatar" class="d-flex align-self-center me-3"
                                                                    width="60">
                                                                <span class="badge bg-warning badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">Kate Moss</p>
                                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="p-2 border-bottom">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava5-bg.webp"
                                                                    alt="avatar" class="d-flex align-self-center me-3"
                                                                    width="60">
                                                                <span class="badge bg-warning badge-dot"></span>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">Kate Moss</p>
                                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Yesterday</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-7 col-xl-8">

                                    <div class="pe-3" style="position: relative; height: 400px">

                                        <div class="chat">
                                            <!-- Header -->
                                            <div class="top">
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                                <div>
                                                    <p>Yos Radavid</p>
                                                    <small><span style="color: rgba(71, 236, 21, 0.655)">Online</span></small>
                                                </div>
                                            </div>
                                            <!-- End Header -->

                                            <!-- Chat -->
                                            <div class="card-detail">
                                                <div class="messages">
                                                    @include('charts.receive', ['message' => 'Hi'])
                                                </div>
                                            </div>
                                            
                                            <!-- End Chat -->

                                        </div>

                                        {{-- <div class="d-flex flex-row justify-content-start">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3"
                                                    style="background-color: #f5f6f7;">Lorem ipsum
                                                    dolor
                                                    sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                                    ut labore et
                                                    dolore
                                                    magna aliqua.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row justify-content-end">
                                            <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Ut enim ad
                                                    minim veniam,
                                                    quis
                                                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                    consequat.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                            </div>
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                        </div>

                                        <div class="d-flex flex-row justify-content-start">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3"
                                                    style="background-color: #f5f6f7;">Duis aute
                                                    irure
                                                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                                                    nulla pariatur.
                                                </p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row justify-content-end">
                                            <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Excepteur
                                                    sint occaecat
                                                    cupidatat
                                                    non proident, sunt in culpa qui officia deserunt mollit anim id est
                                                    laborum.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                            </div>
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: 100%;">
                                        </div> --}}
                                    </div>

                                    <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="message" placeholder="Enter message" aria-label="Enter message" aria-describedby="button-addon2">
                                            {{-- <a class="ms-1 text-muted" href="#!"><i class="fa fa-paperclip"></i> --}}
                                            {{-- <button class="ms-3 text-muted" href="#!" id="button-addon2"><i class="fa fa-smile"></i></button> --}}
                                            <button type="button" class="btn btn-info btn-chart" id="button-addon2" style="color: #f5f6f7"><i class="fa fa-paper-plane"></i></button>
                                        </div>
                                        {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                            alt="avatar 3" style="width: 40px; height: 100%;"> --}}
                                        {{-- <input type="text" class="form-control form-control-lg"
                                            id="exampleFormControlInput2" placeholder="Type message">
                                        <a class="ms-1 text-muted" href="#!"><i class="fa fa-paperclip"></i></a>
                                        <a class="ms-3 text-muted" href="#!"><i class="fa fa-smile-o" aria-hidden="true"></i></a>
                                        <a class="ms-3 btn-chart" href="#!"><i class="fa fa-paper-plane"></i></a> --}}
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    {{-- <div class="chat">
        <!-- Header -->
        <div class="top">
            <img style="width: 6% " src="{{ asset('admin/img/avatar-02.jpg') }}" alt="Avatar">
            <div>
                <p>Yos Radavid</p>
                <small><span style="color: rgba(71, 236, 21, 0.655)">Online</span></small>
            </div>
        </div>
        <!-- End Header -->

        <!-- Chat -->
        <div class="messages">
            @include('charts.receive', ['message' => ''])
        </div>
        <!-- End Chat -->

        <!-- Footer -->
        <div class="bottom">
            <form>
                <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                <button type="button" class="btn-chart"></button>
            </form>
        </div>
        <!-- End Footer -->

    </div> --}}
@endsection
@include('includs.script')
@push('javascript')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico" />
    <!-- CSS -->
    <link rel="stylesheet" href="/style.css">
    <!-- End CSS -->

    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: 'eu'
        });
        const channel = pusher.subscribe('public');
        //Receive messages
        channel.bind('chat', function(data) {
            $.post("/receive", {
                    _token: '{{ csrf_token() }}',
                    message: data.message,
                })
                .done(function(res) {
                    $(".messages > .message").last().after(res);
                    $(document).scrollTop($(document).height());
                });
        });

        $(function() {
            //Broadcast messages
            $(".btn-chart").on("click", function() {
                $.ajax({
                    url: "/broadcast",
                    method: 'POST',
                    headers: {
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: $("#message").val(),
                    }
                }).done(function(res) {
                    $(".messages > .message").last().after(res);
                    $("#message").val('');
                    $(document).scrollTop($(document).height());
                });
            });
        });
    </script>
