<?php

namespace App\Http\Controllers;

use App\Bus;
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
        $bus->track_status = 'OFF';
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
        $bus = Bus::find($id);

        return redirect('bus')->with('message', 'Bus profile has deleted successfully.');
    }
}
