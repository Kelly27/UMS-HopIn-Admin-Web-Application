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
            <div class="col-sm-2" style="padding-top: 20px;">
                {{-- <a href="#"><button class="btn basic-btn submit-btn">Print</button></a> --}}
            </div>
            <div class="col-sm-2" style="padding-top: 20px;">
                {{-- <a href="#"><button class="btn basic-btn submit-btn">Cancel</button></a> --}}
            </div>
        {{ Form::open(['url' => route($url, ['id' => Request::segment(2)]), 'method' => 'post']) }}
            <div class="col-sm-2" style="padding-top: 20px;">
                @if($reservation->approval_status == 0)
                    <a href="{{Route('approveReservation', [$reservation->id])}}" style="color:white"><button type="submit" style="float: right; font-weight: bold;" class="btn basic-btn approve-btn">Approve</a>
                @else
                    <span style="float: right; font-weight: bold;" style="color:white"><button disabled class="btn basic-btn done-btn">Approved</span>
                @endif
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
                    {{Form::text('vehicle_plate_no')}}
                </div>
                <div class="col-sm-5">
                    <h5>Assigned Bus Driver</h5>
                    {{Form::text('vehicle_plate_no')}}
                </div>
                <div class="col-sm-4">
                    <h5>Vehicle Type</h5>
                    {{Form::text('vehicle_plate_no')}}
                </div>
                <div class="col-sm-12">
                    <h5>Remarks</h5>
                    {{Form::textarea('remarks')}}
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
            center: <?php echo $reservation->pick_up_location; ?>,
        });

        map2 = new google.maps.Map(document.getElementById('map2'), {
            zoom: 17,
            center: <?php echo $reservation->drop_off_location;?>,
        });

        var geocoder = new google.maps.Geocoder;
        var infowindow1 = new google.maps.InfoWindow;
        var infowindow2 = new google.maps.InfoWindow;

        this.getAddress(geocoder, 
                        <?php echo $reservation->pick_up_location; ?>, 
                        map1,
                        infowindow1);

        this.getAddress(geocoder, 
                        <?php echo $reservation->drop_off_location; ?>, 
                        map2,
                        infowindow2);
    }

    function getAddress(geocoder, position, map, infowindow){
        geocoder.geocode({'location': position}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var marker = new google.maps.Marker({
                        position: position,
                        map: map
                    });
                    console.log(results);
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                } else {
                    infowindow.setContent("Sorry, cannot find address.");
                }
            } else {
              window.alert('Geocoder failed due to: ' + status);
            }
        })
    }
</script>
@endpush