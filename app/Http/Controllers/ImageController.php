<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function showProfileImage($filename)
    {
        // Tentukan path lengkap ke file di dalam folder storage
        $path = 'profiles/' . $filename;

        // Cek apakah file tersebut benar-benar ada di disk 'public'
        if (!Storage::disk('public')->exists($path)) {
            // Jika tidak ada, kembalikan error 404
            abort(404, 'Image not found.');
        }

        // Ambil file dari storage
        $file = Storage::disk('public')->get($path);


        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->buffer($file);
 
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
