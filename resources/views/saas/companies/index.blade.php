@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Companies
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Companies</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Companies</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-primary" type="button" onclick="addNew()">Add New</button>
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
                                    <input type="text" name="search" class="form-control" placeholder="Search with company name">
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th class="nosort">{{ __('Company') }}</th>
                                    <th class="nosort">{{ __('Contact') }}</th>
                                    <th class="nosort">{{ __('Address') }}</th>
                                    {{-- <th class="nosort">{{ __('Pricing Plan') }}</th>
                                    <th class="nosort">{{ __('No of Users') }}</th>
                                    <th class="nosort">{{ __('No of Invoices') }}</th> --}}
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
                    <h5 class="modal-title">View Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="view-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jQueryValidationForm" method="POST" enctype="multipart/form-data">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" title="Company name" name="company_name" id="company_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}" title="Logo" name="logo" id="logo" type="file" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" title="Address" name="address" id="address" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <h6>For Admin Access</h6><hr>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" title="First name" name="first_name" id="first_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" title="Last name" name="last_name" id="last_name" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" title="Mobile" name="mobile" id="mobile" type="number" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('password_string') ? ' is-invalid' : '' }}" title="Password" name="password_string" id="password_string" type="password" required="False"/>
                            </div>
                        </div><p> </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addNewButton" data-id="0">Submit</button>
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
                    "url": '{{route("admin.companies.index")}}',
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
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    // {
                    //     data: 'plan',
                    //     name: 'plan'
                    // },
                    // {
                    //     data: 'users',
                    //     name: 'users'
                    // },
                    // {
                    //     data: 'invoices',
                    //     name: 'invoices'
                    // },
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
            var url="{{route('admin.companies.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success==true){
                        $('#jQueryValidationForm')[0].reset();
                        clearValidation();
                        $('#company_name').val(response.data.company_name);
                        $('#address').val(response.data.address);
                        $('#pricing_plan_id').val(response.data.pricing_plan_id);
                        if(response.data.company_admin){
                            $('#first_name').val(response.data.company_admin.first_name);
                            $('#last_name').val(response.data.company_admin.last_name);
                            $('#email').val(response.data.company_admin.email);
                            $('#mobile').val(response.data.company_admin.mobile);
                        }else{
                            $('#first_name').val('');
                            $('#last_name').val('');
                            $('#email').val('');
                            $('#mobile').val('');
                        }
                        $('#addNewModal').modal('show');
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
                    var url="{{route('admin.companies.destroy','ID')}}";
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

        function viewModal(id){
            var url="{{route('admin.companies.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    console.log(response);
                    if(response.success==true){
                        var html="<table class='table table-striped table-bordered'>";
                        html+="<tr>";
                        html+="<td>Company Name</td>";
                        html+="<td>"+response.data.company_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Logo</td>";
                        if(response.data.logo!=null && response.data.logo!=""){
                            html+="<td><img src='"+window.location.origin+"/uploads/logos/"+response.data.logo+"'/></td>";
                        }else{
                            html+="<td> </td>";
                        }
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Address</td>";
                        html+="<td>"+response.data.address+"</td>";
                        html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>Website</td>";
                        // html+="<td>"+response.data.website+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>Date format</td>";
                        // html+="<td>"+response.data.date_format+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>Time zone</td>";
                        // html+="<td>"+response.data.time_zone+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>Currency symbol</td>";
                        // html+="<td>"+response.data.currency_symbol+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>Currency position</td>";
                        // html+="<td>"+response.data.currency_position+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>Precision</td>";
                        // html+="<td>"+response.data.precision+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>Invoice footer</td>";
                        // html+="<td>"+response.data.invoice_footer+"</td>";
                        // html+="</tr>";
                        html+="<tr>";
                        html+="<td>Address</td>";
                        html+="<td>"+response.data.address+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        // html+="<td>Pricing Plan</td>";
                        // html+="<td>"+response.data.pricing_plan.plan_name+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>No of Users</td>";
                        // html+="<td>"+response.data.pricing_plan.maximum_users+"</td>";
                        // html+="</tr>";
                        // html+="<tr>";
                        // html+="<td>No of Invoices</td>";
                        // html+="<td>"+response.data.pricing_plan.monthly_invoices+"</td>";
                        // html+="</tr>";
                        html+="<tr>";
                        html+="<td colspan='2' style='text-align:center;font-weight:bold;'>Admin details</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Name</td>";
                        if(response.data.company_admin){
                            html+="<td>"+response.data.company_admin.full_name+"</td>";
                        }else{
                            html+="<td> </td>";
                        }
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Email</td>";
                        if(response.data.company_admin){
                            html+="<td>"+response.data.company_admin.email+"</td>";
                        }else{
                            html+="<td> </td>";
                        }
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Mobile/Contact</td>";
                        if(response.data.company_admin){
                            html+="<td>"+response.data.company_admin.mobile+"</td>";
                        }else{
                            html+="<td> </td>";
                        }
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
            }

            $('#addNewButton').click(function(){
                if($('#jQueryValidationForm').valid()){
                    var id=$('#addNewButton').attr('data-id');
                    var form = $('#jQueryValidationForm')[0];
                    var formData = new FormData(form);
                    if(id==0){
                        var url="{{route('admin.companies.store')}}";
                        var method="post";
                    }else{
                        var url="{{route('admin.companies.update','ID')}}";
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
            });


    </script>
@endsection