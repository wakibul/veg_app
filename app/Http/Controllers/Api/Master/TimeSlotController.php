<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Models\Category;
use Facade\FlareClient\Time\Time;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $cur_time = date('H:i', strtotime('+1 hour'));
	    $date = date('Y-m-d');
        $categories = json_decode($request->category_array);
        $category = Category::where([['status',1],['name','Fish']])->first();
        if($category != null){
	    foreach ($categories as $key => $val) {
	    	foreach ($val as $key => $newval) {
		       	if($newval->category_id == $category->id){
		       		if($cur_time >= "19:00")
		       			$date = date('Y-m-d', strtotime($date. ' + 2 days'));
		       		else
		       			$date = date('Y-m-d', strtotime($date. ' + 1 days'));
		       		
		       		$timeslot = TimeSlot::select('id','from','to','slot')->where('status',1)->where('id',1)->get();
		       		return response()->json(['success'=>true,'timeslot'=>$timeslot,'date'=>$date]);
		       		
		       	}
			}
	    }
        }   	
	    $timeslot = TimeSlot::select('id','from','to','slot')->where('status',1)->whereTime('from','>', $cur_time)->get();
	        if(!$timeslot->isEmpty()){
	            return response()->json(['success'=>true,'timeslot'=>$timeslot,'date'=>$date]);
	        }
	        else{
	            $timeslot = TimeSlot::select('id','from','to','slot')->where('status',1)->get();
	            $date = date('Y-m-d', strtotime($date. ' + 1 days'));
	            return response()->json(['success'=>true,'timeslot'=>$timeslot,'date'=>$date]);
	        }
   		 


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
        //
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
