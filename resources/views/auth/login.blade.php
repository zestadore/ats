@extends('layouts.parent')
@section('title_head')
    Login
@endsection
@section('content')
    <div class="page-holder align-items-center py-4 bg-gray-100 vh-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 px-lg-4">
                    <div class="card">
                        <div class="card-header px-lg-5">
                            <div class="card-heading text-primary">Bubbly Dashboard</div>
                        </div>
                        <div class="card-body p-lg-5">
                            <h3 class="mb-4">Hi, welcome back! 👋👋</h3>
                            <p class="text-muted text-sm mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                            <form id="loginForm" action="index.html">
                                <div class="form-floating mb-3">
                                <input class="form-control" id="floatingInput" type="email" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                <input class="form-control" id="floatingPassword" type="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                </div>
                                <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                            </form>
                        </div>
                        <div class="card-footer px-lg-5 py-lg-4">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 ms-xl-auto px-lg-4 text-center text-primary"><img class="img-fluid mb-4" width="300" src="img/drawkit-illustration.svg" alt="" style="transform: rotate(10deg)">
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
    <script src="{{asset('assets/plugins/validation/jquery.validate.min.js')}}"></script>
	{{-- <script src="{{asset('assets/plugins/validation/validation-script.js')}}"></script> --}}
    <script>
        $( document ).ready( function () {
            $( "#jQueryValidationForm" ).validate( {
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
            } );
        } );
    </script>
    
@endsection