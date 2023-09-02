@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <!-- include summernote css/js -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('title')
    ATS - Candidate Matches
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Candidate Matches</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.candidates.index')}}">Candidates</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Candidate Matches</li>
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
                    <table class="table table-striped">
                        <tr>
                            <th class="nosort">#</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Job Owner') }}</th>
                            <th>{{ __('Client') }}</th>
                            <th>{{ __('Key Skills') }}</th>
                            <th class="nosort">Action</th>
                        </tr>
                        @foreach ($matches as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    @if ($item->type==0)
                                        Contract
                                    @else
                                        Fulltime
                                    @endif
                                </td>
                                <td>{{ $item->job_owner_names }}</td>
                                <td>{{ $item->client?->client_name }}</td>
                                <td>{{ $item->key_skills }}</td>
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