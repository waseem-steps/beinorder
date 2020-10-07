<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\User;
use App\OrderDetail;
use App\Submenu;
use App\SubmenuItem;
use Pusher\Pusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getActiveCart_ar(Request $request)
    {

        $ip = $_SERVER['REMOTE_ADDR'];
        $count = CartController::getTotalCarts($ip);
        if ($count > 0) {
            $cart = Cart::select(
                'carts.product_id',
                'notes',
                'products.ar_product_name',
                DB::raw(
                    'coalesce(carts.ar_description,"-1") description'
                ),
                DB::raw('sum(carts.quantity) quantity'),
                DB::raw('sum(carts.price) price')
            )->join('products', 'carts.product_id', '=', 'products.id')
                ->groupBy(
                    'carts.product_id',
                    'notes',
                    DB::raw(
                        'coalesce(carts.ar_description,"-1") '
                    ),
                    'products.ar_product_name'
                )->where('carts.ip_address', '=', $ip)->get();

            $total = Cart::select(DB::raw('sum(carts.price) price'))->join('products', 'carts.product_id', '=', 'products.id')->where('ip_address', '=', $ip)->groupBy('products.product_name', 'carts.product_id')->first();
            return view('cart.view_order-ar', ['carts' => $cart, 'total' => $total]);
        } else return redirect()->route('product-categories.rest-cat-ar', ['id' => $request->session()->get('rest_id')]);
    }

    public function finalConfirm_ar(Request $request)
    {
        $cust_name = $request->name;
        $cust_mobile = $request->phone_number;
        $cust_email = $request->email;

        $car_name = $request->car_name;
        $car_color = $request->color;
        $license_number = $request->license_number;

        $payment_method = $request->payment_method;

        $ip = $_SERVER['REMOTE_ADDR'];
        $cart =
            $cart = Cart::select(
                'carts.product_id',
                'products.ar_product_name',
                'notes',
                DB::raw(
                    'coalesce(carts.ar_description,"-1") description'
                ),
                DB::raw('sum(carts.quantity) quantity'),
                DB::raw('sum(carts.price) price')
            )->join('products', 'carts.product_id', '=', 'products.id')
            ->groupBy(
                'carts.product_id',
                DB::raw(
                    'coalesce(carts.ar_description,"-1") '
                ),
                'notes',
                'products.ar_product_name'
            )->where('carts.ip_address', '=', $ip)->get();
        $total = Cart::select(DB::raw('sum(carts.price) price'))->join('products', 'carts.product_id', '=', 'products.id')->where('ip_address', '=', $ip)->groupBy()->first();

        return view('cart.final-ar', [
            'car_name' => $car_name, 'car_color' => $car_color, 'license_number' => $license_number, 'cust_name' => $cust_name, 'cust_mobile' => $cust_mobile, 'cust_email' => $cust_email,
            'carts' => $cart, 'total' => $total,
            'payment_method' => $payment_method
        ]);
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

    public static function getTotalCart_ar($id, $ip)
    {
        return $products = Cart::where('carts.product_id', '=', $id)->where('carts.ip_address', '=', $ip)->sum('carts.quantity');
    }

    public static function getTotalCarts_ar($ip)
    {
        return $products = Cart::where('carts.ip_address', '=', $ip)->count('carts.quantity');
    }

    public static function getTotalAmount_ar($ip)
    {

        return number_format(Cart::where('carts.ip_address', '=', $ip)->sum('carts.price'), 3, '.', '');
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
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->unit_price = $request->product_price;
        $cart->price = $request->product_price * $request->quantity;
        $cart->ip_address
            = $request->session()->get('ip_address');
        $cart->notes = $request->notes;
        $cart->save();
        //echo $request->session()->get('ip_address');
        //$request->session()->forget('ip_branch');
        return redirect()->route('products.index-ar', ['id' => $request->cat_id]);
    }

    public function store_product_cart_ar(Request $request)
    {
        //
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->quantity = 1;
        $cart->unit_price = $request->price;
        $cart->price = $request->price * 1;
        $cart->ip_address
            = $request->session()->get('ip_address');
        $cart->notes = $request->notes;
        $cart->save();
        //echo $request->session()->get('ip_address');
        //$request->session()->forget('ip_branch');
        return redirect()->route('products.index-ar', ['id' => $request->cat_id]);
    }

    public function store_cart_ar(Request $request)
    {

        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->unit_price = $request->product_price;

        $cart->ip_address = $request->session()->get('ip_address');
        $cart->notes = $request->notes;
        $description = null;
        $price = $request->product_price * $request->quantity;


        $input = $request->all();
        $input['test'] = $request->input('test');
        if ($input['test']) {
            foreach ($input['test'] as $in)
                if ($in != '-1') {
                    echo $in . ', ';
                    $item = SubmenuItem::find($in);

                    $description = $description . ' Extra: ' . $item->item_name . ', ';
                    $price = $price + ($item->price * $request->quantity);
                }
        }

        foreach ($request->except('_token') as  $key => $part) {
            $item = SubmenuItem::where('submenu_items.id', '=', $part)->where('submenu_items.submenu_id', '=', $key)->get();

            if ($item) {
                foreach ($item as $i) {
                    $menu = Submenu::where('submenus.id', '=', $i->submenu_id)->where('submenus.submenu_type', '=', 0)->first();
                    $price = $price + ($i->price * $request->quantity);

                    $description = $description . ' ' . $menu->submenu_name . ': ' . $i->item_name;
                }
            }
        }





        $cart->price = $price;
        $cart->description = $description;

        $cart->save();
        return redirect()->route('products.index-ar', ['id' => $request->cat_id]);
    }

    public function delete_ar($product_id, $description)
    {

        $ip = $_SERVER['REMOTE_ADDR'];


        if ($description == '-1') {
            $carts = Cart::where('carts.product_id', '=', $product_id)->where('ip_address', '=', $ip)->get();
            foreach ($carts as $cart) {
                $x = Cart::find($cart->id);
                $x->delete();
            }
        } else {
            $carts = Cart::where('carts.product_id', '=', $product_id)->where('description', '=', $description)->where('ip_address', '=', $ip)->get();
            foreach ($carts as $cart) {
                $x = Cart::find($cart->id);
                $x->delete();
            }
        }


        return redirect()->route('cart.active-cart-ar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public static function destroy_ar(Request $request)
    {
        //
        $request->session()->forget('ip_branch');
        $request->session()->forget('ip_rest');
        $ip = $_SERVER['REMOTE_ADDR'];
        $carts = Cart::where('ip_address', '=', $ip)->get();
        foreach ($carts as $cart) {
            $cart = Cart::find($cart->id);
            $cart->delete();
        }
    }

    public function finalConfirm_table_ar(Request $request)
    {
        dd($request);
    }

    public static function checkout_table_ar(Request $request)
    {

        //dd($request);
        $ip = $request->session()->get('ip_address');
        /* if(!empty($request->session()->get('table_order')))
        {
            $order_code= $request->session()->get('table_order');
            $order=Order::where('orders.order_code','=',$order_code)
            ->where('orders.rest_id','=',$request->rest_id)
            ->where('orders.table_id','=',$request->table_id)
            ->where('orders.ip_address','=',$ip)
            ->get()->first();
            echo $order->id;

            $detail=new OrderDetail();
            $detail->order_id=$order->id;
            $detail->quantity=$request->quantity;
            $detail->price=$request->product_price*$request->quantity;
            $detail->notes=$request->notes;
            $request->session()->forget('table_order');
        }
        else
        {
            $order_code = "";

            while (true) {
                $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
                $order = Order::select()->where('order_code', '=', $order_code)->get();
                if (count($order) == 0) {
                    break;
                }
            }
            $request->session()->put('table_order', $order_code);

            $order =new Order();
            $order->order_code=$order_code;
            $order->table_id=$request->table_id;
            $order->rest_id=$request->rest_id;
            $order->order_type=1;
            $order->order_status_id=1;
            $order->ip_address=$ip;
            $order->payment_method='CASH';
            $order->save();
        } */

        $order_code = "";

        if(empty($request->session()->get('table_order')))
        {
            while (true) {
                $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
                $order = Order::select()->where('order_code', '=', $order_code)->get();
                if (count($order) == 0) {
                    break;
                }
            }
            $request->session()->put('table_order', $order_code);
        }
        else
        {
            $order_code= $request->session()->get('table_order');
        }


        $description =
            ProductController::getProductName_ar($request->product_id);

        $order = new Order();
        $order->order_code = $order_code;
        $order->table_id = $request->table_id;
        $order->rest_id = $request->rest_id;
        $order->order_type = 1;
        $order->order_status_id = 1;
        $order->ip_address = $ip;
        $order->payment_method = 'CASH';
        $order->save();

        $price
            = $request->product_price * $request->quantity;

        $input = $request->all();
        $input['test'] = $request->input('test');
        if ($input['test']) {
            foreach ($input['test'] as $in)
                if ($in != '-1') {

                    $item = SubmenuItem::find($in);

                    $description = $description . ' Extra: ' . $item->item_name . ', ';
                    $price = $price + ($item->price * $request->quantity);
                }
        }

        foreach ($request->except('_token') as  $key => $part) {
            $item = SubmenuItem::where('submenu_items.id', '=', $part)->where('submenu_items.submenu_id', '=', $key)->get();

            if ($item) {
                foreach ($item as $i) {
                    $menu = Submenu::where('submenus.id', '=', $i->submenu_id)->where('submenus.submenu_type', '=', 0)->first();
                    $price = $price + ($i->price * $request->quantity);

                    $description = $description . ' ' . $menu->submenu_name . ': ' . $i->item_name;
                }
            }
        }

        $detail = new OrderDetail();
        $detail->order_id = $order->id;
        $detail->quantity = $request->quantity;
        $detail->price = $price;
        $detail->notes = $request->notes;
        $detail->description = $description;
        $detail->save();

        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );


        $user_id=(User::where('users.rest_id','=', $request->rest_id)->get()->first())->id;

        $data['message'] = 'New Order has been submitted';
        $pusher->trigger('notify-channel'. $user_id, 'App\\Events\\Notify', $data);
		//ProductCategoryController::tableCategories1($request);
        return redirect()->route('table.product-categories-cart-ar',['rest_id'=>$request->rest_id,'table_id'=>$request->table_id]);
		//return $request;
    }

    public function checkout_ar()
    {
        return view('cart.checkout-ar');
    }
    
    public function getActiveCart(Request $request)
    {

        $ip = $_SERVER['REMOTE_ADDR'];
        $count = CartController::getTotalCarts($ip);
        if ($count > 0) {
            $cart = Cart::select(
                'carts.product_id',
                'notes',
                'products.product_name',
                DB::raw(
                    'coalesce(carts.description,"-1") description'
                ),
                DB::raw('sum(carts.quantity) quantity'),
                DB::raw('sum(carts.price) price')
            )->join('products', 'carts.product_id', '=', 'products.id')
                ->groupBy(
                    'carts.product_id',
                    'notes',
                    DB::raw(
                        'coalesce(carts.description,"-1") '
                    ),
                    'products.product_name'
                )->where('carts.ip_address', '=', $ip)->get();

            $total = Cart::select(DB::raw('sum(carts.price) price'))->join('products', 'carts.product_id', '=', 'products.id')->where('ip_address', '=', $ip)->groupBy('products.product_name', 'carts.product_id')->first();
            return view('cart.view_order', ['carts' => $cart, 'total' => $total]);
        } else return redirect()->route('product-categories.rest-cat', ['id' => $request->session()->get('rest_id')]);
    }

    public function finalConfirm(Request $request)
    {
        $cust_name = $request->name;
        $cust_mobile = $request->phone_number;
        $cust_email = $request->email;

        $car_name = $request->car_name;
        $car_color = $request->color;
        $license_number = $request->license_number;

        $payment_method = $request->payment_method;

        $ip = $_SERVER['REMOTE_ADDR'];
        $cart =
            $cart = Cart::select(
                'carts.product_id',
                'products.product_name',
                'notes',
                DB::raw(
                    'coalesce(carts.description,"-1") description'
                ),
                DB::raw('sum(carts.quantity) quantity'),
                DB::raw('sum(carts.price) price')
            )->join('products', 'carts.product_id', '=', 'products.id')
            ->groupBy(
                'carts.product_id',
                DB::raw(
                    'coalesce(carts.description,"-1") '
                ),
                'notes',
                'products.product_name'
            )->where('carts.ip_address', '=', $ip)->get();
        $total = Cart::select(DB::raw('sum(carts.price) price'))->join('products', 'carts.product_id', '=', 'products.id')->where('ip_address', '=', $ip)->groupBy()->first();

        return view('cart.final', [
            'car_name' => $car_name, 'car_color' => $car_color, 'license_number' => $license_number, 'cust_name' => $cust_name, 'cust_mobile' => $cust_mobile, 'cust_email' => $cust_email,
            'carts' => $cart, 'total' => $total,
            'payment_method' => $payment_method
        ]);
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

    public static function getTotalCart($id, $ip)
    {
        return $products = Cart::where('carts.product_id', '=', $id)->where('carts.ip_address', '=', $ip)->sum('carts.quantity');
    }

    public static function getTotalCarts($ip)
    {
        return $products = Cart::where('carts.ip_address', '=', $ip)->count('carts.quantity');
    }

    public static function getTotalAmount($ip)
    {

        return number_format(Cart::where('carts.ip_address', '=', $ip)->sum('carts.price'), 3, '.', '');
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
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->unit_price = $request->product_price;
        $cart->price = $request->product_price * $request->quantity;
        $cart->ip_address
            = $request->session()->get('ip_address');
        $cart->notes = $request->notes;
        $cart->save();
        //echo $request->session()->get('ip_address');
        //$request->session()->forget('ip_branch');
        return redirect()->route('products.index', ['id' => $request->cat_id]);
    }

    public function store_product_cart(Request $request)
    {
        //
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->quantity = 1;
        $cart->unit_price = $request->price;
        $cart->price = $request->price * 1;
        $cart->ip_address
            = $request->session()->get('ip_address');
        $cart->notes = $request->notes;
        $cart->save();
        //echo $request->session()->get('ip_address');
        //$request->session()->forget('ip_branch');
        return redirect()->route('products.index', ['id' => $request->cat_id]);
    }

    public function store_cart(Request $request)
    {

        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->unit_price = $request->product_price;

        $cart->ip_address = $request->session()->get('ip_address');
        $cart->notes = $request->notes;
        $description = null;
        $price = $request->product_price * $request->quantity;


        $input = $request->all();
        $input['test'] = $request->input('test');
        if ($input['test']) {
            foreach ($input['test'] as $in)
                if ($in != '-1') {
                    echo $in . ', ';
                    $item = SubmenuItem::find($in);

                    $description = $description . ' Extra: ' . $item->item_name . ', ';
                    $price = $price + ($item->price * $request->quantity);
                }
        }

        foreach ($request->except('_token') as  $key => $part) {
            $item = SubmenuItem::where('submenu_items.id', '=', $part)->where('submenu_items.submenu_id', '=', $key)->get();

            if ($item) {
                foreach ($item as $i) {
                    $menu = Submenu::where('submenus.id', '=', $i->submenu_id)->where('submenus.submenu_type', '=', 0)->first();
                    $price = $price + ($i->price * $request->quantity);

                    $description = $description . ' ' . $menu->submenu_name . ': ' . $i->item_name;
                }
            }
        }





        $cart->price = $price;
        $cart->description = $description;

        $cart->save();
        return redirect()->route('products.index', ['id' => $request->cat_id]);
    }

    public function delete($product_id, $description)
    {

        $ip = $_SERVER['REMOTE_ADDR'];


        if ($description == '-1') {
            $carts = Cart::where('carts.product_id', '=', $product_id)->where('ip_address', '=', $ip)->get();
            foreach ($carts as $cart) {
                $x = Cart::find($cart->id);
                $x->delete();
            }
        } else {
            $carts = Cart::where('carts.product_id', '=', $product_id)->where('description', '=', $description)->where('ip_address', '=', $ip)->get();
            foreach ($carts as $cart) {
                $x = Cart::find($cart->id);
                $x->delete();
            }
        }


        return redirect()->route('cart.active-cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public static function destroy(Request $request)
    {
        //
        $request->session()->forget('ip_branch');
        $request->session()->forget('ip_rest');
        $ip = $_SERVER['REMOTE_ADDR'];
        $carts = Cart::where('ip_address', '=', $ip)->get();
        foreach ($carts as $cart) {
            $cart = Cart::find($cart->id);
            $cart->delete();
        }
    }

    public function finalConfirm_table(Request $request)
    {
        dd($request);
    }

    public static function checkout_table(Request $request)
    {

        //dd($request);
        $ip = $request->session()->get('ip_address');
        /* if(!empty($request->session()->get('table_order')))
        {
            $order_code= $request->session()->get('table_order');
            $order=Order::where('orders.order_code','=',$order_code)
            ->where('orders.rest_id','=',$request->rest_id)
            ->where('orders.table_id','=',$request->table_id)
            ->where('orders.ip_address','=',$ip)
            ->get()->first();
            echo $order->id;

            $detail=new OrderDetail();
            $detail->order_id=$order->id;
            $detail->quantity=$request->quantity;
            $detail->price=$request->product_price*$request->quantity;
            $detail->notes=$request->notes;
            $request->session()->forget('table_order');
        }
        else
        {
            $order_code = "";

            while (true) {
                $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
                $order = Order::select()->where('order_code', '=', $order_code)->get();
                if (count($order) == 0) {
                    break;
                }
            }
            $request->session()->put('table_order', $order_code);

            $order =new Order();
            $order->order_code=$order_code;
            $order->table_id=$request->table_id;
            $order->rest_id=$request->rest_id;
            $order->order_type=1;
            $order->order_status_id=1;
            $order->ip_address=$ip;
            $order->payment_method='CASH';
            $order->save();
        } */

        $order_code = "";

        if(empty($request->session()->get('table_order')))
        {
            while (true) {
                $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
                $order = Order::select()->where('order_code', '=', $order_code)->get();
                if (count($order) == 0) {
                    break;
                }
            }
            $request->session()->put('table_order', $order_code);
        }
        else
        {
            $order_code= $request->session()->get('table_order');
        }


        $description =
            ProductController::getProductName($request->product_id);

        $order = new Order();
        $order->order_code = $order_code;
        $order->table_id = $request->table_id;
        $order->rest_id = $request->rest_id;
        $order->order_type = 1;
        $order->order_status_id = 1;
        $order->ip_address = $ip;
        $order->payment_method = 'CASH';
        $order->save();

        $price
            = $request->product_price * $request->quantity;

        $input = $request->all();
        $input['test'] = $request->input('test');
        if ($input['test']) {
            foreach ($input['test'] as $in)
                if ($in != '-1') {

                    $item = SubmenuItem::find($in);

                    $description = $description . ' Extra: ' . $item->item_name . ', ';
                    $price = $price + ($item->price * $request->quantity);
                }
        }

        foreach ($request->except('_token') as  $key => $part) {
            $item = SubmenuItem::where('submenu_items.id', '=', $part)->where('submenu_items.submenu_id', '=', $key)->get();

            if ($item) {
                foreach ($item as $i) {
                    $menu = Submenu::where('submenus.id', '=', $i->submenu_id)->where('submenus.submenu_type', '=', 0)->first();
                    $price = $price + ($i->price * $request->quantity);

                    $description = $description . ' ' . $menu->submenu_name . ': ' . $i->item_name;
                }
            }
        }

        $detail = new OrderDetail();
        $detail->order_id = $order->id;
        $detail->quantity = $request->quantity;
        $detail->price = $price;
        $detail->notes = $request->notes;
        $detail->description = $description;
        $detail->save();

        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );


        $user_id=(User::where('users.rest_id','=', $request->rest_id)->get()->first())->id;

        $data['message'] = 'New Order has been submitted';
        $pusher->trigger('notify-channel'. $user_id, 'App\\Events\\Notify', $data);
		//ProductCategoryController::tableCategories1($request);
        return redirect()->route('table.product-categories-cart',['rest_id'=>$request->rest_id,'table_id'=>$request->table_id]);
		//return $request;
    }

    public function checkout()
    {
        return view('cart.checkout');
    }
}
