<!doctype html>
<html lang="en" class="">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<META HTTP-EQUIV="REFRESH" CONTENT="csrf_timeout_in_seconds">
	<meta name="robots" content="all,follow">
	<link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
    <!-- Prism Syntax Highlighting-->
    <link rel="stylesheet" href="{{asset('assets/vendor/prismjs/plugins/toolbar/prism-toolbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/prismjs/themes/prism-okaidia.css')}}">
    <!-- The Main Theme stylesheet (Contains also Bootstrap CSS)-->
    <link rel="stylesheet" href="{{asset('assets/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
	
    @yield('style')
	<title>@yield('title_head')</title>
</head>
<body>
	@yield('menus')
	@yield('content')
	<!-- JavaScript files-->
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="{{asset('assets/js/theme.js')}}"></script>
    <!-- Prism for syntax highlighting-->
    <script src="{{asset('assets/vendor/prismjs/prism.js')}}"></script>
    <script src="{{asset('assets/vendor/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js')}}"></script>
    <script src="{{asset('assets/vendor/prismjs/plugins/toolbar/prism-toolbar.min.js')}}"></script>
    <script src="{{asset('assets/vendor/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js')}}"></script>
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
    </script>
    @yield('javascripts')
</body>

</html>