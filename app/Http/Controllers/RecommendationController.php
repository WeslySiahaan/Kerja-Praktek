<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    public function index(): View
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat rekomendasi.');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Debugging
        \Log::info('User loaded: ' . $user->id);
        \Log::info('Liked Videos count: ' . $user->likedVideos()->count());
        \Log::info('Watch Histories count: ' . $user->watchHistories()->count());
        \Log::info('Watch Histories video_ids: ' . $user->watchHistories()->pluck('video_id')->toJson());

        $likedVideos = $user->likedVideos()->with('likedByUsers')->get();
        $watchHistories = $user->watchHistories()->with('video')->get();

        if ($likedVideos->isEmpty() && $watchHistories->isEmpty()) {
            $recommendedVideos = Video::where('is_popular', true)
                ->orderBy('rating', 'desc')
                ->take(10)
                ->get();
        } else {
            $excludedVideoIds = $likedVideos->pluck('id')
                ->merge($watchHistories->pluck('video_id')->filter()->map(function ($id) {
                    return (int)$id;
                }))
                ->unique()
                ->values()
                ->all();

            $watchedPreferences = $watchHistories->filter(function ($history) {
                return $history->video_id && is_numeric($history->video_id) && Video::where('id', $history->video_id)->exists();
            })->mapWithKeys(function ($history) {
                $weight = $history->progress > 50 ? 2 : 1;
                return [(int)$history->video_id => $weight];
            });

            $recommendedVideos = Video::query()
                ->whereNotIn('id', array_filter($excludedVideoIds))
                ->when(!empty($watchedPreferences), function ($query) use ($watchedPreferences) {
                    $videoIds = array_keys($watchedPreferences->toArray());
                    return $query->orderByRaw("FIELD(id, " . implode(',', array_map('intval', $videoIds)) . ") DESC");
                }, function ($query) {
                    return $query; 
                })
                ->orderBy('rating', 'desc')
                ->take(10)
                ->get();

            // Jika kurang dari 5, isi dengan video populer lainnya
            if ($recommendedVideos->count() < 5) {
                $additionalVideos = Video::where('is_popular', true)
                    ->whereNotIn('id', array_filter($excludedVideoIds))
                    ->orderBy('rating', 'desc')
                    ->take(10 - $recommendedVideos->count())
                    ->get();
                $recommendedVideos = $recommendedVideos->merge($additionalVideos)->unique('id')->take(5);
            }
        }

        return view('users.rekomendasi', compact('recommendedVideos'));
    }
}