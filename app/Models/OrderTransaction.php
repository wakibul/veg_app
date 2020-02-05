<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function product(){
		return $this->belongsTo('App\Models\Product', 'product_id','id');
    }

    public function productPackage(){
		return $this->belongsTo('App\Models\ProductPackage', 'product_package_id','id');
    }

    public function order(){
		return $this->belongsTo('App\Models\Order', "order_id", "id");
    }
}
