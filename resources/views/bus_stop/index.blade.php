@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">store_mall_directory</i><b style="font-size: large;">Bus Stop Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/bus_stop.css')}}">
@endsection

@section('content')
    <div class="BusStopManagerPage datatable container-fluid contentPage">
        <a href="{{route('createBusStop')}}"><button class="btn basic-btn" style="margin-bottom: 20px;">ADD</button></a>
        @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        <table class="table table-bordered" id="bus-table">
        <thead style = "background-color: #0379be; color: white;">
            <tr>
                <td width="25%">Stop Name</td>
                <td>Details</td>
                <td width="10%">Latitude</td>
                <td width="10%">Longitude</td>
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
        ajax: '{!! route('bus_stop_datatables.data') !!}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'location.lat', name: 'location.lat'},
            { data: 'location.lng', name: 'lng.longitude'},
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [{
            targets: 1,
            {{--make data truncate multiline and removed image and horizontal line--}}
            render: function ( data, type, row ) {
                var d = $.parseHTML(data)[0].textContent; 
                var mydata = d.replace(/<img.{0,50}>/g, '');
                var mydata = mydata.replace('<hr>', '');
                if (mydata.length > 200){
                    return mydata.substr(0, 200) + '...';
                }
                else{
                    return mydata;
                }
            }
        },{
            targets: 0,
            render: function ( data, type, row ) {
                return data.length > 50 ? data.substr( 0, 50 ) + '...' : data;
            }
        }],
    });
});
</script>
@endpush