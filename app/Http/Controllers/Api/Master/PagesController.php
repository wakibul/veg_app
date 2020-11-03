<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\MiscellaneousMaster;
class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contents = Content::where('status',1)->get();
        if(!$contents->isEmpty())
            return response()->json(['success'=>true,'contents'=>$contents]);
        else
            return response()->json(['success'=>false,'message'=>'No record found']);

    }

    public function toEmail()
    {

        $email = MiscellaneousMaster::where('type','email')->first();
        $contact = MiscellaneousMaster::where('type','contact')->first();
        $whatsapp = MiscellaneousMaster::where('type','whatsapp')->first();
        if($email)
            return response()->json(['success'=>true,'to_email'=>$email->master_value,'contact'=>$contact->master_value,'whatsapp'=>$whatsapp->master_value]);
        else
            return response()->json(['success'=>false,'error'=>'Email does not exist']);

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
