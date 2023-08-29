@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Add New Company
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Company</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.companies.index')}}">Company</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Company</li>
                        </ol>
                    </nav>
                </div>
            </div>
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
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Add New Company</h5>
                    <form action="{{route('admin.companies.store')}}" id="jQueryValidationForm" method="POST" enctype='multipart/form-data'>@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" title="Company name" name="company_name" id="company_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}" title="Logo" name="logo" id="logo" type="file" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" title="Address" name="address" id="address" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        {{-- <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="date_format">Date format <span style="color:red;">*</span></label>
                                <select name="date_format" id="date_format" class="form-select" required>
                                    <option value="">Select date format</option>
                                    <option value="d-m-Y">d-m-Y</option>
                                    <option value="m-d-Y">m-d-Y</option>
                                    <option value="Y-m-d">Y-m-d</option>
                                </select>
                                @error('date_format')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="time_zone">Time zone <span style="color:red;">*</span></label>
                                <select name="time_zone" id="time_zone" class="form-select" required>
                                    <option value="">Select your time zone</option>
                                    @foreach (timezone_identifiers_list() as $item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
                                </select>
                                @error('time_zone')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p> --}}
                        {{-- <div class="row g-3">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('currency_symbol') ? ' is-invalid' : '' }}" title="Currency symbol" name="currency_symbol" id="currency_symbol" type="text" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="currency_position">Currency position <span style="color:red;">*</span></label>
                                <select name="currency_position" id="currency_position" class="form-select" required>
                                    <option value="before_amount">Before_Amount</option>
                                    <option value="after_amount">After_Amount</option>
                                </select>
                                @error('currency_position')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="precision">Precision <span style="color:red;">*</span></label>
                                <select name="precision" id="precision" class="form-select" required>
                                    <option value="2_digit">2_Digit</option>
                                    <option value="3_digit">3_Digit</option>
                                </select>
                                @error('precision')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p> --}}
                        <div class="row g-3">
                            {{-- <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('invoice_footer') ? ' is-invalid' : '' }}" title="Invoice footer" name="invoice_footer" id="invoice_footer" type="text" required="False"/>
                            </div> --}}
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="pricing_plan_id">Pricing plan <span style="color:red;">*</span></label>
                                <select name="pricing_plan_id" id="pricing_plan_id" class="form-select" required>
                                    <option value="">Select pricing plan</option>
                                    @foreach ($pricingPlans as $item)
                                        <option value="{{$item->id}}">{{$item->plan_name}}</option>
                                    @endforeach
                                </select>
                                @error('pricing_plan_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <h6>For Admin Access</h6><hr>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" title="First name" name="first_name" id="first_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" title="Last name" name="last_name" id="last_name" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" title="Mobile" name="mobile" id="mobile" type="number" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="inputChoosePassword" class="form-label">Password</label>
                                <div class="input-group" id="show_hide_passwords">
                                    <input type="password" class="form-control border-end-0" name="password_string" id="inputChoosePassword" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                </div>
                            </div>
                        </div><p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.clients.index')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('javascripts')
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

        $(document).ready(function () {
			$("#show_hide_passwords a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_passwords input').attr("type") == "text") {
					$('#show_hide_passwords input').attr('type', 'password');
					$('#show_hide_passwords i').addClass("bx-hide");
					$('#show_hide_passwords i').removeClass("bx-show");
				} else if ($('#show_hide_passwords input').attr("type") == "password") {
					$('#show_hide_passwords input').attr('type', 'text');
					$('#show_hide_passwords i').removeClass("bx-hide");
					$('#show_hide_passwords i').addClass("bx-show");
				}
			});
            $('#inputChoosePassword').val('');
		});
    </script>
@endsection