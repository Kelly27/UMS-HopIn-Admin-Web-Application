@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">settings_phone</i><b style="font-size: large;">Bus Reservation Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/reservation.css')}}">
@endsection

@section('content')
    <div class="ReservationManagerPage datatable container-fluid contentPage">
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
    $('#bus-table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: '{!! route('reservation_datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'applicant_name', name: 'applicant_name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'approval_status', name: 'approval_status'},
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endpush