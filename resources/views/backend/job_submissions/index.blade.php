@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <style>
        #viewLargeModal .modal-dialog {
        height: 100%; /* = 90% of the .modal-backdrop block = %90 of the screen */
        }
        #viewLargeModal .modal-content {
        height: 100%; /* = 100% of the .modal-dialog block */
        }
    </style>
@endsection
@section('title')
    ATS - Job Submissions
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Job Submissions</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Job Submissions</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{route('admin.job-submissions.create')}}" class="btn btn-primary">Add New</a>
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
                                <div class="col">
                                    <input type="text" name="candidate" class="form-control" placeholder="Search with candidate">
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th>{{ __('Job Title') }}</th>
                                    <th>{{ __('Candidate') }}</th>
                                    <th>{{ __('Contact') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Current Location') }}</th>
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
                    <h5 class="modal-title">View Job Submission</h5>
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
    <div class="modal fade" id="viewLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="height: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Attachment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="view-attachment-body"></div>
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
                    "url": '{{route("admin.job-submissions.index")}}',
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
                        data: 'job_opportunity',
                        name: 'job_opportunity'
                    },
                    {
                        data: 'candidate',
                        name: 'candidate'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'email_id',
                        name: 'email_id'
                    },
                    {
                        data: 'current_location',
                        name: 'current_location'
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
            var url="{{route('admin.job-submissions.edit','ID')}}";
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
                    var url="{{route('admin.job-submissions.destroy','ID')}}";
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
            });
        }

        function viewModal(id){
            var url="{{route('admin.job-submissions.show','ID')}}";
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
                            html2+="<tr>";
                            html2+="<td>Additional Attachments</td>";
                            html2+="</tr>";
                            $.each(atts, function( index, value ) {
                                html2+="<tr>";
                                html2+="<td>"+value.description+"</td>";
                                html2+="<td><a href='#'class='viewAttachment' data-url='"+value.attachment_path+"'>View</a></td>";
                                html2+="</tr>";
                            });
                        }
                        var html="<table class='table table-striped table-bordered'>";
                        html+="<tr>";
                        html+="<td>Job title</td>";
                        var title=response.data.job_opportunity.title?response.data.job_opportunity.title:"-";
                        html+="<td>"+title+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Candidate</td>";
                        var candidate=response.data.candidate.candidate_name?response.data.candidate.candidate_name:"-";
                        html+="<td>"+candidate+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Contact</td>";
                        var contact=response.data.contact?response.data.contact:"-";
                        html+="<td>"+contact+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Email</td>";
                        var email_id=response.data.email_id?response.data.email_id:"-";
                        html+="<td>"+email_id+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Current location</td>";
                        var current_location=response.data.current_location?response.data.current_location:"-";
                        html+="<td>"+current_location+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Total experience</td>";
                        var total_experience=response.data.total_experience?response.data.total_experience:"-";
                        html+="<td>"+total_experience+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Relevant experience</td>";
                        var relevant_experience=response.data.relevant_experience?response.data.relevant_experience:"-";
                        html+="<td>"+relevant_experience+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Visa status</td>";
                        var visa_status=response.data.visa_status?response.data.visa_status:"-";
                        html+="<td>"+visa_status+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Education</td>";
                        var education=response.data.education?response.data.education:"-";
                        html+="<td>"+education+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Rate</td>";
                        var rate=response.data.rate?response.data.rate:"-";
                        html+="<td>"+rate+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Notice period</td>";
                        var notice_period=response.data.notice_period?response.data.notice_period:"-";
                        html+="<td>"+notice_period+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Candidate type</td>";
                        var candidate_type=response.data.candidate_type?response.data.candidate_type:"-";
                        html+="<td>"+candidate_type+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Relocation</td>";
                        var relocation=response.data.relocation?response.data.relocation:"-";
                        html+="<td>"+relocation+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interview availability</td>";
                        var interview_availability=response.data.interview_availability?response.data.interview_availability:"-";
                        html+="<td>"+interview_availability+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Resume</td>";
                        if(response.data.resume_path!==null && response.data.resume_path!="" && response.data.resume_path!="null"){
                            html+="<td><a href='#'class='viewAttachment' data-url='"+response.data.resume_path+"'>View</a></td>";
                        }else{
                            html+="<td style='color:red;'>Resume not uploaded</td>";
                        }
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

        $(document).on('click', '.viewAttachment', function(e){
            e.preventDefault();
            var url=$(this).data('url');
            var html="";
            html+='<iframe src="'+url+'" width="100%" height="100%"></iframe>';
            $('#view-attachment-body').html(html);
            // $('#exampleLargeModal').modal('hide');
            $('#viewLargeModal').modal('show');
        });

    </script>
@endsection