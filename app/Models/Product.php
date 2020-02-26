<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $guarded = ['id', 'token'];
    protected $fillable = ['name','details','unit_desc','category_id','large_picture','small_picture','status','is_available','is_subscribed','is_product'];
    use SoftDeletes;

    public function productPackage()
    {
        return $this->hasMany('App\Models\ProductPackage', 'product_id', 'id')->where('status',1)->withTrashed();
    }
     public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function defultPackage(){
        return $this->belongsTo('App\Models\ProductPackage','default_package','id');

    }
}
