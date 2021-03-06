<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Business Partner Portal</title>
    <meta name="description" content="Systra Vendor Management System">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" href="">

    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="{{asset('assets/css/normalize.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/icheck-bootstrap.min.css')}}">
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

    <style>
                html, body {
        font-family: 'Lato', sans-serif;
    }
        .reqFields::after{
            content: "*";
            color: red;
        }
    </style>

   
</head>

<body>
    <div id="right-panel" style="background-color:white" class="right-panel ml-2">
        <!-- Header-->
        <header id="header" style="background-color:#003e4b " class="header">
            <div class="top-left" style="background-color:#003e4b ">
                <div class="navbar-header" style="color:white;background-color:#003e4b ">
                    <a class="navbar-brand" style="color:white;background-color:#003e4b " href="./">Business Partner Portal</a>
                </div>
            </div>

        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
        <!-- /.content -->
        <div class="clearfix"></div>

    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
   

    {{-- <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.min.js')}}"></script> --}}



</body>
</html>
