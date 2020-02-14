<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeTransaction;
use Illuminate\Http\Request;

class settlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(10);

        return view('admin.settlement.index', compact('employees'));
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

        foreach ($request->employee_transactions as $key => $employee_transaction) {
            $employee_transaction = EmployeeTransaction::find($employee_transaction);
            $data = [
                'status' => 2,

            ];
            $employee_transaction->update($data);
            $employee_transaction->save();

        }
        $employee_transactions = EmployeeTransaction::where("employee_id", $request->employee_id)->get();

        $employee_transaction_settlements = EmployeeTransaction::where("employee_id", $request->employee_id)->where('status', 2)->get();
        $paid = 0;
        $total = 0;
        foreach ($employee_transactions as $employee_transaction) {
            $total = $total + ($employee_transaction->amount);
        }
        foreach ($employee_transaction_settlements as $employee_transaction_settlement) {
            $paid = $paid + ($employee_transaction_settlement->amount);
        }
        $updated_balance = $total - $paid;
        $employee = Employee::find($request->employee_id);
        $data = [
            'updated_balance' => $updated_balance,

        ];
        $employee->update($data);
        $employee->save();

        return redirect()->back()->with('success', 'Updated successfully');

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
}
