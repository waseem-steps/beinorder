<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use App\OrderType;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
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
        $order_type=new OrderType();
        $order_type->type_name=$request->type_name;
        $order_type->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function show(OrderType $orderType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderType $orderType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $order_type=OrderType::find($id);
        $order_type->type_name=$request->type_name;
        $order_type->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderType  $orderType
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $order_type = OrderType::find($id);
        $order_type->delee();
    }
}
