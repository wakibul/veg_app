<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $guarded = ['id','token'];
    protected $fillable = ['id','uuid','notification_msg','created_at','updated_at'];


    public function notificationDetails(){
        return $this->hasMany(NotificationDetail::class);
    }
}
