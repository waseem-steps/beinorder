<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    public function restaurants(){
        return $this->hasMany('App\Restaurant');
    }

    public function price_plans(){
        return $this->hasMany('App\PricePlan');
    }
}
