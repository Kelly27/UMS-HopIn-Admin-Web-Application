<div class="modal fade" id="addOperationModal" tabindex="-1" role="dialog" aria-labelledby="operationModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="operationModalLabel">Add Bus Operation</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if(session()->has('error'))
                    <div class="alert alert-danger">{{session()->get('error')}}</div>
                    @endif
                    <div class="col-sm-4">
                        {{ Form::open(['url' => route('setupOperation'), 'method' => 'post']) }}
                        <h6>Select Bus: </h6>
                        {{Form::select('bus', $bus_id, null, ['class' => 'select_bus'])}}
                        <p class='bus_err_msg' hidden>Please select a bus.</p>
                    </div>
                    <div class="col-sm-4">
                        <h6>Select Route: </h6>
                        {{Form::select('route', $bus_route, null, ['class' => 'select_route'])}}
                        <p class='route_err_msg' hidden>Please select a route.</p>
                    </div>
                    <div class="col-sm-4">
                        <h6>Select Driver: </h6>
                        {{Form::select('driver', $bus_driver, null, ['class' => 'select_driver'])}}
                        <p class='driver_err_msg' hidden>Please select a driver.</p>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
            <span class="pull-right">
                {{-- {{ Form::submit('Submit', array('class' => 'btn btn-info btn-block')) }} --}}
                <button class="btn btn-primary sumbit-modal-btn" disabled="true">Submit</button>
                {{ Form::close()}}
            </span>
        </div>
    </div>
</div>