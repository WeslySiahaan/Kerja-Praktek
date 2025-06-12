<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Video;
use App\Models\Upcoming;
use App\Models\Popular;

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

    public function index4()
    {
        $upcomings = Upcoming::all(); // Fetch all upcoming releases for "Up Coming"
        $videos = Video::latest()->take(6)->get(); // Fetch latest 6 videos for "Video Terbaru"
        $populars = Popular::all();
        return view('welcome', compact('upcomings', 'videos', 'populars'));
    }

    public function detail($id): View
    {
      $videos = Video::findOrFail($id);
      return view('dramabox.detail', compact('videos'));
    }
    
    
}