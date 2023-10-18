@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('title')
    ATS - Job Opportunities
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Job Opportunities</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Job Opportunities</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
                        <button class="btn btn-primary" type="button" onclick="addNew()">Add New</button>
                        {{-- <a href="{{route('admin.job-opportunities.create')}}" class="btn btn-primary">Add New</a> --}}
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
                                    <th>{{ __('Matches') }}</th>
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
    <!-- Modal -->
    <div class="modal fade" id="addNewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jQueryValidationForm" method="POST">@csrf
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" title="Job title" name="title" id="title" type="text" required="True"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="type">Job type</label>
                                <select name="type" id="type" class="form-select mb-3">
                                    <option value="0">Contract</option>
                                    <option value="1">Full time</option>
                                </select>
                                @error('type')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('salary') ? ' is-invalid' : '' }}" title="Salary" name="salary" id="salary" type="number" required="False"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="job_owner">Job owner(s) </label>
                                <select name="job_owner[]" id="job_owner" class="form-select" data-placeholder="Select job owner(s)" multiple style="width: 100%;">
                                    @foreach ($accountManagers as $item)
                                        <option value="{{$item->id}}">{{$item->full_name}}</option>
                                    @endforeach
                                </select>
                                @error('job_owner')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="client_id">Client</label>
                                <select name="client_id" id="client_id" class="form-select mb-3" required>
                                    <option value="">Select a client</option>
                                    @foreach ($clients as $item)
                                        <option value="{{$item->id}}">{{$item->client_name}}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="client_id">Client</label>
                                <select name="end_client_id" id="end_client_id" class="form-select mb-3" required>
                                    <option value="">Select end client</option>
                                </select>
                                @error('end_client_id')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><p> </p>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label class="form-label" for="assign_recruiter">Assign recruiter(s) </label>
                                <select name="assign_recruiter[]" id="assign_recruiter" class="form-select" data-placeholder="Assign recruiter(s)" multiple style="width: 100%;">
                                    @foreach ($recruiters as $item)
                                        <option value="{{$item->id}}">{{$item->full_name}}</option>
                                    @endforeach
                                </select>
                                @error('job_owner')
                                    <span class="error mt-2 text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('key_skills') ? ' is-invalid' : '' }}" title="Key skills" name="key_skills" id="key_skills" type="text" required="False"/>
                            </div>
                        </div><p> </p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value=1 id="status" checked>
                            <label class="form-check-label" for="type">Job status</label>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control {{ $errors->has('notes') ? ' is-invalid' : '' }}" title="Notes" name="notes" id="notes" type="textarea" required="False"/>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <x-forms.input class="form-control summernote {{ $errors->has('description') ? ' is-invalid' : '' }}" title=" " name="description" id="description" type="textarea" required="False"/>
                            </div>
                        </div><p> </p>
                        {{-- <div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
                            <a href="{{route('admin.job-opportunities.index')}}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/css/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/css/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script>
        $('#job_owner').select2({
            dropdownParent: $("#addNewModal  .modal-content")
        });
        $('#assign_recruiter').select2({
            dropdownParent: $("#addNewModal  .modal-content")
        });
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
                        data: 'matches',
                        name: 'matches'
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
            $('#addNewButton').attr("data-id",id);
            var url="{{route('admin.job-opportunities.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success==true){
                        $('#job_owner').val('').trigger('change');
                        $('#assign_recruiter').val('').trigger('change');
                        $('#end_client_id').empty();
                        $.each(response.endClients, function(index, item) {
                            $('#end_client_id').append($('<option>', {
                                value: item.id,
                                text: item.end_client
                            }));
                        });
                        $('#jQueryValidationForm')[0].reset();
                        $('#title').val(response.data.title);
                        $('#type').val(response.data.type);
                        $('#salary').val(response.data.salary);
                        $('#client_id').val(response.data.client_id);
                        $('#end_client_id').val(response.data.end_client_id);
                        $('#notes').val(response.data.notes);
                        $('#description').html(response.data.description);
                        $('#key_skills').val(response.data.key_skills);
                        $('#job_owner').val(response.data.job_owner).trigger('change');
                        $('#assign_recruiter').val(response.data.assign_recruiter).trigger('change');
                        var status=response.data.status;
                        if(status==0){
                            $("#status").prop('checked', false);
                        }else{
                            $("#status").prop('checked', true);
                        }
                        $('#addNewModal').modal('show');
                    }else{
                        swal("Oops!", "Failed to fetch the data!", "error");
                    }
                },
            });
            // var url="{{route('admin.job-opportunities.edit','ID')}}";
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
                        if(response.data.end_client){
                            var end_client=response.data.end_client.end_client?response.data.end_client.end_client:"-";
                        }else{
                            var end_client="-";
                        }
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

    <script>
        $( document ).ready( function () {
            $('#description').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                ]
            });
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
                },
            } );
        } );
        $('#client_id').change(function(){
            var id = $(this).val();
            var list = $("#end_client_id");
            var url="{{route('admin.get-end-clients','ID')}}";
            url=url.replace('ID',id);
            list.empty();
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    list.append(new Option("Select end client", ""));
                    $.each(response, function(index, item) {
                        list.append($('<option/>', {
                            value: item.id,
                            text: item.end_client,
                        }));
                    });
                },
            });
        });

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
                $('#job_owner').val('').trigger('change');
                $('#assign_recruiter').val('').trigger('change');
                $('#addNewButton').attr('data-id','0');
                $('#addNewModal').modal('show');
            }

            $('#addNewButton').click(function(){
                if($('#jQueryValidationForm').valid()){
                    var id=$('#addNewButton').attr('data-id');
                    if(id==0){
                        var url="{{route('admin.job-opportunities.store')}}";
                        var method="post";
                    }else{
                        var url="{{route('admin.job-opportunities.update','ID')}}";
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
                                swal("Good job!", "Data added successfully", "success");
                                $('#addNewModal').modal('hide');
                                $('#jQueryValidationForm')[0].reset();
                                drawTable();
                            }else{
                                swal("Oops!", "Failed to add the data!", "error");
                            }
                        }
                    });
                }
            })

    </script>
@endsection