@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">people</i><b style="font-size: large;">Driver Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/driver.css')}}">
@endsection

@section('content')
    <div class="DriverManagerPage datatable container-fluid contentPage">
        <a href="{{route('createDriver')}}"><button class="btn basic-btn" style="margin-bottom: 20px;">ADD</button></a>
        @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        <table class="table table-bordered" id="driver-table">
        <thead style = "background-color: #0379be; color: white;">
            <tr>
                <td>Driver's Name </td>
                <td>Staff Number</td>
                <td>Action</td>
            </tr>
        </thead>
    </table>
    </div>
@endsection

@section('script')
<script>
$(function() {
    $('#driver-table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: '{!! route('driver_datatables.data') !!}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'staff_number', name: 'staff_number' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection