<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiscellaneousMaster extends Model
{
    protected $guarded = ['id', 'token'];
    protected $fillable = ['master_value','type','status'];
}
