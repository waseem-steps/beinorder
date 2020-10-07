<?php

namespace App\Http\Controllers;

use App\Submenu;
use App\Product;
use Illuminate\Http\Request;

class SubmenuController extends Controller
{

    public static function getSubmenu_ar($product_id)
    {
        return count(Submenu::where('submenus.product_id', '=', $product_id)->get());
    }

    public static function getSubmenus_ar($product_id)
    {
        return Submenu::where('submenus.product_id', '=', $product_id)->get();
    }

    public static function getSubmenuType_ar($id)
    {
        $submenu = Submenu::find($id);
        return $submenu->submenu_type;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar($id)
    {
        //
        $menus = Submenu::where('submenus.product_id', '=', $id)->orderBy('submenus.submenu_type')->get();
        $product = Product::find($id);
        return view('product.details-ar', ['id' => $id, 'product' => $product, 'menus' => $menus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_ar()
    {
        //
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
        $menu = new Submenu();
        $menu->submenu_name = $request->menu_name;
        $menu->ar_submenu_name = $request->ar_menu_name;
        $menu->product_id = $request->product_id;
        $menu->submenu_type = $request->menu_type;
        $menu->product_id = $request->product_id;
        $menu->save();

        return redirect()->route('product.details-ar', ['id' => $request->product_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Submenu $submenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(Submenu $submenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, Submenu $submenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        //
        $item = Submenu::find($id);
        $item->delete();
        return redirect()->back();
    }

    public static function getSubmenu($product_id)
    {
        return count(Submenu::where('submenus.product_id', '=', $product_id)->get());
    }

    public static function getSubmenus($product_id)
    {
        return Submenu::where('submenus.product_id', '=', $product_id)->get();
    }

    public static function getSubmenuType($id)
    {
        $submenu = Submenu::find($id);
        return $submenu->submenu_type;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $menus = Submenu::where('submenus.product_id', '=', $id)->orderBy('submenus.submenu_type')->get();
        $product = Product::find($id);
        return view('product.details', ['id' => $id, 'product' => $product, 'menus' => $menus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $menu=new Submenu();
        $menu->submenu_name=$request->menu_name;
        $menu->ar_submenu_name = $request->ar_menu_name;
        $menu->product_id=$request->product_id;
        $menu->submenu_type=$request->menu_type;
        $menu->product_id=$request->product_id;
        $menu->save();

        return redirect()->route('product.details',['id'=>$request->product_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function show(Submenu $submenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function edit(Submenu $submenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submenu $submenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $item = Submenu::find($id);
        $item->delete();
        return redirect()->back();
    }
}
