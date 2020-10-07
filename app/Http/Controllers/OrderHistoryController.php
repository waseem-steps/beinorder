<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;
use App\OrderHistory;
use Pusher\Pusher;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function history_orders_ar()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = OrderHistory::select(
            'restaurants.ar_rest_name',
            'order_histories.rest_id',
            'tables.table_no',
            'order_histories.table_id',
            'order_histories.order_type',
            'order_histories.order_code',
            'order_histories.ip_address'
        )
            ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
            ->join('tables', 'order_histories.table_id', '=', 'tables.id')
            ->where('order_histories.ip_address', '=', $ip)
            ->groupBY(
                'restaurants.ar_rest_name',
                'order_histories.rest_id',
                'tables.table_no',
                'order_histories.table_id',
                'order_histories.order_type',
                'order_histories.order_code',
                'order_histories.ip_address'
            )
            ->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = OrderHistory::select(
                'restaurants.ar_rest_name',
                'order_histories.rest_id',
                'tables.table_no',
                'order_histories.table_id',
                'order_histories.order_type',
                'order_histories.order_code',
                'order_histories.payment_method',
                'order_histories.updated_at',
                'order_histories.created_at'
                //'order_histories.ip_address'
            )
                ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
                ->join('tables', 'order_histories.table_id', '=', 'tables.id')
                ->where('order_histories.rest_id', '=', $rest_id->rest_id)
                ->groupBY(
                    'restaurants.ar_rest_name',
                    'order_histories.rest_id',
                    'tables.table_no',
                    'order_histories.table_id',
                    'order_histories.order_type',
                    'order_histories.order_code',
                    'order_histories.payment_method',
                    'order_histories.updated_at',
                    'order_histories.created_at'
                    //'order_histories.ip_address'
                )
                ->orderBy('order_histories.created_at', 'DESC')
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = OrderHistory::all();
        }

        //echo $orders;

        return view('order.history-orders-ar', ['orders' => $orders]);
    }

    public static function getTableOrders_ar($table_id, $rest_id, $ip_address, $order_code)
    {

        $role_name = session()->get('user_role');
        $orders = OrderHistory::select(
            'order_histories.id',
            'order_histories.order_code',
            'order_histories.order_status_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
            ->join('tables', 'order_histories.table_id', '=', 'tables.id')
            ->where('ip_address', '=', $ip_address)
            ->where('order_histories.rest_id', '=', $rest_id)
            ->where('order_histories.table_id', '=', $table_id)
            ->where('order_histories.order_code', '=', $order_code)
            ->groupBY(
                'order_histories.id',
                'order_histories.order_code',
                'order_histories.order_status_id'
            )
            ->get();

        if ($role_name == 'Restaurant Admin') {
            //$user_id = auth()->user()->id;
            //$rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = OrderHistory::select(
                'order_histories.id',
                'order_histories.order_id',
                'order_histories.order_code',
                'order_histories.rest_id',
                'order_histories.table_id',
                'order_histories.order_status_id'
            )
                ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
                ->join('tables', 'order_histories.table_id', '=', 'tables.id')
                ->where('order_histories.rest_id', '=', $rest_id)
                ->where('order_histories.table_id', '=', $table_id)
                ->where('order_histories.order_code', '=', $order_code)
                ->groupBY(
                    'order_histories.id',
                    'order_histories.order_id',
                    'order_histories.order_code',
                    'order_histories.rest_id',
                    'order_histories.table_id',
                    'order_histories.order_status_id'
                )
                ->get();
        }
        return $orders;
    }

    public static function getTableTotalOrderRestAdmin_ar($table_id, $rest_id, $ip_address, $order_code)
    {
        return OrderDetail::join('order_histories', 'order_details.order_id', '=', 'order_histories.order_id')
        ->where('order_histories.table_id', '=', $table_id)
            ->where('order_histories.rest_id', '=', $rest_id)
            //->where('orders.ip_address', '=', $ip_address)
            ->where('order_histories.order_code', '=', $order_code)
            ->sum('order_details.price');
    }

    public function printInternalTable_ar($id)
    {
        //
        $role_name = session()->get('user_role');

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = OrderHistory::select(
                'restaurants.ar_rest_name',
                'order_histories.rest_id',
                'tables.table_no',
                'order_histories.table_id',
                'order_histories.order_type',
                'order_histories.order_code',
                'order_histories.payment_method',
                'order_histories.updated_at',
                'order_histories.created_at'
            )
                ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
                ->join('tables', 'order_histories.table_id', '=', 'tables.id')
                ->where('order_histories.rest_id', '=', $rest_id->rest_id)
                ->where('order_histories.order_code', '=', $id)
                ->groupBY(
                    'restaurants.ar_rest_name',
                    'order_histories.rest_id',
                    'tables.table_no',
                    'order_histories.table_id',
                    'order_histories.order_type',
                    'order_histories.order_code',
                    'order_histories.payment_method',
                    'order_histories.updated_at',
                    'order_histories.created_at'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = OrderHistory::all();
        }

        //echo $orders;
        return view('order.print-history-ar', ['orders' => $orders]);
    }
	public function history_orders()
    {
        //
        $ip = session()->get('client_ip');
        $role_name = session()->get('user_role');
        $orders = OrderHistory::select(
            'restaurants.rest_name',
            'order_histories.rest_id',
            'tables.table_no',
            'order_histories.table_id',
			'order_histories.order_type',
            'order_histories.order_code',
            'order_histories.ip_address'
        )
        ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
        ->join('tables', 'order_histories.table_id', '=', 'tables.id')
        ->where('order_histories.ip_address', '=', $ip)
        ->groupBY(
            'restaurants.rest_name',
            'order_histories.rest_id',
            'tables.table_no',
            'order_histories.table_id',
			'order_histories.order_type',
            'order_histories.order_code',
            'order_histories.ip_address'
        )
        ->get();

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = OrderHistory::select(
                    'restaurants.rest_name',
                    'order_histories.rest_id',
                    'tables.table_no',
                    'order_histories.table_id',
					'order_histories.order_type',
                    'order_histories.order_code',
					'order_histories.payment_method',
					'order_histories.updated_at',
					'order_histories.created_at'
                    //'order_histories.ip_address'
                )
                ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
                ->join('tables', 'order_histories.table_id', '=', 'tables.id')
                ->where('order_histories.rest_id', '=', $rest_id->rest_id)
                ->groupBY(
                    'restaurants.rest_name',
                    'order_histories.rest_id',
                    'tables.table_no',
                    'order_histories.table_id',
					'order_histories.order_type',
                    'order_histories.order_code',
					'order_histories.payment_method',
					'order_histories.updated_at',
					'order_histories.created_at'
                    //'order_histories.ip_address'
                )
				->orderBy('order_histories.created_at','DESC')
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = OrderHistory::all();
        }

		//echo $orders;

        return view('order.history-orders', ['orders' => $orders]);
    }
	
	public static function getTableOrders($table_id,$rest_id,$ip_address,$order_code){

		$role_name = session()->get('user_role');
        $orders = OrderHistory::select(
           'order_histories.id',
		   'order_histories.order_code',
           'order_histories.order_status_id'
        )
            ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
            ->join('tables', 'order_histories.table_id', '=', 'tables.id')
            ->where('ip_address', '=', $ip_address)
            ->where('order_histories.rest_id','=',$rest_id)
            ->where('order_histories.table_id', '=', $table_id)
            ->where('order_histories.order_code', '=', $order_code)
            ->groupBY(
            'order_histories.id',
			'order_histories.order_code',
            'order_histories.order_status_id'
            )
            ->get();

		if ($role_name == 'Restaurant Admin') {
			//$user_id = auth()->user()->id;
            //$rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
			$orders = OrderHistory::select(
           'order_histories.id',
		   'order_histories.order_id',
		   'order_histories.order_code',
		   'order_histories.rest_id',
		   'order_histories.table_id',
           'order_histories.order_status_id'
			)
            ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
            ->join('tables', 'order_histories.table_id', '=', 'tables.id')
            ->where('order_histories.rest_id','=',$rest_id)
            ->where('order_histories.table_id', '=', $table_id)
            ->where('order_histories.order_code', '=', $order_code)
            ->groupBY(
            'order_histories.id',
			'order_histories.order_id',
			'order_histories.order_code',
			'order_histories.rest_id',
			'order_histories.table_id',
            'order_histories.order_status_id'
            )
            ->get();
		}
            return $orders;
    }
	
	public static function getTableTotalOrderRestAdmin($table_id, $rest_id, $ip_address, $order_code)
    {
        return OrderDetail::join('order_histories','order_details.order_id','=','order_histories.order_id')
        ->where('order_histories.table_id', '=', $table_id)
        ->where('order_histories.rest_id', '=', $rest_id)
        //->where('orders.ip_address', '=', $ip_address)
        ->where('order_histories.order_code', '=', $order_code)
        ->sum('order_details.price');
    }
	
	public function printInternalTable($id)
    {
        //
        $role_name = session()->get('user_role');        

        if ($role_name == 'Restaurant Admin') {
            $user_id = auth()->user()->id;
            $rest_id = User::select('rest_id')->where('users.id', '=', $user_id)->groupBy()->first();
            $orders = OrderHistory::select(
                    'restaurants.rest_name',
                    'order_histories.rest_id',
                    'tables.table_no',
                    'order_histories.table_id',
					'order_histories.order_type',
					'order_histories.order_code',
					'order_histories.payment_method',
					'order_histories.updated_at',
					'order_histories.created_at'                    
                )
                ->join('restaurants', 'restaurants.id', '=', 'order_histories.rest_id')
                ->join('tables', 'order_histories.table_id', '=', 'tables.id')
                ->where('order_histories.rest_id', '=', $rest_id->rest_id)
				->where('order_histories.order_code', '=', $id)
				->groupBY(
                    'restaurants.rest_name',
                    'order_histories.rest_id',
                    'tables.table_no',
                    'order_histories.table_id',
					'order_histories.order_type',
                    'order_histories.order_code',
					'order_histories.payment_method',
					'order_histories.updated_at',
					'order_histories.created_at'
                )
                ->get();
        }

        if ($role_name == 'Administrator') {

            $orders = OrderHistory::all();
        }
		
		//echo $orders;
        return view('order.print-history', ['orders' => $orders]);
    }
	
}
