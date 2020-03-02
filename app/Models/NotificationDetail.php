<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationDetail extends Model
{
    protected $guarded = ['id', 'token'];
     protected $fillable = ['id','notification_id','customer_id','created_at','updated_at'];
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
