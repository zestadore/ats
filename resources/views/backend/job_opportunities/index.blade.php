@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Job Opportunities
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Job Opportunities</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Job Opportunities</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
                        <a href="{{route('admin.job-opportunities.create')}}" class="btn btn-primary">Add New</a>
                    @endcanany
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
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Job Owner') }}</th>
                                    <th>{{ __('Job Status') }}</th>
                                    <th>{{ __('Client') }}</th>
                                    <th>{{ __('End Client') }}</th>
                                    <th>{{ __('Key Skills') }}</th>
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
                    <h5 class="modal-title">View Job Opportunity</h5>
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
                    "url": '{{route("admin.job-opportunities.index")}}',
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
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        render: function(data) {
                            if(data==0){
                                return "Contract";
                            }else if(data==1){
                                return "Fulltime";
                            }
                        }
                    },
                    {
                        data: 'job_owner_names',
                        name: 'job_owner_names'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if(data==0){
                                return "<span class='badge bg-danger'>Inactive</span>";
                            }else if(data==1){
                                return "<span class='badge bg-success'>Active</span>";
                            }
                        }
                    },
                    {
                        data: 'client',
                        name: 'client'
                    },
                    {
                        data: 'end_client',
                        name: 'end_client'
                    },
                    {
                        data: 'key_skills',
                        name: 'key_skills'
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
            var url="{{route('admin.job-opportunities.edit','ID')}}";
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
                    var url="{{route('admin.job-opportunities.destroy','ID')}}";
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
            var url="{{route('admin.job-opportunities.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    console.log(response);
                    if(response.success==true){
                        var type="Contract";
                        if(response.data.type==1){
                            type="Fulltime";
                        }
                        var status="Active";
                        if(response.data.status==0){
                            status="Inactive";
                        }
                        var html="<table class='table table-striped table-bordered'>";
                        html+="<tr>";
                        html+="<td>Title</td>";
                        var title=response.data.title?response.data.title:"-";
                        html+="<td>"+title+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Type</td>";
                        html+="<td>"+type+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Job Owner</td>";
                        var job_owner=response.data.job_owner_names?response.data.job_owner_names:"-";
                        html+="<td>"+job_owner+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Assign Recruiter</td>";
                        var assign_recruiter=response.data.assign_recruiter_names?response.data.assign_recruiter_names:"-";
                        html+="<td>"+assign_recruiter+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Status</td>";
                        html+="<td>"+status+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Client</td>";
                        var client=response.data.client.client_name?response.data.client.client_name:"-";
                        html+="<td>"+client+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>End Client</td>";
                        var end_client=response.data.end_client.end_client?response.data.end_client.end_client:"-";
                        html+="<td>"+end_client+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Key Skills</td>";
                        var key_skills=response.data.key_skills?response.data.key_skills:"-";
                        html+="<td>"+key_skills+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Notes</td>";
                        var notes=response.data.notes?response.data.notes:"-";
                        html+="<td>"+notes+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Description</td>";
                        var description=response.data.description?response.data.description:"-";
                        html+="<td>"+description+"</td>";
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