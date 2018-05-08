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
                <td>Route Name</td>
                <td>Route Description</td>
                <td>Created On</td>
                <td>Updated On</td>
                <td>Action</td>
            </tr>
        </thead>
    </table>
    </div>
@endsection

@push('script')
<script>
$(function() {
    $('#routes-table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: '{!! route('route_datatables.data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [{
            targets: 1,
            render: function ( data, type, row ) {
                var d = $.parseHTML(data)[0].textContent;
                return d.length > 200 ? d.substr( 0, 200 ) + '...' : d;
            }
        },{
            targets: 0,
            render: function ( data, type, row ) {
                var d = $.parseHTML(data)[0].textContent;
                return d.length > 200 ? d.substr( 0, 200 ) + '...' : d;
            }
        }]
    }); 
});
</script>
@endpush