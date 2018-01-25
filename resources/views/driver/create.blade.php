@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">people</i><b style="font-size: large;">Driver Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/driver.css')}}">
@endsection

@section('content')
    <div class="createDriverPage createPage container-fluid contentPage">
        <div class="row">
            <div class="col-sm-10">
                <h3>Create Drivers's Profile</h3>
            </div>
            @php
            if(collect(request()->segments())->last() == 'edit'){
                $url = 'updateDriver';
            }
            else if(collect(request()->segments())->last() == 'create'){
                $url = 'storeDriver';
            }
            @endphp
            {{ Form::open(['url' => route($url, ['id' => Request::segment(2)]), 'method' => 'post']) }}
            <div class="col-sm-2" style="padding-top: 20px;">
                <a href="#"><button class="btn basic-btn submit-btn">Submit</button></a>
            </div>
        </div>
        <div class="inputForm">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h4>Basic Information</h4>
            <div class="row">
                <div class="col-sm-10">
                    <h5>Name</h5>
                    @if(isset($name))
                        {{Form::text('name', $name)}}
                    @else
                        {{Form::text('name')}}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h5>Identification Number (E.G. 912345-12-5123)</h5>
                    @if(isset($ic_number))
                        {{Form::text('ic_number', $ic_number)}}
                    @else
                        {{Form::text('ic_number')}}
                    @endif
                </div>
                <div class="col-sm-6">
                    <h5>Staff Number</h5>
                    @if(isset($staff_number))
                        {{Form::text('staff_number', $staff_number)}}
                    @else
                        {{Form::text('staff_number')}}
                    @endif
                </div>
            </div>

            <hr>
            <div class="row">
                <h4>Mobile Application Profile</h4>
                <div class="col-sm-6">
                    <h5>Password</h5>
                    @if(isset($password))
                        {{Form::text('password', $password)}}
                    @else
                        {{Form::text('password')}}
                    @endif
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endsection