<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Manup Template">
    <meta name="keywords" content="Manup, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&amp;display=swap" rel="stylesheet">
    {{-- jQuery cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    {{-- sweet alert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- last added --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('user_assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user_assets/css/style.css') }}" type="text/css">
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">


</head>

<body>
    <!-- Page Preloder -->
    @include('sweetalert::alert')
    @yield('dashboard')
   

    <!-- Js Plugins -->
    <script src="http://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" defer="defer"></script>

    <script src="{{ asset('user_assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('user_assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/main.js') }}"></script>

    
</body>
<footer class="footer-section mt-5 left-0 right-0" >
    <div class="">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-text">
                    <div class="ft-logo">
                        <a href="{{route('home')}}" class="footer-logo"><img src="{{asset('user_assets/img/footer-logo.png')}}" alt=""></a>
                    </div>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Speakers</a></li>
                        <li><a href="#">Schedule</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <div class="copyright-text">
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i
                            class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com/"
                            target="_blank">Colorlib</a>
                        </p>
                    </div>
                    <div class="ft-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Mirrored from themewagon.github.io/manup/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Aug 2023 13:58:37 GMT -->

</html>
