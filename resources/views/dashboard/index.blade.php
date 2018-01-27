@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">home</i><b style="font-size: large;">Dashboard</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/dashboard.css')}}">
@endsection

@push('content')
    <div class="dashboardPage container">
        Welcome, {{$user}}!
    </div>
@endpush