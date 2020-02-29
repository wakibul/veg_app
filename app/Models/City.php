<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $guarded = ['id','token'];
    public function categoryCity(){
        return $this->belongsTo('App\Models\CategoryCity','city_id','id')->where('status',1);
    }
}
