<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTransaction extends Model
{
    //
    use SoftDeletes;
    protected $guarded  = ['id','token'];
    public function product(){
		return $this->belongsTo('App\Models\Product', 'product_id','id')->withTrashed();
    }

    public function productPackage(){
		return $this->belongsTo('App\Models\ProductPackage', 'product_package_id','id')->withTrashed();
    }

    public function order(){
		return $this->belongsTo('App\Models\Order', "order_id", "id")->withTrashed();
    }
}
