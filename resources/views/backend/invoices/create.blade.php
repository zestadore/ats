@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <style>
        .select2-container .select2-choice:not(.select2-default) {
            background-image: none !important;
            background-color: #f9860b;
        }
    </style>
@endsection
@section('title')
    ATS - Add New Invoice
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
                            <li class="breadcrumb-item active" aria-current="page">Add New Invoice</li>
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
                        <form action="{{route('admin.invoices.store')}}" id="jQueryValidationForm" method="POST">@csrf
                            <div class="row g-3">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                        <button type="button" class="btn blue-button btn-sm" style="float:right;" data-bs-toggle="modal" data-bs-target="#addClientModal">Add Client</button>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                        <button type="button" class="btn blue-button btn-sm" style="float:right;" data-bs-toggle="modal" data-bs-target="#addCandidateModal">Add Candidate</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                    <div class="form-floating mb-3">
                                        <select name="client_id" id="client_id" class="form-select  mb-3" data-placeholder="Select client" required>
                                            <option value="">Select a client</option>
                                            @foreach ($clients as $item)
                                                <option value="{{Crypt::encrypt($item->id)}}">{{$item->client_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="client_id">Vendor name <span style="color:red;"> *</span></label>
                                    </div>
                                    @error('interviewers_id')
                                        <span class="error mt-2 text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-floating mb-3">
                                        <select name="candidate_id" id="candidate_id" class="form-select mb-3" required>
                                            <option value="">Select candidate</option>
                                        </select>
                                        <label class="form-label" for="candidate_id">Candidate name <span style="color:red;"> *</span></label>
                                    </div>
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
                                    {{-- <button type="button" id="addDetailsButton" class="btn blue-button btn-sm" style="float: right;">Add details</button> --}}
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="nosort">{{ __('Hours') }}</th>
                                        <th class="nosort">{{ __('From date') }}</th>
                                        <th class="nosort">{{ __('To date') }}</th>
                                        <th class="nosort">{{ __('Rate') }}</th>
                                        <th class="nosort">{{ __('Amount') }}</th>
                                        <th class="nosort">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="wrapperRows"></tbody>
                            </table><p> </p>
                            <div>
                                <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                                    <a href="{{route('admin.invoices.index')}}" class="btn cancel-button">Cancel</a>
                                    <button type="submit" class="btn blue-button" style="float:right;">Generate Invoice</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" style="height: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="addClientForm">
                        <x-forms.input class="form-control {{ $errors->has('client_name') ? ' is-invalid' : '' }}" title="Client name" name="client_name" id="client_name" type="text" required="True"/>
                        <p> </p>
                        <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel-button" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn blue-button" id="addClientButton" data-bs-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addCandidateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" style="height: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="addCandidateForm">
                        <x-forms.input class="form-control {{ $errors->has('candidate_name') ? ' is-invalid' : '' }}" title="Candidate name" name="candidate_name" id="candidate_name" type="text" required="True"/>
                        <p> </p>
                        <x-forms.input class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" title="Designation" name="designation" id="designation" type="text" required="True"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel-button" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn blue-button" id="addCandidateButton" data-bs-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    {{-- <script src="{{asset('assets/plugins/validation/validation-script.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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

            $( "#addClientForm").validate( {
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

            $( "#addCandidateForm").validate( {
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
                        // html+="Poc : "+ response.poc;
                        // html+="</br>";
                        html+="Email : "+ response.email;
                        html+="</br>";
                        html+="Contact : "+ response.contact;
                        html+="</br>";
                        // html+="Location : "+ response.region;
                        // html+="</br>";
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

        $('#wrapperRows').on('click', '.addDetailsButton', function(e){
            e.preventDefault();
            rowCount++;
            addRow();
        });

        function addRow(){
            var html='{!!$renderHtml!!}';
            var dateId1='from_date_'+rowCount;
            html=html.replace('FROMDATEFIELD', dateId1);
            var dateId2='to_date_'+rowCount;
            html=html.replace('TODATEFIELD', dateId2);
            $('#wrapperRows').append(html);
            $('#'+dateId1).datepicker({
                dateFormat: 'dd-mm-yy',
                firstDay: 1
            });
            $('#'+dateId2).datepicker({
                dateFormat: 'dd-mm-yy',
                firstDay: 1
            });
        }

        $('#wrapperRows').on('click', '.remove_button', function(e){
            e.preventDefault();
            if(rowCount>1){
                $(this).parent('td').parent('tr').remove(); //Remove field html
                rowCount--; //Decrement field counter
            }
        });

        addRow();

        $(document).on("change",".hrs",function(e) { 
            calculateTotalAmount();
        });

        $(document).on("change",".rate",function(e) { 
            calculateTotalAmount();
        });

        function calculateTotalAmount(){
            const inputFields = document.querySelectorAll('.hrs');
            inputFields.forEach((inputField, index) => {
                var hrs=parseInt($(inputField).val());
                var rate=parseInt($(".rate").eq(index).val());
                var amount=hrs*rate;
                $(".amt").eq(index).val(amount);
            });
        }

        $('#addClientButton').click(function(){
            if($('#addClientForm').valid()){
                var clientName=$('#client_name').val();
                var email=$('#email').val();
                $.ajax({
                    url: "{{route('admin.add-client')}}",
                    type:"POST",
                    data:{
                        _token: "{{csrf_token()}}",
                        client_name:clientName,
                        email:email
                    },
                    success:function(response){
                        if(response.success){
                            window.location.reload();
                        }
                    }
                });
            }
        });

        $('#addCandidateButton').click(function(){
            if($('#addCandidateForm').valid()){
                var candidateName=$('#candidate_name').val();
                var title=$('#designation').val();
                $.ajax({
                    url: "{{route('admin.add-candidate')}}",
                    type:"POST",
                    data:{
                        _token: "{{csrf_token()}}",
                        candidate_name:candidateName,
                        job_title:title
                    },
                    success:function(response){
                        if(response.success){
                            window.location.reload();
                        }
                    }
                });
            }
        });

    </script>
    
@endsection