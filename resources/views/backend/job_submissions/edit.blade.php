@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .select2-container .select2-selection--single {
            height: 37px !important;
        }
    </style>
@endsection
@section('title')
    ATS - Edit Job Submission
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Job Submissions</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.job-submissions.index')}}">Job Submissions</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Job Submission</li>
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
                    <h5 class="mb-4">Edit Job Submission</h5>
                    <form action="{{route('admin.job-submissions.update',[Crypt::encrypt($data->id)])}}" id="jQueryValidationForm" method="POST" enctype="multipart/form-data">@csrf
                        @method('put')
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
                                <label class="form-label" for="candidate_id">Legal name <span style="color:red;"> *</span></label><button type="button" class="btn btn-primary btn-sm" style="float:right;" data-bs-toggle="modal" data-bs-target="#addCandidateModal">+</button>
                                <select name="candidate_id" id="candidate_id" class="form-select mb-3" required>
                                    <option value="{{$candidates->id}}">{{$candidates->candidate_name}}</option>
                                    {{-- @foreach ($candidates as $item)
                                        <option value="{{$item->id}}">{{$item->candidate_name}}</option>
                                    @endforeach --}}
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
                            {{-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('open_for_location') ? ' is-invalid' : '' }}" title="Open for location" name="open_for_location" id="open_for_location" type="text" required="False"/>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('resume') ? ' is-invalid' : '' }}" title="Resume" name="resume" id="resume" type="file" required="False"/>
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
                                            <a href="#" class="btn btn-danger btn-sm btn-del-attachment" data-id="{{Crypt::encrypt($item->id)}}"><i class="fadeIn animated fa fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><p> </p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="nosort">{{ __('Attachment Name') }}</th>
                                    <th class="nosort">{{ __('Attach file(Supports .pdf/.jpg/.png)') }}</th>
                                    <th class="nosort">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="wrapperRows"></tbody>
                        </table>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.job-submissions.index')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="addCandidateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="candidateValidationForm" method="POST" enctype="multipart/form-data">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('candidate_name') ? ' is-invalid' : '' }}" title="Candidate name" name="candidate_name" id="candidate_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('contact') ? ' is-invalid' : '' }}" title="Contact" name="contact" id="contact" type="text" required="True"/>
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
                                <x-forms.input class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" title="Location" name="location" id="location" type="text" required="True"/>
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
                                <x-forms.input class="form-control {{ $errors->has('job_title') ? ' is-invalid' : '' }}" title="Job title" name="job_title" id="job_title" type="text" required="True"/>
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
                        <button type="button" class="btn btn-primary" id="submitCandidate" style="float:right;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    {{-- <script src="{{asset('assets/plugins/validation/validation-script.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $( "#candidateValidationForm" ).validate( {
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
        

        function prefillForm(){
            $('#job_title_id').val('{{$data->job_title_id}}');
            $('#candidate_id').val('{{$data->candidate_id}}');
            $('#contact').val('{{$data->contact}}');
            $('#email_id').val('{{$data->email_id}}');
            $('#total_experience').val('{{$data->total_experience}}');
            $('#relevant_experience').val('{{$data->relevant_experience}}');
            $('#current_location').val('{{$data->current_location}}');
            $('#education').val('{{$data->education}}');
            $('#rate').val('{{$data->rate}}');
            $('#notice_period').val('{{$data->notice_period}}');
            $('#visa_status').val('{{$data->visa_status}}');
            $('#relocation').val('{{$data->relocation}}');
            $('#candidate_type').val('{{$data->candidate_type}}');
            $('#interview_availability').val('{{$data->interview_availability}}');
            // $('#open_for_location').val('{{$data->open_for_location}}');
        }
        prefillForm();

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

        $('#submitCandidate').click(function(){
            if($( "#candidateValidationForm" ).valid()){
                var formData = new FormData($('#candidateValidationForm')[0]);
                $.ajax({
                    url: "{{route('admin.candidates.store')}}",
                    method: "post",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (data) {
                        $('#addCandidateModal').modal('hide');
                    },
                });
            }
        });

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