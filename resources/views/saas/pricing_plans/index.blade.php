@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Pricing Plans
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pricing Plans</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Pricing Plans</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{route('admin.pricing-plans.create')}}" class="btn btn-primary">Add New</a>
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
                                    <th>{{ __('Plan Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Interval') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Max Users') }}</th>
                                    <th>{{ __('Max Invoices') }}</th>
                                    <th>{{ __('Trail Days') }}</th>
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
@endsection
@section('javascripts')
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
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
                        data: 'plan_type',
                        name: 'plan_type',
                        render: function(data) {
                            return data.toUpperCase();
                        }
                    },
                    {
                        data: 'plan_interval',
                        name: 'plan_interval',
                        render: function(data) {
                            if(data==0){
                                return "Monthly";
                            }else{
                                return "Yearly";
                            }
                        }
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'maximum_users',
                        name: 'maximum_users'
                    },
                    {
                        data: 'monthly_invoices',
                        name: 'monthly_invoices'
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
            var url="{{route('admin.pricing-plans.edit','ID')}}";
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
                            html+="<td>Plan Type</td>";
                            html+="<td>"+response.data.plan_type.toUpperCase()+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Plan Interval</td>";
                            if(response.data.plan_interval==0){
                                html+="<td>Monthly</td>";
                            }else{
                                html+="<td>Yearly</td>";

                            }
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Price</td>";
                            html+="<td>"+response.data.price+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Maximum Users</td>";
                            html+="<td>"+response.data.maximum_users+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Monthly Invoices</td>";
                            html+="<td>"+response.data.monthly_invoices+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Trail Days</td>";
                            html+="<td>"+response.data.trail_days+"</td>";
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