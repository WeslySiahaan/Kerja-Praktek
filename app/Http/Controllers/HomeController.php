<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Upcoming;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function index1()
    {
        return view('users.dashboard');
    }

    public function index3()
    {
        $videos = Video::latest()->take(6)->get(); // Fetch latest 6 videos for "Video Terbaru"
        return view('welcome', compact('videos'));
    }

    public function index4()
    {
        $upcomings = Upcoming::all(); // Fetch all upcoming releases for "Up Coming"
        $videos = Video::latest()->take(6)->get(); // Fetch latest 6 videos for "Video Terbaru"
        return view('welcome', compact('upcomings', 'videos'));
    }
}