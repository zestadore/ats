@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
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
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Invoices</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.invoices.index')}}">Invoices</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Invoice</li>
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
            <div class="bs-stepper">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Add New Invoice</h5>
                        <form action="{{route('admin.invoices.update',Crypt::encrypt($data->id))}}" id="jQueryValidationForm" method="POST">@csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                    <label class="form-label" for="client_id">Vendor name <span style="color:red;"> *</span></label>
                                    <select name="client_id" id="client_id" class="form-select" data-placeholder="Select client" required>
                                        <option value="">Select a client</option>
                                        @foreach ($clients as $item)
                                            <option value="{{Crypt::encrypt($item->id)}}">{{$item->client_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('interviewers_id')
                                        <span class="error mt-2 text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="form-label" for="candidate_id">Candidate name <span style="color:red;"> *</span></label>
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
                                    <span id="vendorAddress"></span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <button type="button" id="addDetailsButton" class="btn btn-primary btn-sm" style="float: right;">Add details</button>
                                </div>
                            </div>
                            <div id="wrapperRows"></div><p> </p>
                            <div>
                                <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                                    <a href="{{route('admin.invoices.index')}}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
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

        $('#candidate_id').select2({
            minimumInputLength: 3,
            ajax: {
                url: getUrl(),
                dataType: 'json',
            },
        });

        $('#client_id').change(function(){
            var id = $(this).val();
            var url="{{route('admin.clients.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success==true){
                        response = response.data;
                        html="";
                        html+="Poc : "+ response.poc;
                        html+="</br>";
                        html+="Email : "+ response.email;
                        html+="</br>";
                        html+="Contact : "+ response.contact;
                        html+="</br>";
                        html+="Location : "+ response.region;
                        html+="</br>";
                        $('#vendorAddress').html(html);
                    }
                }
            });
        });

        function getUrl(){
            var search=$('#candidate_id').val();
            var url="{{route('admin.get-candidates-list','SEARCH')}}";
            url=url.replace('SEARCH',search);
            return url;
        }

        $('#addDetailsButton').click(function(){
            rowCount++;
            addRow();
        });

        function addRow(){
            $('#wrapperRows').append('{!!$renderHtml!!}');
        }

        $('#wrapperRows').on('click', '.remove_button', function(e){
            e.preventDefault();
            if(rowCount>1){
                $(this).parent('div').remove(); //Remove field html
                rowCount--; //Decrement field counter
            }
        });

        addRow();

        function prefillForm(){
            $('#candidate_id').val('{{$data->candidate_id}}').trigger('change');
            $('#client_id').val('{{Crypt::encrypt($data->client_id)}}').trigger('change');
        }

        prefillForm();

    </script>
@endsection