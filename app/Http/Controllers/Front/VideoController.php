<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

class VideoController extends Controller
{
    // public function getVideo(Request $request, $id)
    // {
    //     if (!$request->hasValidSignature()) {
    //         abort(401);
    //     }

    //     $media = Media::find($id);
    //     $path = storage_path('app/videos/' . basename($media->path));

    //     if (!file_exists($path)) {
    //         abort(404);
    //     }

    //     return Response::make(file_get_contents($path), 200, [
    //         'Content-Type' => 'video/mp4',
    //         'Content-Disposition' => 'inline; filename="' . basename($media->path) . '"',
    //     ]);
    // }
}
