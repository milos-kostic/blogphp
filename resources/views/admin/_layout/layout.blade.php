
<!--START STRANU IZ ADMIN DELA OVDE PRIKAZUJEMO-->
<!--KOPIRAMO IZ: starter.html-->


<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('seo_title') | Admin Area</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/fontawesome-free/css/all.min.css')}}">

        <!-- Toastr -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/toastr/toastr.min.css')}}">


        <!-- Theme style -->
        <link rel="stylesheet" href="{{url('/themes/admin/dist/css/adminlte.min.css')}}">

        <link href="{{url('/themes/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('/themes/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
        
        
        <!-- Datatables plugin -->
        <link href="{{url('/themes/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
        
        @stack('head_links') 

    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
 
            @include('admin._layout.partials.top_menu')


            @include('admin._layout.partials.sidebar')
 

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                @yield('content')


            </div>
            <!-- /.content-wrapper -->
 

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>
            <!-- /.control-sidebar -->


            @include('admin._layout.partials.footer')

        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="{{url('/themes/admin/plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{url('/themes/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <!--validation plugin-->
        <script src="{{url('/themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
        <script src="{{url('/themes/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>



        <!-- Toastr -->
        <script src="{{url('/themes/admin/plugins/toastr/toastr.min.js')}}"></script>
        
        <!-- Select2 plugin za multiple select -->
        <script src="{{url('/themes/admin/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
        
        <!-- Datatables plugin, js -->
        <script src="{{url('/themes/admin/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
        <script src="{{url('/themes/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>
        
        
        <script> 
            /* CITANJE I PRIKAZ SISTEMSKIH PORUKA IZ SESIJE POMOCU toastr - a */
            let systemMessage="{{session()->pull('system_message')}}"; // ako ima u sesiji prikaze. pull() obrise kad procita
            if(systemMessage !== ""){
                toastr.success(systemMessage);
            }
                
            // ZA ERROR PORUKE:
            let systemError = "{{session()->pull('system_error')}}";
            if(systemError !== ""){
                toastr.error(systemError);
            }
        </script>
                 

        <!-- AdminLTE App -->
        <script src="{{url('/themes/admin/dist/js/adminlte.min.js')}}"></script>

        @stack('footer_javascript')

    </body>
</html>
