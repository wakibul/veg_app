<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPackage extends Model
{
    protected $fillable = ['skucode','product_id','package_masters_id','market_price','offer_price','offer_percentage','is_offer','status'];
    public function packageMaster(){
    	return $this->belongsTo('App\Models\PackageMaster','package_masters_id','id')->where('status',1);
    }


}
