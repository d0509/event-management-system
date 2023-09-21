<!DOCTYPE html>
<html lang="zxx">


<!-- Mirrored from themewagon.github.io/manup/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Aug 2023 13:58:19 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Manup Template">
    <meta name="keywords" content="Manup, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&amp;display=swap" rel="stylesheet">

{{-- sweet alert --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('user_assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/style.css') }}" type="text/css">
    {{-- <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css"> --}}
</head>

<body>
    <!-- Page Preloder -->
    @include('sweetalert::alert')
    @yield('dashboard')
    <!-- Js Plugins -->
    <script src="{{ asset('user_assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('user_assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/main.js') }}"></script>

    {{-- <script src="js/jquery-3.3.1.min.js"></script> 
     <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script> --}}
</body>


<!-- Mirrored from themewagon.github.io/manup/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Aug 2023 13:58:37 GMT -->

</html>
