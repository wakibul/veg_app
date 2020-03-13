<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    //
    protected $guarded = ['id','token'];
    protected $hidden = ['created_at','updated_at','deleted_at'];
}
