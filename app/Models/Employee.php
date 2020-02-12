<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = ['id', 'token'];

    public static $default_password = 'employee@veg_app';
    public function employeeTransactions(){
        return $this->hasMany(EmployeeTransaction::class);
    }

}
