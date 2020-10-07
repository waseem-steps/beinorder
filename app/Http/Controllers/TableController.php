<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;
use App\Restaurant;
use App\ProductCategory;
use App\Order;
use App\OrderHistory;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar($id, Request $request)
    {
        //

        $tables = Table::where('tables.rest_id', '=', $id)->get();
        return view('table.index-ar', ['tables' => $tables, 'id' => $id]);
    }

    public function table_code_ar(Request $request)
    {

        echo $request;
        //return view('table.check_table',['rest_id'=>$request->rest_id,'table_id'=>$request->table_id]);
    }

    public function closeTable_ar($id)
    {

        $order_code = "";
        while (true) {
            $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
            $order = OrderHistory::select()->where('order_code', '=', $order_code)->get();
            if (count($order) == 0) {
                break;
            }
        }

        $orders = Order::where('orders.table_id', '=', $id)->get();
        foreach ($orders as $order) {
            $order_history = new OrderHistory();
            $order_history->order_id = $order->id;
            $order_history->order_code = $order_code;
            $order_history->rest_id = $order->rest_id;
            $order_history->branch_id = $order->branch_id;
            $order_history->phone_number = $order->phone_number;
            $order_history->car_color = $order->car_color;
            $order_history->car_type = $order->car_type;
            $order_history->customer_name = $order->customer_name;
            $order_history->customer_email = $order->customer_email;
            $order_history->li_number = $order->li_number;
            $order_history->order_type = $order->order_type;
            $order_history->payment_method = $order->payment_method;
            $order_history->order_status_id = $order->order_status_id;
            $order_history->voucher_id = $order->voucher_id;
            $order_history->ip_address = $order->ip_address;
            $order_history->table_id = $order->table_id;
            $order_history->save();

            $o = Order::find($order->id);
            $o->delete();
        }


        $table_code = "";
        while (true) {
            $table_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1)  . substr(str_shuffle("0123456789"), 0, 2);
            $table = table::select()
                ->where('tables.table_code', '=', $table_code)
                //->where('tables.rest_id', '=', 2)
                ->get();
            if (count($table) == 0) {
                break;
            }
        }
        $t = Table::find($id);
        $t->table_code = $table_code;
        $t->save();
        return redirect()->back();
    }

    public function validate_table_ar()
    {
        //
        return view('table.validate-table-ar');
    }

    public function valid_ar(Request $request)
    {
        //dd($request);
        $table = Table::where('tables.rest_id', '=', $request->rest_id)
            ->where('tables.id', '=', $request->table_id)
            ->where('tables.table_code', '=', $request->table_code)
            ->get();

        if (count($table) > 0) {
            $request->session()->put('ip_rest', $request->rest_id);
            $rest = Restaurant::find($request->rest_id);
            $product_cats = ProductCategory::where('product_categories.rest_id', '=', $request->rest_id)->get();
            return view('product_category.table-index-ar', ['cats' => $product_cats, 'rest_id' => $request->rest_id, 'rest' => $rest, 'table_id' => $request->table_id]);
        } else
            return redirect()->back()->with('status', 'Invalid table code... Please contact restaurant admin');
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

        $table_code = "";
        while (true) {
            $table_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1)  . substr(str_shuffle("0123456789"), 0, 2);
            $table = table::select()->where('table_code', '=', $table_code)
                ->where('tables.rest_id', '=', 2)->get();
            if (count($table) == 0) {
                break;
            }
        }
        $table = new Table();
        $table->table_no = $request->table_no;
        $table->captin_name = $request->captain_name;
        $table->rest_id = $request->rest_id;
        $table->table_code = $table_code;
        $table->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, Table $table)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function delete_ar(Request $request, $id)
    {
        //
        $table = Table::find($id);
        $table->delete();
        return redirect()->back();
    }

    public function generateQrExternal_ar($id)
    {
        /* $branch = Branch::find($id);
        $rest_url = Route('branch.details', $id);
        $qr = \QrCode::size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);

        $image = \QrCode::format('png')

            ->size(500)->errorCorrection('H')
            ->generate($rest_url);
        return response($image)->header('Content-type', 'image/png');


        return view('branch.qrcode', ['qr' => $qr, 'id' => $id, 'image' => $image]); */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        //

        $tables = Table::where('tables.rest_id', '=', $id)->get();
        return view('table.index', ['tables' => $tables,'id'=>$id]);
    }

    public function table_code(Request $request){
		
		echo $request;
		//return view('table.check_table',['rest_id'=>$request->rest_id,'table_id'=>$request->table_id]);
    }

    public function closeTable($id){
		
		$order_code = "";
        while (true) {
            $order_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6) . "-" . substr(str_shuffle("0123456789"), 0, 4);
            $order = OrderHistory::select()->where('order_code', '=', $order_code)->get();
            if (count($order) == 0) {
                break;
            }
        }
        
        $orders=Order::where('orders.table_id','=',$id)->get();
        foreach($orders as $order)
        {
            $order_history=new OrderHistory();
            $order_history->order_id=$order->id;
            $order_history->order_code=$order_code;
            $order_history->rest_id=$order->rest_id;
            $order_history->branch_id=$order->branch_id;
            $order_history->phone_number=$order->phone_number;
            $order_history->car_color=$order->car_color;
            $order_history->car_type=$order->car_type;
            $order_history->customer_name=$order->customer_name;
            $order_history->customer_email=$order->customer_email;
            $order_history->li_number=$order->li_number;            
            $order_history->order_type=$order->order_type;
            $order_history->payment_method=$order->payment_method;
            $order_history->order_status_id= $order->order_status_id;
            $order_history->voucher_id=$order->voucher_id;
            $order_history->ip_address=$order->ip_address;
			$order_history->table_id=$order->table_id;
            $order_history->save();

            $o=Order::find($order->id);
            $o->delete();
        }

        
        $table_code = "";
        while (true) {
            $table_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1)  . substr(str_shuffle("0123456789"), 0, 2);
            $table = table::select()
				->where('tables.table_code', '=', $table_code)
                //->where('tables.rest_id', '=', 2)
				->get();
            if (count($table) == 0) {
                break;
            }
        }
        $t = Table::find($id);
        $t->table_code = $table_code;
        $t->save();
        return redirect()->back();
    }

    public function validate_table()
    {
        //
        return view('table.validate-table');
    }

    public function valid(Request $request){
        //dd($request);
        $table=Table::where('tables.rest_id','=',$request->rest_id)
        ->where('tables.id','=',$request->table_id)
        ->where('tables.table_code','=',$request->table_code)
        ->get();

        if(count($table)>0){
            $request->session()->put('ip_rest', $request->rest_id);
            $rest = Restaurant::find($request->rest_id);
            $product_cats = ProductCategory::where('product_categories.rest_id','=', $request->rest_id)->get();
            return view('product_category.table-index', ['cats' => $product_cats, 'rest_id' =>$request->rest_id, 'rest' => $rest,'table_id'=>$request->table_id]);
        }
        else
        return redirect()->back()->with('status','Invalid table code... Please contact restaurant admin');

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

        $table_code = "";
        while (true) {
            $table_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1)  . substr(str_shuffle("0123456789"), 0, 2);
            $table = table::select()->where('table_code', '=', $table_code)
            ->where('tables.rest_id','=',2)->get();
            if (count($table) == 0) {
                break;
            }
        }
        $table = new Table();
        $table->table_no = $request->table_no;
        $table->captin_name = $request->captain_name;
        $table->rest_id = $request->rest_id;
        $table->table_code = $table_code;
        $table->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {
        //
        $table = Table::find($id);
        $table->delete();
        return redirect()->back();
    }

    public function generateQrExternal($id)
    {
        /* $branch = Branch::find($id);
        $rest_url = Route('branch.details', $id);
        $qr = \QrCode::size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);

        $image = \QrCode::format('png')

            ->size(500)->errorCorrection('H')
            ->generate($rest_url);
        return response($image)->header('Content-type', 'image/png');


        return view('branch.qrcode', ['qr' => $qr, 'id' => $id, 'image' => $image]); */
    }


}
