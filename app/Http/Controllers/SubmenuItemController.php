<?php

namespace App\Http\Controllers;

use App\SubmenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SubmenuItemController extends Controller
{
    public static function getItemValueByItem_ar($itm_name, $product_id)
    {

        $item_exits = SubmenuItem::select(
            'submenu_items.price',
            'submenu_items.id',
            DB::raw('submenus.id submenu_id')
        )->join('submenus', 'submenu_items.submenu_id', '=', 'submenus.id')
            ->where('submenu_items.id', '=', $itm_name)
            ->where('submenus.product_id', '=', $product_id)
            ->get();
        return $item_exits;
    }

    public static function getItems_ar($id)
    {
        $items = SubmenuItem::where('submenu_items.submenu_id', '=', $id)->get();
        return $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar()
    {
        //

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
        $item = new SubmenuItem();
        $item->item_name = $request->item_name;
        $item->ar_item_name = $request->ar_item_name;
        $item->price = $request->price;
        $item->submenu_id = $request->menu_id;
        $item->save();
        return redirect()->route('product.details-ar', ['id' => $request->product_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function show_ar(SubmenuItem $submenuItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(SubmenuItem $submenuItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, SubmenuItem $submenuItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        //
        $item = SubmenuItem::find($id);
        $item->delete();
        return redirect()->back();
    }

    public static function getItemValueByItem($itm_name,$product_id){

        $item_exits=SubmenuItem::select('submenu_items.price',
            'submenu_items.id',DB::raw('submenus.id submenu_id'))->
        join('submenus','submenu_items.submenu_id','=','submenus.id')
        ->where('submenu_items.id','=',$itm_name)
        ->where('submenus.product_id','=',$product_id)
        ->get();
        return $item_exits;
    }

    public static function getItems($id){
        $items= SubmenuItem::where('submenu_items.submenu_id','=',$id)->get();
        return $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
        $item=new SubmenuItem();
        $item->item_name=$request->item_name;
        $item->ar_item_name=$request->ar_item_name;
        $item->price=$request->price;
        $item->submenu_id=$request->menu_id;
        $item->save();
        return redirect()->route('product.details',['id'=>$request->product_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function show(SubmenuItem $submenuItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SubmenuItem $submenuItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubmenuItem $submenuItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubmenuItem  $submenuItem
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $item=SubmenuItem::find($id);
        $item->delete();
        return redirect()->back();
    }
}
