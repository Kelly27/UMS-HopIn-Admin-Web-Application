<?php

namespace App\Http\Controllers;

use App\Bus_Stop;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BusStopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bus_stop.index');
    }

    //datatable purpose
    public function anyData()
    {
        $bus_stops = Bus_Stop::query()->orderBy('created_at', 'desc');

        return Datatables::of($bus_stops)
            ->editColumn('location.lat', function($bus_stop){
                $location = json_decode($bus_stop->location);
                return $location->lat;
            })
            ->editColumn('location.lng', function($bus_stop){
                $location = json_decode($bus_stop->location);
                return $location->lng;
            })
            ->addColumn('action', function($bus_stop){
                return '<a href="bus_stop/' . $bus_stop->id . '/edit" class="action"><i class="material-icons">mode_edit</i></a><a href="bus_stop/' . $bus_stop->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
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
        return view('bus_stop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bus_stop = new Bus_Stop;

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
        ]);

        $bus_stop->name = $request->input('name');
        $bus_stop->description = $request->input('description');
        $bus_stop->location = $request->input('location');
        $bus_stop->save();

        return redirect('bus_stop')->with('message', 'Bus stop profile has created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bus_Stop  $bus_Stop
     * @return \Illuminate\Http\Response
     */
    public function show(Bus_Stop $bus_Stop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bus_Stop  $bus_Stop
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Bus_Stop $bus_Stop)
    {
        $bus_stop = Bus_Stop::find($id);

        return view('bus_stop.create', [
            'name' => $bus_stop->name,
            'description' => $bus_stop->description,
            'location' => $bus_stop->location
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bus_Stop  $bus_Stop
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Bus_Stop $bus_Stop)
    {
        $bus_stop = Bus_Stop::find($id);

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
        ]);

        $bus_stop->name = $request->input('name');
        $bus_stop->description = $request->input('description');
        $bus_stop->location = $request->input('location');
        $bus_stop->save();

        return redirect('bus_stop')->with('message', 'Bus stop profile has updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bus_Stop  $bus_Stop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Bus_Stop $bus_Stop)
    {
        $bus_stop = Bus_Stop::destroy($id);

        return redirect('bus_stop')->with('message', 'Bus stop profile has deleted succesfully');
    }

    public function getBusStopData()
    {
        $bus_stops = Bus_Stop::orderBy('id', 'asc')-> get(['id', 'name', 'description', 'location']);
        return $bus_stops;
    }
}
