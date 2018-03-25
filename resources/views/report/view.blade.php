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
            <div class="col-sm-7">
                <h3>View Report</h3>
            </div>
            <div class="col-sm-2" style="padding-top: 20px;">
                <a href="#"><button class="btn basic-btn submit-btn">Print</button></a>
            </div>
            <div class="col-sm-1" style="padding-top: 20px;">
                <a href="{{route('report')}}"><button class="btn basic-btn submit-btn">Back</button></a>
            </div>
            <div class="col-sm-2" style="padding-top: 20px;">
                <a href="{{route('resolveReport', ['id' => $report->id])}}"><button class="btn basic-btn" id="resolve_btn">Resolve</button></a>
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
                    {{Form::text('id', $report->id, ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-5">
                    <h5>Type</h5>
                    {{Form::text('type', $report->type, ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-5">
                    <h5>Reported On</h5>
                    {{Form::text('date', $report->created_at, ['disabled' => 'disabled'])}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h5>Subject</h5>
                    {{Form::text('subject', $report->subject, ['disabled' => 'disabled'])}}
                </div>
                <div class="col-sm-12">
                    <h5>Content</h5>
                    {{Form::textarea('content', $report->content, ['disabled' => 'disabled'])}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script type="text/javascript">
    $(function(){
        if(<?php echo $report->status; ?> == 1){
            $('#resolve_btn').prop('disabled', true);
        }
    })
</script>
@endpush