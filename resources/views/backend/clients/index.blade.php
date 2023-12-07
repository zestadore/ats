@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Clients
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Clients</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Clients</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button class="btn blue-button" type="button" onclick="addNew()">Add New</button>
                    {{-- <a href="{{route('admin.clients.create')}}" class="btn blue-button">Add New</a> --}}
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
                                    <div class="form-floating mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search with client name">
                                        <label class="form-label" for="search">Search with client name</label>
                                    </div>
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th class="nosort">{{ __('Client') }}</th>
                                    <th class="nosort">{{ __('Designation') }}</th>
                                    <th class="nosort">{{ __('Email') }}</th>
                                    <th class="nosort">{{ __('Contact') }}</th>
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
                    <h5 class="modal-title">View Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="view-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel-button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addNewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jQueryValidationForm" method="POST">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('client_name') ? ' is-invalid' : '' }}" title="Client name" name="client_name" id="client_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('poc') ? ' is-invalid' : '' }}" title="PoC" name="poc" id="poc" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" title="Designation" name="designation" id="designation" type="text" required="False"/>
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
                                <x-forms.input class="form-control {{ $errors->has('region') ? ' is-invalid' : '' }}" title="Region" name="region" id="region" type="text" required="True"/>
                            </div>
                        </div><p> </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel-button" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-submit" id="addNewButton" data-id="0">Submit</button>
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
    <script>
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
                    "url": '{{route("admin.clients.index")}}',
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
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'designation',
                        name: 'designation'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
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
            var url="{{route('admin.clients.show','ID')}}";
            url=url.replace('ID',id);
            clearValidation();
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success==true){
                        $('#jQueryValidationForm')[0].reset();
                        $('#client_name').val(response.data.client_name);
                        $('#designation').val(response.data.designation);
                        $('#email').val(response.data.email);
                        $('#contact').val(response.data.contact);
                        $('#region').val(response.data.region);
                        $('#poc').val(response.data.poc);
                        $('#addNewModal').modal('show');
                        $('#addNewModalLabel').text("{{getPageTitle(request()->route()->getName(), 'Edit')}}");
                    }else{
                        // swal("Oops!", "Failed to fetch the data!", "error");
                        $('#toast-body').text("Failed to fetch the data!");
                        $('#toast_class').addClass('bg-danger');
                        $('#toast_class').removeClass('bg-success');
                        window.scrollTo(0, 0);
                        toastList.forEach(toast => toast.show());
                    }
                },
            });
            // var url="{{route('admin.clients.edit','ID')}}";
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
                    var url="{{route('admin.clients.destroy','ID')}}";
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
                                // swal("Good job!", "You deleted the data!", "success");
                                $('#toast-body').text("You deleted the data!");
                                $('#toast_class').addClass('bg-success');
                                $('#toast_class').removeClass('bg-danger');
                                window.scrollTo(0, 0);
                                toastList.forEach(toast => toast.show());
                                drawTable();
                            }else{
                                // swal("Oops!", "Failed to deleted the data!", "danger");
                                $('#toast-body').text("You deleted the data!");
                                $('#toast_class').addClass('bg-danger');
                                $('#toast_class').removeClass('bg-success');
                                window.scrollTo(0, 0);
                                toastList.forEach(toast => toast.show());
                            }
                        },
                    });
                }
            })
        }

        function endClients(id){
            var url="{{route('admin.clients.end-clients.index','ID')}}";
            url=url.replace('ID',id);
            window.location.href=url;
        }

        function viewModal(id){
                var url="{{route('admin.clients.show','ID')}}";
                url=url.replace('ID',id);
                $.ajax({
                    url: url,
                    type:"get",
                    success:function(response){
                        console.log(response);
                        if(response.success==true){
                            var html="<table class='table table-striped table-bordered'>";
                            html+="<tr>";
                            html+="<td>Client Name</td>";
                            var client_name=response.data.client_name?response.data.client_name:"-";
                            html+="<td>"+client_name+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Poc</td>";
                            var poc=response.data.poc?response.data.poc:"-";
                            html+="<td>"+poc+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Designation</td>";
                            var designation=response.data.designation?response.data.designation:"-";
                            html+="<td>"+designation+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Email</td>";
                            var email=response.data.email?response.data.email:"-";
                            html+="<td>"+email+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Contact</td>";
                            var contact=response.data.contact?response.data.contact:"-";
                            html+="<td>"+contact+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Region</td>";
                            var region=response.data.region?response.data.region:"-";
                            html+="<td>"+region+"</td>";
                            html+="</tr>";
                            html+="</table>";
                            html=html+"</html>";
                            $('#view-modal-body').html(html);
                            $('#exampleLargeModal').modal('show');
                        }else{
                            // swal("Oops!", "Failed to fetch the data!", "error");
                        $('#toast-body').text("Failed to fetch the data!");
                        $('#toast_class').addClass('bg-danger');
                        $('#toast_class').removeClass('bg-success');
                        window.scrollTo(0, 0);
                        toastList.forEach(toast => toast.show());
                        }
                    },
                });
            }

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

            function addNew(){
                //clear the form
                $('#jQueryValidationForm')[0].reset();
                clearValidation();
                $('#addNewButton').attr('data-id','0');
                $('#addNewModal').modal('show');
                $('#addNewModalLabel').text("{{getPageTitle(request()->route()->getName(), ' Add New')}}");
            }

            $('#addNewButton').click(function(){
                clearValidation();
                if($('#jQueryValidationForm').valid()){
                    var id=$('#addNewButton').attr('data-id');
                    if(id==0){
                        var url="{{route('admin.clients.store')}}";
                        var method="post";
                    }else{
                        var url="{{route('admin.clients.update','ID')}}";
                        url=url.replace('ID',id);
                        var method="put";
                    }
                    //submit form via ajax
                    $.ajax({
                        url:url,
                        "headers": {"X-Requested-With":'XMLHttpRequest'},
                        method:method,
                        data:$('#jQueryValidationForm').serialize(),
                        success:function(response){
                            console.log(response);
                            if(response.success==true){
                                // swal("Good job!", "Data added successfully", "success");
                                $('#toast-body').text("Data added successfully");
                                $('#toast_class').addClass('bg-success');
                                $('#toast_class').removeClass('bg-danger');
                                window.scrollTo(0, 0);
                                toastList.forEach(toast => toast.show());
                                $('#addNewModal').modal('hide');
                                $('#jQueryValidationForm')[0].reset();
                                clearValidation();
                                drawTable();
                            }else{
                                $('#toast-body').text("Failed to add the data!");
                                $('#toast_class').addClass('bg-danger');
                                $('#toast_class').removeClass('bg-success');
                                window.scrollTo(0, 0);
                                toastList.forEach(toast => toast.show());
                                // swal("Oops!", "Failed to add the data!", "error");
                            }
                        }
                    });
                }
            })

    </script>
@endsection