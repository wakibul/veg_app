<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = ['id','token'];
    public function categoryCity(){
        return $this->hasMany('App\Models\CategoryCity','category_id','id')->where('status',1);
    }
    public function city(){
        return $this->hasManyThrough('App\Models\CategoryCity', 'App\Models\City');
    }
}
