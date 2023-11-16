@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Pricing Plans
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pricing Plans</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Pricing Plans</li>
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
                                    <input type="text" name="search" class="form-control" placeholder="Search with plan name">
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th class="nosort">{{ __('Plan Name') }}</th>
                                    <th class="nosort">{{ __('Price/User Monthly') }}</th>
                                    <th class="nosort">{{ __('Price/User Yearly') }}</th>
                                    <th class="nosort">{{ __('Excluded Permissions') }}</th>
                                    <th class="nosort">{{ __('Trail Days') }}</th>
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
                    <h5 class="modal-title">View Plan</h5>
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
    <div class="modal fade" id="addNewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jQueryValidationForm" method="POST">@csrf
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('plan_name') ? ' is-invalid' : '' }}" title="Pricing plan name" name="plan_name" id="plan_name" type="text" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('price_per_user') ? ' is-invalid' : '' }}" title="Monthly price per user" name="price_per_user" id="price_per_user" type="number" required="True"/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('price_per_user_yearly') ? ' is-invalid' : '' }}" title="Yearly price per user" name="price_per_user_yearly" id="price_per_user_yearly" type="number" required="True"/>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('trail_days') ? ' is-invalid' : '' }}" title="Trail days" name="trail_days" id="trail_days" type="number" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <select name="permissions[]" class="form-select" id="permissions" multiple>
                                        <option value="Matches">Matches</option>
                                        <option value="Autofill">Autofill</option>
                                    </select>
                                    <label for="permissions">Excluded permissions</label>
                                    @error('permissions')
                                        <span class="error mt-2 text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" title="Description" name="description" id="description" type="textarea" required="False"/>
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
                    "url": '{{route("admin.pricing-plans.index")}}',
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
                        data: 'plan_name',
                        name: 'plan_name'
                    },
                    {
                        data: 'price_per_user',
                        name: 'price_per_user'
                    },
                    {
                        data: 'price_per_user_yearly',
                        name: 'price_per_user_yearly'
                    },
                    {
                        data: 'permissions',
                        name: 'permissions'
                    },
                    {
                        data: 'trail_days',
                        name: 'trail_days'
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
            var url="{{route('admin.pricing-plans.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success==true){
                        $('#jQueryValidationForm')[0].reset();
                        $('#plan_name').val(response.data.plan_name);
                        $('#price_per_user').val(response.data.price_per_user);
                        $('#trail_days').val(response.data.trail_days);
                        $('#description').val(response.data.description);
                        $('#price_per_user_yearly').val(response.data.price_per_user_yearly);
                        $('#permissions').val(response.data.permissions);
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
                    var url="{{route('admin.pricing-plans.destroy','ID')}}";
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
                var url="{{route('admin.pricing-plans.show','ID')}}";
                url=url.replace('ID',id);
                $.ajax({
                    url: url,
                    type:"get",
                    success:function(response){
                        console.log(response);
                        if(response.success==true){
                            var html="<table class='table table-striped table-bordered'>";
                            html+="<tr>";
                            html+="<td>Plan Name</td>";
                            html+="<td>"+response.data.plan_name+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Price/User Monthly</td>";
                            html+="<td>"+response.data.price_per_user+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Price/User Yearly</td>";
                            html+="<td>"+response.data.price_per_user_yearly+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Trail Days</td>";
                            html+="<td>"+response.data.trail_days+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Permissions</td>";
                            if(response.data.permissions!=null){
                                html+="<td>"+response.data.permissions+"</td>";
                            }else{
                                html+="<td> </td>";
                            }
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Description</td>";
                            html+="<td>"+response.data.description+"</td>";
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
                $('#addNewButton').attr('data-id','0');
                $('#addNewModal').modal('show');
            }

            $('#addNewButton').click(function(){
                if($('#jQueryValidationForm').valid()){
                    var id=$('#addNewButton').attr('data-id');
                    if(id==0){
                        var url="{{route('admin.pricing-plans.store')}}";
                        var method="post";
                    }else{
                        var url="{{route('admin.pricing-plans.update','ID')}}";
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