<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\packageMaster;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Validator;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = packageMaster::paginate(10);

        return view('admin.unit.create', compact('units'));

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
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $data = ['name' => $request->name,
                'status' => $request->status,

            ];
            packageMaster::create($data);
            return Redirect::route('admin.unit.index')->with('success', 'Unit added successfully');

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
        $unit = packageMaster::find($id);

        $units = packageMaster::paginate(10);

        return view('admin.unit.edit', compact('units', 'unit'));

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
        $unit = packageMaster::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $data = ['name' => $request->name,
                'status' => $request->status,

            ];
            $unit->update($data);
            $unit->save();
            return Redirect::route('admin.unit.index')->with('success', 'Unit updated successfully');

        } catch (Exception $e) {
            DB::rollback();
            dd($e);

            return back()->with('error', 'Something Went Wrong');

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
        dd($id);
        $id = Crypt::decrypt($id);
        packageMaster::findOrFail($id)->delete();
        return Redirect::route('admin.unit.index')->with('Error', 'Unit deleted successfully');

    }
}
