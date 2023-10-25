@extends('layouts.parent')
@section('title_head')
    Register
@endsection
@section('style')
    {{-- <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}"> --}}
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }

        

    </style>
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
                            <div class="row gx-5">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h3 class="mb-4">Hi, Welcome! 👋👋</h3>
                                    {{-- <div style="text-align: center;"><img class="img-fluid mb-4" width="20%" src="{{asset('uploads/site_logo/'.env('SITE_LOGO',''))}}" alt=""></div> --}}
                                    <p class="text-muted text-sm">Welcome to Ezisaas Application Tracking System (ATS). <br>Please enter your login credentials below to access your account.</p>
                                    <form id="loginForm" action="{{ route('company-signup.register') }}" method="post">@csrf
                                        <x-forms.input class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" title="First name " name="first_name" id="first_name" type="text" required="True"/>
                                        <x-forms.input class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" title="Last name" name="last_name" id="last_name" type="text" required="False"/>
                                        <x-forms.input class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" title="Contact" name="mobile" id="mobile" type="number" required="True"/>
                                        <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Work email" name="email" id="email" type="email" required="True"/>
                                        <x-forms.input class="form-control {{ $errors->has('password_string') ? ' is-invalid' : '' }}" title="Create password" name="password_string" id="password_string" type="password" required="True"/>
                                        <hr>
                                        <h3>Your Company</h3>
                                        <div>
                                            <label class="form-label" for="hiring_as">Hiring as</label>
                                            <div class="form-check">
                                                <input class="form-check-input" id="customRadioInline1" type="radio" name="hiring_as" value="agency" onchange="toggleDiv()">
                                                <label class="custom-control-label" for="customRadioInline1">An agency or third-party recruiter</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="customRadioInline2" type="radio" name="hiring_as" value="hr" onchange="toggleDiv()">
                                                <label class="custom-control-label" for="customRadioInline2">Corporate or internal HR</label>
                                            </div>
                                            @error('hiring_as')
                                                <span class="error mt-2 text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div><p> </p>
                                        <div id="primary_focus_div">
                                            <label class="form-label" for="primary_focus">Primary focus</label>
                                            <select name="primary_focus" id="primary_focus" class="form-select">
                                                <option value="">Select an option</option>
                                                <option value="cpmmercial_staffing">Commercial staffing / Temp agency</option>
                                                <option value="executive_search">Executive search</option>
                                                <option value="permanent_placement">Permanent placement</option>
                                                <option value="professional_staffing">Professional staffing</option>
                                                <option value="rpo">RPO</option>
                                                <option value="job_board">Job board</option>
                                            </select>
                                        </div><p> </p>
                                        <x-forms.input class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" title="Company name " name="company_name" id="company_name" type="text" required="True"/>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input-group" style="height: calc(3.5rem + 2px);box-shadow: 3px 3px 3px #ced4da;">
                                                    {{-- <input type="button" value="-" class="button-minus" data-field="quantity"> --}}
                                                    <button class="btn btn-secondary" type="button" style="height: calc(3.5rem + 2px);" onclick="getUserCount('minus')">-</button>
                                                    <x-forms.input class="form-control {{ $errors->has('estimated_users') ? ' is-invalid' : '' }}" title="Estimated users " name="estimated_users" id="estimated_users" type="number" required="True"/>
                                                    <button class="btn btn-secondary" type="button" style="height: calc(3.5rem + 2px);" onclick="getUserCount('add')">+</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <x-forms.input class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}" title="Logo" name="logo" id="logo" type="file" required="False"/>
                                            </div>
                                        </div><p> </p>
                                        <x-forms.input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" title="Address" name="address" id="address" type="textarea" required="False"/>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="terms" id="terms" {{ old('remember') ? 'checked' : '' }} required checked>
                                            <label class="form-check-label" for="remember">I agree to the <a href="javascript:void(0);">Terms and Conditions</a> & <a href="javascript:void(0);">Privacy Policy</a>.</label>
                                        </div>
                                        <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                                    </form><br>
                                    {{-- <p>By signing up, </p> --}}
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
                            <div class="text-sm text-muted">Already have an account? <a href="{{route('login')}}">Login</a>.</div>
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
    {{-- <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput-jquery.min.js')}}"></script> --}}
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
                
            } );
        } );

        function toggleDiv(){
            $('#primary_focus_div').hide();
            var checked=$("#customRadioInline1").is(":checked")
            if(checked){
                $('#primary_focus_div').show();
            }else{
                $('#primary_focus_div').hide();
            }
        }
        
        toggleDiv();

        function getUserCount(option){
            var users=$("#estimated_users").val();
            if(users==null || users==""){
                users=0
            }
            if(option=="add"){
                users=parseInt(users)+1;
            }else{
                if(users>0){
                    users=parseInt(users)-1
                }else{
                    users=0;
                }
            }
            $("#estimated_users").val(users);
        }

    </script>
    
@endsection