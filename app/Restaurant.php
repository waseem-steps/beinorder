<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    //
    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function branches(){
        return $this->hasMany('App\Branch');;
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }
}
