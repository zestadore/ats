@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('title')
    ATS - Notes / ToDos
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{$type}}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$type}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button class="btn blue-button" type="button" onclick="addNew()">Add New</button>
                    {{-- <a href="{{route('admin.users.create')}}" class="btn blue-button">Add New</a> --}}
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
                    <div class="table-responsive" id="view-notes-body">
                        
                    </div>
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
    <script>
        function drawTable()
        {
            var type="{{$type}}";
            $.ajax({
                url: "{{route('admin.notes.index')}}",
                type:"get",
                data:{
                    'type':type
                },
                success:function(response){
                    $('#view-notes-body').html(response.html);
                    // $('#notesTitle').text(type);
                    if(type=="Notes"){
                        $('.assigned_to').hide();
                        $('#note_choice').val(0);
                    }else{
                        $('.assigned_to').show();
                        $('#note_choice').val(1);
                    }
                    // $('#note_title').val('');
                    // $('#note_description').summernote('code','');
                    // $('#assigned_to').val('')
                    // $('#saveNotes').attr('data-id','0');
                    // $('#notesModal').modal('show');
                },
            });
        }
        drawTable();

        function addNew(){
            //clear the form
            $('#note_title').val('');
            $('#note_description').summernote('code','');
            $('#assigned_to').val('');
            $('#saveNotes').attr('data-id','0');
            $('#notesModal').modal('show');
            $('#notesTitle').text("{{getPageTitle('Note/Todo', ' Add New')}}");
        }


    </script>
@endsection