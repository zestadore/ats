@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Add New Job Submission
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Job Submissions</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.job-submissions.index')}}">Job Submissions</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Job Submission</li>
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
                    <form action="{{route('admin.job-submissions.store')}}" id="jQueryValidationForm" method="POST" enctype="multipart/form-data">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="job_title_id">Job title <span style="color:red;"> *</span></label>
                                <select name="job_title_id" id="job_title_id" class="form-select mb-3" required>
                                    <option value="">Select Job Opportunity</option>
                                    @foreach ($opportunities as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                                @error('job_title_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="candidate_id">Legal name <span style="color:red;"> *</span></label>
                                <select name="candidate_id" id="candidate_id" class="form-select mb-3" required>
                                    <option value="">Select candidate</option>
                                    @foreach ($candidates as $item)
                                        <option value="{{$item->id}}">{{$item->candidate_name}}</option>
                                    @endforeach
                                </select>
                                @error('candidate_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('contact') ? ' is-invalid' : '' }}" title="Contact" name="contact" id="contact" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('email-id') ? ' is-invalid' : '' }}" title="Email" name="email_id" id="email_id" type="email" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('total_experience') ? ' is-invalid' : '' }}" title="Total experience" name="total_experience" id="total_experience" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('relevant_experience') ? ' is-invalid' : '' }}" title="Relevant experience" name="relevant_experience" id="relevant_experience" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('current_location') ? ' is-invalid' : '' }}" title="Current location" name="current_location" id="current_location" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('education') ? ' is-invalid' : '' }}" title="Education" name="education" id="education" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('rate') ? ' is-invalid' : '' }}" title="Rate" name="rate" id="rate" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('notice_period') ? ' is-invalid' : '' }}" title="Notice period" name="notice_period" id="notice_period" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="visa_status">Visa status <span style="color:red;"> *</span></label>
                                <select name="visa_status" id="visa_status" class="form-select mb-3" required>
                                    <option value="OPT">OPT</option>
                                    <option value="CPT">CPT</option>
                                    <option value="H1B">H1B</option>
                                    <option value="H4 EAD">H4 EAD</option>
                                    <option value="GC">GC</option>
                                    <option value="GC EAD">GC EAD</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('visa_status')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('relocation') ? ' is-invalid' : '' }}" title="Relocation" name="relocation" id="relocation" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('candidate_type') ? ' is-invalid' : '' }}" title="Candidate type" name="candidate_type" id="candidate_type" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('interview_availability') ? ' is-invalid' : '' }}" title="Interview availability" name="interview_availability" id="interview_availability" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('open_for_location') ? ' is-invalid' : '' }}" title="Open for location" name="open_for_location" id="open_for_location" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('resume') ? ' is-invalid' : '' }}" title="Resume" name="resume" id="resume" type="file" required="False"/>
                            </div>
                        </div><p> </p>
                        <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
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

        $('#candidate_id').change(function(){
            var id = $(this).val();
            var url="{{route('admin.get-candidates-details','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    $('#contact').val(response.contact);
                    $('#email_id').val(response.email);
                },
            });
        });
    </script>
@endsection