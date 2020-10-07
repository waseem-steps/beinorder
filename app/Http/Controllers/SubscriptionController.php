<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Subscription;
use Carbon\Carbon;
use App\User;
use App\PricePlan;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\RestaurantAdmins;
use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Hash;

class SubscriptionController extends Controller
{
    public function subscribe_ar(Request $request)
    {
        return view('subscription.subscriber-ar', ['id' => $request->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar()
    {
        //
        return view('plans.index-ar');
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
        $validatedData = $request->validate([
            'email' => 'required|unique:users',
        ]);
        // new res
        $new_rest = new Restaurant();
        $new_rest->rest_name = $request->rest_name;
        $new_rest->description = $request->description;
        $new_rest->ar_rest_name = $request->ar_rest_name;
        $new_rest->ar_description = $request->ar_description;
        $new_rest->country_id = $request->country_id;
        $new_rest->logo = $request->logo;
        $new_rest->thumbnail_logo = $request->thumbnail_logo;

        $new_rest->save();

        $rest_id = $new_rest->id;

        // new user
        $new_user = new User();
        $new_user->name = $request->username;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->role_id = 2;
        $new_user->rest_id = $rest_id;
        $new_user->ip_address = $_SERVER['REMOTE_ADDR'];
        $new_user->save();

        $count = Subscription::where('subscriptions.rest_id', '=', $new_rest->id)->first();
        $plan = PricePlan::find($request->plan_id)->first();
        $period = $plan->period;

        if (!($count)) {
            $period = $period * 2;
        }
        $st_date = Carbon::now()->toDateTimeString();
        $en_date = Carbon::now()->addDays($period)->toDateTimeString();

        // new subscription
        $subscription = new Subscription();
        $subscription->start_date = $st_date;
        $subscription->end_date = $en_date;
        $subscription->status = 1;
        $subscription->price_plan_id = $request->plan_id;
        $subscription->next_price_plan_id = $request->plan_id;
        $subscription->rest_id = $rest_id;

        $subscription->save();
        return redirect()->route('welcome-ar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy_ar(Subscription $subscription)
    {
        //
    }

    public function pending_ar()
    {
        $subs = Subscription::select('subscriptions.id', 'subscriptions.start_date', 'subscriptions.end_date', 'subscriptions.rest_id', 'a.ar_plan_name as current_plan', 'b.ar_plan_name as next_plan', 'a.status', 'c.ar_rest_name')
        ->join(DB::raw('price_plans  a'), DB::raw('subscriptions.price_plan_id'), '=', DB::raw('a.id'))
            ->join(DB::raw('price_plans  b'), DB::raw('subscriptions.next_price_plan_id'), '=', DB::raw('b.id'))
            ->join(DB::raw('restaurants  c'), DB::raw('subscriptions.rest_id'), '=', DB::raw('c.id'))
            ->whereRaw('subscriptions.price_plan_id != subscriptions.next_price_plan_id')
            ->where('subscriptions.status', '=', 1)
            ->get();

        $all_active =
            Subscription::select('subscriptions.id', 'subscriptions.start_date', 'subscriptions.end_date', 'subscriptions.rest_id', 'a.ar_plan_name as current_plan', 'b.ar_plan_name as next_plan', 'a.status', 'c.ar_rest_name')
            ->join(DB::raw('price_plans  a'), DB::raw('subscriptions.price_plan_id'), '=', DB::raw('a.id'))
            ->join(DB::raw('price_plans  b'), DB::raw('subscriptions.next_price_plan_id'), '=', DB::raw('b.id'))
            ->join(DB::raw('restaurants  c'), DB::raw('subscriptions.rest_id'), '=', DB::raw('c.id'))
            ->where('subscriptions.status', '=', 1)
            ->get();

        $all_subs
            = Subscription::select('subscriptions.id', 'subscriptions.start_date', 'subscriptions.end_date', 'subscriptions.rest_id', 'a.ar_plan_name as current_plan', 'b.ar_plan_name as next_plan', 'a.status', 'c.ar_rest_name')
            ->join(DB::raw('price_plans  a'), DB::raw('subscriptions.price_plan_id'), '=', DB::raw('a.id'))
            ->join(DB::raw('price_plans  b'), DB::raw('subscriptions.next_price_plan_id'), '=', DB::raw('b.id'))
            ->join(DB::raw('restaurants  c'), DB::raw('subscriptions.rest_id'), '=', DB::raw('c.id'))
            ->get();

        //echo $subs;
        //echo $all_active;
        //echo $all_subs;

        return view('subscription.pending-ar', ['all' => $subs, 'all_actv' => $all_active, 'all_subs' => $all_subs]);
    }
    public function subscribe(Request $request)
    {
        return view('subscription.subscriber', ['id' => $request->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('plans.index');
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
        $validatedData = $request->validate([
            'email' => 'required|unique:users',
        ]);
        // new res
        $new_rest = new Restaurant();
        $new_rest->rest_name = $request->rest_name;
        $new_rest->description = $request->description;
        $new_rest->ar_rest_name = $request->ar_rest_name;
        $new_rest->ar_description = $request->ar_description;
        $new_rest->country_id = $request->country_id;
        $new_rest->logo=$request->logo;
        $new_rest->thumbnail_logo=$request->thumbnail_logo;

        $new_rest->save();

        $rest_id = $new_rest->id;

        // new user
        $new_user = new User();
        $new_user->name = $request->username;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->role_id = 2;
        $new_user->rest_id = $rest_id;
        $new_user->ip_address = $_SERVER['REMOTE_ADDR'];
        $new_user->save();

        $count = Subscription::where('subscriptions.rest_id', '=', $new_rest->id)->first();
        $plan = PricePlan::find($request->plan_id)->first();
        $period = $plan->period;

        if (!($count)) {
            $period = $period * 2;
        }
        $st_date = Carbon::now()->toDateTimeString();
        $en_date = Carbon::now()->addDays($period)->toDateTimeString();

        // new subscription
        $subscription = new Subscription();
        $subscription->start_date = $st_date;
        $subscription->end_date = $en_date;
        $subscription->status = 1;
        $subscription->price_plan_id = $request->plan_id;
        $subscription->next_price_plan_id = $request->plan_id;
        $subscription->rest_id = $rest_id;

        $subscription->save();
        return redirect()->route('welcome');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function pending()
    {
        $subs = Subscription::select('subscriptions.id', 'subscriptions.start_date', 'subscriptions.end_date', 'subscriptions.rest_id', 'a.plan_name as current_plan', 'b.plan_name as next_plan', 'a.status', 'c.rest_name')
            ->join(DB::raw('price_plans  a'), DB::raw('subscriptions.price_plan_id'), '=', DB::raw('a.id'))
            ->join(DB::raw('price_plans  b'), DB::raw('subscriptions.next_price_plan_id'), '=', DB::raw('b.id'))
            ->join(DB::raw('restaurants  c'), DB::raw('subscriptions.rest_id'), '=', DB::raw('c.id'))
            ->whereRaw('subscriptions.price_plan_id != subscriptions.next_price_plan_id')
            ->where('subscriptions.status', '=', 1)
            ->get();

        $all_active = Subscription::select('subscriptions.id', 'subscriptions.start_date', 'subscriptions.end_date', 'subscriptions.rest_id', 'a.plan_name as current_plan', 'b.plan_name as next_plan', 'a.status', 'c.rest_name')
        ->join(DB::raw('price_plans  a'), DB::raw('subscriptions.price_plan_id'), '=', DB::raw('a.id'))
            ->join(DB::raw('price_plans  b'), DB::raw('subscriptions.next_price_plan_id'), '=', DB::raw('b.id'))
            ->join(DB::raw('restaurants  c'), DB::raw('subscriptions.rest_id'), '=', DB::raw('c.id'))
            ->where('subscriptions.status', '=', 1)
            ->get();

        $all_subs = Subscription::select('subscriptions.id', 'subscriptions.start_date', 'subscriptions.end_date', 'subscriptions.rest_id', 'a.plan_name as current_plan', 'b.plan_name as next_plan', 'a.status', 'c.rest_name')
        ->join(DB::raw('price_plans  a'), DB::raw('subscriptions.price_plan_id'), '=', DB::raw('a.id'))
            ->join(DB::raw('price_plans  b'), DB::raw('subscriptions.next_price_plan_id'), '=', DB::raw('b.id'))
            ->join(DB::raw('restaurants  c'), DB::raw('subscriptions.rest_id'), '=', DB::raw('c.id'))
            ->get();
            
        //echo $subs;
        //echo $all_active;
        //echo $all_subs;

        return view('subscription.pending', ['all' => $subs, 'all_actv' => $all_active, 'all_subs' => $all_subs]);
    }
}
