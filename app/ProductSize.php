<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    //
    public function product(){
        return $this->belongsTo('App\Product');
    }
}
