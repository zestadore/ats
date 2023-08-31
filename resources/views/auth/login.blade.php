@extends('layouts.parent')
@section('title_head')
    Login
@endsection
@section('content')
    <div class="page-holder align-items-center py-4 bg-gray-100 vh-100" style="background:#d9eefd !important;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 px-lg-4">
                    <div class="card">
                        <div class="card-header px-lg-5">
                            <div class="card-heading text-primary">Amnext - ATS</div>
                        </div>
                        <div class="card-body p-lg-5">
                            <h3 class="mb-4">Hi, welcome back! 👋👋</h3>
                            <div style="text-align: center;"><img class="img-fluid mb-4" width="20%" src="{{asset('uploads/site_logo/'.env('SITE_LOGO',''))}}" alt=""></div>
                            <p class="text-muted text-sm mb-5">Welcome to Amnext's Application Tracking System (ATS). Please enter your login credentials below to access your account.</p>
                            <form id="loginForm" action="{{ route('login') }}" method="post">@csrf
                                <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Username [Email Addrerss] : " name="email" id="email" type="email" required="True"/>
                                <x-forms.input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" title="Password : " name="password" id="password" type="password" required="True"/>
                                <button class="btn btn-primary btn-lg" type="submit" style="float:right;">Submit</button>
                            </form>
                        </div>
                        <div class="card-footer px-lg-5 py-lg-4">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 ms-xl-auto px-lg-4 text-center text-primary">
                    <img class="img-fluid mb-4" width="100%" src="{{asset('assets/img/ats_login.png')}}" alt="">
                </div>
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