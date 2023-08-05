@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .select2-container .select2-choice:not(.select2-default) {
            background-image: none !important;
            background-color: #f9860b;
        }
    </style>
@endsection
@section('title')
    ATS - Add New Iterview
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Interviews</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.interviews.index')}}">Interviews</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Interview</li>
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
                    <h5 class="mb-4">Add New Interview</h5>
                    <form action="{{route('admin.interviews.store')}}" id="jQueryValidationForm" method="POST">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="interview_name">Interview name</label><span style="color:red;">*</span>
                                <select name="interview_name" id="interview_name" class="form-select mb-3" required>
                                    <option value="">Select a role</option>
                                    <option value="internal_interview">Internal Interview</option>
                                    <option value="general_iterview">General Interview</option>
                                    <option value="online_interview">Online Interview</option>
                                    <option value="phone_interview">Phone Interview</option>
                                    <option value="level1_interview">Level 1 Interview</option>
                                    <option value="level2_interview">Level 2 Interview</option>
                                    <option value="level3_interview">Level 3 Interview</option>
                                    <option value="level4_interview">Level 4 Interview</option>
                                </select>
                                @error('interview_name')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="candidate_id">Legal name <span style="color:red;"> *</span></label>
                                <select name="candidate_id" id="candidate_id" class="form-select mb-3" required>
                                    <option value="">Select candidate</option>
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
                                <label class="form-label" for="client_id">Client <span style="color:red;"> *</span></label>
                                <select name="client_id" id="client_id" class="form-select mb-3" required>
                                    <option value="">Select a client</option>
                                    @foreach ($clients as $item)
                                        <option value="{{$item->id}}">{{$item->client_name}}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="job_opportunity_id">Job title <span style="color:red;"> *</span></label>
                                <select name="job_opportunity_id" id="job_opportunity_id" class="form-select mb-3" required>
                                    <option value="">Select Job Opportunity</option>
                                    @foreach ($opportunities as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                                @error('job_opportunity_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="from_date">From <span style="color:red;"> *</span></label>
                                <input type="datetime-local" name="from_date" id="from_date" class="form-control mb-3" required>
                                @error('from_date')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="to_date">To <span style="color:red;"> *</span></label>
                                <input type="datetime-local" name="to_date" id="to_date" class="form-control mb-3" required>
                                @error('to_date')
                                <span class="error mt-2 text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                <label class="form-label" for="interviewers_id">Interviewer(s) </label>
                                <select name="interviewers_id[]" id="interviewers_id" class="form-select" data-placeholder="Select interviewer(s)" multiple>
                                    @foreach ($clients as $item)
                                        <option value="{{$item->id}}">{{$item->client_name}}</option>
                                    @endforeach
                                </select>
                                @error('interviewers_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="interview_owner_id">Interview owner </label>
                                <select name="interview_owner_id" id="interview_owner_id" class="form-select mb-3">
                                    <option value="">Select interview owner</option>
                                    @foreach ($users as $item)
                                        <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                    @endforeach
                                </select>
                                @error('interview_owner_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" title="Location" name="location" id="location" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('assesment_name') ? ' is-invalid' : '' }}" title="Assesment name" name="assesment_name" id="assesment_name" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <x-forms.input class="form-control {{ $errors->has('comments') ? ' is-invalid' : '' }}" title="Comments" name="comments" id="comments" type="textarea" required="False"/>
                        <p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.interviews.index')}}" class="btn btn-secondary">Cancel</a>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $('#candidate_id').select2({
            minimumInputLength: 3,
            ajax: {
                url: getUrl(),
                dataType: 'json',
            },
        });

        function getUrl(){
            var search=$('#candidate_id').val();
            var url="{{route('admin.get-candidates-list','SEARCH')}}";
            url=url.replace('SEARCH',search);
            return url;
        }

        $('#interviewers_id').select2();

    </script>
@endsection