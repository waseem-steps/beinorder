<?php

namespace App\Http\Controllers;

use App\Country;
use App\Restaurant;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public static function countriesInter_ar()
    {
        $all_countries = Country::all();
        return $all_countries;
    }

    public static function getCountries_ar()
    {
        $all_countries = Country::all();
        return $all_countries;
    }


    public static function getCurrency_ar($rest_id)
    {

        $country = (Country::select('countries.ar_currency_symbol')->join('restaurants', 'countries.id', '=', 'restaurants.country_id')
        ->where('restaurants.id', '=', $rest_id)->groupBy()->first());
        return $country->ar_currency_symbol;
    }

    public static function getCurrencyByProductCategory_ar($cat_id)
    {
        $country = Country::select('countries.ar_currency_symbol')
        ->join('restaurants', 'countries.id', '=', 'restaurants.country_id')
        ->join('product_categories', 'restaurants.id', '=', 'product_categories.rest_id')
        ->where('product_categories.id', '=', $cat_id)
            ->groupBy()
            ->first();

        return $country->ar_currency_symbol;
    }

    public static function getCurrencyByProduct_ar($product_id)
    {
        $country = Country::select('countries.ar_currency_symbol')
        ->join('restaurants', 'countries.id', '=', 'restaurants.country_id')
        ->join('product_categories', 'restaurants.id', '=', 'product_categories.rest_id')
        ->join('products', 'product_categories.id', '=', 'products.product_cat_id')
        ->where('products.id', '=', $product_id)
            ->groupBy()
            ->first();

        return $country->ar_currency_symbol;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ar()
    {
        //
        $all_countries = Country::all();
        return view('country.index-ar', ['countries' => $all_countries]);
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
        $new_country = new Country();
        $new_country->country_name = $request->country_name;
        $new_country->country_code = $request->country_code;
        $new_country->country_currency = $request->country_currency;
        $new_country->currency_symbol = $request->currency_symbol;

        $new_country->ar_country_name = $request->ar_country_name;
        $new_country->ar_country_code = $request->ar_country_code;
        $new_country->ar_country_currency = $request->ar_country_currency;
        $new_country->ar_currency_symbol = $request->ar_currency_symbol;

        $new_country->int_code = $request->int_code;
        $new_country->save();
        return redirect()->route('countries.index-ar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show_ar(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit_ar(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update_ar(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function delete_ar($id)
    {
        //
        $country = Country::find($id);
        $country->delete();
        return redirect()->route('countries.index-ar');
    }
    public static function countriesInter(){
        $all_countries = Country::all();
        return $all_countries;
    }

    public static function getCountries()
    {
        $all_countries = Country::all();
        return $all_countries;
    }


    public static function getCurrency($rest_id){

        $country=(Country::select('countries.currency_symbol')->join('restaurants','countries.id','=','restaurants.country_id')
        ->where('restaurants.id','=',$rest_id)->groupBy()->first());
        return $country->currency_symbol;



    }

    public static function getCurrencyByProductCategory($cat_id)
    {
        $country = Country::select('countries.currency_symbol')
        ->join('restaurants', 'countries.id', '=', 'restaurants.country_id')
        ->join('product_categories','restaurants.id','=','product_categories.rest_id')
        ->where('product_categories.id', '=', $cat_id)
        ->groupBy()
        ->first();

        return $country->currency_symbol;
    }

    public static function getCurrencyByProduct($product_id)
    {
        $country = Country::select('countries.currency_symbol')
        ->join('restaurants', 'countries.id', '=', 'restaurants.country_id')
        ->join('product_categories', 'restaurants.id', '=', 'product_categories.rest_id')
        ->join('products', 'product_categories.id','=','products.product_cat_id')
        ->where('products.id', '=', $product_id)
            ->groupBy()
            ->first();

        return $country->currency_symbol;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all_countries=Country::all();
        return view ('country.index',['countries'=>$all_countries]);
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
        $new_country =new Country();
        $new_country->country_name=$request->country_name;
        $new_country->country_code = $request->country_code;
        $new_country->country_currency = $request->country_currency;
        $new_country->currency_symbol = $request->currency_symbol;

        $new_country->ar_country_name = $request->ar_country_name;
        $new_country->ar_country_code = $request->ar_country_code;
        $new_country->ar_country_currency = $request->ar_country_currency;
        $new_country->ar_currency_symbol = $request->ar_currency_symbol;

        $new_country->int_code = $request->int_code;
        $new_country->save();
        return redirect()->route('countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $country=Country::find($id);
        $country->delete();
        return redirect()->route('countries.index');
    }
}
