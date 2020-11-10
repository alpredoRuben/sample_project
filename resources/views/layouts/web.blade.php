<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PROJECTS</title>

    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">

    <link href="{{ asset('template/css/tagsinput.css')}}" rel="stylesheet" type="text/css">

    <link href="{{ asset('template/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/style.css')}}" rel="stylesheet">

</head>
<body>
    <div id="wrapper">


        @include('partials/sidenav', ['user' => $records['user'], 'title' => $records['title']])

        <div id="page-wrapper" class="gray-bg">


            @include('partials/header')

            @yield('content')

            @include('partials/footer')


        </div>

    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('template/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('template/js/popper.min.js')}}"></script>
    <script src="{{ asset('template/js/axios.min.js') }}"></script>

    <script src="{{ asset('template/js/bootstrap.js')}}"></script>

    <script src="{{ asset('template/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('template/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('template/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('template/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>


    <script src="{{ asset('template/js/tagsinput.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- Flot -->
    <script src="{{ asset('template/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('template/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('template/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('template/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('template/js/plugins/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{ asset('template/js/plugins/flot/jquery.flot.symbol.js')}}"></script>
    <script src="{{ asset('template/js/plugins/flot/curvedLines.js')}}"></script>

    <!-- Peity -->
    <script src="{{ asset('template/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('template/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('template/js/inspinia.js') }}"></script>
    <script src="{{ asset('template/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('template/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('template/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('template/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('template/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('template/js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('template/js/plugins/chartJs/Chart.min.js') }}"></script>
    <script>
        var BASE_URL = {!! json_encode(url('/')) !!};
        var Api = axios.create({
            baseURL: BASE_URL,
        });

    </script>
    @stack('scripts')
</body>
</html>
