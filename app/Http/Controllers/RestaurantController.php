<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Country;
use App\Product;
use App\Branch;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;


class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar()
    {
        //
        $all_rest = Restaurant::all();
        $all_countries = Country::all();
        return view('restaurant.index-ar', ["rests" => $all_rest, "countries" => $all_countries]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_ar()
    {
        //
        $all_countries = Country::all();
        return view('restaurant.create-ar', ["countries" => $all_countries]);
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
        $new_rest = new Restaurant();
        $new_rest->rest_name = $request->rest_name;
        $new_rest->description = $request->description;
        $new_rest->ar_rest_name = $request->ar_rest_name;
        $new_rest->ar_description = $request->ar_description;
        $new_rest->country_id = $request->country;

        /* $logo = $request->file('logo');
        $extension = $logo->getClientOriginalExtension();
        Storage::disk('public\restaurants')->put($logo->getFilename() . '.' . $extension,  File::get($logo));

        $new_rest->logo = $logo->getFilename() . '.' . $extension; */

        $new_rest->logo = $request->logo;
        $new_rest->save();
        return redirect()->route('restaurants.active-ar');
    }

    public function upload_rest_ar(Request $request)
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

    public function upload_rest_thumbnail_ar(Request $request)
    {
        $folderPath = public_path('images/restaurants/thumbnails/');

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

    public function upload_rest_edit_ar(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit_ar($id)
    {
        $rest = Restaurant::find($id);
        $all_countries = Country::whereNotIn('id', [$rest->country->id])->get();
        return view('restaurant.edit-ar', ['rest' => $rest, 'countries' => $all_countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, $id)
    {
        $old_rest = Restaurant::find($id);
        $old_rest->rest_name = $request->rest_name;
        $old_rest->description = $request->description;
        $old_rest->country_id = $request->country;
        $old_rest->ar_rest_name = $request->ar_rest_name;
        $old_rest->ar_description = $request->ar_description;
        $old_rest->logo = $request->logo;
        $old_rest->thumbnail_logo = $request->thumbnail_logo;
        $old_rest->save();
        return redirect()->route('restaurants.active-ar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        //
        $rest = Restaurant::find($id);
        $rest->delete();
        $branches = Branch::where('branches.rest_id', '=', $id)->get();
        foreach ($branches as $branch) {
            $b = Branch::find($branch->id);
            $b->delete();
        }

        $users = User::where('users.rest_id', '=', $id)->get();
        foreach ($users as $user) {
            $b = User::find($user->id);
            $b->delete();
        }
        return redirect()->route('restaurants.active-ar');
    }

    public function unlock_ar($id)
    {
        $rest = Restaurant::find($id);
        $rest->status = 1;
        $rest->save();
        return redirect()->route('restaurants.active-ar');
    }

    public function lock_ar($id)
    {
        $rest = Restaurant::find($id);
        $rest->status = 0;
        $rest->save();
        return redirect()->route('restaurants.active-ar');
    }

    public function details_ar($id)
    {
        $rest = Restaurant::find($id);
        $products = Product::where('rest_id', $id)->get();
        $sizes = Product::select('product_sizes.id', 'product_sizes.ar_size_name', 'product_sizes.price', 'product_sizes.product_id')->join('product_sizes', 'products.id', '=', 'product_sizes.product_id')->where('products.rest_id', $id)->get();
        $prod_types = Product::select('product_types.ar_type_name')->join('product_types', 'products.product_type_id', '=', 'product_types.id')->where('rest_id', $id)->groupBy('product_types.ar_type_name')->get();
        $prod_cats = Product::select('product_categories.ar_category_name')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')->where('rest_id', $id)->groupBy('product_categories.ar_category_name')->get();
        return view('restaurant.details-ar', ['rest' => $rest, 'products' => $products, 'prod_types' => $prod_types, 'prod_cats' => $prod_cats, 'sizes' => $sizes]);
    }

    public function generateQrExternal_ar($rest_id, $table_id)
    {
        /* $rest_url = Route('table.table_code', ['rest_id'=> $rest_id,'table_id'=>$table_id]);
        $qr = \QrCode::size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);
        return view('restaurant.qrcode', ['qr' => $qr]); */

        //$rest_url = Route('table.table_code', ['rest_id' => $rest_id, 'table_id' => $table_id]);
        $rest_url = Route('table.product-categories-cart-ar', ['rest_id' => $rest_id, 'table_id' => $table_id]);

        $qr = \QrCode::size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);

        $image = \QrCode::format('png')

        ->size(500)->errorCorrection('H')
        ->generate($rest_url);
        return response($image)->header('Content-type', 'image/png');


        return view('restaurant.qrcode-ar', ['qr' => $qr]);
    }


    public function getActive_ar(Request $request)
    {

        CartController::destroy($request);
        $role = $request->session()->get('user_role');
        $all_rest = Restaurant::where('status', 1)->get();
        $all_countries = Country::all();

        if ($role == 'Administrator') {
            $all_rest =
                Restaurant::all();
            return view('restaurant.restaurants-ar', ["rests" => $all_rest, "countries" => $all_countries]);
        }
        if ($role == 'Restaurant Admin') {
            $id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $id)->groupBy()->first();
            $all_rest = Restaurant::where('status', 1)->where('restaurants.id', '=', $rest_id->rest_id)->get();
            return view('restaurant.restaurants-ar', ["rests" => $all_rest, "countries" => $all_countries]);
        } else {
            $all_rest = Restaurant::where('status', 1)->get();
            return view('restaurant.restaurants-ar', ["rests" => $all_rest, "countries" => $all_countries]);
        }
        $request->session()->forget('ip_branch');
        $request->session()->forget('rest_id');

        return view('restaurants.active-ar', ["rests" => $all_rest, "countries" => $all_countries]);
    }

    public function getActiveByName_ar(Request $request)
    {
        CartController::destroy($request);
        $role = $request->session()->get('user_role');
        $all_rest = Restaurant::where('status', 1)->get();
        $all_countries = Country::all();

        if ($role == 'Administrator') {
            $all_rest =
                Restaurant::all();
            return view('restaurant.restaurants-ar', ["rests" => $all_rest, "countries" => $all_countries]);
        }
        if ($role == 'Restaurant Admin') {
            $id = auth()->user()->id;

            $rest_id = User::select('rest_id')->where('users.id', '=', $id)->groupBy()->first();

            $all_rest = Restaurant::where('status', 1)->where('restaurants.id', '=', $rest_id->rest_id)->get();
            return view('restaurant.restaurants-ar', ["rests" => $all_rest, "countries" => $all_countries]);
        } else {
            $all_rest = Restaurant::where('status', 1)->where('rest_name', 'like', '%' . $request->rest_name . '%')->get();
            return view('restaurant.restaurants-ar', ["rests" => $all_rest, "countries" => $all_countries]);
        }

        return view('restaurants.active-ar', ["rests" => $all_rest, "countries" => $all_countries]);
    }

    public function test_ar(Request $request)
    {
        $request->session()->flush();
    }

    public function crop_ar(Request $request)
    {
        dd($request);
        //return view('restaurant.crop');
    }

    public function dummy_ar()
    {


        if (auth()->user()) {
            $role_name =  RoleController::getUserRole(auth()->user()->id);
            $rest_id = (User::find(auth()->user()->id))->rest_id;
            $plan_type = Subscription::join('price_plans', 'subscriptions.price_plan_id', '=', 'price_plans.id')
            ->where('subscriptions.rest_id', '=', $rest_id)
                ->where('subscriptions.status', '=', 1)
                ->get()->first();
            session(['user_role' => $role_name]);
            session(['rest_id' => $rest_id]);

            if (session()->get('user_role') == "Branch Admin")
            return redirect()->route('orders.index-ar');
            else if (session()->get('user_role') == "Restaurant Admin" && $plan_type->plan_type == 1) {
                return redirect()->route('table.index-ar', ['id' => $rest_id]);
            } else if (session()->get('user_role') == "Restaurant Admin" && $plan_type->plan_type == 0) {
                return redirect()->route('orders.index-ar');
            }
        }
        return redirect()->route('welcome-ar');
    }

    public function getAdmins_ar($id)
    {
        $users = User::where('users.branch_id', '=', $id)->get();

        return view('branch.admins-ar', ['admins' => $users]);
    }

    public function change_admin_settings_ar($id)
    {
        $rest = Restaurant::find($id);
        //$rest->status = 0;
        //$rest->save();
        //echo $rest;
        return view('restaurant.admin_settings-ar', ['settings' => $rest]);
    }

    public function enable_place_order_ar($id)
    {
        $rest = Restaurant::find($id);
        $rest->place_order_status = 1;
        $rest->save();
        return redirect()->back();
    }

    public function disable_place_order_ar($id)
    {
        $rest = Restaurant::find($id);
        $rest->place_order_status = 0;
        $rest->save();
        return redirect()->back();
    }

    public function enable_table_code_ar($id)
    {
        $rest = Restaurant::find($id);
        $rest->table_code_status = 1;
        $rest->save();
        return redirect()->back();
    }

    public function disable_table_code_ar($id)
    {
        $rest = Restaurant::find($id);
        $rest->table_code_status = 0;
        $rest->save();
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all_rest = Restaurant::all();
        $all_countries = Country::all();
        return view('restaurant.index', ["rests" => $all_rest, "countries" => $all_countries]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $all_countries = Country::all();
        return view('restaurant.create', [ "countries" => $all_countries]);
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
        $new_rest = new Restaurant();
        $new_rest->rest_name = $request->rest_name;
        $new_rest->description = $request->description;
        $new_rest->ar_rest_name = $request->ar_rest_name;
        $new_rest->ar_description = $request->ar_description;
        $new_rest->country_id = $request->country;
        
        /* $logo = $request->file('logo');
        $extension = $logo->getClientOriginalExtension();
        Storage::disk('public\restaurants')->put($logo->getFilename() . '.' . $extension,  File::get($logo));

        $new_rest->logo = $logo->getFilename() . '.' . $extension; */
        
        $new_rest->logo=$request->logo;
        $new_rest->save();
        return redirect()->route('restaurants.active');
    }
    
    public function upload_rest(Request $request)
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

    public function upload_rest_thumbnail(Request $request)
    {
        $folderPath = public_path('images/restaurants/thumbnails/');

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rest = Restaurant::find($id);
        $all_countries = Country::whereNotIn('id', [$rest->country->id])->get();
        return view('restaurant.edit', ['rest' => $rest, 'countries' => $all_countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $old_rest = Restaurant::find($id);
        $old_rest->rest_name = $request->rest_name;
        $old_rest->description = $request->description;
        $old_rest->country_id = $request->country;
        $old_rest->ar_rest_name = $request->ar_rest_name;
        $old_rest->ar_description = $request->ar_description;
        $old_rest->logo=$request->logo;
        $old_rest->thumbnail_logo=$request->thumbnail_logo;
        $old_rest->save();
        return redirect()->route('restaurants.active');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $rest = Restaurant::find($id);
        $rest->delete();
        $branches=Branch::where('branches.rest_id','=',$id)->get();
        foreach($branches as $branch){
            $b=Branch::find($branch->id);
            $b->delete();
        }

        $users = User::where('users.rest_id', '=', $id)->get();
        foreach ($users as $user) {
            $b = User::find($user->id);
            $b->delete();
        }
        return redirect()->route('restaurants.active');
    }

    public function unlock($id)
    {
        $rest = Restaurant::find($id);
        $rest->status = 1;
        $rest->save();
        return redirect()->route('restaurants.active');
    }

    public function lock($id)
    {
        $rest = Restaurant::find($id);
        $rest->status = 0;
        $rest->save();
        return redirect()->route('restaurants.active');
    }

    public function details($id)
    {
        $rest = Restaurant::find($id);
        $products = Product::where('rest_id', $id)->get();
        $sizes = Product::select('product_sizes.id', 'product_sizes.size_name', 'product_sizes.price', 'product_sizes.product_id')->join('product_sizes', 'products.id', '=', 'product_sizes.product_id')->where('products.rest_id', $id)->get();
        $prod_types = Product::select('product_types.type_name')->join('product_types', 'products.product_type_id', '=', 'product_types.id')->where('rest_id', $id)->groupBy('product_types.type_name')->get();
        $prod_cats = Product::select('product_categories.category_name')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')->where('rest_id', $id)->groupBy('product_categories.category_name')->get();
        return view('restaurant.details', ['rest' => $rest, 'products' => $products, 'prod_types' => $prod_types, 'prod_cats' => $prod_cats, 'sizes' => $sizes]);
    }

    public function generateQrExternal($rest_id,$table_id)
    {
        /* $rest_url = Route('table.table_code', ['rest_id'=> $rest_id,'table_id'=>$table_id]);
        $qr = \QrCode::size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);
        return view('restaurant.qrcode', ['qr' => $qr]); */

        //$rest_url = Route('table.table_code', ['rest_id' => $rest_id, 'table_id' => $table_id]);
		$rest_url = Route('table.product-categories-cart', ['rest_id' => $rest_id, 'table_id' => $table_id]);
		
        $qr = \QrCode::size(250)
        ->backgroundColor(255, 255, 204)
        ->generate($rest_url);

        $image = \QrCode::format('png')

            ->size(500)->errorCorrection('H')
            ->generate($rest_url);
        return response($image)->header('Content-type', 'image/png');


        return view('restaurant.qrcode', ['qr' => $qr]);
    }

    public function getActive(Request $request)
    {

        CartController::destroy($request);
        $role = $request->session()->get('user_role');
        $all_rest = Restaurant::where('status', 1)->get();
        $all_countries = Country::all();

        if ($role == 'Administrator') {
            $all_rest =
                Restaurant::all();
            return view('restaurant.restaurants', ["rests" => $all_rest, "countries" => $all_countries]);
        }
        if ($role == 'Restaurant Admin') {
            $id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $id)->groupBy()->first();
            $all_rest = Restaurant::where('status', 1)->where('restaurants.id', '=', $rest_id->rest_id)->get();
            return view('restaurant.restaurants', ["rests" => $all_rest, "countries" => $all_countries]);
        } else {
            $all_rest = Restaurant::where('status', 1)->get();
            return view('restaurant.restaurants', ["rests" => $all_rest, "countries" => $all_countries]);
        }
        $request->session()->forget('ip_branch');
        $request->session()->forget('rest_id');
        return view('restaurants.active', ["rests" => $all_rest, "countries" => $all_countries]);
    }

    
    public function getActiveByName(Request $request)
    {
        CartController::destroy($request);
        $role = $request->session()->get('user_role');
        $all_rest = Restaurant::where('status', 1)->get();
        $all_countries = Country::all();

        if ($role == 'Administrator') {
            $all_rest =
                Restaurant::all();
            return view('restaurant.restaurants', ["rests" => $all_rest, "countries" => $all_countries]);
        }
        if ($role == 'Restaurant Admin') {
            $id = auth()->user()->id;

            $rest_id = User::select('rest_id')->where('users.id', '=', $id)->groupBy()->first();

            $all_rest = Restaurant::where('status', 1)->where('restaurants.id', '=', $rest_id->rest_id)->get();
            return view('restaurant.restaurants', ["rests" => $all_rest, "countries" => $all_countries]);
        } else {
            $all_rest = Restaurant::where('status', 1)->where('rest_name', 'like', '%' . $request->rest_name . '%')->get();
            return view('restaurant.restaurants', ["rests" => $all_rest, "countries" => $all_countries]);
        }

        return view('restaurants.active', ["rests" => $all_rest, "countries" => $all_countries]);
    }

    public function test(Request $request)
    {
        $request->session()->flush();
    }

    public function crop(Request $request){
        dd($request);
        //return view('restaurant.crop');
    }

    public function dummy()
    {


        if (auth()->user()) {
            $role_name =  RoleController::getUserRole(auth()->user()->id);
            $rest_id=(User::find(auth()->user()->id))->rest_id;
            $plan_type=Subscription::join('price_plans','subscriptions.price_plan_id','=','price_plans.id')
            ->where('subscriptions.rest_id','=',$rest_id)
            ->where('subscriptions.status','=',1)
            ->get()->first();
            session(['user_role' => $role_name]);
            session(['rest_id' => $rest_id]);

            if (session()->get('user_role') == "Branch Admin")
                return redirect()->route('orders.index');
            else if (session()->get('user_role') == "Restaurant Admin" && $plan_type->plan_type==1){
                return redirect()->route('table.index',['id'=>$rest_id]);
                }
            else if(session()->get('user_role') == "Restaurant Admin" && $plan_type->plan_type==0){
                return redirect()->route('orders.index');
            }
        }
        return redirect()->route('welcome');

    }

    public function getAdmins($id){
        $users=User::where('users.branch_id','=',$id)->get();

        return view('branch.admins',['admins'=>$users]);
    }
	
	public function change_admin_settings($id)
    {
        $rest = Restaurant::find($id);
        //$rest->status = 0;
        //$rest->save();
		//echo $rest;
        return view('restaurant.admin_settings',['settings'=>$rest]);
    }
	
	public function enable_place_order($id)
    {
        $rest = Restaurant::find($id);
        $rest->place_order_status = 1;
        $rest->save();
        return redirect()->back();
    }
	
	public function disable_place_order($id)
    {
        $rest = Restaurant::find($id);
        $rest->place_order_status = 0;
        $rest->save();
        return redirect()->back();
    }
	
	public function enable_table_code($id)
    {
        $rest = Restaurant::find($id);
        $rest->table_code_status = 1;
        $rest->save();
        return redirect()->back();
    }
	
	public function disable_table_code($id)
    {
        $rest = Restaurant::find($id);
        $rest->table_code_status = 0;
        $rest->save();
        return redirect()->back();
    }
}
