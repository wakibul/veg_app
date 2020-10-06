<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPackage extends Model
{
    use SoftDeletes;
    protected $fillable = ['skucode','product_id','package_masters_id','market_price','offer_price','offer_percentage','is_offer','status'];
    public function packageMaster(){
    	return $this->belongsTo('App\Models\PackageMaster','package_masters_id','id')->where('status',1);
    }

    public function cart(){
    	return $this->belongsTo('App\Models\cart','id','product_package_id');
    }
}
