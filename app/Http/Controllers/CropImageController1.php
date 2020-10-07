<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageCropperController extends Controller
{
    //
   public function index()
    {
      return view('croppie');
    }

    public function uploadCropImage(Request $request)
    {
        $images = $request->image;

        list($type, $images) = explode(';', $images);
        list(, $images)      = explode(',', $image);
        $images = base64_decode($images);
        $image_name= time().'.png';
        $path = public_path('upload/'.$image_name);

        file_put_contents($path, $images);
        return response()->json(['status'=>true]);
    }
}
