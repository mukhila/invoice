<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | Gold Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- plugin css -->
        <link href="{{ asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/animations.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/transformations.min.css" rel="stylesheet">

        <!-- Head CSS -->
        <script src="{{ asset('assets/js/head.js') }}"></script>

        @stack('styles')
    </head>

    <!-- body start -->
    <body data-menu-color="dark">

        <!-- Begin page -->
        <div id="app-layout">

            @include('Admin.layouts.header')

            @include('Admin.layouts.sidebar')

            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div> 
                </div> 

                @include('Admin.layouts.footer')
            </div>

        </div>
        <!-- END layout-wrapper -->

        @include('Admin.layouts.customscripts')
    </body>

</html>
