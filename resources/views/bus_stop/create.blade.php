@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">store_mall_directory</i><b style="font-size: large;">Bus Stop Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/bus_stop.css')}}">
@endsection

@section('content')
    <div class="createBusStopPage createPage container-fluid contentPage">
        <div class="row">
            <div class="col-sm-10">
                <h3>Create Bus Stop's Profile</h3>
            </div>
            @php
            if(collect(request()->segments())->last() == 'edit'){
                $url = 'updateBusStop';
            }
            else if(collect(request()->segments())->last() == 'create'){
                $url = 'storeBusStop';
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
                <div class="col-sm-9">
                    <h5>Bus Stop Name</h5>
                    @if(isset($name))
                        {{Form::text('name', $name)}}
                    @else
                        {{Form::text('name')}}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h5>Bus Stop Details</h5>
                    @if(isset($description))
                        {{Form::textarea('description', $description)}}
                    @else
                        {{Form::textarea('description')}}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-map">
                    <h5>Bus Stop Location</h5>
                    @if(isset($location))
                        <input type="text" name="location" value="{{$location}}" style="visibility: hidden; position:absolute;" id="setLocation">
                    @else
                        <input type="text" name="location" style="visibility: hidden; position:absolute;" id="setLocation">
                    @endif
                    <div id="map" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endsection

@push('script')
<script type="text/javascript" src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARzgseB8wPPpiP65N9rzPqFwcdA4WuugY&callback=initMap"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        plugins : 'advlist autolink link image lists charmap print preview',
        skin: 'lightgray'
    });
</script>
<script>
    var map, marker;
    function initMap(){
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            center: {lat: 6.0333, lng: 116.1229},
        });

        if (document.getElementById('setLocation').value !== ''){
            var oldMarker = JSON.parse(document.getElementById('setLocation').value);
            marker = new google.maps.Marker({
                position: oldMarker,
                draggable: true,
                animation: google.maps.Animation.DROP,
                map: map
            })
        }
        map.addListener('click', addMarker);
    }

    function addMarker(event){
        if(marker){
            marker.setAnimation(google.maps.Animation.DROP);
            marker.setPosition(event.latLng);
        }
        else{
            marker = new google.maps.Marker({
                position: event.latLng,
                {{-- title: '#' + path.getLength(), --}}
                draggable: true,
                animation: google.maps.Animation.DROP,
                map: map
            });
        }
        updateData(event.latLng);
    }

    function updateData(data){
        var location = {lat: data.lat(), lng:data.lng()};
        document.getElementById('setLocation').value = JSON.stringify(location);
    }
</script>
@endpush