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
        <thead style = "background-color: #0379be; color: white;">
            <tr>
                <td width="25%">Route Name</td>
                <td>Route Description</td>
                <td width="10%">Action</td>
            </tr>
        </thead>
    </table>
    </div>
@endsection

@push('script')
<script>
//ajax error occuring due to laravel datatable bug
// disable datatables error prompt
$.fn.dataTable.ext.errMode = 'throw';
$(document).ajaxError(function(event, jqxhr, settings, exception) {

    if (exception == 'Unauthorized') {

        // Prompt user if they'd like to be redirected to the login page
        bootbox.confirm("Your session has expired. Would you like to be redirected to the login page?", function(result) {
            if (result) {
                window.location = '/login';
            }
        });

    }
});

$(function() {
    $('#routes-table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: '{!! route('route_datatables.data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [{
            targets: 1,
            render: function ( data, type, row ) {
                return data.length > 200 ? data.substr( 0, 200 ) + '...' : data;
            }
        },{
            targets: 0,
            render: function ( data, type, row ) {
                return data.length > 50 ? data.substr( 0, 50 ) + '...' : data;
            }
        }]
    });
});
</script>
@endpush