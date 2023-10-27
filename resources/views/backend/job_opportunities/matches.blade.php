@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <!-- include summernote css/js -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
    ATS - Job Opportunity Matches
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Job Opportunity Matches</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.job-opportunities.index')}}">Job Opportunity</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Job Opportunity Matches</li>
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
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Candidates Matches</h5>
                    <h6>Job opportunity : {{$opportunity->title}} <button class="btn btn-primary btn-sm" onclick="viewOpportunityModal('{{Crypt::encrypt($opportunity->id)}}')">View</h6>
                    <table class="table table-striped">
                        <tr>
                            <th class="nosort">#</th>
                            <th class="nosort">{{ __('Candidate Name') }}</th>
                            <th class="nosort">{{ __('Email') }}</th>
                            <th class="nosort">{{ __('Contact') }}</th>
                            <th class="nosort">{{ __('Location') }}</th>
                            <th class="nosort">{{ __('Title') }}</th>
                            <th class="nosort">Action</th>
                        </tr>
                        @foreach ($matches as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->candidate_name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->contact }}</td>
                                <td>{{ $item->location }}</td>
                                <td>{{ $item->job_title }}</td>
                                <td><a href="Javascript:void(0);" onclick="viewModal('{{Crypt::encrypt($item->id)}}')" class="btn btn-primary btn-sm"><i class="fa far fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $matches->links('pagination::bootstrap-5') }}
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
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script>
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

        function viewOpportunityModal(id){
            var url="{{route('admin.job-opportunities.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    console.log(response);
                    if(response.success==true){
                        var type="Contract";
                        $('#modalTitle').text("View Job Opportunity");
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