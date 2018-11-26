<!DOCTYPE html>
<html >
@include('partials._head')
@yield('css')
<body>
@include('partials.navbar')
@include('partials._message')

<div id="main">
    <div class="container-fluid" style="margin-top: 70px;">
        @yield('body')
    </div>
</div>
</body>
@include('partials._footer')
@include('partials._javascript')
@yield('js')
</html>