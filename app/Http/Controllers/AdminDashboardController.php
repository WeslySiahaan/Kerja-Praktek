<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Upcoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // For potential advanced queries if needed

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Data untuk kartu ringkasan
        $totalVideos = Video::count();
        $totalUsers = User::where('role', 'users')->count();
        $totalUpcoming = Upcoming::count();

        $popularVideos = Video::withCount(['likedByUsers', 'collectedByUsers'])
                            ->orderByDesc('liked_by_users_count')
                            ->orHaving('collected_by_users_count', '>', 0) 
                            ->orderByDesc('collected_by_users_count')
                            ->take(12)
                            ->get();

        $videoLabels = $popularVideos->pluck('name')->toArray();
        $likeData = $popularVideos->pluck('liked_by_users_count')->toArray();
        $collectionData = $popularVideos->pluck('collected_by_users_count')->toArray();

        return view('admin.dashboard', [
            'totalVideos' => $totalVideos,
            'totalUsers' => $totalUsers,
            'totalUpcoming' => $totalUpcoming,
            'videoLabels' => $videoLabels,
            'likeData' => $likeData,      
            'collectionData' => $collectionData, 
        ]);
    }
}