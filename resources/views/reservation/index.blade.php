@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">settings_phone</i><b style="font-size: large;">Bus Reservation Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/reservation.css')}}">
@endsection

@section('content')
    <div class="ReservationManagerPage datatable container-fluid contentPage">
        <a href="{{route('createReservation')}}"><button class="btn basic-btn" style="margin-bottom: 20px;">ADD</button></a>
        @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        <table class="table table-bordered" id="bus-table">
        <thead style = "background-color: #0379be; color: white;">
            <tr>
                <td>Reference Number</td>
                <td>Applicant's Name</td>
                <td>Requested On</td>
                <td>Approval Status</td>
                <td>Action</td>
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
        ajax: '{!! route('reservation_datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'applicant_info.name', name: 'applicant_info.name' },
            { data: 'created_on', name: 'created_on'},
            { data: 'approval_status', name: 'approval_status'},
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endpush