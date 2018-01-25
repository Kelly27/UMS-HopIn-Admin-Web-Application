@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">directions_bus</i><b style="font-size: large;">Bus Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/bus.css')}}">
@endsection

@section('content')
    <div class="BusManagerPage datatable container-fluid contentPage">
        <a href="{{route('createBus')}}"><button class="btn basic-btn" style="margin-bottom: 20px;">ADD</button></a>
        @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        <table class="table table-bordered" id="bus-table">
        <thead style = "background-color: #0379be; color: white;">
            <tr>
                <td>Bus Number</td>
                <td>Plate Number</td>
                <td>Year Manufactured</td>
                <td>Track Status</td>
                <td>Action</td>
            </tr>
        </thead>
    </table>
    </div>
@endsection

@section('script')
<script>
//ajax error occuring due to laravel datatable bug
// disable datatables error prompt
{{-- $.fn.dataTable.ext.errMode = 'throw';
$(document).ajaxError(function(event, jqxhr, settings, exception) {

    if (exception == 'Unauthorized') {

        // Prompt user if they'd like to be redirected to the login page
        bootbox.confirm("Your session has expired. Would you like to be redirected to the login page?", function(result) {
            if (result) {
                window.location = '/login';
            }
        });

    }
}); --}}

$(function() {
    $('#bus-table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: '{!! route('bus_datatables.data') !!}',
        columns: [
            { data: 'bus_number', name: 'bus_number' },
            { data: 'plate_no', name: 'plate_no' },
            { data: 'year_manufactured', name: 'year_manufactured'},
            { data: 'track_status', name: 'track_status'},
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection