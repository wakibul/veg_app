<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Admin::where('type','!=','1')->paginate(10);

        return view('admin.user.create', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            try {
                $data=[
                    "name"=>$request->name,
                    "username"=>$request->username,
                    "email"=>$request->email,
                    //password=lf@123
                    "type"=> "2",
                    "status"=> "1",
                    "password"=>bcrypt("lf@123"),
                ];
                $user=Admin::create($data);
                return Redirect::route('admin.user.index')->with('success', 'User Assigned Successfully');
                } catch (\Throwable $e) {
                    DB::rollback();
                    dd($e);
                    Session::flash('error', 'Something Went Wrong');
                    return back();
                 }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function status($id)
    {

        $id = Crypt::decrypt($id);
        $user = Admin::find($id);

        if ($user->status == 1) {
            $status = 0;
        } else {
            $status = 1;

        }

        $user->update(['status' => $status]);
        $user->save();
        return Redirect::route('admin.user.index')->with('success', 'User Status Updated successfully');

    }
}
