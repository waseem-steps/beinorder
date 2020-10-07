<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function productCategory(){
        return $this->belongsTo('App\ProductCategory');
    }

    public function productType()
    {
        return $this->belongsTo('App\ProductType');
    }

    public function extras(){
        return $this->hasMany('App\ProductExtra');
    }

    public function productSizes(){
        return $this->hasMany('App\ProductSize');
    }
}
