<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Reservation;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reservation.index');
    }

    //datatable purpose
    public function anyData()
    {
        $reservations = Reservation::query()->orderBy('created_at', 'desc');

        return Datatables::of($reservations)
            ->editColumn('applicant_name', function($reservation){
                $applicant = json_decode($reservation->applicant_info);
                return $applicant->applicant_name;
            })
            ->addColumn('action', function($reservation){
                return '<a href="reservation/' . $reservation->id . '/view" class="action"><i class="material-icons">mode_edit</i></a><a href="reservation/' . $reservation->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
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
        return view('reservation.create', [
            'ref_num' => 1 ,
            'requested_date' =>'fda'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $applicant = [
            'applicant_name' => $request->input('event_desc'),
            'contact_no' => $request->input('contact_no'),
            'contact_no' => $request->input('contact_no'),
            'faculty' => $request->input('faculty'),
            'staff_no' => $request->input('staff_no')
        ];

        $reservation = new Reservation;
        $reservation->applicant_info = json_encode($applicant);
        $reservation->vehicle_type = $request->input('vehicle_type');
        $reservation->required_datetime = Carbon::parse($request->input('required_datetime'));
        $reservation->pick_up_location = $request->input('pickupLoc');
        $reservation->number_of_passenger = $request->input('number_of_passenger');
        $reservation->event_desc = $request->input('event_desc');
        $reservation->drop_off_location = $request->input('dropoffLoc');
        $reservation->save();
        return response()->json([$reservation]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function view($id){
        $reservation = Reservation::find($id);
        $applicant = json_decode($reservation->applicant_info);
        $datetime = Carbon::parse($reservation->required_datetime);
        $req_date = $datetime->toFormattedDateString();
        $req_time = $datetime->toTimeString();
        return view('reservation.create', [
            'reservation' => $reservation,
            'applicant' => $applicant,
            'req_date' => $req_date,
            'req_time' => $req_time,
        ]);
    }

    //api
    public function getNewID(){
        $reservation = Reservation::orderBy('id', 'desc')->first();
        return $reservation->id;
    }

    public function getReservationData(){
        $reservations = Reservation::all();
        return $reservations;
    }
}
