<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request){

        // Set file upload to public
        $imagePath = Storage::disk('public')->put('images', request()->file('image'));
        $imageUrl = Storage::disk('public')->url($imagePath);
        return json_encode([
            'location' => $imageUrl
        ]);
    }
}
