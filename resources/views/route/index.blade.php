@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">directions</i><b style="font-size: large;">Route Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/route.css')}}">
@endsection

@section('content')
    <div class="routeManagerPage container-fluid contentPage">
        <a href="{{route('createRoute')}}"><button class="btn basic-btn">ADD</button></a>
        <table>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Route Name</td>
                    <td>Route Description</td>
                    <td>Route Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $route)
                <tr>
                    <td>{{$route->id}}</td>
                    <td>{{$route->title}}</td>
                    <td>{{$route->description}}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection