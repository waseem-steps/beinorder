<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    //
    public function restaurant(){
        return $this->belongsTo('App\Restaurant');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function orderType(){
        return $this->belongsTo('App\OrderType');
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus');
    }

}
