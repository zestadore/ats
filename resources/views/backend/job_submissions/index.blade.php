@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        #viewLargeModal .modal-dialog {
            height: 100%; /* = 90% of the .modal-backdrop block = %90 of the screen */
        }
        #viewLargeModal .modal-content {
            height: 100%; /* = 100% of the .modal-dialog block */
        }
        .select2-container .select2-selection--single {
            height: 37px !important;
        }
    </style>
@endsection
@section('title')
    ATS - Job Submissions
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
                            <li class="breadcrumb-item active" aria-current="page">Job Submissions</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-primary" type="button" onclick="addNew()">Add New</button>
                    {{-- <a href="{{route('admin.job-submissions.create')}}" class="btn btn-primary">Add New</a> --}}
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
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="filterfordatatable" class="form-horizontal" onsubmit="event.preventDefault();">
                            <div class="row ">
                                <div class="col">
                                    <input type="text" name="search" class="form-control" placeholder="Search with title">
                                </div>
                                <div class="col">
                                    <input type="text" name="candidate" class="form-control" placeholder="Search with candidate">
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th>{{ __('Job Title') }}</th>
                                    <th>{{ __('Candidate') }}</th>
                                    <th>{{ __('Contact') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Current Location') }}</th>
                                    <th class="nosort">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Job Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="view-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="viewLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="height: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Attachment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="view-attachment-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addNewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jQueryValidationForm" method="POST" enctype="multipart/form-data">@csrf
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
                                        <strong style="cpolor:red;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="candidate_id">Legal name <span style="color:red;"> *</span></label><button type="button" class="btn btn-primary btn-sm" style="float:right;" data-bs-toggle="modal" data-bs-target="#addCandidateModal">+</button>
                                <select name="candidate_id" id="candidate_id" class="form-select mb-3" style="width:100%;" required>
                                    <option value="">Select candidate</option>
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
                        <div id="listAdditionalAttachments"></div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Attachment Name') }}</th>
                                    <th>{{ __('Attach file(Supports .pdf/.jpg/.png)') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="wrapperRows"></tbody>
                        </table>
                        {{-- <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.job-submissions.index')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addNewButton" data-id="0">Submit</button>
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
    <script src="{{asset('assets/css/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/css/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var rowCount=1;
        function drawTable()
        {
            var table = $('#item-table').DataTable({
                processing: true,
                serverSide: true,
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "",
                        "sLast": ""
                    }
                },
                destroy: true,
                // responsive: true,
                buttons: buttons,
                lengthChange: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                displayLength: 10,
                pagingType: "full_numbers",
                dom: 'B<"clear">lrtip',
                ajax: {
                    "url": '{{route("admin.job-submissions.index")}}',
                    "headers": {"X-Requested-With":'XMLHttpRequest'},
                    "data": function(d) {
                        var searchprams = $('#filterfordatatable').serializeArray();
                        var indexed_array = {};

                        $.map(searchprams, function(n, i) {
                            indexed_array[n['name']] = n['value'];
                        });
                        return $.extend({}, d, indexed_array);
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'name'
                    },
                    {
                        data: 'job_opportunity',
                        name: 'job_opportunity'
                    },
                    {
                        data: 'candidate',
                        name: 'candidate'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'email_id',
                        name: 'email_id'
                    },
                    {
                        data: 'current_location',
                        name: 'current_location'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],

                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]

            });

            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('#filterfordatatable').change(function() {
                table.draw();
            });
        }
        drawTable();

        function editData(id){
            $('#addNewButton').attr("data-id",id);
            var url="{{route('admin.job-submissions.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success==true){
                        // $('#candidate_id').val('').trigger('change');
                        $('#candidate_id').empty();
                        $('#candidate_id').append($('<option>', {
                            value: response.data.candidate.id,
                            text: response.data.candidate.candidate_name
                        }));
                        var atts=response.data.additional_attachments;
                        var html2="<table class='table table-striped table-bordered'>";
                        if(atts.length>0){
                            html2+="<tr>";
                            html2+="<td colspan='2'>Additional Attachments</td>";
                            html2+="</tr>";
                            $.each(atts, function( index, value ) {
                                html2+="<tr>";
                                html2+="<td>"+value.description+"</td>";
                                html2+="<td><a href='#' onclick='deleteAttachment("+value.id+")'><i class='fadeIn animated fa fas fa-trash-alt'></i></a></td>";
                                html2+="</tr>";
                            });
                        }
                        html2+="</table>";
                        $('#listAdditionalAttachments').html(html2);
                        $('#jQueryValidationForm')[0].reset();
                        $('#job_title_id').val(response.data.job_title_id);
                        // $('#candidate_id').val(response.data.candidate_id).trigger('change');
                        $('#contact').val(response.data.contact);
                        $('#email_id').val(response.data.email_id);
                        $('#total_experience').val(response.data.total_experience);
                        $('#relevant_experience').val(response.data.relevant_experience);
                        $('#current_location').val(response.data.current_location);
                        $('#education').val(response.data.education);
                        $('#rate').val(response.data.rate);
                        $('#notice_period').val(response.data.notice_period);
                        $('#visa_status').val(response.data.visa_status);
                        $('#relocation').val(response.data.relocation);
                        $('#candidate_type').val(response.data.candidate_type);
                        $('#interview_availability').val(response.data.interview_availability);
                        $('#addNewModal').modal('show');
                    }else{
                        swal("Oops!", "Failed to fetch the data!", "error");
                    }
                },
            });
            // var url="{{route('admin.job-submissions.edit','ID')}}";
            // url=url.replace('ID',id);
            // window.location.href=url;
        }

        function deleteData(id)
        {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    var url="{{route('admin.job-submissions.destroy','ID')}}";
                    url=url.replace('ID',id);
                    $.ajax({
                        url: url,
                        type:"delete",
                        data:{
                            "_token": "{{ csrf_token() }}",
                        },
                        success:function(response){
                            console.log(response);
                            if(response.success){
                                swal("Good job!", "You deleted the data!", "success");
                                drawTable();
                            }else{
                                swal("Oops!", "Failed to deleted the data!", "danger");
                            }
                        },
                    });
                }
            });
        }

        function viewModal(id){
            var url="{{route('admin.job-submissions.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    console.log(response);
                    if(response.success==true){
                        var atts=response.data.additional_attachments;
                        var html2="";
                        if(atts.length>0){
                            html2+="<tr>";
                            html2+="<td>Additional Attachments</td>";
                            html2+="</tr>";
                            $.each(atts, function( index, value ) {
                                html2+="<tr>";
                                html2+="<td>"+value.description+"</td>";
                                html2+="<td><a href='#'class='viewAttachment' data-url='"+value.attachment_path+"'>View</a></td>";
                                html2+="</tr>";
                            });
                        }
                        var html="<table class='table table-striped table-bordered'>";
                        html+="<tr>";
                        html+="<td>Job title</td>";
                        if(response.data.job_opportunity){
                            var title=response.data.job_opportunity.title?response.data.job_opportunity.title:"-";
                        }else{
                            var title="-";
                        }
                        html+="<td>"+title+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Candidate</td>";
                        var candidate=response.data.candidate.candidate_name?response.data.candidate.candidate_name:"-";
                        html+="<td>"+candidate+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Contact</td>";
                        var contact=response.data.contact?response.data.contact:"-";
                        html+="<td>"+contact+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Email</td>";
                        var email_id=response.data.email_id?response.data.email_id:"-";
                        html+="<td>"+email_id+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Current location</td>";
                        var current_location=response.data.current_location?response.data.current_location:"-";
                        html+="<td>"+current_location+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Total experience</td>";
                        var total_experience=response.data.total_experience?response.data.total_experience:"-";
                        html+="<td>"+total_experience+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Relevant experience</td>";
                        var relevant_experience=response.data.relevant_experience?response.data.relevant_experience:"-";
                        html+="<td>"+relevant_experience+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Visa status</td>";
                        var visa_status=response.data.visa_status?response.data.visa_status:"-";
                        html+="<td>"+visa_status+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Education</td>";
                        var education=response.data.education?response.data.education:"-";
                        html+="<td>"+education+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Rate</td>";
                        var rate=response.data.rate?response.data.rate:"-";
                        html+="<td>"+rate+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Notice period</td>";
                        var notice_period=response.data.notice_period?response.data.notice_period:"-";
                        html+="<td>"+notice_period+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Candidate type</td>";
                        var candidate_type=response.data.candidate_type?response.data.candidate_type:"-";
                        html+="<td>"+candidate_type+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Relocation</td>";
                        var relocation=response.data.relocation?response.data.relocation:"-";
                        html+="<td>"+relocation+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interview availability</td>";
                        var interview_availability=response.data.interview_availability?response.data.interview_availability:"-";
                        html+="<td>"+interview_availability+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Resume</td>";
                        if(response.data.resume_path!==null && response.data.resume_path!="" && response.data.resume_path!="null"){
                            html+="<td><a href='#'class='viewAttachment' data-url='"+response.data.resume_path+"'>View</a></td>";
                        }else{
                            html+="<td style='color:red;'>Resume not uploaded</td>";
                        }
                        html+="</tr>";
                        html+=html2;
                        html+="</table>";
                        html=html+"</html>";
                        $('#view-modal-body').html(html);
                        $('#exampleLargeModal').modal('show');
                    }else{
                        swal("Oops!", "Failed to fetch the data!", "error");
                    }
                },
            });
        }

        $(document).on('click', '.viewAttachment', function(e){
            e.preventDefault();
            var url=$(this).data('url');
            var html="";
            html+='<iframe src="'+url+'" width="100%" height="100%"></iframe>';
            $('#view-attachment-body').html(html);
            // $('#exampleLargeModal').modal('hide');
            $('#viewLargeModal').modal('show');
        });

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

        $('#employer_details').change(function(){
            if($(this).is(':checked')) { 
                $('#employerSection').show();
            }else{
                $('#employerSection').hide();
            }
        });
        $('#employerSection').hide();

        function addNew(){
            //clear the form
            $('#jQueryValidationForm')[0].reset();
            $('#addNewButton').attr('data-id','0');
            $('#addNewModal').modal('show');
        }

        $('#addNewButton').click(function(){
            if($('#jQueryValidationForm').valid()){
                var id=$('#addNewButton').attr('data-id');
                var formData = new FormData($('#jQueryValidationForm')[0]);
                if(id==0){
                    var url="{{route('admin.job-submissions.store')}}";
                    var method="post";
                }else{
                    var url="{{route('admin.job-submissions.update','ID')}}";
                    url=url.replace('ID',id);
                    var method="post";
                    formData.append('_method', 'put');
                }
                //submit form via ajax
                $.ajax({
                    url:url,
                    "headers": {"X-Requested-With":'XMLHttpRequest'},
                    method:method,
                    processData: false,
                    contentType: false,
                    data:formData,
                    success:function(response){
                        console.log(response);
                        if(response.success==true){
                            swal("Good job!", "Data added successfully", "success");
                            $('#addNewModal').modal('hide');
                            $('#jQueryValidationForm')[0].reset();
                            drawTable();
                        }else{
                            swal("Oops!", "Failed to add the data!", "error");
                        }
                    }
                });
            }
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
            dropdownParent: $("#addNewModal  .modal-content"),
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

        function deleteAttachment(id){
            var viewId=$('#addNewButton').attr('data-id');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
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
                                editData(viewId);
                            }else{
                                swal("Oops!", "Failed to delete the attachment", "error");
                            }
                        },
                    });
                }
            });
        }

    </script>
@endsection