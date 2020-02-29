<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryCity extends Model
{
    //
    protected $guarded = ['id','token'];
    public function category(){
        return $this->belongsTo("App\Models\Category","category_id","id")->where('parent_id',null);
    }
    public function city(){
        return $this->belongsTo('App\Models\City','city_id','id')->where('status',1);
    }
}
