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
        $announcement = Announcement::orderBy('created_at', 'desc')->first();
        $newID = $announcement->id + 1;
        return view('announcement.index', ['id' => $newID]);
    }

    //datatable purpose
    public function anyData()
    {
        $announcements = Announcement::query();
        return Datatables::of($announcements)
            ->order(function($query){
                $query->orderBy('created_at', 'DESC');
            })
            ->addColumn('action', function($announcement){
                return '<a href="announcement/' . $announcement->id . '/edit" class="action"><i class="material-icons">mode_edit</i></a><a href="announcement/' . $announcement->id . '/delete" class="action"><i class="material-icons">delete</i></a>';
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
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

        return redirect('announcement');
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

        return redirect('announcement');
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
        return redirect('announcement')->with('message', 'Announcement has been deleted succesfully');

    }
}
