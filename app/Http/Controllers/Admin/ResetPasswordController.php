<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DB;
class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('admin.auth.passwords.reset');

    }
    public function update(Request $request){
        $password=bcrypt($request->pass);
        
      $admin= DB::table('admins')->where('id',1);
      $data=[
          'password'=>$password,
      ];
      $admin->update($data);
     
    return Redirect::back()->with('success', 'Password update successfully');

    }

}
