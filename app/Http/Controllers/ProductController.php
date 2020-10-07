<?php

namespace App\Http\Controllers;

use App\Product;
use App\Restaurant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function details_ar($id)
    {
        $product = Product::where('products.id', '=', $id)->groupBy()->first();

        return view('product.details-ar', ['product' => $product]);
    }

    public function details_table_ar($id, Request $request)
    {

        $product = Product::where('products.id', '=', $id)->groupBy()->first();
        $rest = Restaurant::find($request->rest_id);

        return view('product.details-table-ar', ['product' => $product, 'rest' => $rest, 'rest_id' => $request->rest_id, 'table_id' => $request->table_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar(Request $request, $id)
    {
        //

        $rest_id = Product::select('product_categories.rest_id')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')
        ->where('product_categories.id', '=', $id)
            ->groupBy('product_categories.rest_id')->get()->first();

        /* $country=CountryController::getCurrency($rest_id[0]->rest_id); */
        $products = Product::where('product_cat_id', '=', $id)->get();

        return view('product.index-ar', ['products' => $products, 'cat_id' => $id, 'rest_id' => $request->rest_id]);
    }

    public function index_table_ar($id, Request $request)
    {
        //

        $rest_id = Product::select('product_categories.rest_id')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')
        ->where('product_categories.id', '=', $id)
            ->groupBy('product_categories.rest_id')->get();
        /* $country=CountryController::getCurrency($rest_id[0]->rest_id); */
        $products = Product::where('product_cat_id', '=', $id)->get();

        return view('product.table-index-ar', ['products' => $products, 'cat_id' => $id, 'rest_id' => $request->rest_id, 'table_id' => $request->table_id]);
    }

    public function all_ar()
    {
        //
        $products = Product::all();
        return view('product.all-ar', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_ar(Request $request)
    {
        //
        return view('product.create-ar', ['request' => $request]);
    }

    public function upload_product_ar(Request $request)
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

    public function upload_product_thumbnail_ar(Request $request)
    {
        $folderPath = public_path('images/products/thumbnails/');

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

    public function upload_product_edit_ar(Request $request)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_ar(Request $request)
    {
        //
        $new_product = new Product();
        $new_product->product_name = $request->product_name;
        $new_product->product_description = $request->product_description;
        $new_product->ar_product_name = $request->ar_product_name;
        $new_product->ar_product_description = $request->ar_product_description;
        $new_product->price = $request->price;
        $new_product->product_cat_id = $request->cat_id;
        $new_product->img_path = $request->img;
        $new_product->thumbnail_path = $request->thumb_img;
        $new_product->save();
        return redirect()->route('products.index-ar', ['id' => $new_product->product_cat_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit_ar($id)
    {
        //
        $product = Product::find($id);
        return view('product.edit-ar', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, $id)
    {
        //
        $product = Product::find($id);
        $product->product_name = $request->product_name;
        $product->product_description = $request->description;
        $product->ar_product_name = $request->ar_product_name;
        $product->ar_product_description = $request->ar_description;
        $product->price = $request->price;
        $product->product_cat_id = $request->cat_id;
        $product->price = $request->price;
        $product->img_path = $request->img;
        $product->thumbnail_path = $request->thumb_img;
        $product->save();
        return redirect()->route('products.index-ar', ['id' => $request->cat_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index-ar', ['id' => $product->product_cat_id]);
    }

    public function unlock_ar($id)
    {
        $product = Product::find($id);
        $product->status = 1;
        $product->save();
        return redirect()->route('products.index-ar', ['id' => $product->product_cat_id]);
    }

    public function lock_ar($id)
    {
        $product = Product::find($id);
        $product->status = 0;
        $product->save();
        return redirect()->route('products.index-ar', ['id' => $product->product_cat_id]);
    }

    public static function getProductName_ar($id)
    {
        return (Product::where('products.id', '=', $id)->get()->first())->ar_product_name;
    }

    public function details($id){
        $product=Product::where('products.id','=',$id)->groupBy()->first();

        return view('product.details',['product'=>$product]);
    }

    public function details_table($id ,Request $request)
    {

        $product = Product::where('products.id', '=', $id)->groupBy()->first();
		$rest = Restaurant::find($request->rest_id);

        return view('product.details-table', ['product' => $product, 'rest' => $rest, 'rest_id' => $request->rest_id, 'table_id'=>$request->table_id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
        //

         $rest_id = Product::select('product_categories.rest_id')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')
            ->where('product_categories.id', '=', $id)
            ->groupBy('product_categories.rest_id')->get()->first();

        /* $country=CountryController::getCurrency($rest_id[0]->rest_id); */
        $products = Product::where('product_cat_id', '=', $id)->get();

        return view('product.index', ['products' => $products, 'cat_id' => $id,'rest_id'=> $request->rest_id]);
    }

    public function index_table($id, Request $request)
    {
        //

        $rest_id = Product::select('product_categories.rest_id')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')
        ->where('product_categories.id', '=', $id)
        ->groupBy('product_categories.rest_id')->get();
        /* $country=CountryController::getCurrency($rest_id[0]->rest_id); */
        $products = Product::where('product_cat_id', '=', $id)->get();

        return view('product.table-index', ['products' => $products, 'cat_id' => $id,'rest_id'=>$request->rest_id,'table_id'=>$request->table_id]);
    }

    public function all()
    {
        //
        $products = Product::all();
        return view('product.all', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        return view('product.create',['request'=>$request]);
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

    public function upload_product_thumbnail(Request $request)
    {
        $folderPath = public_path('images/products/thumbnails/');

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $new_product=new Product();
        $new_product->product_name=$request->product_name;
        $new_product->product_description = $request->product_description;
        $new_product->ar_product_name = $request->ar_product_name;
        $new_product->ar_product_description = $request->ar_product_description;
        $new_product->price = $request->price;
        $new_product->product_cat_id = $request->cat_id;
		$new_product->img_path=$request->img;
		$new_product->thumbnail_path=$request->thumb_img;
        $new_product->save();
        return redirect()->route('products.index', ['id' => $new_product->product_cat_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::find($id);
        return view('product.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $product = Product::find($id);
        $product->product_name = $request->product_name;
        $product->product_description = $request->description;
        $product->ar_product_name = $request->ar_product_name;
        $product->ar_product_description = $request->ar_description;
        $product->price = $request->price;
        $product->product_cat_id = $request->cat_id;
        $product->price=$request->price;
		$product->img_path=$request->img;
		$product->thumbnail_path=$request->thumb_img;
        $product->save();
        return redirect()->route('products.index', ['id' => $request->cat_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $product=Product::find($id);
        $product->delete();
        return redirect()->route('products.index', ['id' => $product->product_cat_id]);
    }

    public function unlock($id)
    {
        $product = Product::find($id);
        $product->status = 1;
        $product->save();
        return redirect()->route('products.index',['id'=>$product->product_cat_id]);
    }

    public function lock($id)
    {
        $product = Product::find($id);
        $product->status = 0;
        $product->save();
        return redirect()->route('products.index', ['id' => $product->product_cat_id]);
    }

    public static function getProductName($id){
        return (Product::where('products.id','=',$id)->get()->first())->product_name;

    }
}
