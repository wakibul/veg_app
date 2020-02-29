<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function product(){
    	return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function productPackage(){
    	return $this->hasMany('App\Models\ProductPackage','id','product_package_id');
    }
}
