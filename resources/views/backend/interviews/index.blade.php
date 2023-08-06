@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Interviews
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Interviews</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Interviews</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{route('admin.interviews.create')}}" class="btn btn-primary">Add New</a>
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
                                    <input type="text" name="search" class="form-control" placeholder="Search with interview name">
                                </div>
                                <div class="col">
                                    <input type="text" name="candidate" class="form-control" placeholder="Search with candidate name">
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th>{{ __('Interview Name') }}</th>
                                    <th>{{ __('Candidate') }}</th>
                                    <th>{{ __('Client') }}</th>
                                    <th>{{ __('Interview Owner') }}</th>
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
                    <h5 class="modal-title">View User</h5>
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
                    "url": '{{route("admin.interviews.index")}}',
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
                        data: 'interview_name',
                        name: 'interview_name',
                        render: function(data) {
                            var name=data.replace('_', ' ');
                            return name.toUpperCase();
                        }
                    },
                    {
                        data: 'candidate',
                        name: 'candidate'
                    },
                    {
                        data: 'client',
                        name: 'client'
                    },
                    {
                        data: 'interview_owner',
                        name: 'interview_owner'
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
            var url="{{route('admin.interviews.edit','ID')}}";
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
                    var url="{{route('admin.interviews.destroy','ID')}}";
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
            var url="{{route('admin.interviews.show','ID')}}";
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
                            $.each(atts, function( index, value ) {
                                html2+="<tr>";
                                html2+="<td>Additinal Attachment</td>";
                                html2+="<td><a target='_blank' href='"+value.attachment_path+"'>View</a></td>";
                                html2+="</tr>";
                            });
                        }
                        var html="<table class='table table-striped table-bordered'>";
                        html+="<tr>";
                        html+="<td>Interview Name</td>";
                        html+="<td>"+response.data.interview_name+"</td>";
                        html+="</tr>";  
                        html+="<tr>";
                        html+="<td>Candidate</td>";
                        html+="<td>"+response.data.candidate.candidate_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Client</td>";
                        html+="<td>"+response.data.client.client_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interview Owner</td>";
                        html+="<td>"+response.data.interview_owners.full_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interviewer's Name</td>";
                        html+="<td>"+response.data.interviewers_names+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>From Date</td>";
                        html+="<td>"+response.data.from_date+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>To Date</td>";
                        html+="<td>"+response.data.to_date+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Location</td>";
                        html+="<td>"+response.data.location+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Comments</td>";
                        html+="<td>"+response.data.comments+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Assestement Name</td>";
                        html+="<td>"+response.data.assesment_name+"</td>";
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

    </script>
@endsection