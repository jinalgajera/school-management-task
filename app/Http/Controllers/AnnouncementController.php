<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Jobs\SendAnnouncementEmails;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Announcement::with('user')->latest();

            if (auth()->user()->role === 'teacher') {
                $data->where('user_id', auth()->id()); // Only their own announcements
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('user', fn($row) => $row->user->name)             
                ->make(true);
        }
        return view('admin.announcement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $announcement = Announcement::create([
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'message' => $request->message,
            'target'  => $request->target
        ]);

        // Dispatch Job
        if($request->target != 'teachers'){
            SendAnnouncementEmails::dispatch($announcement);
        }

        return redirect()->route('announcements.index')->with('success', 'Announcement posted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
