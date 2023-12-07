@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Edit User
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
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
                    <h5 class="mb-4">Add New User</h5>
                    <form action="{{route('admin.users.update',[Crypt::encrypt($data->id)])}}" id="jQueryValidationForm" method="POST">@csrf
                        @method('put')
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" title="First name" name="first_name" id="first_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" title="Last name" name="last_name" id="last_name" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" title="Contact" name="mobile" id="mobile" type="text" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="role">Role</label>
                                <select name="role" id="role" class="form-select mb-3" required>
                                    <option value="">Select a role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{$role['id']}}">{{$role['text']}}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="inputChoosePassword" class="form-label">Password</label>
                                <div class="input-group" id="show_hide_passwords">
                                    <input type="password" class="form-control border-end-0" name="password_string" id="inputChoosePassword" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                </div>
                            </div>
                        </div><p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.users.index')}}" class="btn cancel-button">Cancel</a>
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

        function prefillData(){
            $('#first_name').val('{{$data->first_name}}');
            $('#last_name').val('{{$data->last_name}}');
            $('#email').val('{{$data->email}}');
            $('#mobile').val('{{$data->mobile}}');
            $('#role').val('{{$data->role}}');
        }

        prefillData();
    </script>
    <script>
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