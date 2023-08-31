@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Add New End Client
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">End Clients</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.clients.index')}}">Clients</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.clients.end-clients.index',[$client_id])}}">End Clients</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create End Client</li>
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
                    <h5 class="mb-4">Add New End Client</h5>
                    <form action="{{route('admin.clients.end-clients.store',[$client_id])}}" id="jQueryValidationForm" method="POST">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="hidden" name="client_id" id="client_id" value="{{Crypt::decrypt($client_id)}}">
                                <x-forms.input class="form-control {{ $errors->has('end_client') ? ' is-invalid' : '' }}" title="End client" name="end_client" id="end_client" type="text" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.clients.end-clients.index',[$client_id])}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('javascripts')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
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
                },errorElement: "div",
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