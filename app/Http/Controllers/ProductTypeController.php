<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product_types=ProductType::all();
        return view('product_type.index',['types'=>$product_types]);
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
        $prod_type=new ProductType();
        $prod_type->type_name=$request->type_name;
        $img = $request->file('img');

        $extension = $img->getClientOriginalExtension();
        Storage::disk('public\product_types')->put($img->getFilename() . '.' . $extension,  File::get($img));

        $prod_type->img_path = $img->getFilename() . '.' . $extension;

        $prod_type->save();
        return redirect()->route('product-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductType $productType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $old_prod_type=ProductType::find($id);
        $old_prod_type->type_name=$request->type_name;
        $old_prod_type->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $old_prod_type = ProductType::find($id);
        $old_prod_type->delete();
    }
}
