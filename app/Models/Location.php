<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Pincode;

class Location extends Model
{
     public function pincodes()
    {

        return $this->belongsToMany(Pincode::Class);
    }
}
