@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
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
    ATS - Candidates
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Candidates</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Candidates</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{route('admin.candidates.create')}}" class="btn btn-primary">Add New</a>
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
                                    <input type="text" name="search" class="form-control" placeholder="Search with candidate name">
                                </div>
                                <div class="col">
                                    <input type="text" name="location" class="form-control" placeholder="Search with location">
                                </div>
                                <div class="col">
                                    <input type="text" name="title" class="form-control" placeholder="Search with title">
                                </div>
                                <div class="col">
                                    <input type="text" name="contact" class="form-control" placeholder="Search with contact">
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th>{{ __('Candidate Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Contact') }}</th>
                                    <th>{{ __('Location') }}</th>
                                    <th>{{ __('Title') }}</th>
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
                    <h5 class="modal-title">View Candidate</h5>
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
                    "url": '{{route("admin.candidates.index")}}',
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
                        data: 'candidate_name',
                        name: 'candidate_name'
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
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'job_title',
                        name: 'job_title'
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
            var url="{{route('admin.candidates.edit','ID')}}";
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
                    var url="{{route('admin.candidates.destroy','ID')}}";
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
                var url="{{route('admin.candidates.show','ID')}}";
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
                            html+="<td>Candidate Name</td>";
                            var candidate_name=response.data.candidate_name?response.data.candidate_name:"-";
                            html+="<td>"+candidate_name+"</td>";
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
                            html+="<td>Key skills</td>";
                            var key_skills=response.data.key_skills?response.data.key_skills:"-";
                            html+="<td>"+key_skills+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Location</td>";
                            var location=response.data.location?response.data.location:"-";
                            html+="<td>"+location+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>LinkedIn</td>";
                            var linked_in=response.data.linked_in?response.data.linked_in:"-";
                            html+="<td>"+linked_in+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Visa status</td>";
                            var visa_status=response.data.visa_status?response.data.visa_status:"-";
                            html+="<td>"+visa_status+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Candidate type</td>";
                            var candidate_type=response.data.candidate_type?response.data.candidate_type:"-";
                            html+="<td>"+candidate_type+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Job tag</td>";
                            var job_tag=response.data.job_tag?response.data.job_tag:"-";
                            html+="<td>"+job_tag+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Job Title</td>";
                            var job_title=response.data.job_title?response.data.job_title:"-";
                            html+="<td>"+job_title+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Notes</td>";
                            var notes=response.data.notes?response.data.notes:"-";
                            html+="<td>"+notes+"</td>";
                            html+="</tr>";
                            html+="<tr>";
                            html+="<td>Resume</td>";
                            if(response.data.resume_path==null || response.data.resume_path==""){
                                html+="<td style='color:red;'>Resume not uploaded</td>";
                            }else{
                                html+="<td><a href='#'class='viewAttachment' data-url='"+response.data.resume_path+"'>View</a></td>";
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