<!doctype html>
<html lang="en" class="">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<!--favicon-->
	<link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png" />
	<!--plugins-->
	<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
    @yield('style')
	<title>@yield('title_head')</title>
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
        @yield('menus')
        @yield('content')
    </div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('assets/js/app.js')}}"></script>
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
        });
    
        function timerIncrement() {
            idleTime = idleTime + 1;
			var userAuth='{{Auth::check()}}';
            if (idleTime >= 15 && userAuth) { // 15 minutes
                document.getElementById('logout-form').submit();
            }
        }
    </script>
    @yield('javascripts')
</body>

</html>