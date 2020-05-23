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
        return $this->hasMany(OrderTransaction::class,'order_id','id');
    }
    public function timeSlot()
    {
        return $this->belongsTo('App\Models\TimeSlot', 'time_slot_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'user_id','id');
    }

}
