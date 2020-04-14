<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>
        <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
        <link href="{{ asset('css/datatable.css')}}" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        @include('include.header')

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('include.sidebar')
            </div>
            <div id="layoutSidenav_content">
                <main>
                    
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>

                @include('include.footer')
                
            </div>
        </div>
        <script src="{{ asset('js/js.js')}}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/popper.js') }}"  crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.min.js')}}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js')}}"></script>
        <script src="{{ asset('js/ip.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatable.js')}}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatable-bootstrap.js')}}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables-demo.js')}}"></script>
        @yield('js')
    </body>
</html>
