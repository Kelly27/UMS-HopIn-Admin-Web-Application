@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">home</i><b style="font-size: large;">Dashboard</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/dashboard.css')}}">
@endsection

@section('content')
    <div class="dashboardPage container-fluid contentPage datatable">
        <h3>Welcome, {{$user}}!</h3>
        <h4>
            Bus Operation
            <button class="btn add-bus-btn" data-toggle="modal" data-target="#addOperationModal"><i class="material-icons">add_box</i>Add Bus Operation</button>
        </h4>
        @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif


        <table class="table table-bordered" id="dashboard-table">
            <thead style = "background-color: #508F58; color: white;">
                <tr>
                    <td><i class="menu-i material-icons">directions_bus</i>Bus Number</td>
                    <td><i class="menu-i material-icons">directions</i>Route</td>
                    <td><i class="menu-i material-icons">people</i>Driver</td>
                    <td><i class="menu-i material-icons">store_mall_directory</i>Next Stop</td>
                    <td>Action</td>
                </tr>
            </thead>
        </table>
    </div>

    @include('dashboard.add_bus_operation_modal')
</div>
@endsection

@push('script')
<script>
$(function() {
    $('#dashboard-table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: '{!! route('dashboard.data') !!}',
        columns: [
            { data: 'bus_number', name: 'bus_number' },
            { data: 'route', name: 'route'},
            { data: 'driver', name: 'driver'},
            { data: 'next_stop', name: 'next_stop'},
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    //form validation in modal 
    $('.select_bus').change(function() {
        var selected = $('.select_bus').find(":selected");
        console.log(selected.val());
        //if val > 0, then option is selected, else option is not selected
        if(selected.val() > 0){
            $('.sumbit-modal-btn').prop('disabled', false);
            $('.bus_err_msg').prop('hidden', 'hidden');
        }
        else{
            $('.select_bus').attr('id', 'invalid-select');
            $('.sumbit-modal-btn').prop('disabled', true);
            $('.bus_err_msg').removeAttr('hidden');
        }
    });

    $('.select_route').change(function() {
        var selected = $('.select_route').find(":selected");
        console.log(selected.val());
        //if val > 0, then option is selected, else option is not selected
        if(selected.val() > 0){
            $('.sumbit-modal-btn').prop('disabled', false);
            $('.route_err_msg').prop('hidden', 'hidden');
        }
        else{
            $('.select_route').attr('id', 'invalid-select');
            $('.sumbit-modal-btn').prop('disabled', true);
            $('.route_err_msg').removeAttr('hidden');
        }
    });

    $('.select_driver').change(function() {
        var selected = $('.select_driver').find(":selected");
        console.log(selected.val());
        //if val > 0, then option is selected, else option is not selected
        if(selected.val() > 0){
            $('.sumbit-modal-btn').prop('disabled', false);
            $('.driver_err_msg').prop('hidden', 'hidden');
        }
        else{
            $('.select_driver').attr('id', 'invalid-select');
            $('.sumbit-modal-btn').prop('disabled', true);
            $('.driver_err_msg').removeAttr('hidden');
        }
    });
});
</script>
@endpush