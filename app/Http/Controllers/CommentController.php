<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Video $video)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $video->id,
            'content' => $request->content,
        ]);

        return redirect()->route('videos.show', $video->id)->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit komentar ini.');
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('videos.show', $comment->video_id)->with('success', 'Komentar berhasil diedit.');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $videoId = $comment->video_id; // Simpan video_id sebelum menghapus
        $comment->delete();

        // Jika request adalah AJAX, kembalikan JSON
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Komentar berhasil dihapus.', 'video_id' => $videoId]);
        }

        // Jika non-AJAX, redirect
        return redirect()->route('videos.show', $videoId)->with('success', 'Komentar berhasil dihapus.');
    }
}