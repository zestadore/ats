@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Edit Pricing Plan
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pricing Plans</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.pricing-plans.index')}}">Pricing Plans</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Pricing Plans</li>
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
                    <h5 class="mb-4">Add New Client</h5>
                    <form action="{{route('admin.pricing-plans.update',[Crypt::encrypt($data->id)])}}" id="jQueryValidationForm" method="POST">@csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('plan_name') ? ' is-invalid' : '' }}" title="Pricing plan name" name="plan_name" id="plan_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="plan_type">Plan type <span style="color:red;"> *</span></label>
                                <select name="plan_type" id="plan_type" class="form-select {{ $errors->has('plan_type') ? ' is-invalid' : '' }}" required>
                                    <option value="">Select plan type</option>
                                    <option value="one_time">One time</option>
                                    <option value="recurring">Recurring</option>
                                </select>
                                @error('plan_type')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="plan_interval">Plan interval <span style="color:red;"> *</span></label>
                                <select name="plan_interval" id="plan_interval" class="form-select {{ $errors->has('plan_interval') ? ' is-invalid' : '' }}" required>
                                    <option value="">Select plan interval</option>
                                    <option value="0">Monthly</option>
                                    <option value="1">Yearly</option>
                                </select>
                                @error('plan_interval')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" title="Price" name="price" id="price" type="number" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('maximum_users') ? ' is-invalid' : '' }}" title="Max users" name="maximum_users" id="maximum_users" type="number" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('monthly_invoices') ? ' is-invalid' : '' }}" title="Max invoices" name="monthly_invoices" id="monthly_invoices" type="number" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('trail_days') ? ' is-invalid' : '' }}" title="Trail days" name="trail_days" id="trail_days" type="number" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" title="Description" name="description" id="description" type="textarea" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.pricing-plans.index')}}" class="btn btn-secondary">Cancel</a>
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

        function prefillForm(){
            $('#plan_name').val('{{$data->plan_name}}');
            $('#plan_type').val('{{ $data->plan_type }}');
            $('#plan_interval').val('{{ $data->plan_interval }}');
            $('#price').val('{{ $data->price }}');
            $('#maximum_users').val('{{ $data->maximum_users }}');
            $('#monthly_invoices').val('{{ $data->monthly_invoices }}');
            $('#trail_days').val('{{ $data->trail_days }}');
            $('#description').val('{{ $data->description }}');
        }
        prefillForm();
    </script>
@endsection