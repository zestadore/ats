@extends('layouts.app')
@section('styles')
@endsection
@section('title')
    ATS - Mail Settings
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Mail settings</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Site settings</li>
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
                    <h5 class="mb-4">Mail settings</h5>
                    <form action="{{route('admin.update-mail.details')}}" id="jQueryValidationForm" method="POST">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mail_type') ? ' is-invalid' : '' }}" title="Mail type" name="mail_type" id="mail_type" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mail_host') ? ' is-invalid' : '' }}" title="Mail host" name="mail_host" id="mail_host" type="text" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mail_port') ? ' is-invalid' : '' }}" title="Mail port" name="mail_port" id="mail_port" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mail_username') ? ' is-invalid' : '' }}" title="Mail username" name="mail_username" id="mail_username" type="text" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mail_password') ? ' is-invalid' : '' }}" title="Mail password" name="mail_password" id="mail_password" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mail_encryption') ? ' is-invalid' : '' }}" title="Mail encryption" name="mail_encryption" id="mail_encryption" type="text" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.dashboard')}}" class="btn cancel-button">Cancel</a>
                            <button type="submit" class="btn btn-submit">Submit</button>
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

        function prefillForm(){
            $('#mail_type').val('{{$data["mail_type"]}}');
            $('#mail_host').val('{{$data["mail_host"]}}');
            $('#mail_port').val('{{$data["mail_port"]}}');
            $('#mail_username').val('{{$data["mail_username"]}}');
            $('#mail_password').val('{{$data["mail_password"]}}');
            $('#mail_encryption').val('{{$data["mail_encryption"]}}');
        }
        prefillForm();

    </script>
@endsection