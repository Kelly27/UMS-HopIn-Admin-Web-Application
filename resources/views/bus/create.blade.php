@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">directions_bus</i><b style="font-size: large;">Bus Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/bus.css')}}">
@endsection

@section('content')
    <div class="createBusPage createPage container-fluid contentPage">
        <div class="row">
            <div class="col-sm-10">
                <h3>Create Bus's Profile</h3>
            </div>
            @php
            if(collect(request()->segments())->last() == 'edit'){
                $url = 'updateBus';
            }
            else if(collect(request()->segments())->last() == 'create'){
                $url = 'storeBus';
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
                <div class="col-sm-4">
                    <h5>Bus Number</h5>
                    @if(isset($bus_number))
                        {{Form::text('bus_number', $bus_number)}}
                    @else
                        {{Form::text('bus_number')}}
                    @endif
                </div>
                <div class="col-sm-4">
                    <h5>Bus Plate Number</h5>
                    @if(isset($plate_no))
                        {{Form::text('plate_no', $plate_no)}}
                    @else
                        {{Form::text('plate_no')}}
                    @endif
                </div>
                <div class="col-sm-4">
                    <h5>Year Manufactured</h5>
                    @if(isset($year_manufactured))
                        {{Form::text('year_manufactured', $year_manufactured)}}
                    @else
                        {{Form::text('year_manufactured')}}
                    @endif
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endsection