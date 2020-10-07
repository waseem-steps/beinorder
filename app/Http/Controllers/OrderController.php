<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;
use Pusher\Pusher;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function confirm_ar($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 2;
        $order->save();
        return redirect()->back();
    }

    public function done_ar($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 3;
        $order->save();
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response9
     *
     *
     */


    public function index_ar()
    {
        //
        $rest_id = 0;
        $branch_id = 0;
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.phone_number',
            'orders.car_color',
            'orders.car_type',
            'orders.customer_name',
            'orders.customer_email',
            'orders.li_number',
            'orders.order_type',
            'branches.ar_branch_name',
            'restaurants.ar_rest_name',
            'orders.rest_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('branches', 'branches.id', '=', 'orders.branch_id')
            ->where('ip_address', '=', $ip)
            ->orderBy('orders.order_status_id', 'ASC')
            ->get();

        if ($role_name == 'Branch Admin') {
            $user_id = auth()->user()->id;
            $branch_id = (User::select('branch_id')->where('users.id', '=', $user_id)->first())->branch_id;
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.ar_branch_name',
                'restaurants.ar_rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
                ->where('orders.order_status_id', '<>', 3)
                ->where('orders.branch_id', '=', $branch_id)
                ->orWhere(function ($query) {
                    $query->where('orders.order_status_id', '=', 3)
                    ->where('orders.updated_at', '>=', Carbon::now()->addMinutes(-15));
                })
                ->orderBy('orders.order_status_id', 'ASC')
                ->get();
        }

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = (User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first())->rest_id;
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.ar_branch_name',
                'restaurants.ar_rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
                ->where('orders.rest_id', '=', $rest_id)
                ->orderBy('orders.order_status_id', 'ASC')
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }
        return view('order.index-ar', ['orders' => $orders, 'rest_id' => $rest_id, 'branch_id' => $branch_id]);
    }

    public function index_table_ar()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.order_type',
            'restaurants.ar_rest_name',
            'orders.rest_id',
            'tables.table_no'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.ip_address', '=', $ip)->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders
                = Order::select(
                    'orders.id',
                    'orders.order_status_id',
                    'orders.created_at',
                    'orders.order_code',
                    'orders.payment_method',
                    'orders.order_type',
                    'restaurants.ar_rest_name',
                    'orders.rest_id',
                    'tables.table_no'
                )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->where('orders.order_status_id', '!=', 3)
                ->orderBy('orders.order_status_id', 'ASC')
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }

        return view('order.index-table-ar', ['orders' => $orders]);
    }

    public static function getTableOrders_ar($table_id, $rest_id, $ip_address, $order_code)
    {

        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('ip_address', '=', $ip_address)
            ->where('orders.rest_id', '=', $rest_id)
            ->where('orders.table_id', '=', $table_id)
            ->where('orders.order_code', '=', $order_code)
            ->groupBY(
                'orders.id',
                'orders.order_status_id'
            )
            ->get();

        if ($role_name == 'Restaurant Admin') {
            //$user_id = auth()->user()->id;
            //$rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                //->where('ip_address', '=', $ip_address)
                ->where('orders.rest_id', '=', $rest_id)
                ->where('orders.table_id', '=', $table_id)
                //->where('orders.order_code', '=', $order_code)
                ->groupBY(
                    'orders.id',
                    'orders.order_status_id'
                )
                ->get();
        }
        return $orders;
    }

    public function table_orders_ar()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'restaurants.ar_rest_name',
            'orders.rest_id',
            'tables.table_no',
            'orders.table_id',
            'orders.order_type',
            'orders.order_code',
            'orders.ip_address'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.ip_address', '=', $ip)
            ->groupBY(
                'restaurants.ar_rest_name',
                'orders.rest_id',
                'tables.table_no',
                'orders.table_id',
                'orders.order_type',
                'orders.order_code',
                'orders.ip_address'
            )
            ->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                'restaurants.ar_rest_name',
                'orders.rest_id',
                'tables.table_no',
                'orders.table_id',
                'orders.order_type' //,
                //'orders.order_code'//,
                //'orders.ip_address'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->groupBY(
                    'restaurants.ar_rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
                    'orders.order_type' //,
                    //'orders.order_code'//,
                    //'orders.ip_address'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }

        //echo $orders;

        return view('order.table-orders-ar', ['orders' => $orders]);
    }

    public function history_orders_ar()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'restaurants.ar_rest_name',
            'orders.rest_id',
            'tables.table_no',
            'orders.table_id',
            'orders.order_type',
            'orders.order_code',
            'orders.ip_address'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.ip_address', '=', $ip)
            ->groupBY(
                'restaurants.ar_rest_name',
                'orders.rest_id',
                'tables.table_no',
                'orders.table_id',
                'orders.order_type',
                'orders.order_code',
                'orders.ip_address'
            )
            ->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                'restaurants.ar_rest_name',
                'orders.rest_id',
                'tables.table_no',
                'orders.table_id',
                'orders.order_type' //,
                //'orders.order_code'//,
                //'orders.ip_address'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->groupBY(
                    'restaurants.ar_rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
                    'orders.order_type' //,
                    //'orders.order_code'//,
                    //'orders.ip_address'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }

        //echo $orders;

        return view('order.history-orders-ar', ['orders' => $orders]);
    }

    public function checkOut_ar($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 2;
        $order->save();
        return redirect()->back();
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
        $ip = $_SERVER['REMOTE_ADDR'];
        $order_code = "";
        while (true) {
            $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
            $order = Order::select()->where('order_code', '=', $order_code)->get();
            if (count($order) == 0) {
                break;
            }
        }

        $product_id = Cart::select(
            'carts.product_id'
        )->where('ip_address', '=', $ip)
            ->groupBy('carts.product_id')
            ->first();

        $rest_id = Product::select('restaurants.id')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')
        ->join('restaurants', 'restaurants.id', '=', 'product_categories.rest_id')
        ->where('products.id', '=', $product_id->product_id)
            ->groupBy()
            ->first();

        $order = new Order();
        $order->order_code = $order_code;
        $order->phone_number = $request->phone_number;
        $order->car_color = $request->color;
        $order->car_type = $request->car_name;
        $order->li_number = $request->license_number;
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->order_type = 2;
        $order->payment_method = $request->payment_method;
        $order->order_status_id = 1;
        $order->rest_id = $rest_id->id;
        $order->branch_id = session()->get('ip_branch');
        $order->ip_address = $_SERVER['REMOTE_ADDR'];

        $order->save();


        $ip = $_SERVER['REMOTE_ADDR'];
        $carts = Cart::select(
            'carts.price',
            'products.ar_product_name',
            'carts.product_id',
            'carts.ar_description',
            'carts.notes',
            DB::raw('sum(carts.quantity) quantity'),
            DB::raw('sum(carts.price) price')
        )->join('products', 'carts.product_id', '=', 'products.id')
        ->where('ip_address', '=', $ip)
            ->groupBy('carts.price', 'products.ar_product_name', 'carts.product_id', 'carts.ar_description', 'carts.notes')
            ->get();

        foreach ($carts as $cart) {
            $detail = new OrderDetail();
            $detail->order_id = $order->id;
            $detail->description = $cart->product_name . ' ' . $cart->description;
            $detail->quantity = $cart->quantity;
            $detail->price = $cart->price;
            $detail->notes = $cart->notes;
            $detail->save();
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $carts = Cart::where('ip_address', '=', $ip)->get();
        foreach ($carts as $cart) {
            $cart = Cart::find($cart->id);
            $cart->delete();
        }

        /* Mail::send([], [], function ($message) {
        $message->to('alhallak.waseem@hotmail.com')
            ->subject('New Order')
            // here comes what you want

            ->setBody('<h1>Hi, welcome user!</h1>', 'text/html'); // for HTML rich messages
        }); */
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


        $user_id = (User::where('users.branch_id', '=', session()->get('ip_branch'))->get()->first())->id;

        $data['message'] = 'New Order has been submitted';
        $pusher->trigger('notify-channel' . $user_id, 'App\\Events\\Notify', $data);
        return redirect()->route('orders.index-ar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy_ar(Order $order)
    {
        //
    }

    public function generateOrderNR_ar()
    {
        $orderObj = Order::select('order_code')->latest('id')->first();
        if ($orderObj) {
            $orderNr = $orderObj->order_nr;
            $removed1char = substr($orderNr, 1);
            $generateOrder_nr = $stpad = '#' . str_pad($removed1char + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $generateOrder_nr = '#' . str_pad(1, 8, "0", STR_PAD_LEFT);
        }
        return $generateOrder_nr;
    }

    public static function getTableTotalOrder_ar($table_id, $rest_id, $ip_address, $order_code)
    {
        return OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
        ->where('orders.table_id', '=', $table_id)
            ->where('orders.rest_id', '=', $rest_id)
            ->where('orders.ip_address', '=', $ip_address)
            ->where('orders.order_code', '=', $order_code)
            ->sum('order_details.price');
    }

    public static function getTableTotalOrderRestAdmin_ar($table_id, $rest_id, $ip_address, $order_code)
    {
        return OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
        ->where('orders.table_id', '=', $table_id)
            ->where('orders.rest_id', '=', $rest_id)
            //->where('orders.ip_address', '=', $ip_address)
            //->where('orders.order_code', '=', $order_code)
            ->sum('order_details.price');
    }

    public static function getTotalOrder_ar($id)
    {
        return OrderDetail::where('order_details.order_id', '=', $id)->sum('order_details.price');
    }

    public function print_ar($id)
    {
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.phone_number',
            'orders.car_color',
            'orders.car_type',
            'orders.customer_name',
            'orders.customer_email',
            'orders.li_number',
            'orders.order_type',
            'branches.ar_branch_name',
            'restaurants.ar_rest_name',
            'orders.rest_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('branches', 'branches.id', '=', 'orders.branch_id')
            ->where('orders.id', '=', $id)
            ->where('ip_address', '=', $ip)
            ->get();

        if ($role_name == 'Branch Admin') {
            $user_id = auth()->user()->id;
            $branch_id = User::select('branch_id')->where('users.id', '=', $user_id)->first();
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.ar_branch_name',
                'restaurants.ar_rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
                //->where('orders.order_status_id', '<>', 3)
                ->where('orders.id', '=', $id)
                ->where('orders.branch_id', '=', $branch_id->branch_id)
                ->get();
        }

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.ar_branch_name',
                'restaurants.ar_rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->where('orders.id', '=', $id)
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }
        return view('order.print-ar', ['orders' => $orders]);
    }

    public function printInternalOrder_ar($id)
    {
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.order_type',
            'restaurants.ar_rest_name',
            'orders.rest_id',
            'tables.table_no'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.ip_address', '=', $ip)->get();





        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders
                = Order::select(
                    'orders.id',
                    'orders.order_status_id',
                    'orders.created_at',
                    'orders.order_code',
                    'orders.payment_method',
                    'orders.order_type',
                    'restaurants.ar_rest_name',
                    'orders.rest_id',
                    'tables.table_no'
                )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->where('orders.id', '=', $id)
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }
        //echo $orders;
        return view('order.print-ar', ['orders' => $orders]);
    }

    public function printInternalTable_ar($id)
    {
        //
        $role_name = session()->get('user_role');

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                'restaurants.ar_rest_name',
                'orders.rest_id',
                'tables.table_no',
                'orders.table_id',
                'orders.order_type' //,
                //'orders.order_code'//,
                //'orders.ip_address'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->where('orders.table_id', '=', $id)
                ->groupBY(
                    'restaurants.rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
                    'orders.order_type'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }

        //echo $orders;
        return view('order.print-internal-table-ar', ['orders' => $orders]);
    }

    public function confirm($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 2;
        $order->save();
        return redirect()->back();
    }

    public function done($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 3;
        $order->save();
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response9
     *
     *
     */


    public function index()
    {
        //
        $rest_id = 0;
        $branch_id = 0;
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.phone_number',
            'orders.car_color',
            'orders.car_type',
            'orders.customer_name',
            'orders.customer_email',
            'orders.li_number',
            'orders.order_type',
            'branches.branch_name',
            'restaurants.rest_name',
            'orders.rest_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('branches', 'branches.id', '=', 'orders.branch_id')
			->where('ip_address', '=', $ip)
			->orderBy('orders.order_status_id','ASC')
			->get();

        if ($role_name == 'Branch Admin') {
            $user_id = auth()->user()->id;
            $branch_id = (User::select('branch_id')->where('users.id', '=', $user_id)->first())->branch_id;
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.branch_name',
                'restaurants.rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
                ->where('orders.order_status_id', '<>', 3)
                ->where('orders.branch_id', '=', $branch_id)
                ->orWhere(function ($query) {
                    $query->where('orders.order_status_id', '=', 3)
                        ->where('orders.updated_at', '>=', Carbon::now()->addMinutes(-15));
                })
				->orderBy('orders.order_status_id','ASC')
                ->get();
        }

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = (User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first())->rest_id;
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.branch_name',
                'restaurants.rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
				->where('orders.rest_id', '=', $rest_id)
				->orderBy('orders.order_status_id','ASC')
				->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }
        return view('order.index', ['orders' => $orders, 'rest_id' => $rest_id, 'branch_id' => $branch_id]);
    }

    public function index_table()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.order_type',
            'restaurants.rest_name',
            'orders.rest_id',
            'tables.table_no'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.ip_address', '=', $ip)->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders
            = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.order_type',
                'restaurants.rest_name',
                'orders.rest_id',
                'tables.table_no'
            )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.rest_id', '=', $rest_id->rest_id)
			->where('orders.order_status_id', '!=', 3)
			->orderBy('orders.order_status_id','ASC')
			->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }

        return view('order.index-table', ['orders' => $orders]);
    }

    public static function getTableOrders($table_id,$rest_id,$ip_address,$order_code){

		$role_name = session()->get('user_role');
        $orders = Order::select(
           'orders.id',
           'orders.order_status_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('ip_address', '=', $ip_address)
            ->where('orders.rest_id','=',$rest_id)
            ->where('orders.table_id', '=', $table_id)
            ->where('orders.order_code', '=', $order_code)
            ->groupBY(
            'orders.id',
            'orders.order_status_id'
            )
            ->get();

		if ($role_name == 'Restaurant Admin') {
			//$user_id = auth()->user()->id;
            //$rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
			$orders = Order::select(
           'orders.id',
           'orders.order_status_id'
			)
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            //->where('ip_address', '=', $ip_address)
            ->where('orders.rest_id','=',$rest_id)
            ->where('orders.table_id', '=', $table_id)
            //->where('orders.order_code', '=', $order_code)
            ->groupBY(
            'orders.id',
            'orders.order_status_id'
            )
            ->get();
		}
            return $orders;
    }

    public function table_orders()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'restaurants.rest_name',
            'orders.rest_id',
            'tables.table_no',
            'orders.table_id',
			'orders.order_type',
            'orders.order_code',
            'orders.ip_address'
        )
        ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
        ->join('tables', 'orders.table_id', '=', 'tables.id')
        ->where('orders.ip_address', '=', $ip)
        ->groupBY(
            'restaurants.rest_name',
            'orders.rest_id',
            'tables.table_no',
            'orders.table_id',
			'orders.order_type',
            'orders.order_code',
            'orders.ip_address'
        )
        ->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                    'restaurants.rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
					'orders.order_type'//,
                    //'orders.order_code'//,
                    //'orders.ip_address'
                )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->groupBY(
                    'restaurants.rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
					'orders.order_type'//,
                    //'orders.order_code'//,
                    //'orders.ip_address'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }

		//echo $orders;

        return view('order.table-orders', ['orders' => $orders]);
    }
	
	public function history_orders()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'restaurants.rest_name',
            'orders.rest_id',
            'tables.table_no',
            'orders.table_id',
			'orders.order_type',
            'orders.order_code',
            'orders.ip_address'
        )
        ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
        ->join('tables', 'orders.table_id', '=', 'tables.id')
        ->where('orders.ip_address', '=', $ip)
        ->groupBY(
            'restaurants.rest_name',
            'orders.rest_id',
            'tables.table_no',
            'orders.table_id',
			'orders.order_type',
            'orders.order_code',
            'orders.ip_address'
        )
        ->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                    'restaurants.rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
					'orders.order_type'//,
                    //'orders.order_code'//,
                    //'orders.ip_address'
                )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
                ->groupBY(
                    'restaurants.rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
					'orders.order_type'//,
                    //'orders.order_code'//,
                    //'orders.ip_address'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }

		//echo $orders;

        return view('order.history-orders', ['orders' => $orders]);
    }

    public function checkOut($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 2;
        $order->save();
        return redirect()->back();
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
        $ip = $_SERVER['REMOTE_ADDR'];
        $order_code = "";
        while (true) {
            $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
            $order = Order::select()->where('order_code', '=', $order_code)->get();
            if (count($order) == 0) {
                break;
            }
        }

        $product_id = Cart::select(
            'carts.product_id'
        )->where('ip_address', '=', $ip)
            ->groupBy('carts.product_id')
            ->first();

        $rest_id = Product::select('restaurants.id')->join('product_categories', 'products.product_cat_id', '=', 'product_categories.id')
            ->join('restaurants', 'restaurants.id', '=', 'product_categories.rest_id')
            ->where('products.id', '=', $product_id->product_id)
            ->groupBy()
            ->first();

        $order = new Order();
        $order->order_code = $order_code;
        $order->phone_number = $request->phone_number;
        $order->car_color = $request->color;
        $order->car_type = $request->car_name;
        $order->li_number = $request->license_number;
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->order_type = 2;
        $order->payment_method = $request->payment_method;
        $order->order_status_id = 1;
        $order->rest_id = $rest_id->id;
        $order->branch_id = session()->get('ip_branch');
        $order->ip_address = $_SERVER['REMOTE_ADDR'];

        $order->save();


        $ip = $_SERVER['REMOTE_ADDR'];
        $carts = Cart::select(
            'carts.price',
            'products.product_name',
            'carts.product_id',
            'carts.description',
            'carts.notes',
            DB::raw('sum(carts.quantity) quantity'),
            DB::raw('sum(carts.price) price')
        )->join('products', 'carts.product_id', '=', 'products.id')
            ->where('ip_address', '=', $ip)
            ->groupBy('carts.price', 'products.product_name', 'carts.product_id', 'carts.description', 'carts.notes')
            ->get();

        foreach ($carts as $cart) {
            $detail = new OrderDetail();
            $detail->order_id = $order->id;
            $detail->description = $cart->product_name . ' ' . $cart->description;
            $detail->quantity = $cart->quantity;
            $detail->price = $cart->price;
            $detail->notes = $cart->notes;
            $detail->save();
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $carts = Cart::where('ip_address', '=', $ip)->get();
        foreach ($carts as $cart) {
            $cart = Cart::find($cart->id);
            $cart->delete();
        }

        /* Mail::send([], [], function ($message) {
        $message->to('alhallak.waseem@hotmail.com')
            ->subject('New Order')
            // here comes what you want

            ->setBody('<h1>Hi, welcome user!</h1>', 'text/html'); // for HTML rich messages
        }); */
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


        $user_id=(User::where('users.branch_id','=', session()->get('ip_branch'))->get()->first())->id;

        $data['message'] = 'New Order has been submitted';
        $pusher->trigger('notify-channel'. $user_id, 'App\\Events\\Notify', $data);
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function generateOrderNR()
    {
        $orderObj = Order::select('order_code')->latest('id')->first();
        if ($orderObj) {
            $orderNr = $orderObj->order_nr;
            $removed1char = substr($orderNr, 1);
            $generateOrder_nr = $stpad = '#' . str_pad($removed1char + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $generateOrder_nr = '#' . str_pad(1, 8, "0", STR_PAD_LEFT);
        }
        return $generateOrder_nr;
    }

    public static function getTableTotalOrder($table_id, $rest_id, $ip_address, $order_code)
    {
        return OrderDetail::join('orders','order_details.order_id','=','orders.id')
        ->where('orders.table_id', '=', $table_id)
        ->where('orders.rest_id', '=', $rest_id)
        ->where('orders.ip_address', '=', $ip_address)
        ->where('orders.order_code', '=', $order_code)
        ->sum('order_details.price');
    }
	
	public static function getTableTotalOrderRestAdmin($table_id, $rest_id, $ip_address, $order_code)
    {
        return OrderDetail::join('orders','order_details.order_id','=','orders.id')
        ->where('orders.table_id', '=', $table_id)
        ->where('orders.rest_id', '=', $rest_id)
        //->where('orders.ip_address', '=', $ip_address)
        //->where('orders.order_code', '=', $order_code)
        ->sum('order_details.price');
    }

    public static function getTotalOrder($id)
    {
        return OrderDetail::where('order_details.order_id', '=', $id)->sum('order_details.price');
    }

    public function print($id)
    {
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.phone_number',
            'orders.car_color',
            'orders.car_type',
            'orders.customer_name',
            'orders.customer_email',
            'orders.li_number',
            'orders.order_type',
            'branches.branch_name',
            'restaurants.rest_name',
            'orders.rest_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('branches', 'branches.id', '=', 'orders.branch_id')
			->where('orders.id', '=', $id)
			->where('ip_address', '=', $ip)
			->get();

        if ($role_name == 'Branch Admin') {
            $user_id = auth()->user()->id;
            $branch_id = User::select('branch_id')->where('users.id', '=', $user_id)->first();
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.branch_name',
                'restaurants.rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
                //->where('orders.order_status_id', '<>', 3)
                ->where('orders.id', '=', $id)
                ->where('orders.branch_id', '=', $branch_id->branch_id)
                ->get();
        }

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.phone_number',
                'orders.car_color',
                'orders.car_type',
                'orders.customer_name',
                'orders.customer_email',
                'orders.li_number',
                'orders.order_type',
                'branches.branch_name',
                'restaurants.rest_name',
                'orders.rest_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('branches', 'branches.id', '=', 'orders.branch_id')
				->where('orders.rest_id', '=', $rest_id->rest_id)
                ->where('orders.id', '=', $id)
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }
        return view('order.print', ['orders' => $orders]);
    }

	public function printInternalOrder($id)
    {
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = Order::select(
            'orders.id',
            'orders.order_status_id',
            'orders.created_at',
            'orders.order_code',
            'orders.payment_method',
            'orders.order_type',
            'restaurants.rest_name',
            'orders.rest_id',
            'tables.table_no'
        )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.ip_address', '=', $ip)->get();





        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders
            = Order::select(
                'orders.id',
                'orders.order_status_id',
                'orders.created_at',
                'orders.order_code',
                'orders.payment_method',
                'orders.order_type',
                'restaurants.rest_name',
                'orders.rest_id',
                'tables.table_no'
            )
            ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->where('orders.rest_id', '=', $rest_id->rest_id)
			->where('orders.id', '=', $id)
			->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }
		//echo $orders;
        return view('order.print', ['orders' => $orders]);
    }
	
	public function printInternalTable($id)
    {
        //
        $role_name = session()->get('user_role');        

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = Order::select(
                    'restaurants.rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
					'orders.order_type'//,
                    //'orders.order_code'//,
                    //'orders.ip_address'
                )
                ->join('restaurants', 'restaurants.id', '=', 'orders.rest_id')
                ->join('tables', 'orders.table_id', '=', 'tables.id')
                ->where('orders.rest_id', '=', $rest_id->rest_id)
				->where('orders.table_id', '=', $id)
				->groupBY(
                    'restaurants.rest_name',
                    'orders.rest_id',
                    'tables.table_no',
                    'orders.table_id',
					'orders.order_type'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = Order::all();
        }
		
		//echo $orders;
        return view('order.print-internal-table', ['orders' => $orders]);
    }
}
