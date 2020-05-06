<?php

namespace App\Models;

use App\Models\OrderTransaction;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id', 'token'];

    public function orderTransactions()
    {
        return $this->hasMany(OrderTransaction::class);
    }
    public function timeSlot()
    {
        return $this->belongsTo('App\Models\TimeSlot', 'time_slot_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderTransaction()
    {
        return $this->hasMany(OrderTransaction::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

}
