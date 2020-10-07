<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Branch;
use App\Restaurant;
use App\Subscription;
use App\User;
use App\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class BranchController extends Controller
{
    public static function getBranches($id)
    {
        //
        $branches = Branch::where('rest_id', '=', $id)->where('branches.status','=',1)->get();
        return $branches;
    }

    public static function getRestName()
    {
        //
        $rest=Restaurant::where('restaurants.id','=', session()->get('rest_id'))->groupBy()->first();
        return $rest->rest_name;
    }

    public static function getBranchName()
    {
        //
        $branches = Branch::where('branches.id', '=', session()->get('ip_branch'))->groupBy()->first();
        return $branches->branch_name;
    }

    public static function getOrderBranchName($id)
    {
        //
        $branches = Order::select('branches.branch_name')->join('branches','orders.branch_id','=','branches.id')->where('orders.id', '=', $id)->groupBy()->first();
        return $branches->branch_name;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $branches= Branch::where('rest_id','=',$id)->get();
        $rest = Restaurant::find($id);
        return view('branch.index',['branches'=>$branches,'rest'=>$rest]);

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

    public function select_branch(Request $request){
		
		

        $request->session()->put('ip_branch',$request->branch_id);

        $request->session()->put('rest_id', $request->rest_id);
		
		//dd($request);
        return redirect()->route('product-categories.rest-cat',['id'=>$request->rest_id]);
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
        $validatedData = $request->validate([
            'email' => 'required|unique:users',
        ]);
        $new_branch=new Branch();
        $new_branch->branch_name=$request->branch_name;
        $new_branch->phone_number=$request->phone_number;
        $new_branch->email=$request->email;
        $new_branch->address=$request->address;
        $new_branch->rest_id=$request->rest_id;
        $new_branch->ar_branch_name = $request->ar_branch_name;
        $new_branch->ar_address = $request->ar_address;
        $new_branch->save();

        $new_user = new User();
        $new_user->name = $request->username;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->role_id = 3;
        $new_user->rest_id = $request->rest_id;
        $new_user->branch_id=$new_branch->id;
        $new_user->ip_address = $_SERVER['REMOTE_ADDR'];
        $new_user->save();

        return redirect()->route('branches.index',['id'=>$request->rest_id]);
    }

    public static function canAddBranch($rest_id){
        $plan_branch_count=Subscription::
        select('price_plans.branch_count')->
        join('price_plans','subscriptions.price_plan_id','=', 'price_plans.id')
        ->where('subscriptions.status','=',1)
        ->where('subscriptions.rest_id','=',$rest_id)->first();

        $act_branch_count=Branch::select(DB::raw('count(*) branch_count'))->where('rest_id','=',$rest_id)->first();


        if($plan_branch_count->branch_count> $act_branch_count->branch_count)
        return true;
        else
        return false;

    }

    public function store_branch_admin(Request $request)
    {
        //
        /* $new_branch = new Branch();

        BranchController::getBranchByName($rest_id, $branch_name);

        $new_user = new User();
        $new_user->name = $request->username;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->role_id = 3;
        $new_user->rest_id = $request->rest_id;
        $new_user->branch_id = $new_branch->id;
        $new_user->ip_address = $_SERVER['REMOTE_ADDR'];
        $new_user->save();

        return redirect()->route('branches.index', ['id' => $request->rest_id]); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $branch = Branch::find($id);
        return view('branch.edit', ['branch' => $branch]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $new_branch=Branch::find($id);
        $new_branch->branch_name = $request->branch_name;
        $new_branch->ar_branch_name = $request->ar_branch_name;
        $new_branch->phone_number = $request->phone_number;
        $new_branch->email = $request->email;
        $new_branch->address = $request->address;
        $new_branch->ar_address = $request->ar_address;
        $new_branch->save();
        return redirect()->route('branches.index', ['id' => $new_branch->rest_id]);
    }

    public function adminEdit($id){
        $admin=User::find($id);
        return view('branch.branch_admin_edit',['admin'=>$admin]);
    }

    public function adminUpdate(Request $request,$id)
    {
        $admin = User::find($id);
        $admin->name=$request->username;
        $admin->email=$request->email;
        $admin->password= Hash::make($request->password);

        $admin->save();

        $admin1=User::where('users.branch_id','=', $admin->branch_id)->groupBy()->first();

        return redirect()->route('branch.admins',['id'=> $admin1->branch_id]);
    }

    public function adminDelete($id){
        $admin = User::find($id);
        $admin1 = User::where('users.id', '=', $id)->groupBy()->first();
        $admin->delete();

        return redirect()->route('branch.admins', ['id' => $admin1->branch_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $branch=Branch::find($id);
        $branch->delete();

        $users = User::where('users.branch_id', '=', $id)->get();
        foreach ($users as $user) {
            $b = User::find($user->id);
            $b->delete();
        }
        return redirect()->route('branches.index', ['id' => $branch->rest_id]);
    }

    public function unlock($id)
    {
        $branch = Branch::find($id);
        $branch->status = 1;
        $branch->save();
        return redirect()->route('branches.index', ['id' => $branch->rest_id]);
    }

    public function lock($id)
    {
        $branch = Branch::find($id);
        $branch->status = 0;
        $branch->save();
        return redirect()->route('branches.index', ['id' => $branch->rest_id]);
    }

    public function generateQrExternal($id)
    {
        /*   $branch = Branch::find($id);
        $rest_url = Route('branch.details', $id);
            $qr = \QrCode::format('png')
            ->size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);


        return view('branch.qrcode', ['qr' => $qr]); */
        $branch = Branch::find($id);
        $rest_url = Route('branch.details', $id);
        $qr = \QrCode::size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);

        $image = \QrCode::format('png')

        ->size(500)->errorCorrection('H')
            ->generate($rest_url);
        return response($image)->header('Content-type', 'image/png');


        return view('branch.qrcode', ['qr' => $qr, 'id' => $id, 'image' => $image]);
    }

    public function qr($id){
        $image = \QrCode::format('png')
            /* ->merge(asset('images\\').'t.jpg', 0.1, true) */
            ->size(200)->errorCorrection('H')
            ->generate('A simple example of QR code!');
        return view('branch.qrcode', ['qr' => $qr]);
    }


    public static function getBranchByName($rest_id,$branch_name){
        $branch=Branch::join('restaurants','restaurants.id','=','branches.rest_id')->where('restaurants.id','=',$rest_id)
        ->where('branches.branch_name','=',$branch_name)->first();
        return $branch;
    }

    public static function getBranchesByRestId($rest_id)
    {
        $branch = Branch::where('branches.rest_id','=',$rest_id)->get();
        return $branch;
    }

    public static function getBranches_ar($id)
    {
        //
        $branches = Branch::where('rest_id', '=', $id)->where('branches.status', '=', 1)->get();
        return $branches;
    }

    public static function getRestName_ar()
    {
        //
        $rest = Restaurant::where('restaurants.id', '=', session()->get('rest_id'))->groupBy()->first();
        return $rest->ar_rest_name;
    }

    public static function getBranchName_ar()
    {
        //
        $branches = Branch::where('branches.id', '=', session()->get('ip_branch'))->groupBy()->first();
        return $branches->ar_branch_name;
    }

    public static function getOrderBranchName_ar($id)
    {
        //
        $branches = Order::select('branches.ar_branch_name')->join('branches', 'orders.branch_id', '=', 'branches.id')->where('orders.id', '=', $id)->groupBy()->first();
        return $branches->ar_branch_name;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar($id)
    {
        //
        $branches = Branch::where('rest_id', '=', $id)->get();
        $rest = Restaurant::find($id);
        return view('branch.index-ar', ['branches' => $branches, 'rest' => $rest]);
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

    public function select_branch_ar(Request $request)
    {



        $request->session()->put('ip_branch', $request->branch_id);

        $request->session()->put('rest_id', $request->rest_id);

        //dd($request);
        return redirect()->route('product-categories.rest-cat-ar', ['id' => $request->rest_id]);
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
        $validatedData = $request->validate([
            'email' => 'required|unique:users',
        ]);
        $new_branch = new Branch();
        $new_branch->branch_name = $request->branch_name;
        $new_branch->phone_number = $request->phone_number;
        $new_branch->email = $request->email;
        $new_branch->address = $request->address;
        $new_branch->rest_id = $request->rest_id;
        $new_branch->ar_branch_name = $request->ar_branch_name;
        $new_branch->ar_address = $request->ar_address;
        $new_branch->save();

        $new_user = new User();
        $new_user->name = $request->username;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->role_id = 3;
        $new_user->rest_id = $request->rest_id;
        $new_user->branch_id = $new_branch->id;
        $new_user->ip_address = $_SERVER['REMOTE_ADDR'];
        $new_user->save();

        return redirect()->route('branches.index-ar', ['id' => $request->rest_id]);
    }

    public static function canAddBranch_ar($rest_id)
    {
        $plan_branch_count = Subscription::select('price_plans.branch_count')->join('price_plans', 'subscriptions.price_plan_id', '=', 'price_plans.id')
            ->where('subscriptions.status', '=', 1)
            ->where('subscriptions.rest_id', '=', $rest_id)->first();

        $act_branch_count = Branch::select(DB::raw('count(*) branch_count'))->where('rest_id', '=', $rest_id)->first();


        if ($plan_branch_count->branch_count > $act_branch_count->branch_count)
            return true;
        else
            return false;
    }

    public function store_branch_admin_ar(Request $request)
    {
        //
        /* $new_branch = new Branch();

        BranchController::getBranchByName($rest_id, $branch_name);

        $new_user = new User();
        $new_user->name = $request->username;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->role_id = 3;
        $new_user->rest_id = $request->rest_id;
        $new_user->branch_id = $new_branch->id;
        $new_user->ip_address = $_SERVER['REMOTE_ADDR'];
        $new_user->save();

        return redirect()->route('branches.index', ['id' => $request->rest_id]); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit_ar($id)
    {
        //
        $branch = Branch::find($id);
        return view('branch.edit-ar', ['branch' => $branch]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, $id)
    {
        //
        $new_branch = Branch::find($id);
        $new_branch->branch_name = $request->branch_name;
        $new_branch->ar_branch_name = $request->ar_branch_name;
        $new_branch->phone_number = $request->phone_number;
        $new_branch->email = $request->email;
        $new_branch->address = $request->address;
        $new_branch->ar_address = $request->ar_address;
        $new_branch->save();
        return redirect()->route('branches.index-ar', ['id' => $new_branch->rest_id]);
    }

    public function adminEdit_ar($id)
    {
        $admin = User::find($id);
        return view('branch.branch_admin_edit-ar', ['admin' => $admin]);
    }

    public function adminUpdate_ar(Request $request, $id)
    {
        $admin = User::find($id);
        $admin->name = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);

        $admin->save();

        $admin1 = User::where('users.branch_id', '=', $admin->branch_id)->groupBy()->first();

        return redirect()->route('branch.admins-ar', ['id' => $admin1->branch_id]);
    }

    public function adminDelete_ar($id)
    {
        $admin = User::find($id);
        $admin1 = User::where('users.id', '=', $id)->groupBy()->first();
        $admin->delete();

        return redirect()->route('branch.admins-ar', ['id' => $admin1->branch_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        //
        $branch = Branch::find($id);
        $branch->delete();

        $users = User::where('users.branch_id', '=', $id)->get();
        foreach ($users as $user) {
            $b = User::find($user->id);
            $b->delete();
        }
        return redirect()->route('branches.index-ar', ['id' => $branch->rest_id]);
    }

    public function unlock_ar($id)
    {
        $branch = Branch::find($id);
        $branch->status = 1;
        $branch->save();
        return redirect()->route('branches.index-ar', ['id' => $branch->rest_id]);
    }

    public function lock_ar($id)
    {
        $branch = Branch::find($id);
        $branch->status = 0;
        $branch->save();
        return redirect()->route('branches.index-ar', ['id' => $branch->rest_id]);
    }

    public function generateQrExternal_ar($id)
    {
        /*   $branch = Branch::find($id);
        $rest_url = Route('branch.details', $id);
            $qr = \QrCode::format('png')
            ->size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);


        return view('branch.qrcode', ['qr' => $qr]); */
        $branch = Branch::find($id);
        $rest_url = Route('branch.details', $id);
        $qr = \QrCode::size(250)
            ->backgroundColor(255, 255, 204)
            ->generate($rest_url);

        $image = \QrCode::format('png')

            ->size(500)->errorCorrection('H')
            ->generate($rest_url);
        return response($image)->header('Content-type', 'image/png');


        return view('branch.qrcode-ar', ['qr' => $qr, 'id' => $id, 'image' => $image]);
    }

    public function qr_ar($id)
    {
        $image = \QrCode::format('png')
            /* ->merge(asset('images\\').'t.jpg', 0.1, true) */
            ->size(200)->errorCorrection('H')
            ->generate('A simple example of QR code!');
        return view('branch.qrcode-ar', ['qr' => $qr]);
    }


    public static function getBranchByName_ar($rest_id, $branch_name)
    {
        $branch = Branch::join('restaurants', 'restaurants.id', '=', 'branches.rest_id')->where('restaurants.id', '=', $rest_id)
            ->where('branches.ar_branch_name', '=', $branch_name)->first();
        return $branch;
    }

    public static function getBranchesByRestId_ar($rest_id)
    {
        $branch = Branch::where('branches.rest_id', '=', $rest_id)->get();
        return $branch;
    }

}
