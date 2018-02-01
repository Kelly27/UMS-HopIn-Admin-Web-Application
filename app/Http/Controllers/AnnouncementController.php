<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('announcement.index');
    }

    //datatable purpose
    public function anyData()
    {
        $announcements = Announcement::query()->orderBy('created_at', 'desc');
        return Datatables::of($announcements)
            ->addColumn('action', function($announcement){
                return '<a href="announcement/' . $announcement->id . '/edit" class="action"><i class="material-icons">mode_edit</i></a><a href="announcement/' . $announcement->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
            })
            ->make(true);
    }

    //provide data to android app
    function json_data()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return $announcements;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $announce = new Announcement;

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ],[
            'title' => 'The field \'Title\' is required',
            'content' => 'The field \'Content\' is required'
        ]);

        $announce->title = $request->input('title');
        $announce->content = $request->input('content');
        $announce->save();

        return redirect('announcement')->with('message', 'Announcement has created succesfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Announcement $announcement)
    {
        $announce = Announcement::find($id);
        return view('announcement.create', [
            'title' => $announce->title,
            'content' => $announce->content
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Announcement $announcement)
    {
        $announce = Announcement::find($id);
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ],[
            'title' => 'The field \'Title\' is required',
            'content' => 'The field \'Content\' is required'
        ]);

        $announce->title = $request->input('title');
        $announce->content = $request->input('content');
        $announce->save();

        return redirect('announcement')->with('message', 'Announcement has updated succesfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Announcement $announcement)
    {
        Announcement::destroy($id);
        return redirect('announcement')->with('message', 'Announcement has deleted succesfully.');

    }
}
