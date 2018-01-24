@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">directions</i><b style="font-size: large;">Route Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/route.css')}}">
@endsection

@section('content')
    <div class="routeManagerPage container-fluid contentPage">
        <a href="{{route('createRoute')}}"><button class="btn basic-btn" style="margin-bottom: 20px;">ADD</button></a>
        @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        <table class="table table-bordered" id="routes-table">
        <thead>
            <tr>
                <td>Route Name</td>
                <td>Route Description</td>
                <td>Route Action</td>
            </tr>
        </thead>
    </table>
    </div>
@endsection

@section('script')
<script>
$(function() {
    $('#routes-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('route_datatables.data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection