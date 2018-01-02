@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">directions</i><b style="font-size: large;">Route Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/route.css')}}">
@endsection

@section('content')
    <div class="createRoutePage container-fluid contentPage">
        <div class="row">
            <div class="col-sm-10">
                <h3>Create Route's Profile</h3>
            </div>
            {{ Form::open(['url' => route('storeRoute'), 'method' => 'post']) }}
            <div class="col-sm-2" style="padding-top: 20px;">
                <a href="#"><button class="btn basic-btn submit-btn">Submit</button></a>
            </div>
        </div>
        <div class="inputForm">
            <div class="row">
                <div class="col-sm-7">
                    <h5>ID</h5>
                    <div id="ID_input">
                        {{Form::text('id', $new_id, ['disabled' => 'disabled'] )}}
                    </div>
                    <div class="route_name">
                        <h5>Route Name</h5>
                        {{Form::text('route_name' )}}
                    </div>
                    <div class="route_desc">
                        <h5>Route Description</h5>
                        {{Form::textarea('route_desc' )}}
                    </div>
                </div>
                <div class="col-sm-4">
                    <h5>Bus Stop that involved</h5>
                    <div class="bus_stop_input">
                        {{Form::checkbox('bus_stop[]', 'FSSA')}} {{Form::label('FSSA', 'FSSA')}} 
                        <br>
                        {{Form::checkbox('bus_stop[]', 'FKJ')}} {{Form::label('FKJ', 'FKJ')}}
                        <br>
                        {{Form::checkbox('bus_stop[]', 'FKSW')}} {{Form::label('FKSW', 'FKSW')}} 
                        <br>
                        {{Form::checkbox('bus_stop[]', 'FKI')}} {{Form::label('FKI', 'FKI')}}
                        <br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h5>Route</h5>
                    <div style="position: absolute; visibility: hidden;"><textarea name="route_arr" id="setRouteArr"></textarea></div>
                    <div id="map" style="width: 100%; height: 500px;"></div>
                    <a class="reset-btn" href="javascript:void(0)" onclick="resetRoute()">Reset</a>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endsection
@section('script')
<script>
    var poly;
    var map;
    var data = [];
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        center: {lat: 6.0333, lng: 116.1229},
        // disableDefaultUI: true
        });

        poly = new google.maps.Polyline({
          strokeColor: '#000000',
          strokeOpacity: 1.0,
          strokeWeight: 3
        });
        poly.setMap(map);

        map.addListener('click', addLatLng);
    }

    function addLatLng(event) {
        var path = poly.getPath();
        path.push(event.latLng);
        data.push({lat: event.latLng.lat(), lng: event.latLng.lng()});
        var marker = new google.maps.Marker({
          position: event.latLng,
          title: '#' + path.getLength(),
          map: map
        });
        updateData();
    }

    function resetRoute(){
        poly.setMap(null);
        data=[];
        console.log(data);
        updateData();
    }

    function updateData(){
        document.getElementById('setRouteArr').value = JSON.stringify(data);
    }
</script>
@endsection