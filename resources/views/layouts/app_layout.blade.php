@extends('layouts.html_head')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/app_layout.css')}}">
@yield('content_style')
@endsection

@section('body')
<div class="wrapper">

   <nav id="sidebar">
      <!-- Sidebar Header -->
      <div class="sidebar-header">
         <div class="sidebar-bg"></div>
      </div>

      <!-- Sidebar Links -->
      <ul class="list-unstyled components">
         <a class="<?php if (Request::segment(1) == "home") {echo "active";} ?>" href={{route('home')}}><li><i class="menu-i material-icons">home</i>Dashboard</li></a>
         <a class="<?php if (Request::segment(1) == "route") {echo "active";} ?>" href="{{route("route")}}"><li><i class="menu-i material-icons">directions</i>Route Manager</li></a>

         {{-- <li><!-- Link with dropdown items -->
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"> </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
               <li><a href="#">Page</a></li>
               <li><a href="#">Page</a></li>
               <li><a href="#">Page</a></li>
            </ul>
         </li> --}}
         <a class="<?php if (Request::segment(1) == "announcement") {echo "active";} ?>" href="{{route('announcement')}}"><li><i class="menu-i material-icons">announcement</i>Announcement Manager</li></a>
         <a class="<?php if (Request::segment(1) == "bus") {echo "active";} ?>" href="{{route('bus')}}"><li><i class="menu-i material-icons">directions_bus</i>Bus Manager</li></a>
         <a class="<?php if (Request::segment(1) == "driver") {echo "active";} ?>" href="{{route('driver')}}"><li><i class="menu-i material-icons">people</i>Driver Manager</li></a>
         <a class="<?php if (Request::segment(1) == "bus_stop") {echo "active";} ?>" href="{{route('bus_stop')}}"><li><i class="menu-i material-icons">store_mall_directory</i>Bus Stop Manager</li></a>
         <a class="<?php if (Request::segment(1) == "reservation") {echo "active";} ?>" href="{{route('reservation')}}"><li><i class="menu-i material-icons">settings_phone</i>Bus Reservation Manager</li></a>
         <a class="<?php if (Request::segment(1) == "report") {echo "active";} ?>" href="{{route('report')}}"><li><i class="menu-i material-icons">assignment</i>Report Manager</li></a>
      </ul>
   </nav>
   <div id="content">
      <div class="content-heading container-fluid">
         <div class="row">
            <div class="col-sm-10" style="color: white;">
               <button type="button" id="sidebarCollapse" class="btn menu-btn">
                   <i class="glyphicon glyphicon-menu-hamburger"></i>
               </button>
               @yield('title')
            </div>
            <div class="col-sm-2 hidden-sm hidden-xs ">
               <div class="desktop_profile nav">
                  @if (Auth::guest())
                     <li><a href="{{ route('login') }}">Login</a></li>
                     <li><a href="{{ route('register') }}">Register</a></li>
                  @else
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                           {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                           <li>
                              <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                 Logout
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 {{ csrf_field() }}
                              </form>
                           </li>
                     </li>
                  @endif
               </div>
            </div>
         </div>
      </div>
         @yield('content')
   </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});
</script>
@endsection