<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function orderTransaction(){
        return $this->hasMany('App\Models\OrderTransaction');
    }
    public function timeSlot(){
        return $this->belongsTo('App\Models\TimeSlot','time_slot_id','id');
    }
}
