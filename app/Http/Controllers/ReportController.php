<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('report.index');
    }

    //datatable purpose
    public function anyData()
    {
        $reports = Report::query()->orderBy('created_at', 'desc');
        return Datatables::of($reports)
            ->addColumn('action', function($report){
                return '<a href="report/' . $report->id . '/view" class="action"><i class="material-icons">remove_red_eye</i></a><a href="report/' . $report->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
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
        // return view('report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report = new Report;
        $report->subject = $request->input('subject');
        $report->content = $request->input('content');
        $report->type = $request->input('type');
        $report->status = 0;
        $report->save();

        return response()->json([$report]);
    }

    public function view($id){
        $report = Report::find($id);
        return view('report.view', ['report' => $report]);
    }

    public function resolve($id){
        $report = Report::find($id);
        $report->status = 1;
        $report->save();
        return redirect('report.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
