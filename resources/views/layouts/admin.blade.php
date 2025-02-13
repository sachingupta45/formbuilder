<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    <link rel="stylesheet" href="{{ asset('admin/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/superadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('loader.css') }}">

    <!-- CSS FOR NOTIFICATION -->
    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous">
    <!-- END  CSS FOR NOTIFICATION -->

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />

    <script src="https://unpkg.com/feather-icons"></script>
    @stack('styles')
    <script>
        const APP_URL = "{{ url('') }}";
    </script>


</head>

<body class="relative">
    {{-- <div class="loader"></div> --}}
    <x-loader />
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('layouts.admin_nav')
            @include('layouts.admin_sidebar')

            <div class="main-content">
                {{ $slot }}
                {{-- @yield('content') --}}
            </div>
        </div>
    </div>
    <!-- JavaScript Files -->
    <script src="{{ asset('admin/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/common.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('admin/js/app.min.js') }}"></script>
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/iziToast.js') }}"></script>

    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>


    @include('vendor.lara-izitoast.toast')

    @stack('particular-scripts')
</body>

</html>
