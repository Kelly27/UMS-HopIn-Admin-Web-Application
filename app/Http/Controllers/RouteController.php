<?php

namespace App\Http\Controllers;

use App\Route;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

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

        // $result = \Guzzle::get('https://umsbus2017.000webhostapp.com/announcement.json');
        // dd(json_decode($result->getBody()));
        $routes = Route::orderBy('created_at', 'DESC')->get();
        $fp = fopen('route.json', 'w');
        fwrite($fp, json_encode($routes));
        fclose($fp);
        return view('route.index', ['routes' => $routes]);
    }

    //datatable purpose
    public function anyData()
    {
        $routes = Route::query();
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
        // return view('route.create', ['id' => Route::orderBy('id', 'desc')->first()->id + 1, 'bus_stop_arr' => $this->bus_stop_arr]);
        return view('route.create', ['bus_stop_arr' => $this->bus_stop_arr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $route = new Route;
        $this->validate($request, [
            'route_name' => 'required',
            'route_desc' => 'required',
            'bus_stop' => 'required',
            'route_arr' => 'required',
        ],[
            'route_name.required' => 'The field \'ROUTE NAME\' is required.',
            'route_desc.required' => 'The field \'ROUTE DESCRIPTION\' is required.',
            'bus_stop.required' => 'The field \'BUS STOP THAT INVOLVED\' is required.',
            'route_arr.required' => 'The field \'ROUTE\' is required.'
        ]);
        $route->title = $request->input('route_name');
        $route->description = $request->input('route_desc');
        $route->bus_stops = json_encode($request->input('bus_stop'));
        $route->route_arr = $request->input('route_arr');
        $route->save();

        return redirect('route');
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
        $route = Route::where('id', $id)->first();
        return view('route.create', [
            'id' => $route->id,
            'route_name' => $route->title,
            'route_desc' => $route->description,
            'bus_stop' => json_decode($route->bus_stops),
            'route_arr' => $route->route_arr,
            'bus_stop_arr' => $this->bus_stop_arr
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        //
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
}
