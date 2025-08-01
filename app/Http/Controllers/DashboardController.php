<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch only announcements targeted to teachers
        $announcements = Announcement::where('target', 'teachers')
            ->latest()
            ->with('user') // load the admin who posted
            ->get();

        return view('dashboard', compact('announcements'));
    }
}
