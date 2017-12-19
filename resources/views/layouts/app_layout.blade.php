@extends('layouts.html_head')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/app_layout.css')}}">
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
         <li class="active"><a href="#">Home</a></li>
         <li><a href="#">About</a></li>

         <li><!-- Link with dropdown items -->
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
               <li><a href="#">Page</a></li>
               <li><a href="#">Page</a></li>
               <li><a href="#">Page</a></li>
            </ul>
         </li>
         <li><a href="#">Portfolio</a></li>
         <li><a href="#">Contact</a></li>
      </ul>
   </nav>
   <div id="content">
      <div class="content-heading container-fluid">
         <div class="row">
            <div class="col-sm-10">
               <button type="button" id="sidebarCollapse" class="btn menu-btn">
                   <i class="glyphicon glyphicon-menu-hamburger"></i>
               </button>
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