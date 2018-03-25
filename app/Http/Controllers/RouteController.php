<?php

namespace App\Http\Controllers;

use App\Route;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Bus_Stop;
use App\Bus;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $bus_stop_arr = ['FKJ','FSSA', 'FKI', 'FKSW', 'FSMP'];

    public function index()
    {
        $routes = Route::orderBy('created_at', 'DESC')->get();
        return view('route.index', ['routes' => $routes]);
    }

    //datatable purpose
    public function anyData()
    {
        $routes = Route::query()->orderBy('created_at', 'desc');
        return Datatables::of($routes)
            ->addColumn('action', function($route){
                return '<a href="route/' . $route->id . '/edit" class="action"><i class="material-icons">mode_edit</i></a><a href="route/' . $route->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
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
        $buses = ['Please Select'];
        // return view('route.create', ['id' => Route::orderBy('id', 'desc')->first()->id + 1, 'bus_stop_arr' => $this->bus_stop_arr]);
        $bus_stops = Bus_Stop::all(['name', 'location']);
        foreach($bus_stops as $stop){
            $stop->location = json_decode($stop->location);
        };
        $buses_data = Bus::orderBy('created_at', 'DESC')->get();
        foreach($buses_data as $b){
            $buses[] = $b->bus_number;
        }
        return view('route.create', ['bus_stop_arr' => $this->bus_stop_arr, 'bus_stops_map' => $bus_stops, 'buses' => $buses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $route = new Route;
        $this->validate($request, [
            'route_name' => 'required',
            'route_desc' => 'required',
            'route_arr' => 'required',
        ],[
            'route_name.required' => 'The field \'ROUTE NAME\' is required.',
            'route_desc.required' => 'The field \'ROUTE DESCRIPTION\' is required.',
            'route_arr.required' => 'The field \'ROUTE\' is required.',
        ]);
        $route->title = $request->input('route_name');
        $route->description = $request->input('route_desc');
        $route->route_arr = $request->input('route_arr');
        $route->polyline = $request->input('path_arr');
        $route->color = '#' . $request->input('color');
        $route->save();

        return redirect('route')->with('message', 'Route profile has created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $bus_stops = Bus_Stop::all(['name', 'location']);
        $route = Route::where('id', $id)->first();
        return view('route.create', [
            'id' => $route->id,
            'route_name' => $route->title,
            'route_desc' => $route->description,
            'bus_stop' => json_decode($route->bus_stops),
            'route_arr' => $route->route_arr,
            'color' => $route->color,
            'bus_stop_arr' => $this->bus_stop_arr,
            'bus_stops_map' => $bus_stops
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Route $route)
    {
        $route = Route::find($id);

        $this->validate($request, [
            'route_name' => 'required',
            'route_desc' => 'required',
            'route_arr' => 'required',
        ],[
            'route_name.required' => 'The field \'ROUTE NAME\' is required.',
            'route_desc.required' => 'The field \'ROUTE DESCRIPTION\' is required.',
            'route_arr.required' => 'The field \'ROUTE\' is required.',
        ]);
        $route->title = $request->input('route_name');
        $route->description = $request->input('route_desc');
        $route->bus_stops = json_encode($request->input('bus_stop'));
        $route->route_arr = $request->input('route_arr');
        $route->polyline = $request->input('path_arr');
        $route->color = '#' . $request->input('color');
        $route->save();

        return redirect('route')->with('message', 'Route profile has updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route, $id)
    {
        Route::destroy($id);
        return redirect('route')->with('message', 'Route has been deleted succesfully');

    }

    //api
    public function getRouteData(){
        $route = Route::orderBy('id', 'asc')->get(['id', 'title', 'description', 'route_arr', 'polyline', 'color']);
        return $route;
    }

    public function getRelevantBuses($id){
        $routes = Route::where('id', $id)->first();
        $buses = $routes->buses;
        return $routes;
    }
}
