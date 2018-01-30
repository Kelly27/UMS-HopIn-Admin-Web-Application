@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">assignment</i><b style="font-size: large;">Report Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/report.css')}}">
@endsection

@section('content')
    <div class="ReportManagerPage datatable container-fluid contentPage">
        <a href="{{route('createReport')}}"><button class="btn basic-btn" style="margin-bottom: 20px;">ADD</button></a>
        @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        <table class="table table-bordered" id="bus-table">
        <thead style = "background-color: #0379be; color: white;">
            <tr>
                <td width="5%">ID</td>
                <td>Report Subject</td>
                <td>Reported On</td>
                <td>Type</td>
                <td>Status</td>
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
        ajax: '{!! route('report_datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'subject', name: 'subject' },
            { data: 'created_on', name: 'created_on'},
            { data: 'type', name: 'type'},
            { data: 'status', name: 'status'},
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