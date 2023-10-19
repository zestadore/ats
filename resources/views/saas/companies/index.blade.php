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
                    <a href="{{route('admin.companies.create')}}" class="btn btn-primary">Add New</a>
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
@endsection
@section('javascripts')
    <script src="{{asset('assets/css/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/css/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
            var url="{{route('admin.companies.edit','ID')}}";
            url=url.replace('ID',id);
            window.location.href=url;
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
                                swal("Good job!", "You deleted the data!", "success");
                                drawTable();
                            }else{
                                swal("Oops!", "Failed to deleted the data!", "danger");
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
                        html+="<tr>";
                        html+="<td>Website</td>";
                        html+="<td>"+response.data.website+"</td>";
                        html+="</tr>";
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
                        html+="<td>"+response.data.company_admin.full_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Email</td>";
                        html+="<td>"+response.data.company_admin.email+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Mobile/Contact</td>";
                        html+="<td>"+response.data.company_admin.mobile+"</td>";
                        html+="</tr>";
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


    </script>
@endsection