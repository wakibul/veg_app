<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    protected $guarded = ['id', 'token'];
    protected $fillable = ['id', 'picture', 'type', 'status'];
    use SoftDeletes;

}
