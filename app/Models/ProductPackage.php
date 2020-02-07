<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPackage extends Model
{
    //
    public function packageMaster(){
    	return $this->belongsTo('App\Models\PackageMaster','package_masters_id','id')->where('status',1);
    }


}
