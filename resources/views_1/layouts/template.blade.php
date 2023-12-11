@include('layouts.header')
@yield('content')

@if(Auth::guard('user')->check())
@extends('chat-box')
@endif



@include('layouts.footer_scripts')
@include('layouts.footer')
<div class="menu-backdrop"></div>
</body>
</html>