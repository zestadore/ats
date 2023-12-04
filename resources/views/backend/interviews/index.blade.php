@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('title')
    ATS - Interviews
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Interviews</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Interviews</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-primary" type="button" onclick="addNew()">Add New</button>
                    {{-- <a href="{{route('admin.interviews.create')}}" class="btn btn-primary">Add New</a> --}}
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
                                    <div class="form-floating mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search with interview name">
                                        <label class="form-label" for="search">Search with interview name</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="candidate" class="form-control" placeholder="Search with candidate name">
                                        <label class="form-label" for="search">Search with candidate name</label>
                                    </div>
                                </div>
                            </div>
                        </form><br>
                        <table id="item-table" class="table table-striped table-bordered" style="white-space:pre-wrap; word-wrap:break-word;">
                            <thead>
                                <tr>
                                    <th class="nosort">#</th>
                                    <th class="nosort">{{ __('Interview Name') }}</th>
                                    <th class="nosort">{{ __('Candidate') }}</th>
                                    <th class="nosort">{{ __('Client') }}</th>
                                    <th class="nosort">{{ __('Interview Owner') }}</th>
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
                    <h5 class="modal-title">View Interview</h5>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.interviews.store')}}" id="jQueryValidationForm" method="POST" enctype="multipart/form-data">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <select name="interview_name" id="interview_name" class="form-select mb-3" required>
                                        <option value="">Select a role</option>
                                        <option value="internal_interview">Internal Interview</option>
                                        <option value="general_interview">General Interview</option>
                                        <option value="online_interview">Online Interview</option>
                                        <option value="phone_interview">Phone Interview</option>
                                        <option value="level1_interview">Level 1 Interview</option>
                                        <option value="level2_interview">Level 2 Interview</option>
                                        <option value="level3_interview">Level 3 Interview</option>
                                        <option value="level4_interview">Level 4 Interview</option>
                                    </select>
                                    <label class="form-label" for="interview_name">Interview name <span style="color:red;">*</span></label>
                                </div>
                                @error('interview_name')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <select name="candidate_id" id="candidate_id" class="form-select mb-3" required style="width: 100%;">
                                        <option value="">Select candidate</option>
                                    </select>
                                    {{-- <label class="form-label" for="candidate_id">Legal name <span style="color:red;"> *</span></label> --}}
                                </div>
                                @error('candidate_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <select name="client_id" id="client_id" class="form-select mb-3" required>
                                        <option value="">Select a client</option>
                                        @foreach ($clients as $item)
                                            <option value="{{$item->id}}">{{$item->client_name}}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="client_id">Client <span style="color:red;"> *</span></label>
                                </div>
                                @error('client_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <select name="job_opportunity_id" id="job_opportunity_id" class="form-select mb-3" required>
                                        <option value="">Select Job Opportunity</option>
                                        {{-- @foreach ($opportunities as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach --}}
                                    </select>
                                    <label class="form-label" for="job_opportunity_id">Job title <span style="color:red;"> *</span></label>
                                </div>
                                @error('job_opportunity_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" name="from_date" id="from_date" class="form-control mb-3" required>
                                    <label class="form-label" for="from_date">From <span style="color:red;"> *</span></label>
                                </div>
                                @error('from_date')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" name="to_date" id="to_date" class="form-control mb-3" required>
                                    <label class="form-label" for="to_date">To <span style="color:red;"> *</span></label>
                                </div>
                                @error('to_date')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <select name="time_zone" id="time_zone" class="form-select mb-3">
                                        <option value="">Select time zone</option>
                                        @foreach (timezone_identifiers_list() as $item)
                                            <option value="{{$item}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="time_zone">Time zone </label>
                                </div>
                                @error('time_zone')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                <div class="form-floating mb-3">
                                    <select name="interviewers_id[]" id="interviewers_id" class="form-select" data-placeholder="Select interviewer(s)" multiple style="width: 100%;">
                                        @foreach ($clients as $item)
                                            <option value="{{$item->id}}">{{$item->client_name}}</option>
                                        @endforeach
                                    </select>
                                    {{-- <label class="form-label" for="interviewers_id">Interviewer(s) </label> --}}
                                </div>
                                @error('interviewers_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <select name="interview_owner_id" id="interview_owner_id" class="form-select mb-3">
                                        <option value="">Select interview owner</option>
                                        @foreach ($users as $item)
                                            <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="interview_owner_id">Interview owner </label>
                                </div>
                                @error('interview_owner_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" title="Location" name="location" id="location" type="text" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('assesment_name') ? ' is-invalid' : '' }}" title="Assesment name" name="assesment_name" id="assesment_name" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="attachments" name="attachments[]" style="width:100% !important;" multiple>
                                    <label class="form-label" for="attachments">Attachments(.docx / .pdf / .jpg) </label>
                                </div>
                                @error("attachments")
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <x-forms.input class="form-control {{ $errors->has('comments') ? ' is-invalid' : '' }}" title="Comments" name="comments" id="comments" type="textarea" required="False"/>
                        <p> </p>
                        {{-- <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.interviews.index')}}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="float:right;">Submit</button>
                        </div> --}}
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $('#candidate_id').select2({
            dropdownParent: $("#addNewModal  .modal-content"),
            minimumInputLength: 3,
            ajax: {
                url: getUrl(),
                dataType: 'json',
            },
        });

        function getUrl(){
            var search=$('#candidate_id').val();
            var url="{{route('admin.get-candidates-list','SEARCH')}}";
            url=url.replace('SEARCH',search);
            return url;
        }

        $('#interviewers_id').select2({
            dropdownParent: $("#addNewModal  .modal-content")
        });

        $('#client_id').change(function(){
            var id = $(this).val();
            var list = $("#job_opportunity_id");
            var url="{{route('admin.get-client-job-opportunity','ID')}}";
            url=url.replace('ID',id);
            list.empty();
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    list.append(new Option("Select job opportunity", ""));
                    $.each(response, function(index, item) {
                        list.append($('<option/>', {
                            value: item.id,
                            text: item.title,
                        }));
                    });
                },
            });
        });

        function editData(id){
            $('#addNewButton').attr("data-id",id);
            var url="{{route('admin.interviews.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success==true){
                        // $('#candidate_id').val('').trigger('change');
                        $('#candidate_id').empty();
                        $('#candidate_id').append($('<option>', {
                            value: response.data.candidate.id,
                            text: response.data.candidate.candidate_name
                        }));
                        $('#job_opportunity_id').empty();
                        $('#job_opportunity_id').append($('<option>', {
                            value: response.data.job_opportunity.id,
                            text: response.data.job_opportunity.title
                        }));
                        $('#interview_name').val(response.data.interview_name);
                        $('#candidate_id').val(response.data.candidate_id);
                        $('#client_id').val(response.data.client_id);
                        $('#job_opportunity_id').val(response.data.job_opportunity_id);
                        $('#from_date').val(response.data.from_date);
                        $('#to_date').val(response.data.to_date);
                        $('#interview_owner_id').val(response.data.interview_owner_id);
                        $('#interviewers_id').val(response.data.interviewers_id).trigger('change');
                        $('#location').val(response.data.location);
                        $('#assesment_name').val(response.data.assesment_name);
                        $('#comments').val(response.data.comments);
                        $('#time_zone').val(response.data.time_zone);
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
            // var url="{{route('admin.interviews.edit','ID')}}";
            // url=url.replace('ID',id);
            // window.location.href=url;
        }

        function addNew(){
            //clear the form
            $('#jQueryValidationForm')[0].reset();
            clearValidation();
            $('#addNewButton').attr('data-id','0');
            // $('#candidate_id').val('').trigger('change');
            $('#addNewModal').modal('show');
        }

        $('#addNewButton').click(function(){
            if($('#jQueryValidationForm').valid()){
                var id=$('#addNewButton').attr('data-id');
                var formData = new FormData($('#jQueryValidationForm')[0]);
                if(id==0){
                    var url="{{route('admin.interviews.store')}}";
                    var method="post";
                }else{
                    var url="{{route('admin.interviews.update','ID')}}";
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
                        var interview_name=response.data.interview_name?response.data.interview_name:"-";
                        html+="<td>"+interview_name+"</td>";
                        html+="</tr>";  
                        html+="<tr>";
                        html+="<td>Candidate</td>";
                        var candidate_name=response.data.candidate.candidate_name?response.data.candidate.candidate_name:"-";
                        html+="<td>"+candidate_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Client</td>";
                        var client_name=response.data.client.client_name?response.data.client.client_name:"-";
                        html+="<td>"+client_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interview Owner</td>";
                        var interview_owner=response.data.interview_owners.full_name?response.data.interview_owners.full_name:"-";
                        html+="<td>"+interview_owner+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interviewer's Name</td>";
                        var interviewer_name=response.data.interviewers_names?response.data.interviewers_names:"-";
                        html+="<td>"+interviewer_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>From Date</td>";
                        var from_date=response.data.from_date?response.data.from_date:"-";
                        html+="<td>"+from_date+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>To Date</td>";
                        var to_date=response.data.to_date?response.data.to_date:"-";
                        html+="<td>"+to_date+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Location</td>";
                        var location=response.data.location?response.data.location:"-";
                        html+="<td>"+location+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Time zone</td>";
                        var time_zone=response.data.time_zone?response.data.time_zone:"-";
                        html+="<td>"+time_zone+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Comments</td>";
                        var comments=response.data.comments?response.data.comments:"-";
                        html+="<td>"+comments+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Assestement Name</td>";
                        var assesment_name=response.data.assesment_name?response.data.assesment_name:"-";
                        html+="<td>"+assesment_name+"</td>";
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

    </script>
@endsection