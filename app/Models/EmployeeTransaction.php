<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTransaction extends Model
{
    //
    protected $guarded = ['id','token'];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
     public function order(){
        return $this->belongsTo(Order::class);
    }
}
