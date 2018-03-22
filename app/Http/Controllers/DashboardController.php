<?php

namespace App\Http\Controllers;

use App\Bus;
use App\Route;
use App\Driver;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guest()){
            return view('app.login');
        }
        else{
            $bus_id = ['Please Select'];
            $bus_driver = [];
            $bus_route = ['Please Select'];

            $no_operation_bus = Bus::where('isOperating', 0)->get(['id', 'bus_number', 'plate_no', 'route_id', 'driver_id']);
            foreach ($no_operation_bus as $bus) {
                $bus_id[$bus->id] = $bus->bus_number . ' - ' . $bus->plate_no;
            }

            $bus_driver = $this->get_no_operation_driver();

            $routes = Route::all(['id', 'title']);
            foreach ($routes as $r) {
                $bus_route[$r->id] = $r->title;
            }

            return view('dashboard.index', [
                "user" => Auth::user()['name'], 
                "bus_id" => $bus_id, 
                "bus_driver" => $bus_driver, 
                "bus_route" => $bus_route
            ]);
        }
    }

    //dashboard datatable
    public function dashboard()
    {
        $data = Bus::query()->where('isOperating', 1)->get(['id', 'bus_number', 'route_id', 'driver_id', 'next_stop']);

        return Datatables::of($data)
        ->addColumn('action', function($d){
            return '<a href="home/' . $d->id . '/deleteOperation" class="action"><i class="material-icons">delete</i></a>';
        })
        ->editColumn('route', function($d){
            return $d->routes->title;
        })
        ->editColumn('driver', function($d){

            return $d->drivers->name;
        })
        ->editColumn('next_stop', function($d){
            $n = ' ';
            if($d->next_stop){
                $next_stop = json_decode($d->next_stop);
                $n = $next_stop->name;
            }
            return $n;
        })
        ->make(true);
    }

    public function get_no_operation_driver()
    {
        $no_operation_drivers = ['Please Select'];

        $all_drivers = Driver::all(['id', 'name']);
        $data = $all_drivers->reject(function ($value, $key) {
            for($i = 0; $i < count($value); $i++){
                $operating_drivers = Bus::where('isOperating', 1)->get(['driver_id']);
                foreach ($operating_drivers as $op) {
                    if($value->id == $op->driver_id){
                        // array_push($temp, $i);
                        return $value;
                    }
                }
            }
        });
        foreach ($data as $d) {
            $no_operation_drivers[$d->id] = $d->name;
        }
        return $no_operation_drivers;
    }

    public function setupOperation(Request $request)
    {
        $this->validate($request, [
            'bus' => 'required|not_in:0',
            'route' => 'required|not_in:0',
            'driver' => 'required|not_in:0',
        ]);

        $bus = Bus::where('id', $request->input('bus'))->first();
        $bus->route_id = $request->input('route');
        $bus->driver_id = $request->input('driver');
        $bus->isOperating = 1;
        $bus->save();

        return redirect('home')->with('message', 'Bus Operation has added succesfully');
    }

    public function deleteOperation($id){
        $data = Bus::where('id', $id)->first();
        $data->isOperating = 0;
        $data->driver_id = null;
        $data->save();
        return redirect('home')->with('message', 'Bus Operation for Bus Number [ ' . $data->bus_number . ' ] has deleted succesfully');
    }
}
