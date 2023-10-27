<!doctype html>
<html lang="en" class="">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
	<link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
    <!-- Prism Syntax Highlighting-->
    <link rel="stylesheet" href="{{asset('assets/vendor/prismjs/plugins/toolbar/prism-toolbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/prismjs/themes/prism-okaidia.css')}}">
    <!-- The Main Theme stylesheet (Contains also Bootstrap CSS)-->
    <link rel="stylesheet" href="{{asset('assets/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
    @yield('style')
	<title>@yield('title_head')</title>
</head>
<body>
	@yield('content')
    <div class="toast-container position-absolute top-0 end-0 p-3">
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="toast_class">
            <div class="d-flex">
              <div class="toast-body" id="toast-body">
                Hello, world! This is a toast message.
              </div>
              <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"><span class="visually-hidden">Close</span></button>
            </div>
        </div>
    </div>
	<!-- JavaScript files-->
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="{{asset('assets/js/theme.js')}}"></script>
    <!-- Prism for syntax highlighting-->
    <script src="{{asset('assets/vendor/prismjs/prism.js')}}"></script>
    <script src="{{asset('assets/vendor/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js')}}"></script>
    <script src="{{asset('assets/vendor/prismjs/plugins/toolbar/prism-toolbar.min.js')}}"></script>
    <script src="{{asset('assets/vendor/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js')}}"></script>
    <!-- Notifications Init-->
    {{-- <script src="{{asset('assets/js/components-notifications.js')}}"> </script> --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js" defer></script>
    <script type="text/javascript">
      // Optional
      Prism.plugins.NormalizeWhitespace.setDefaults({
      'remove-trailing': true,
      'remove-indent': true,
      'left-trim': true,
      'right-trim': true,
      });
          
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<script>
        var role="{{Auth::user()?->role}}";
        var buttons=[];
        if(role!="super_admin"){
            buttons=[];
        }else{
			buttons=['excel','pdf','print','copy'];
		}
    </script>
	<script type="text/javascript">
        var idleTime = 0;
        $(document).ready(function () {
            //Increment the idle time counter every minute.
            idleInterval = setInterval(timerIncrement, 60000); // 1 minute
    
            //Zero the idle timer on mouse movement.
            $('body').mousemove(function (e) {
                //alert("mouse moved" + idleTime);
                idleTime = 0;
            });
    
            $('body').keypress(function (e) {
                //alert("keypressed"  + idleTime);
                idleTime = 0;
            });
    
            $('body').click(function() {
                //alert("mouse moved" + idleTime);
                idleTime = 0;
            });

            $('#note_description').summernote({
                placeholder: 'Notes Description',
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

        });
    
        function timerIncrement() {
            idleTime = idleTime + 1;
			var userAuth='{{Auth::check()}}';
            if (idleTime >= 15 && userAuth) { // 15 minutes
                document.getElementById('logout-form').submit();
            }else if(idleTime >= 10 && !userAuth){
				location.reload();
			}
        }
        
        function openNotes(type){
            $.ajax({
                url: "{{route('admin.notes.index')}}",
                type:"get",
                data:{
                    'type':type
                },
                success:function(response){
                    $('#view-notes-modal-body').html(response.html);
                    $('#notesTitle').text(type);
                    if(type=="Notes"){
                        $('.assigned_to').hide();
                        $('#note_choice').val(0);
                    }else{
                        $('.assigned_to').show();
                        $('#note_choice').val(1);
                    }
                    $('#note_title').val('');
                    $('#note_description').summernote('code','');
                    $('#assigned_to').val('')
                    $('#saveNotes').attr('data-id','0');
                    $('#notesModal').modal('show');
                },
            });
        }

        function openCalendar(){
            window.location.href="{{route('admin.view.calendar')}}";
        }

        // $('#toggleDiv').click(function(){
        //     $('#note_title').val('');
        //     $('#note_description').summernote('code','');
        //     $('#assigned_to').val('');
        //     $('#saveNotes').attr('data-id','0');
        // });

        $('#saveNotes').click(function(){
            var id=$('#saveNotes').attr('data-id');
            if(id==0){
                var url="{{route('admin.notes.store')}}";
                var type="POST";
            }else{
                var url="{{route('admin.notes.update','ID')}}";
                url=url.replace('ID',id);
                var type="PUT";
            }
            $.ajax({
                url: url,
                type:type,
                data:{
                    "_token": "{{ csrf_token() }}",
                    "title": $('#note_title').val(),
                    "type": $('#note_choice').val(),
                    "description": $('#note_description').val(),
                    'assigned_to': $('#assigned_to').val(),
                },
                success:function(response){
                    if(response.success){
                        // $('#hiddenDiv').toggle();
                        $('#view-notes-body').html(response.html);
                        $('#notesModal').modal('hide');
                    }   
                },
            });
        });

        function deleteNote(id)
        {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    var url="{{route('admin.notes.destroy','ID')}}";
                    url=url.replace('ID',id);
                    $.ajax({
                        url: url,
                        type:"delete",
                        data:{
                            "_token": "{{ csrf_token() }}",
                        },
                        success:function(response){
                            // console.log(response);
                            if(response.success){
                                // swal("Good job!", "You deleted the data!", "success");
                                $('#toast-body').text("You deleted the data!");
                                $('#toast_class').addClass('bg-success');
                                $('#toast_class').removeClass('bg-danger');
                                window.scrollTo(0, 0);
                                toastList.forEach(toast => toast.show());
                                $('#view-notes-modal-body').html(response.html);
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
            });
        }

        function editNote(id){
            var url="{{route('admin.notes.edit','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    console.log(response);
                    $('#note_title').val(response.title);
                    $('#note_description').summernote('code',response.description);
                    if(response.assigned_to){
                        $('#assigned_to').val(response.assigned_to.id)
                    }
                    if(response.type==1){
                        $('.assigned_to').show();
                    }
                    $('#notesModal').modal('show');
                    $('#saveNotes').attr('data-id',id);
                },
            });
        }

        function changeStatus(id,status){
            var url="{{route('admin.notes.update','ID')}}";
            url=url.replace('ID',id);
            var changeStatus=1;
            if(status==1){
                changeStatus=0;
            }
            $.ajax({
                url: url,
                type:"PUT",
                data:{
                    "_token": "{{ csrf_token() }}",
                    "status": changeStatus
                },
                success:function(response){
                    console.log(response);
                    if(response.success){
                        // swal("Good job!", "You changed the status!", "success");
                        $('#toast-body').text("You changed the status!");
                        $('#toast_class').addClass('bg-success');
                        $('#toast_class').removeClass('bg-danger');
                        window.scrollTo(0, 0);
                        toastList.forEach(toast => toast.show());
                        drawTable();
                    }else{
                        // swal("Oops!", "Failed to change the status!", "danger");
                        $('#toast-body').text("Failed to change the status!");
                        $('#toast_class').addClass('bg-danger');
                        $('#toast_class').removeClass('bg-success');
                        window.scrollTo(0, 0);
                        toastList.forEach(toast => toast.show());
                    }
                },
            });
        }

    </script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
       if ("serviceWorker" in navigator) {
          // Register a service worker hosted at the root of the
          // site using the default scope.
          navigator.serviceWorker.register("/sw.js").then(
          (registration) => {
             console.log("Service worker registration succeeded:", registration);
          },
          (error) => {
             console.error(`Service worker registration failed: ${error}`);
          },
        );
      } else {
         console.error("Service workers are not supported.");
      }

        $('.centerLoader').hide();
        //show loader on ajax call
        $(document).ajaxStart(function(){
            $('.centerLoader').show();
        });
        //hide loader on ajax call
        $(document).ajaxStop(function(){
            $('.centerLoader').hide();
        });
        $('.hidden_icon').hide();
        $('.show_icon').show();
    </script>
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl);
        })
    </script>
    @yield('javascripts')
</body>

</html>