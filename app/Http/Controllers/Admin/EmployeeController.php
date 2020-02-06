<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use DB;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(10);

        return view('admin.employee.create', compact('employees'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'address' => 'required',
            'pin' => 'required',
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $data = ['name' => $request->name,
                'address' => $request->address,
                'pincode' => $request->pin,
                'mobile' => $request->mobile,
                'password' => bcrypt(Employee::$default_password),

            ];
            Employee::create($data);
            return Redirect::route('admin.employee.index')->with('success', 'Unit added successfully');

        } catch (Exception $e) {
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
        $id = Crypt::decrypt($id);
        $employee = employee::find($id);

        $employees = employee::paginate(10);

        return view('admin.employee.edit', compact('employees', 'employee'));

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
        $id = Crypt::decrypt($id);
        $employee = Employee::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'pin' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $data = ['name' => $request->name,
                'address' => $request->address,
                'pincode' => $request->pin,
                'mobile' => $request->mobile,

            ];
            $employee->update($data);
            $employee->save();
            return Redirect::route('admin.employee.index')->with('success', 'Employee updated successfully');

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            Session::flash('error', 'Something Went Wrong');
            return back();

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        Employee::findOrFail($id)->delete();

        return back()->with('error', 'Employeee Deleted Successfully');

    }
}
