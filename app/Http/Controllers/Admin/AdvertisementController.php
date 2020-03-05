<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Crypt,Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::where('type',1)->paginate(10);

        return view('admin.advertisement.create', compact('advertisements'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,jpg,png|',
        ]);

        $path = public_path() . '/images/';
        $imageName = date('dmyhis') . 'banner_image.' . $request->file('image')->getClientOriginalExtension();

        $request->file('image')->move($path, $imageName);
        $data = [
            'picture' => url('/public') . $imageName,
        ];

        $advertisement = Advertisement::create($data);
        return Redirect::back()->with('success', 'Image added successfully');

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

    public function status($id)
    {

        $id = Crypt::decrypt($id);
        $advertisement = Advertisement::find($id);

        if ($advertisement->status == 1) {
            $status = 0;
        } else {
            $status = 1;

        }
        $advertisement->update(['status' => $status]);

        $advertisement->save();

        return Redirect::route('admin.footer-banner.index')->with('success', 'Footer Banner Status Updated successfully');

    }
    public function destroy($id)
    {

        $id = Crypt::decrypt($id);
        $Advertisement = Advertisement::findOrFail($id)->delete();

        Session::flash('error', 'Footer banner successfully Deleted');
        return back();
    }

}
