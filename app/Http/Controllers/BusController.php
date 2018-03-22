<?php

namespace App\Http\Controllers;

use App\Bus;
use App\Route;
use App\Driver;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bus.index');
    }

    //datatable purpose
    public function anyData()
    {
        $buses = Bus::query()->orderBy('created_at', 'desc');

        return Datatables::of($buses)
        ->addColumn('action', function($bus){
            return '<a href="bus/' . $bus->id . '/edit" class="action"><i class="material-icons">mode_edit</i></a><a href="bus/' . $bus->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
        })
        ->editColumn('bus_location', function($bus){
            if($bus->bus_location == NULL){
                return 'OFF';
            }
            else{
                return 'ON';
            }
        })
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $bus = new Bus;

        $this->validate($request, [
            'bus_number' => 'required',
            'plate_no' => 'required',
            'year_manufactured' => 'required|digits:4',
        ],[
            'bus_number.required' => 'The field \'Bus Number\' is required.',
            'plate_no.required' => 'The field \'Bus Plate Number\' is required.',
            'year_manufactured.required' => 'The field \'Year Manufactured\' is required.',
            'year_manufactured.digits' => 'The field \'Year Manufactured\' must be digits of 4.',
        ]);

        $bus->bus_number = $request->input('bus_number');
        $bus->plate_no = $request->input('plate_no');
        $bus->year_manufactured = $request->input('year_manufactured');
        // $bus->isOperating = 0;
        $bus->save();

        return redirect('bus')->with('message', 'Bus profile has created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $bus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Bus $bus)
    {
        $bus = Bus::find($id);

        return view('bus.create', [
            'bus_number' => $bus->bus_number,
            'plate_no' => $bus->plate_no,
            'year_manufactured' => $bus->year_manufactured
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Bus $bus)
    {
        $bus = Bus::find($id);

        $this->validate($request, [
            'bus_number' => 'required',
            'plate_no' => 'required',
            'year_manufactured' => 'required|digits:4',
        ]);

        $bus->bus_number = $request->input('bus_number');
        $bus->plate_no = $request->input('plate_no');
        $bus->year_manufactured = $request->input('year_manufactured');
        // $bus->isOperating = 0;
        $bus->save();

        return redirect('bus')->with('message', 'Bus profile has updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Bus $bus)
    {
        Bus::destroy($id);

        return redirect('bus')->with('message', 'Bus profile has deleted successfully.');
    }

    //api
    public function updateLocation($id, Request $request)
    {
        $bus = Bus::find($id);
        $bus->bus_location = $request->input('bus_location');
        $bus->next_stop = $request->input('next_stop');
        $bus->save();
        return response()->json([$bus]);
    }

    public function getBusTrackingData()
    {
        $bus = Bus::all();
        return $bus;
    }

    public function getOperatingInfo($id){
        $bus = Bus::where('id', $id)->first();
        $route = $bus->routes;
        $driver = $bus->drivers;
        return $bus;
    }

    public function getETA($origin, $destination){
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origin . '&destinations=' . $destination . '&key=AIzaSyARzgseB8wPPpiP65N9rzPqFwcdA4WuugY';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        return $response;
    }
}
