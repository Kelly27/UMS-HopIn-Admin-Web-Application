@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">directions</i><b style="font-size: large;">Route Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/route.css')}}">
@endsection

@section('content')
<div class="createRoutePage createPage container-fluid contentPage">
    <div class="row">
        <div class="col-sm-10">
            <h3>Create Route's Profile</h3>
        </div>
        @php
        if(collect(request()->segments())->last() == 'edit'){
            $url = 'updateRoute';
        }
        else if(collect(request()->segments())->last() == 'create'){
            $url = 'storeRoute';
        }
        @endphp
        {{ Form::open(['url' => route($url, ['id' => Request::segment(2)]), 'method' => 'post']) }}
        <div class="col-sm-2" style="padding-top: 20px;">
            <a href="#"><button class="btn basic-btn submit-btn">Submit</button></a>
        </div>
    </div>
    <div class="inputForm">
        <div class="row">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="col-sm-7">
                {{-- <h5>ID</h5>
                    <div id="ID_input">
                    {{Form::text('id', $id, ['disabled' => 'disabled'] )}}
                </div> --}}
                <div class="route_name">
                    <h5>Route Name</h5>
                    @if(isset($route_name))
                    {{Form::text('route_name', $route_name)}}
                    @else
                    {{Form::text('route_name')}}
                    @endif
                </div>
                <div class="route_desc">
                    <h5>Route Description</h5>
                    @if(isset($route_desc))
                    {{Form::textarea('route_desc', $route_desc, ['id' => 'desc_field'])}}
                    @else
                    {{Form::textarea('route_desc', null, ['id' => 'desc_field'])}}
                    @endif
                </div>
            </div>
            <div class="col-sm-5">
                <h5>Please Select Route Color</h5>
                <input name="color" class="jscolor" value="3AD664">
            </div>
        </div>
<div class="row">
    <div class="col-sm-12">
        <h5>Route</h5>
        <div class="row">
            <p>NOTE: in order to remove item from the 'new route' list, simply drag the item to 'select from here' list</p>
            <div class="col-sm-5 sort-col">
                <h5>Select from here</h5>
                <div id="stop-item" class="itembox">
                    @foreach($bus_stops_map as $stop)
                    <p>{{$stop->name}}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-2 arrow-col">
                <i class="material-icons">arrow_forward</i>
            </div>
            <div class="col-sm-5 sort-col">
                <h5>New Route</h5>
                <div id="stop-item2" class="itembox">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="margin-top: 50px;">
            <div class="map-div">
                {{-- @php var_dump($route_arr); @endphp --}}
                <div style="position: absolute; top: -30px" hidden><textarea name="route_arr" id="setRouteArr"></textarea></div>
                <div style="position: absolute; top: -30px" hidden><textarea name="path_arr" id="setPathArr"></textarea></div>
                {{-- <div id="map" value={{$route_arr}} style="width: 100%; height: 500px;"></div> --}}
                <div id="map" style="width: 100%; height: 500px;"></div>
                <button class="generate-btn" type="button" onclick=showRoute()>Generate Route on Map</button>
                <a class="reset-btn" href="javascript:void(0)" onclick="resetRoute()">Reset</a>
            </div>
        </div>
    </div>
</div>
{{ Form::close()}}
</div>
</div>
@endsection
@section('script')
@include('route.script')
@endsection
