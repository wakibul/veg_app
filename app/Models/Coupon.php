<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ['id', 'token'];
    protected $fillable = ['name', 'coupon_code', 'coupon_in', 'coupon_value', 'coupon_type', 'max_coupon_use', 'is_active', 'valid_to', 'is_subscribed', 'minimun_amount'];
    public function miscellaneousMaster()
    {
        return $this->belongsTo(MiscellaneousMaster::where('type','=','coupon_type'));
    }

}
