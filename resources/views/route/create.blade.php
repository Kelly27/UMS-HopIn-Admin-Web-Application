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
                <h5>Select Bus the operates this route</h5>
                {{Form::select('operating bus', $buses)}}

                <h5>Please Select Route Color</h5>
                <input class="jscolor" value="3AD664">
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
                <div style="position: absolute; top: -30px"><textarea name="route_arr" id="setRouteArr"></textarea></div>
                <div style="position: absolute; top: -30px"><textarea name="path_arr" id="setPathArr"></textarea></div>
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARzgseB8wPPpiP65N9rzPqFwcdA4WuugY&callback=initMap"></script>
<script type="text/javascript" src="{{asset('js/Sortable.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    tinymce.init({
        selector: '#desc_field',
        plugins : 'advlist autolink link image lists charmap print preview',
        skin: 'lightgray'
    });

</script>
<script type="text/javascript" src="{{asset('js/jscolor.min.js')}}"></script>
<script>
    var map;
    var directionsService;
    var directionsDisplay;
    var selectedRoute = [];
    var allMarkers = [];
    var pathArchive; //save path retrieve from google direction service
    var pathArr = [];
    var plineArray = [];
    var directionDataArr = [] // to save the whole direction data
    var routeDom = document.getElementById('setRouteArr');

    function initMap() {
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: 6.0333, lng: 116.1229},
            disableDefaultUI: true
        });

        directionsDisplay.setMap(map);
    }

    function resetRoute(){
        removePolylines();
        setMapOnAll(null);
        removeAllMarkers();
    }

    //save selected route data to database
    function setSelectedRoute(data, plineArray){
        let routeDom = document.getElementById('setRouteArr');
        routeDom.value = JSON.stringify(data);
    }

    var el = document.getElementById('stop-item');
    var sortable = Sortable.create(el,{
        group: {name: "sorting", put: true, pull: true},
        sort: false,
        animation: 100,
        scroll: true, // or HTMLElement
        scrollSensitivity: 30, // px, how near the mouse must be to an edge to start scrolling.
        scrollSpeed: 10,
    });
    var el2 = document.getElementById('stop-item2');
    var onSort = Sortable.create(el2,{
        group: {name: "sorting", put: true, pull: true},
        sort: true,
        animation: 100,
        onSort: function(evt){
            selectedRoute = []; //init selected route array to empty
            allMarkers = [];
            plineArray = [];
            pathArr = [];
            updateList();
            showRoute();
        },
        onRemove: function(){
            removePolylines();
            updateList();
            showRoute();
            removeAllMarkers();
        }
    });

    function updateList(){
        let DOMarray = [];
        var stop = @php echo $bus_stops_map; @endphp;

        for(var i = 1; i < el2.childNodes.length; i++){
            DOMarray.push(el2.childNodes[i].textContent);
        }

        for(var j = 0; j < DOMarray.length; j++){
            for(var k = 0; k < stop.length; k++){
                if(DOMarray[j] == stop[k].name){
                    selectedRoute.push(stop[k]);
                }
            }

        };
        console.log('selectedRoute', selectedRoute);
        showRoute();
    }

    function showRoute(){
        if(selectedRoute.length >= 2){
            for(var i = 0; i < selectedRoute.length - 1; i++){
                //making request to Google Javascript API to get the polyline path
                var request = {
                    origin: selectedRoute[i].location,
                    destination: selectedRoute[i+1].location, //change here
                    travelMode: 'DRIVING'
                };
                directionsService.route(request, function(result, status) {
                    if (status == 'OK') {
                        addPath(google.maps.geometry.encoding.decodePath(result.routes[0].overview_polyline));
                        // this.pathArchive = google.maps.geometry.encoding.decodePath(result.routes[0].overview_polyline);
                    }
                });
            };
        };
        // var waypoints_stop = [];
        // console.log(waypoints_stop);
        // console.log('selectedRoute.length', selectedRoute.length);
        // console.log('selectedRoute', selectedRoute);
        // for(var i = 1; i < selectedRoute.length - 2; i++){
        //     let w = {
        //         location: selectedRoute[i].location,
        //         stopover: true,
        //     };

        //     waypoints_stop.push(w);
        // };
        // if(selectedRoute.length > 2){
        //     //making request to Google Javascript API to get the polyline path
        //     var request = {
        //         origin: selectedRoute[0].location,
        //         destination: selectedRoute[selectedRoute.length - 1].location, //change here
        //         waypoints: waypoints_stop,
        //         travelMode: 'DRIVING'
        //     };
        //     directionsService.route(request, function(result, status) {
        //         if (status == 'OK') {
        //             // setPath(google.maps.geometry.encoding.decodePath(result.routes[0].overview_polyline));
        //             // this.pathArchive = google.maps.geometry.encoding.decodePath(result.routes[0].overview_polyline);
        //             directionsDisplay.setDirections(result);
        //         }
        //     });
        // }
        for(var j = 0; j < selectedRoute.length; j++){
            var m = new google.maps.Marker({
                position: selectedRoute[j].location,
                title: selectedRoute[j].name,
                map: map,
            });
            allMarkers.push(m);
        };
        this.setSelectedRoute(selectedRoute, plineArray);
    };

    function addPath(path){
        // pathArchive = path;
        pathArr.push(path);
        createPolylines(pathArr);
        console.log('pathArr', pathArr);
        saveDirectionData(pathArr);
    };

    function createPolylines(pathArray){
        // console.log('patharray',pathArray);
        for(var i = 0; i < pathArray.length; i++){
            // console.log('pa', pathArray[i]);
            let pline = new google.maps.Polyline({
                path: pathArray[i],
                stokeColor: "#ff0000",
                strokeOpacity: 1.0,
                strokeWeight: 3
            });

            plineArray.push(pline);
            pline.setMap(map);
        };

    }

    function removePolylines(){
        for(var i = 0; i < plineArray.length; i++){
            plineArray[i].setMap(null);
        }
        selectedRoute = [];
        pathArr = [];
        plineArray = [];
    }

    function setMapOnAll(map) {
        for (var i = 0; i < allMarkers.length; i++) {
            allMarkers[i].setMap(map);
        }
    };

    function removeAllMarkers(){
        allMarkers = [];
        setMapOnAll(null);
    }

    //saves the data from google map direction
    function saveDirectionData(data){
        directionDataArr.push(data);
        let pathDom = document.getElementById('setPathArr');
        pathDom.value = JSON.stringify(directionDataArr);
    }
</script>
@endsection
