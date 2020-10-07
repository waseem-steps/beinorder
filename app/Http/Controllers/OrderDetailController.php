<?php

namespace App\Http\Controllers;

use App\OrderDetail;
use Illuminate\Http\Request;
use App\Order;
use App\Restaurant;

class OrderDetailController extends Controller
{

    public static function getDetails_ar($id)
    {
        //
        $order_details = OrderDetail::where('order_id', '=', $id)->get();
        return $order_details;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar($id)
    {
        //
        $order_details = OrderDetail::where('order_id', '=', $id)->get();
        return view('order_detail.index-ar', ['order_details' => $order_details]);
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
        $ip = $request->session()->get('client_ip');
        $order = Order::where('ip_address', '=', $ip)
        ->where('orders.order_status_id', '=', 1)
            ->where('orders.rest_id', '=', $request->rest_id)
            ->get();
        if (count($order) > 0) {
            $order_details = new OrderDetail();
            $order_details->order_id = $order[0]->id;
            $order_details->product_id = $request->product_id;
            $order_details->size_id = $request->size_id;
            $order_details->quantity = 1;
            $order_details->notes = 'note';
            $order_details->ip_address = $ip;
            $order_details->save();
            return redirect()->route('orders.index-ar');
        } else {
            $order_code = $this->test();
            $rest = Restaurant::find($request->rest_id);
            return view('order.create-ar', ['request' => $request, 'order_code' => $order_code, 'rest' => $rest]);
            /* $order=new Order();
            $order->order_code= $this->test();
            $order->rest_id=$request->rest_id;
            $order->phone_number="123123";
            $order->car_color="color";
            $order->car_type="car type";
            $order->order_type=1;
            $order->payment_method_id=1;
            $order->notes="note";
            $order->order_status_id=1;
            $order->ip_address=$ip;

            $order->save();

            $order = Order::where('ip_address', '=', $ip)
            ->where('orders.rest_id', '=', $request->rest_id)
            ->where('orders.order_status_id','=',1)
            ->get();

            $order_details = new OrderDetail();
            $order_details->order_id = $order[0]->id;
            $order_details->product_id = $request->product_id;
            $order_details->size_id = 1;
            $order_details->quantity = 1;
            $order_details->notes = 'note';
            $order_details->ip_address = $ip;
            $order_details->save(); */
        }
    }

    public function new_order_ar(Request $request)
    {
        $ip = $request->session()->get('client_ip');

        $order = new Order();
        $order->order_code = $request->order_code;
        $order->rest_id = $request->rest_id;
        $order->phone_number = $request->phone_number;
        $order->car_color = $request->car_color;
        $order->car_type = $request->car_type;
        $order->order_type = 1;
        $order->payment_method_id = $request->payment_type;
        $order->notes = "asdasd";
        $order->order_status_id = 1;
        $order->ip_address = $ip;

        $order->save();

        $order = Order::where('ip_address', '=', $ip)
        ->where('orders.rest_id', '=', $request->rest_id)
            ->where('orders.order_status_id', '=', 1)
            ->get();

        $order_details = new OrderDetail();
        $order_details->order_id = $order[0]->id;
        $order_details->product_id = $request->product_id;
        $order_details->size_id = $request->size_id;
        $order_details->quantity = $request->quantity;
        $order_details->notes = $request->d_note;
        $order_details->ip_address = $ip;
        $order_details->save();
        return redirect()->route('orders.index-ar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show_ar(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        //
        $order_detail = OrderDetail::find($id);
        $order_detail->delete();
        return redirect()->route('order_details.index-ar', ['id' => $order_detail->order_id]);
    }

    public function test_ar()
    {
        while (true) {
            $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
            $order = Order::select()->where('order_code', '=', $order_code)->get();
            if (count($order) == 0) {
                break;
            }
        }
        return $order_code;
    }

    public static function getDetails($id)
    {
        //
        $order_details = OrderDetail::where('order_id', '=', $id)->get();
        return $order_details;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $order_details=OrderDetail::where('order_id','=',$id)->get();
        return view('order_detail.index',['order_details'=>$order_details]);
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
        $ip = $request->session()->get('client_ip');
        $order = Order::where('ip_address', '=', $ip)
            ->where('orders.order_status_id', '=', 1)
            ->where('orders.rest_id', '=', $request->rest_id)
            ->get();
        if (count($order)>0) {
            $order_details = new OrderDetail();
            $order_details->order_id=$order[0]->id;
            $order_details->product_id=$request->product_id;
            $order_details->size_id=$request->size_id;
            $order_details->quantity=1;
            $order_details->notes='note';
            $order_details->ip_address=$ip;
            $order_details->save();
            return redirect()->route('orders.index');
        } else {
            $order_code= $this->test();
            $rest=Restaurant::find($request->rest_id);
            return view('order.create',['request'=>$request,'order_code' => $order_code,'rest'=>$rest]);
            /* $order=new Order();
            $order->order_code= $this->test();
            $order->rest_id=$request->rest_id;
            $order->phone_number="123123";
            $order->car_color="color";
            $order->car_type="car type";
            $order->order_type=1;
            $order->payment_method_id=1;
            $order->notes="note";
            $order->order_status_id=1;
            $order->ip_address=$ip;

            $order->save();

            $order = Order::where('ip_address', '=', $ip)
            ->where('orders.rest_id', '=', $request->rest_id)
            ->where('orders.order_status_id','=',1)
            ->get();

            $order_details = new OrderDetail();
            $order_details->order_id = $order[0]->id;
            $order_details->product_id = $request->product_id;
            $order_details->size_id = 1;
            $order_details->quantity = 1;
            $order_details->notes = 'note';
            $order_details->ip_address = $ip;
            $order_details->save(); */
        }
    }

    public function new_order(Request $request){
        $ip = $request->session()->get('client_ip');

        $order = new Order();
        $order->order_code = $request->order_code;
        $order->rest_id = $request->rest_id;
        $order->phone_number = $request->phone_number;
        $order->car_color = $request->car_color;
        $order->car_type = $request->car_type;
        $order->order_type = 1;
        $order->payment_method_id = $request->payment_type;
        $order->notes = "asdasd";
        $order->order_status_id = 1;
        $order->ip_address = $ip;

        $order->save();

        $order = Order::where('ip_address', '=', $ip)
            ->where('orders.rest_id', '=', $request->rest_id)
            ->where('orders.order_status_id', '=', 1)
            ->get();

        $order_details = new OrderDetail();
        $order_details->order_id = $order[0]->id;
        $order_details->product_id = $request->product_id;
        $order_details->size_id = $request->size_id;
        $order_details->quantity = $request->quantity;
        $order_details->notes = $request->d_note;
        $order_details->ip_address = $ip;
        $order_details->save();
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $order_detail=OrderDetail::find($id);
        $order_detail->delete();
        return redirect()->route('order_details.index',['id'=>$order_detail->order_id]);
    }

    public function test()
    {
        while(true){
            $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
             $order = Order::select()->where('order_code', '=', $order_code)->get();
             if(count($order)==0){
                break;
             }
        }
        return $order_code;

    }
}
