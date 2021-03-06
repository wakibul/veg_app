<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTransaction extends Model
{
    use SoftDeletes;
    protected $guarded = ['id','token'];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
     public function order(){
        return $this->belongsTo(Order::class);
    }
}
