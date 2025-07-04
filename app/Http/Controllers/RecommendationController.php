<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    public function index(): View
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat rekomendasi.');
        }

        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Debugging
        Log::info('User loaded: ' . $user->id);
        Log::info('Liked Videos count: ' . $user->likedVideos()->count());

        // Ambil video yang disukai
        $likedVideos = $user->likedVideos()->get();

        // Kumpulkan kategori dari video yang disukai
        $likedCategories = $likedVideos->flatMap(function ($video) {
            $category = $video->category;
            if (is_string($category)) {
                $category = json_decode($category, true) ?? [$category];
            }
            return is_array($category) ? array_map('trim', $category) : [];
        })->unique()->filter()->values()->all();

        // Kumpulkan ID video yang sudah disukai untuk dikecualikan
        $excludedVideoIds = $likedVideos->pluck('id')->values()->all();

        // Logika rekomendasi
        if ($likedVideos->isEmpty()) {
            // Jika tidak ada video yang disukai, rekomendasi video populer
            $recommendedVideos = Video::where('is_popular', true)
                ->orderBy('rating', 'desc')
                ->paginate(12);
        } else {
            $query = Video::query()
                ->whereNotIn('id', array_filter($excludedVideoIds));

            // Prioritaskan video dengan kategori yang sama
            if (!empty($likedCategories)) {
                $query->where(function ($q) use ($likedCategories) {
                    foreach ($likedCategories as $category) {
                        $q->orWhereJsonContains('category', $category)
                          ->orWhere('category', 'like', '%' . $category . '%');
                    }
                });
            }

            $recommendedVideos = $query
                ->orderBy('rating', 'desc')
                ->paginate(12);

            // Jika kurang dari 6 video di halaman pertama, tambahkan video populer
            if ($recommendedVideos->count() < 6 && $recommendedVideos->currentPage() === 1) {
                $additionalVideos = Video::where('is_popular', true)
                    ->whereNotIn('id', array_filter($excludedVideoIds))
                    ->when(!empty($likedCategories), function ($q) use ($likedCategories) {
                        $q->where(function ($q) use ($likedCategories) {
                            foreach ($likedCategories as $category) {
                                $q->orWhereJsonContains('category', $category)
                                  ->orWhere('category', 'like', '%' . $category . '%');
                            }
                        });
                    })
                    ->orderBy('rating', 'desc')
                    ->take(12 - $recommendedVideos->count())
                    ->get();
                $recommendedVideos->getCollection()->merge($additionalVideos)->unique('id')->take(12);
            }
        }

        return view('users.rekomendasi', compact('recommendedVideos'));
    }
}