@extends('layouts.parent')
@section('title_head')
    Login
@endsection
@section('content')
    <div class="page-holder align-items-center py-4 bg-gray-100 vh-100" style="background:#d9eefd !important;">
        <div class="container">
            <div class="align-items-center">
                <div class="h-100 d-flex align-items-center justify-content-center">
                    
                    <div class="card ">
                        <div class="card-header px-lg-5">
                            <div class="card-heading text-primary" style="text-align:center;"><img src="{{asset('assets/img/EZISAAS-LOGO-PNG.png')}}" alt="" class="img-responsive" style="width:200px;"></div>
                        </div>
                        <div class="card-body p-lg-5">
                            @if (session('error'))
                                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                                    <div class="text-white">{{ session('error') }}</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-primary border-0 bg-primary alert-dismissible fade show">
                                    <div class="text-white">{{ session('success') }}</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="row gx-5">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h3 class="mb-4">Hi, Welcome Back! 👋👋</h3>
                                    {{-- <div style="text-align: center;"><img class="img-fluid mb-4" width="20%" src="{{asset('uploads/site_logo/'.env('SITE_LOGO',''))}}" alt=""></div> --}}
                                    <p class="text-muted text-sm ">Welcome to Ezisaas Application Tracking System (ATS). <br>Please enter your login credentials below to access your account.</p>
                                    <form id="loginForm" action="{{ route('login') }}" method="post">
                                        <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Username [Email Addrerss] : " name="email" id="email" type="email" required="True"/>
                                        <x-forms.input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" title="Password : " name="password" id="password" type="password" required="True"/>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                        <button class="btn blue-button btn-lg" type="submit">Submit</button>
                                    </form><br>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <!-- Carousel -->
                                    <div id="demo" class="carousel slide" data-bs-ride="carousel">
                                        <!-- Indicators/dots -->
                                        <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                                        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                                        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                                        </div>
                                    
                                        <!-- The slideshow/carousel -->
                                        <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{asset('assets/img/photos/aron-visuals-3jBU9TbKW7o-unsplash.jpg')}}" alt="Los Angeles" class="d-block w-100">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{asset('assets/img/photos/henrique-ferreira-RKsLQoSnuTc-unsplash.jpg')}}" alt="Chicago" class="d-block w-100">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{asset('assets/img/photos/luca-bravo-O453M2Liufs-unsplash.jpg')}}" alt="New York" class="d-block w-100">
                                        </div>
                                        </div>
                                    
                                        <!-- Left and right controls/icons -->
                                        {{-- <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer px-lg-5 py-lg-4" style="text-align:center;">
                            <div class="text-sm text-muted">Don't have an account? <a href="{{route('company-signup')}}">Register</a>.</div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-6 col-xl-5 ms-xl-auto px-lg-4 text-center text-primary">
                    <img class="img-fluid mb-4" width="100%" src="{{asset('assets/img/ats_login.png')}}" alt="">
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script>
        $( document ).ready( function () {
            $( "#loginForm" ).validate( {
                rules: {
                    yourname: "required",
                    phone: "required",
                    username: {
                        required: true,
                        minlength: 2
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#input38"
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    country: "required",
                    address: "required",
                    agree: "required"
                },
                messages: {
                    yourname: "Please enter your your name",
                    phone: "Please enter your phone number",
                    username: {
                        required: "Please enter a username",
                        minlength: "Your username must consist of at least 2 characters"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    email: "Please enter a valid email address",
                    country: "Please select country",
                    address: "Please type your message",
                    agree: "Please accept our policy"
                },
                errorElement: "div",
                    errorPlacement: function ( error, element ) {
                        error.addClass( "invalid-feedback" );
                        error.insertAfter( element );
                    },
                highlight: function(element) {
                    $(element).removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                }
            } );
        } );
    </script>
    
@endsection