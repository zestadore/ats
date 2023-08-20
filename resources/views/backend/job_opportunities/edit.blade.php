@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <!-- include summernote css/js -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('title')
    ATS - Edit Job Opportunity
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Job Opportunity</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.job-opportunities.index')}}">Job Opportunity</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Job Opportunity</li>
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
                    <h5 class="mb-4">Edit Job Opportunity</h5>
                    <form action="{{route('admin.job-opportunities.update',[Crypt::encrypt($data->id)])}}" id="jQueryValidationForm" method="POST">@csrf
                        @method('put')
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" title="Job title" name="title" id="title" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="type">Job type</label>
                                <select name="type" id="type" class="form-select mb-3">
                                    <option value="0">Contract</option>
                                    <option value="1">Full time</option>
                                </select>
                                @error('type')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('salary') ? ' is-invalid' : '' }}" title="Salary" name="salary" id="salary" type="number" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="job_owner">Job owner(s) </label>
                                <select name="job_owner[]" id="job_owner" class="form-select" data-placeholder="Select job owner(s)" multiple>
                                    @foreach ($accountManagers as $item)
                                        @if (in_array($item->id, $data->job_owner?? []))
                                            <option value="{{$item->id}}" selected>{{$item->full_name}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->full_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('job_owner')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="client_id">Client</label>
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
                                <label class="form-label" for="client_id">Client</label>
                                <select name="end_client_id" id="end_client_id" class="form-select mb-3" required>
                                    <option value="">Select end client</option>
                                    @foreach ($endClients as $item)
                                        <option value="{{$item->id}}">{{$item->end_client}}</option>
                                    @endforeach
                                </select>
                                @error('end_client_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="assign_recruiter">Assign recruiter(s) </label>
                                <select name="assign_recruiter[]" id="assign_recruiter" class="form-select" data-placeholder="Assign recruiter(s)" multiple>
                                    @foreach ($recruiters as $item)
                                        @if (in_array($item->id, $data->assign_recruiter?? []))
                                            <option value="{{$item->id}}" selected>{{$item->full_name}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->full_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('assign_recruiter')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('key_skills') ? ' is-invalid' : '' }}" title="Key skills" name="key_skills" id="key_skills" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value=1 id="status" checked>
                            <label class="form-check-label" for="type">Job status</label>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('notes') ? ' is-invalid' : '' }}" title="Notes" name="notes" id="notes" type="textarea" required="False"/>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control summernote {{ $errors->has('description') ? ' is-invalid' : '' }}" title="Description" name="description" id="description" type="textarea" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.job-opportunities.index')}}" class="btn btn-secondary">Cancel</a>
                            @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
                                <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
                            @endcanany
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('javascripts')
    <script src="{{asset('assets/plugins/validation/jquery.validate.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="{{asset('assets/plugins/validation/validation-script.js')}}"></script> --}}
    <script>
        $( document ).ready( function () {
            $('#description').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                ]
            });
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

        $('#client_id').change(function(){
            var id = $(this).val();
            var list = $("#end_client_id");
            var url="{{route('admin.get-end-clients','ID')}}";
            url=url.replace('ID',id);
            list.empty();
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    list.append(new Option("Select end client", ""));
                    $.each(response, function(index, item) {
                        list.append($('<option/>', {
                            value: item.id,
                            text: item.end_client,
                        }));
                    });
                },
            });
        });

        function prefillData(){
            $('#title').val('{{$data->title}}');
            $('#type').val('{{$data->type}}');
            $('#salary').val('{{$data->salary}}');
            $('#client_id').val('{{$data->client_id}}');
            $('#end_client_id').val('{{$data->end_client_id}}');
            $('#notes').val('{{$data->notes}}');
            $('#description').html('{{$data->description}}');
            $('#key_skills').val('{{$data->key_skills}}');
            var status='{{$data->status}}';
            if(status==0){
                $("#status").prop('checked', false);
            }else{
                $("#status").prop('checked', true);
            }
        }

        prefillData();

        $('#job_owner').select2();
        $('#assign_recruiter').select2();

    </script>
@endsection