<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $guarded = ['id','token'];
    protected $fillable = ['id','name','address','pincode','mobile','document','updated_balance','password','token'];

    public static $default_password = 'employee@veg_app';
    public function employeeTransactions(){
        return $this->hasMany(EmployeeTransaction::class);
    }
    public function employeePaidTransactions(){
        return $this->hasMany(EmployeeTransaction::class)->where('status',2);
    }
    public function employeeUnpaidTransactions(){
        return $this->hasMany(EmployeeTransaction::class)->where('status', 1);

    }

}
