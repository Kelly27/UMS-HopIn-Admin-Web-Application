<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Bus;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('driver.index');
    }

    //datatable purpose
    public function anyData()
    {
        $drivers = Driver::query()->orderBy('created_at', 'desc');

        return Datatables::of($drivers)
            ->addColumn('action', function($driver){
                return '<a href="driver/' . $driver->id . '/edit" class="action"><i class="material-icons">mode_edit</i></a><a href="driver/' . $driver->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
            })
            ->make(true);
    }

    //api
    function json_data()
    {
        $drivers = Driver::orderBy('created_at', 'desc')->get();
        return $drivers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('driver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $driver = new Driver;

        $this->validate($request, [
            'name' => 'required',
            'ic_number' => 'required',
            'staff_number' => 'required',
            'password' => 'required',
        ]);

        $driver->name = $request->input('name');
        $driver->ic_number = $request->input('ic_number');
        $driver->staff_number = $request->input('staff_number');
        $driver->staff_number = $request->input('staff_number');
        $driver->password = Hash::make($request->input('password'));
        $driver->save();

        return redirect('driver')->with('message', 'Driver\'s profile has created succesfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Driver $driver)
    {
        $driver = Driver::find($id);

        return view('driver.create', [
            'name' => $driver->name,
            'ic_number' => $driver->ic_number,
            'staff_number' => $driver->staff_number,
            'password' => $driver->password,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Driver $driver)
    {
        $driver = Driver::find($id);

        $this->validate($request, [
            'name' => 'required',
            'ic_number' => 'required',
            'staff_number' => 'required',
            'password' => 'required',
        ]);

        $driver->name = $request->input('name');
        $driver->ic_number = $request->input('ic_number');
        $driver->staff_number = $request->input('staff_number');
        $driver->staff_number = $request->input('staff_number');
        $driver->password = Hash::make($request->input('password'));
        $driver->save();

        return redirect('driver')->with('message', 'Driver\'s profile has updated succesfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Driver $driver)
    {
        $driver = Driver::destroy($id);
        return redirect('driver')->with('message', 'Driver\'s has deleted succesfully');
    }

    public function getAssignedInfo($id){
        $driver = Driver::where('id', $id)->first();
        $assignedBus = $driver->assignedBus;
        $assignedBusData = Bus::where('id', $assignedBus->id)->first();
        $assignedBus->routes;
        return $driver;
    }
}
