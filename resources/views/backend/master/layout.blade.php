<!DOCTYPE html>
<html lang="en">

<head>

    @yield('contentHeader')
    @include('backend.includes.head')
</head>

<body>
    @include('backend.includes.header')
    
    @include('backend.includes.footer')

    @include('backend.includes.scripts')
    @yield('contentfooter')
</body>

</html>
