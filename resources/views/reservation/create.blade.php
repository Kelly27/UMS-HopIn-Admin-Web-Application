@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">settings_phone</i><b style="font-size: large;">Bus Reservation Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/reservation.css')}}">
@endsection

@section('content')
    <div class="createReservationPage createPage container-fluid contentPage">
        <div class="row">
            <div class="col-sm-6">
                @if(collect(request()->segments())->last() == 'edit')
                    <h3>View Bus Reservation</h3>
                @else
                    <h3>Create Bus Reservation</h3>
                @endif
            </div>
            @php
            $url = 'viewReservation';
            @endphp
            {{ Form::open(['url' => route($url, ['id' => Request::segment(2)]), 'method' => 'post']) }}
            {{-- <div class="col-sm-2" style="padding-top: 20px;">
                <a href="#"><button class="btn basic-btn submit-btn">Print</button></a>
            </div>
            <div class="col-sm-2" style="padding-top: 20px;">
                <a href="#"><button class="btn basic-btn submit-btn">Cancel</button></a>
            </div> --}}
            <div class="col-sm-2" style="padding-top: 20px;">
                <a href="#"><button class="btn basic-btn submit-btn">Submit</button></a>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="inputForm" style="padding: 5px 25px 15px;">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Reference Number</h5>
                    {{Form::text('reference_number', 'RR-' . str_pad($reservation->id, 4, '0', STR_PAD_LEFT), ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-6">
                    <h5>Requested On</h5>
                    {{Form::text('requested_date', $reservation->created_at, ['disabled' => 'disabled'])}}
                </div>
            </div>
        </div>
        <div class="inputForm">
            <h4>Applicant's Information</h4>
            <div class="row">
                <div class="col-sm-7">
                    <h5>Name</h5>
                    {{Form::text('name', $applicant->applicant_name, ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-5">
                    <h5>Staff Number</h5>
                    {{Form::text('staff_number', $applicant->staff_no, ['disabled' => 'disabled'])}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <h5>Contact Number</h5>
                    {{Form::text('contact_num', $applicant->contact_no, ['disabled' => 'disabled'])}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h5>Faculty</h5>
                    {{Form::text('faculty', $applicant->faculty, ['disabled' => 'disabled'])}}
                </div>
            </div>
        </div>
        <div class="inputForm">
            <h4>Bus Reservation Details</h4>
            <div class="row">
                <div class="col-sm-12">
                    <h5>Event / Activity Description</h5>
                    {{Form::textarea('desc', $reservation->event_desc, ['disabled' => 'disabled'])}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6" style="border-right: 2px solid #aba9a9">
                    <h5 style="font-weight: bold;">Bus Required On</h5>
                    <h5>Date</h5>
                    {{Form::text('date', $req_date, ['disabled' => 'disabled'])}}
                    <h5>time</h5>
                    {{Form::text('time', $req_time, ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-6">
                    <h5>Type of Vehicle</h5>
                    {{Form::text('type', $reservation->vehicle_type, ['disabled' => 'disabled'])}}
                    <h5>Number of Passenger</h5>
                    {{Form::text('31', $reservation->number_of_passenger, ['disabled' => 'disabled'])}}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <h5>Pick Up Location:</h5>
                </div>
                <div class="col-sm-9">
                    {{Form::text('pick_up', $reservation->pick_up_location)}}
                </div>
                <div class="col-sm-12">
                    <div id="map1" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <h5>Drop off Location:</h5>
                </div>
                <div class="col-sm-9">
                    {{Form::text('pick_up', $reservation->dro_off_location)}}
                </div>
                <div class="col-sm-12">
                    <div id="map2" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>
        <div class="inputForm">
            <h4>Approval Details</h4>
            <div class="row">
                <div class="col-sm-3">
                    <h5>Vehicle Plate Number</h5>
                    {{Form::text('vehicle_plate_no', 'vehicle_plate_no')}}
                </div>
                <div class="col-sm-5">
                    <h5>Assigned Bus Driver</h5>
                    {{Form::text('vehicle_plate_no', 'vehicle_plate_no')}}
                </div>
                <div class="col-sm-4">
                    <h5>Vehicle Type</h5>
                    {{Form::text('vehicle_plate_no', 'vehicle_plate_no')}}
                </div>
                <div class="col-sm-12">
                    <h5>Remarks</h5>
                    {{Form::textarea('remarks', 'remarks')}}
                </div>
            </div>
        </div>
        {{ Form::close()}}
    </div>
@endsection

@push('script')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARzgseB8wPPpiP65N9rzPqFwcdA4WuugY&libraries=places&callback=initMap"></script>
<script>
    var map1, map2, marker1, marker2;
    function initMap(){
        map1 = new google.maps.Map(document.getElementById('map1'), {
            zoom: 17,
            center: {lat: 6.0333, lng: 116.1229},
        });

        map2 = new google.maps.Map(document.getElementById('map2'), {
            zoom: 17,
            center: {lat: 6.0333, lng: 116.1229},
        });

        var service = new google.maps.places.PlacesService(map1);
        
        console.log(service);
        {{-- if (document.getElementById('setLocation').value !== ''){
            var oldMarker = JSON.parse(document.getElementById('setLocation').value);
            marker = new google.maps.Marker({
                position: oldMarker,
                draggable: true,
                animation: google.maps.Animation.DROP,
                map: map
            })
        } --}}
        map1.addListener('click', addMarker1);
        map2.addListener('click', addMarker2);
    }

    function addMarker1(event){
        if(marker1){
            marker1.setAnimation(google.maps.Animation.DROP);
            marker1.setPosition(event.latLng);
        }
        else{
            marker1 = new google.maps.Marker({
                position: event.latLng,
                {{-- title: '#' + path.getLength(), --}}
                draggable: true,
                animation: google.maps.Animation.DROP,
                map: map1
            });
        }
        {{-- updateData(event.latLng); --}}
    }

    function addMarker2(event){
        if(marker2){
            marker2.setAnimation(google.maps.Animation.DROP);
            marker2.setPosition(event.latLng);
        }
        else{
            marker2 = new google.maps.Marker({
                position: event.latLng,
                {{-- title: '#' + path.getLength(), --}}
                draggable: true,
                animation: google.maps.Animation.DROP,
                map: map2
            });
        }
        {{-- updateData(event.latLng); --}}
    }

    function updateData(data){
        var location = {lat: data.lat(), lng:data.lng()};
        document.getElementById('setLocation').value = JSON.stringify(location);
    }
</script>
@endpush