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
        @if(session()->has('message'))
        <div class="alert alert-info">{{session()->get('message')}}</div>
        @endif
        <table>
            <thead>
                <tr>
                    {{-- <td>ID</td> --}}
                    <td>Route Name</td>
                    <td>Route Description</td>
                    <td>Route Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $route)
                <tr>
                    {{-- <td>{{$route->id}}</td> --}}
                    <td>{{$route->title}}</td>
                    <td>{{$route->description}}</td>
                    <td><a href="{{URL::to('route/'. $route->id . '/edit')}}" class="action"><i class="material-icons">mode_edit</i></a><a href="{{URL::to('route/' . $route->id . '/delete')}}" class="action"><i class="material-icons">delete</i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection