<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Business Partner Portal</title>
  <meta name="description" content="Systra Business Partner Portal">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" href="">
  <link rel="shortcut icon" href="">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- Theme style -->

  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">

  <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

  <link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">

  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
 
  
  <style>
    @media print {
        .hide-print {
            display: none;
        }
    }

      .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
        padding-top: 0.25em
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: 0.5em 1em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        *cursor: hand;
        color: #333 !important;
        border: 1px solid transparent;
        border-radius: 2px
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button.current,
      .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #333 !important;
        border: 1px solid #979797;
        background-color: white;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fff), color-stop(100%, #dcdcdc));
        background: -webkit-linear-gradient(top, #fff 0%, #dcdcdc 100%);
        background: -moz-linear-gradient(top, #fff 0%, #dcdcdc 100%);
        background: -ms-linear-gradient(top, #fff 0%, #dcdcdc 100%);
        background: -o-linear-gradient(top, #fff 0%, #dcdcdc 100%);
        background: linear-gradient(to bottom, #fff 0%, #dcdcdc 100%)
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
      .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
      .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
        cursor: default;
        color: #666 !important;
        border: 1px solid transparent;
        background: transparent;
        box-shadow: none
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: white !important;
        border: 1px solid #111;
        background-color: #585858;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #585858), color-stop(100%, #111));
        background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
        background: -moz-linear-gradient(top, #585858 0%, #111 100%);
        background: -ms-linear-gradient(top, #585858 0%, #111 100%);
        background: -o-linear-gradient(top, #585858 0%, #111 100%);
        background: linear-gradient(to bottom, #585858 0%, #111 100%)
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button:active {
        outline: none;
        background-color: #2b2b2b;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2b2b2b), color-stop(100%, #0c0c0c));
        background: -webkit-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -moz-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -ms-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -o-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: linear-gradient(to bottom, #2b2b2b 0%, #0c0c0c 100%);
        box-shadow: inset 0 0 3px #111
      }

      .dataTables_wrapper .dataTables_paginate .ellipsis {
        padding: 0 1em
      }

      #cover-spin {
          position:fixed;
          width:100%;
          left:0;right:0;top:0;bottom:0;
          background-color: rgba(255,255,255,0.7);
          z-index:9999;
          
      }

      @-webkit-keyframes spin {
        from {-webkit-transform:rotate(0deg);}
        to {-webkit-transform:rotate(360deg);}
      }

      @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
      }
    </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="loader  justify-content-center" id="cover-spin">
      <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;position: fixed;top: 50%;left: 50%;" role="status">
          
      </div>
      <div style="position: fixed;top: 58%;left: 50%;">Loading..</div>
    </div>

    <div class="wrapper">

      <!-- Navbar -->
        @include('vms.main.nav')
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      @include('vms.main.sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="background-color:white;">
        <div class="container-fluid mt-3"  style="background-color:white;">
          @yield('content')
        </div>
        <hr>
      </div>
      <!-- /.content-wrapper -->

      {{-- <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>Version</b> 2.0 Beta
        </div>
        <strong>Copyright © {{config('app.name')}} </strong> All rights reserved.
      </footer> --}}


    </div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
{{-- <script src="{{asset('js/main.js')}}"></script> --}}

<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/datatables.min.js')}}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  $(document).ready(function () {
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    $('.loader').hide();
  });
</script>

@if(Session::has('success'))
<script>
    toastr.options.positionClass = 'toast-bottom-right' ;
    toastr.success('{{ Session::get('success') }}');
    
</script>

@elseif(Session::has('error'))

<script>
    toastr.options.positionClass = 'toast-bottom-right' ;
    toastr.error('{{ Session::get('error') }}');  
</script>



@endif
</body>
</html>
