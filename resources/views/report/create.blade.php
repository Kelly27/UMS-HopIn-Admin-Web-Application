@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">assignment</i><b style="font-size: large;">Report Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/report.css')}}">
@endsection

@section('content')
    <div class="viewReportPage createPage container-fluid contentPage">
        <div class="row">
            <div class="col-sm-10">
                <h3>View Report</h3>
            </div>
            @php
            if(collect(request()->segments())->last() == 'edit'){
                $url = 'updateAnnouncement';
            }
            else if(collect(request()->segments())->last() == 'create'){
                $url = 'storeAnnouncement';
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
                <div class="col-sm-2">
                    <h5>ID(Disabled)</h5>
                    {{Form::text('id', '1', ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-5">
                    <h5>Type</h5>
                    {{Form::text('type', 'driver', ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-5">
                    <h5>Reported On</h5>
                    {{Form::text('date', '12/12/12', ['disabled' => 'disabled'])}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h5>Content</h5>
                    {{Form::textarea('content', 'adfafdadsf', ['disabled' => 'disabled'])}}
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endsection

@push('script')

@endpush