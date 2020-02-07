<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function productPackage(){
    	return $this->hasMany('App\Models\ProductPackage','product_id','id')->where('status',1);
    }
}
