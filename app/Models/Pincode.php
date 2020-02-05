<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use location;

class Pincode extends Model
{
    //
    public function locations()
    {
        # code...
        return $this->belongsToMany(Location::Class);
    }
}
