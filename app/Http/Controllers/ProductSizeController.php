<?php

namespace App\Http\Controllers;

use App\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $sizes=ProductSize::where('product_id','=',$id)->get();
        return view('product_size.index',['sizes'=>$sizes,'product_id'=>$id]);
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
        $new_size=new ProductSize();
        $new_size->size_name=$request->size_name;
        $new_size->price=$request->price;
        $new_size->product_id=$request->product_id;
        $new_size->save();
        return redirect()->route('product_sizes.index',['id'=>$request->product_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSize $productSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSize $productSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductSize $productSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $new_size=ProductSize::find($id);
        $new_size->delete();
        return redirect()->route('product_sizes.index', ['id' => $new_size->product_id]);
    }
}
