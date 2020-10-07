<?php

namespace App\Http\Controllers;

use App\PricePlan;
use App\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PricePlanController extends Controller
{
    public static function getPlanTypeByRest_ar($id)
    {
        return (PricePlan::join('subscriptions', 'subscriptions.price_plan_id', '=', 'price_plans.id')->where('subscriptions.rest_id', '=', $id)
            ->where('subscriptions.status', '=', 1)
            ->get()->first())->plan_type;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar(Request $request)
    {
        // if admin display all
        $role = $request->session()->get('user_role');
        $plans = PricePlan::where('price_plans.status', '=', 1)->where('price_plans.plan_type', '=', 0)->get();
        if ($role == 'Administrator')
        $plans = PricePlan::where('price_plans.plan_type', '=', 0)->get();
        return view('plans.index-ar', ['plans' => $plans]);
    }

    public function index_internal_ar(Request $request)
    {
        // if admin display all
        $role = $request->session()->get('user_role');
        $plans = PricePlan::where('price_plans.status', '=', 1)->where('price_plans.plan_type', '=', 1)->get();
        if ($role == 'Administrator')
        $plans = PricePlan::where('price_plans.plan_type', '=', 1)->get();
        return view('plans.index_internal-ar', ['plans' => $plans]);
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
        $plan = new PricePlan();
        $plan->plan_name = $request->plan_name;
        $plan->ar_plan_name = $request->ar_plan_name;
        $plan->period = $request->period;
        $plan->price = $request->price;
        $plan->branch_count = $request->branch_count;
        $plan->country_id = $request->country_id;
        $plan->plan_type = $request->plan_type;

        $plan->save();
        return redirect()->route('plans.index-ar');
    }

    public function toggle_lock_ar($plan_id)
    {
        $plan = PricePlan::find($plan_id);
        if ($plan->status == 1)
            $plan->status = 0;
        else
            $plan->status = 1;
        $plan->save();
        return redirect()->route('plans.index-ar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function show_ar(PricePlan $pricePlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(PricePlan $pricePlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, PricePlan $pricePlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy_ar(PricePlan $pricePlan)
    {
        //
    }

    public function updgradePlan_ar($rest_id)
    {
        $plan_branch_count = Subscription::select('price_plans.branch_count')->join('price_plans', 'subscriptions.price_plan_id', '=', 'price_plans.id')
        ->where('subscriptions.status', '=', 1)
        ->where('subscriptions.rest_id', '=', $rest_id)->first();

        $plans = PricePlan::where('price_plans.branch_count', '>', $plan_branch_count)->get();
        return view('plans.upgrade-list-ar', ['rest_id' => $rest_id, 'plans' => $plans]);
    }

    public function change_ar($id, $rest_id)
    {
        $subscription = Subscription::select('subscriptions.rest_id', 'subscriptions.id')->where('subscriptions.rest_id', '=', $rest_id)
            ->where('subscriptions.status', '=', 1)->first();

        $current_subs = Subscription::find($subscription->id);
        $current_subs->next_price_plan_id = $id;
        $current_subs->save();

        $plan = PricePlan::where('price_plans.id', '=', $id)->first();
        $period = $plan->period;

        $st_date = Carbon::now()->toDateTimeString();
        $en_date = Carbon::now()->addDays($period)->toDateTimeString();


        // new subscription
        $new_subscription = new Subscription();
        $new_subscription->start_date = $st_date;
        $new_subscription->end_date = $en_date;
        $new_subscription->status = 0;
        $new_subscription->price_plan_id = $id;
        $new_subscription->next_price_plan_id = $id;
        $new_subscription->rest_id
            = $subscription->rest_id;

        $new_subscription->save();

        return redirect()->route('restaurants.active-ar');
    }


    public function activateUpgrade_ar($id, $rest_id)
    {
        // active sub
        $old_subscription = Subscription::select('subscriptions.rest_id', 'subscriptions.id', 'subscriptions.next_price_plan_id')
        ->where('subscriptions.rest_id', '=', $rest_id)
            ->where('subscriptions.status', '=', 1)->first();

        $current_subscription = Subscription::select('subscriptions.rest_id', 'subscriptions.id', 'subscriptions.next_price_plan_id')
        ->where('subscriptions.status', '=', 0)
        ->where('subscriptions.price_plan_id', '=', $old_subscription->next_price_plan_id)
            ->where('subscriptions.rest_id', '=', $rest_id)
            ->first();

        $current_subs = Subscription::find($current_subscription->id);
        $current_subs->status = 1;
        $current_subs->save();


        $new_subs = Subscription::find($id);
        $new_subs->status = 0;
        $new_subs->save();



        return redirect()->route('subs.pending-_ar');
    }

    public function switch_ar()
    {
        return view('subscription.switch-ar');
    }
    
    public static function getPlanTypeByRest($id){
        return (PricePlan::join('subscriptions','subscriptions.price_plan_id','=','price_plans.id')->
        where('subscriptions.rest_id','=',$id)
        ->where('subscriptions.status','=',1)
        ->get()->first())->plan_type;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if admin display all
        $role = $request->session()->get('user_role');
        $plans = PricePlan::where('price_plans.status', '=', 1)->where('price_plans.plan_type','=',0)->get();
        if ($role == 'Administrator')
            $plans = PricePlan::where('price_plans.plan_type', '=', 0)->get();
        return view('plans.index', ['plans' => $plans]);
    }

    public function index_internal(Request $request)
    {
        // if admin display all
        $role = $request->session()->get('user_role');
        $plans = PricePlan::where('price_plans.status', '=', 1)->where('price_plans.plan_type', '=', 1)->get();
        if ($role == 'Administrator')
        $plans = PricePlan::where('price_plans.plan_type', '=', 1)->get();
        return view('plans.index_internal', ['plans' => $plans]);
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
        $plan = new PricePlan();
        $plan->plan_name = $request->plan_name;
        $plan->ar_plan_name = $request->ar_plan_name;
        $plan->period = $request->period;
        $plan->price = $request->price;
        $plan->branch_count = $request->branch_count;
        $plan->country_id = $request->country_id;
        $plan->plan_type=$request->plan_type;

        $plan->save();
        return redirect()->route('plans.index');
    }

    public function toggle_lock($plan_id)
    {
        $plan = PricePlan::find($plan_id);
        if ($plan->status == 1)
            $plan->status = 0;
        else
            $plan->status = 1;
        $plan->save();
        return redirect()->route('plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function show(PricePlan $pricePlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function edit(PricePlan $pricePlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PricePlan $pricePlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PricePlan $pricePlan)
    {
        //
    }

    public function updgradePlan($rest_id)
    {
        $plan_branch_count = Subscription::select('price_plans.branch_count')->join('price_plans', 'subscriptions.price_plan_id', '=', 'price_plans.id')
            ->where('subscriptions.status', '=', 1)
            ->where('subscriptions.rest_id', '=', $rest_id)->first();

        $plans = PricePlan::where('price_plans.branch_count', '>', $plan_branch_count)->get();
        return view('plans.upgrade-list', ['rest_id' => $rest_id, 'plans' => $plans]);
    }

    public function change($id,$rest_id)
    {
        $subscription = Subscription::select('subscriptions.rest_id', 'subscriptions.id')->where('subscriptions.rest_id', '=', $rest_id)
            ->where('subscriptions.status', '=', 1)->first();

        $current_subs = Subscription::find($subscription->id);
        $current_subs->next_price_plan_id=$id;
        $current_subs->save();

        $plan = PricePlan::where('price_plans.id', '=', $id)->first();
        $period = $plan->period;

        $st_date = Carbon::now()->toDateTimeString();
        $en_date = Carbon::now()->addDays($period)->toDateTimeString();


        // new subscription
        $new_subscription = new Subscription();
        $new_subscription->start_date = $st_date;
        $new_subscription->end_date = $en_date;
        $new_subscription->status = 0;
        $new_subscription->price_plan_id = $id;
        $new_subscription->next_price_plan_id = $id;
        $new_subscription->rest_id
            = $subscription->rest_id;

        $new_subscription->save();

        return redirect()->route('restaurants.active');
    }


    public function activateUpgrade($id,$rest_id)
    {
        // active sub
        $old_subscription = Subscription::select('subscriptions.rest_id', 'subscriptions.id','subscriptions.next_price_plan_id')
        ->where('subscriptions.rest_id', '=', $rest_id)
            ->where('subscriptions.status', '=', 1)->first();

        $current_subscription = Subscription::select('subscriptions.rest_id', 'subscriptions.id', 'subscriptions.next_price_plan_id')
            ->where('subscriptions.status', '=', 0)
            ->where('subscriptions.price_plan_id','=', $old_subscription->next_price_plan_id)
            ->where('subscriptions.rest_id', '=', $rest_id)
            ->first();

        $current_subs = Subscription::find($current_subscription->id);
        $current_subs->status = 1;
        $current_subs->save();


        $new_subs = Subscription::find($id);
        $new_subs->status = 0;
        $new_subs->save();



       return redirect()->route('subs.pending');
    }

    public function switch(){
        return view('subscription.switch');
    }

}
