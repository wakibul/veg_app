<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function orderTransactions(){
        return $this->hasMany(OrderTransaction::class);
    }
    public function timeSlot(){
        return $this->belongsTo('App\Models\TimeSlot','time_slot_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class);


    }

}
