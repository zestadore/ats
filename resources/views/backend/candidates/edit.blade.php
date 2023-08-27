@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Edit Candidate
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Candidates</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.candidates.index')}}">Candidates</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Candidate</li>
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
                    <form action="{{route('admin.candidates.update',[Crypt::encrypt($data->id)])}}" id="jQueryValidationForm" method="POST" enctype="multipart/form-data">@csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('candidate_name') ? ' is-invalid' : '' }}" title="Candidate name" name="candidate_name" id="candidate_name" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('contact') ? ' is-invalid' : '' }}" title="Contact" name="contact" id="contact" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('skills') ? ' is-invalid' : '' }}" title="Skills" name="skills" id="skills" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('key_skills') ? ' is-invalid' : '' }}" title="Key skills" name="key_skills" id="key_skills" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" title="Location" name="location" id="location" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('linked_in') ? ' is-invalid' : '' }}" title="LinkedIn" name="linked_in" id="linked_in" type="text" required="False"/>
                            </div>
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
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="candidate_type">Candidate type</label>
                                <select name="candidate_type" id="candidate_type" class="form-select mb-3">
                                    <option value="1099">1099</option>
                                    <option value="W2">W2</option>
                                    <option value="C2C">C2C</option>
                                    <option value="Bench Candidate">Bench Candidate</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('candidate_type')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('job_tag') ? ' is-invalid' : '' }}" title="Job tag" name="job_tag" id="job_tag" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('job_title') ? ' is-invalid' : '' }}" title="Job title" name="job_title" id="job_title" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('resume') ? ' is-invalid' : '' }}" title="Resume" name="resume" id="resume" type="file" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('notes') ? ' is-invalid' : '' }}" title="Notes" name="notes" id="notes" type="textarea" required="False"/>
                            </div>
                        </div><p> </p>
                        <h6>Additional attachments</h6>
                        <hr>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Attachment Name</th>
                                    <th>Attach file</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->additionalAttachments as $item)
                                    <tr>
                                        <td>{{$item->description}}</td>
                                        <td><a href="{{$item->attachment_path}}" target="_blank">View</a></td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-sm btn-del-attachment" data-id="{{Crypt::encrypt($item->id)}}"><i class="fadeIn animated bx bx-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><p> </p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Attachment Name') }}</th>
                                    <th>{{ __('Attach file') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="wrapperRows"></tbody>
                        </table>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="employer_details" value=1 id="employer_details">
                            <label class="form-check-label" for="employer_details">Employer details</label>
                        </div><p> </p>
                        <div class="row g-3" id="employerSection">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('employer_name') ? ' is-invalid' : '' }}" title="Employer name" name="employer_name" id="employer_name" type="text" required="False"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('employer_contact') ? ' is-invalid' : '' }}" title="Employer contact" name="employer_contact" id="employer_contact" type="text" required="False"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('employer_email') ? ' is-invalid' : '' }}" title="Employer email" name="employer_email" id="employer_email" type="email" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.candidates.index')}}" class="btn btn-secondary">Cancel</a>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var rowCount=1;
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

        $('#employer_details').change(function(){
            if($(this).is(':checked')) { 
                $('#employerSection').show();
            }else{
                $('#employerSection').hide();
            }
        });
        function prefillForm(){
            $('#candidate_name').val('{{$data->candidate_name}}');
            $('#email').val('{{$data->email}}');
            $('#contact').val('{{$data->contact}}');
            $('#skills').val('{{$data->skills}}');
            $('#key_skills').val('{{$data->key_skills}}');
            $('#location').val('{{$data->location}}');
            $('#linked_in').val('{{$data->linked_in}}');
            $('#visa_status').val('{{$data->visa_status}}');
            $('#candidate_type').val('{{$data->candidate_type}}');
            $('#job_tag').val('{{$data->job_tag}}');
            $('#job_title').val('{{$data->job_title}}');
            $('#notes').val('{{$data->notes}}');
            $('#employer_name').val('{{$data->employer_name}}');
            $('#employer_contact').val('{{$data->employer_contact}}');
            $('#employer_email').val('{{$data->employer_email}}');
            var employerDetails='{{$data->employer_details}}';
            if(employerDetails==0){
                $("#employerDetails").prop('checked', false);
                $('#employerSection').hide();
            }else{
                $("#employerDetails").prop('checked', true);
                $('#employerSection').show();
            }
        }
        prefillForm();

        $('#wrapperRows').on('click', '.addDetailsButton', function(e){
            e.preventDefault();
            rowCount++;
            addRow();
        });

        function addRow(){
            $('#wrapperRows').append('{!!$renderHtml!!}');
        }

        $('#wrapperRows').on('click', '.remove_button', function(e){
            e.preventDefault();
            if(rowCount>1){
                $(this).parent('td').parent('tr').remove(); //Remove field html
                rowCount--; //Decrement field counter
            }
        });

        addRow();

        $('.btn-del-attachment').on('click', function(e){
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    var id=$(this).data('id');
                    var url="{{route('admin.delete-additional-attachment','ID')}}";
                    url=url.replace('ID',id);
                    $.ajax({
                        url: url,
                        type:"delete",
                        data:{
                            "_token": "{{ csrf_token() }}",
                        },
                        success:function(response){
                            if(response.success){
                                swal("Good job!", response.success, "success");
                                window.location.reload();
                            }else{
                                swal("Oops!", "Failed to delete the attachment", "error");
                            }
                        },
                    });
                }
            })
        });
    </script>
@endsection