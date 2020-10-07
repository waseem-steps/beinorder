<?php

namespace App\Http\Controllers;

use App\ProductCategory;

use App\Restaurant;
use App\Country;
use App\Product;
use App\Branch;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class ImageCropperController extends Controller
{

    public function index()
    {
        return view('cropper');
    }

    public function upload(Request $request)
    {
        $folderPath = public_path('images/product_categories/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id=uniqid() ;
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);

    }

    public function upload_rest(Request $request)
    {
		//dd($request);
        $folderPath = public_path('images/restaurants/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id = uniqid();
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);
    }

    public function upload_rest_edit(Request $request)
    {
        $folderPath = public_path('images/restaurants/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id = uniqid();
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);
    }

    public function upload_cat(Request $request)
    {
        $folderPath = public_path('images/product_categories/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id = uniqid();
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);
    }

    public function upload_cat_edit(Request $request)
    {
        $folderPath = public_path('images/product_categories/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id = uniqid();
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);
    }

    public function upload_product(Request $request)
    {
        $folderPath = public_path('images/products/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id = uniqid();
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);
    }

    public function upload_product_edit(Request $request)
    {
        $folderPath = public_path('images/products/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id = uniqid();
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);
    }

    public function upload_subscriber(Request $request)
    {
        $folderPath = public_path('images/restaurants/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $id = uniqid();
        $file = $folderPath . $id . '.tmp.jpg';

        file_put_contents($file, $image_base64);

        /*  return response()->json(['success' => 'success']); */
        return response()->json(['success' => $id . '.tmp.jpg']);
    }
}
