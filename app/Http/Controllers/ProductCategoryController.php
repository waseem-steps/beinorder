<?php

namespace App\Http\Controllers;

use App\Branch;
use App\ProductCategory;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Table;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar()
    {
        //
        $product_cats = ProductCategory::all();
        return view('product_category.index-ar', ['cats' => $product_cats]);
    }


    public function getRestCats_ar($id)
    {
        //
        $rest = Restaurant::find($id);

        $product_cats = ProductCategory::where('product_categories.rest_id', '=', $id)->get();
        return view('product_category.index-ar', ['cats' => $product_cats, 'rest_id' => $id, 'rest' => $rest]);
    }

    public function getRestCatsTable_ar($id)
    {
        //
        $rest = Restaurant::find($id);

        $product_cats = ProductCategory::where('product_categories.rest_id', '=', $id)->get();
        return view('product_category.index-table-ar', ['cats' => $product_cats, 'rest_id' => $id, 'rest' => $rest]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_ar(Request $request)
    {
        //
        return view('product_category.create-ar', ['request' => $request]);
    }

    public function upload_cat_ar(Request $request)
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

    public function upload_cat_thumbnail_ar(Request $request)
    {
        $folderPath = public_path('images/product_categories/thumbnails/');

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

    public function upload_cat_edit_ar(Request $request)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_ar(Request $request)
    {
        //
        $new_prod_cat = new ProductCategory();
        $new_prod_cat->category_name = $request->cat_name;
        $new_prod_cat->ar_category_name = $request->ar_cat_name;
        $new_prod_cat->img_path = $request->img;
        $new_prod_cat->thumbnail_path = $request->thumb_img;
        $new_prod_cat->rest_id = $request->rest_id;

        $new_prod_cat->save();
        return redirect()->back();
        //return redirect()->route('product-categories.rest-cat',$request->rest_id);
    }

    public static function store_crop_ar(Request $request, $path)
    {

        $new_prod_cat = new ProductCategory();
        $new_prod_cat->category_name = $request->cat_name;
        $new_prod_cat->ar_category_name = $request->ar_cat_name;
        $new_prod_cat->rest_id = $request->rest_id;
        /*  $img = $request->file('img');

        $extension = $img->getClientOriginalExtension();
        Storage::disk('public\product_categories')->put($img->getFilename() . '.' . $extension,  File::get($img));

        $new_prod_cat->img_path = $img->getFilename() . '.' . $extension;
 */
        $new_prod_cat->img_path = $path;
        //$new_prod_cat->save();
        //return redirect()->route('product-categories.rest-cat', $request->rest_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show_ar(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit_ar($id)
    {
        //
        $cat = ProductCategory::find($id);
        return view('product_category.edit-ar', ['cat' => $cat]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, $id)
    {
        $old_prod_cat = ProductCategory::find($id);
        $old_prod_cat->category_name = $request->category_name;
        $old_prod_cat->ar_category_name = $request->ar_category_name;
        $old_prod_cat->img_path = $request->img;
        $old_prod_cat->thumbnail_path = $request->thumb_img;


        $old_prod_cat->save();
        return redirect()->back();
        //return redirect()->route('product-categories.rest-cat', $old_prod_cat->rest_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        $old_prod_cat = ProductCategory::find($id);
        $old_prod_cat->delete();
        return redirect()->back();
        //return redirect()->route('product-categories.rest-cat', $old_prod_cat->rest_id);
    }

    public function branchCategories_ar(Request $request, $id)
    {
        $request->session()->put('ip_branch', $id);
        $rest_id = Branch::select('restaurants.id')->join('restaurants', 'branches.rest_id', '=', 'restaurants.id')->where('branches.id', '=', $id)->groupBy()->first();
        $request->session()->put('rest_id', $rest_id->id);
        $rest = Restaurant::where('restaurants.id', '=', $rest_id->id)->groupBy()->first();
        $branch = Branch::find($id);
        $product_cats = ProductCategory::where('product_categories.rest_id', '=', $rest_id->id)->groupBy()->get();
        if ($branch->status == 0)
            return view('branch.busy-ar');
        return view('product_category.qr-details-ar', ['rest_id' => $rest_id->id, 'branch' => $branch, 'rest' => $rest, 'cats' => $product_cats]);
    }

    public static function tableCategories1_ar(Request $request)
    {

        //echo $request;

        $rest = Restaurant::find($request->rest_id);
        $request->session()->put('rest_id', $request->rest_id);
        $product_cats = ProductCategory::where('product_categories.rest_id', '=', $request->rest_id)->groupBy()->get();
        return view('product_category.qr-table-details-ar', ['rest_id' => $request->rest_id, 'table_id' => $request->table_id, 'rest' => $rest, 'cats' => $product_cats]);
    }

    public function tableCategories_ar(Request $request)
    {
        $table = Table::where('tables.rest_id', '=', $request->rest_id)
            ->where('tables.id', '=', $request->table_id)
            ->where('tables.table_code', '=', $request->table_code)
            ->get();

        if (count($table) > 0) {
            $rest = Restaurant::find($request->rest_id);
            $request->session()->put('rest_id', $request->rest_id);
            $product_cats = ProductCategory::where('product_categories.rest_id', '=', $request->rest_id)->groupBy()->get();
            if ($rest->status == 0)
                return view('restaurant.busy-ar');
            CartController::checkout_table($request);
            return view('product_category.qr-table-details-ar', ['rest_id' => $request->rest_id, 'table_id' => $request->table_id, 'rest' => $rest, 'cats' => $product_cats]);
        } else
            return redirect()->back()->with('status', 'Invalid Table Code... Please Contact Restaurant Admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $product_cats = ProductCategory::all();
        return view('product_category.index', ['cats' => $product_cats]);
    }


    public function getRestCats($id)
    {
        //
        $rest=Restaurant::find($id);

        $product_cats = ProductCategory::where('product_categories.rest_id','=',$id)->get();
        return view('product_category.index', ['cats' => $product_cats,'rest_id'=>$id,'rest'=>$rest]);
    }

    public function getRestCatsTable($id)
    {
        //
        $rest = Restaurant::find($id);

        $product_cats = ProductCategory::where('product_categories.rest_id', '=', $id)->get();
        return view('product_category.index-table', ['cats' => $product_cats, 'rest_id' => $id, 'rest' => $rest]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        return view('product_category.create',['request'=>$request]);
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

    public function upload_cat_thumbnail(Request $request)
    {
        $folderPath = public_path('images/product_categories/thumbnails/');

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $new_prod_cat = new ProductCategory();
        $new_prod_cat->category_name = $request->cat_name;
        $new_prod_cat->ar_category_name = $request->ar_cat_name;
		$new_prod_cat->img_path = $request->img;
		$new_prod_cat->thumbnail_path = $request->thumb_img;
        $new_prod_cat->rest_id = $request->rest_id;
		
        $new_prod_cat->save();
        return redirect()->back();
        //return redirect()->route('product-categories.rest-cat',$request->rest_id);
    }

    public static function store_crop(Request $request,$path) {

        $new_prod_cat = new ProductCategory();
        $new_prod_cat->category_name = $request->cat_name;
        $new_prod_cat->ar_category_name = $request->ar_cat_name;
        $new_prod_cat->rest_id= $request->rest_id;
        /*  $img = $request->file('img');

        $extension = $img->getClientOriginalExtension();
        Storage::disk('public\product_categories')->put($img->getFilename() . '.' . $extension,  File::get($img));

        $new_prod_cat->img_path = $img->getFilename() . '.' . $extension;
 */
        $new_prod_cat->img_path=$path;
        //$new_prod_cat->save();
        //return redirect()->route('product-categories.rest-cat', $request->rest_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cat = ProductCategory::find($id);
        return view('product_category.edit', ['cat' => $cat]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $old_prod_cat=ProductCategory::find($id);
        $old_prod_cat->category_name=$request->category_name;
        $old_prod_cat->ar_category_name = $request->ar_category_name;
        $old_prod_cat->img_path=$request->img;
		$old_prod_cat->thumbnail_path=$request->thumb_img;
		

        $old_prod_cat->save();
        return redirect()->back();
        //return redirect()->route('product-categories.rest-cat', $old_prod_cat->rest_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $old_prod_cat = ProductCategory::find($id);
        $old_prod_cat->delete();
        return redirect()->back();
        //return redirect()->route('product-categories.rest-cat', $old_prod_cat->rest_id);
    }

    public function branchCategories(Request $request, $id)
    {
        $request->session()->put('ip_branch', $id);
        $rest_id = Branch::select('restaurants.id')->join('restaurants', 'branches.rest_id', '=', 'restaurants.id')->where('branches.id', '=', $id)->groupBy()->first();
        $request->session()->put('rest_id', $rest_id->id);
        $rest = Restaurant::where('restaurants.id', '=', $rest_id->id)->groupBy()->first();
        $branch = Branch::find($id);
        $product_cats = ProductCategory::where('product_categories.rest_id', '=', $rest_id->id)->groupBy()->get();
        if ($branch->status == 0)
            return view('branch.busy');
        return view('product_category.qr-details', ['rest_id' => $rest_id->id, 'branch' => $branch, 'rest' => $rest, 'cats' => $product_cats]);

    }

    public static function tableCategories1(Request $request){
		
		//echo $request;

        $rest = Restaurant::find($request->rest_id);
        $request->session()->put('rest_id', $request->rest_id);
        $product_cats = ProductCategory::where('product_categories.rest_id', '=', $request->rest_id)->groupBy()->get();
        return view('product_category.qr-table-details', ['rest_id' => $request->rest_id, 'table_id' => $request->table_id, 'rest' => $rest, 'cats' => $product_cats]);
    }

    public function tableCategories(Request $request){
        $table = Table::where('tables.rest_id', '=', $request->rest_id)
        ->where('tables.id', '=', $request->table_id)
        ->where('tables.table_code', '=', $request->table_code)
        ->get();

        if (count($table) > 0) {
            $rest = Restaurant::find($request->rest_id);
            $request->session()->put('rest_id', $request->rest_id);
            $product_cats = ProductCategory::where('product_categories.rest_id', '=', $request->rest_id)->groupBy()->get();
            if ($rest->status == 0)
                return view('restaurant.busy');
			CartController::checkout_table($request);
			return view('product_category.qr-table-details', ['rest_id' => $request->rest_id, 'table_id' => $request->table_id, 'rest' => $rest, 'cats' => $product_cats]);
        } else
        return redirect()->back()->with('status', 'Invalid Table Code... Please Contact Restaurant Admin');
    }
}
