<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::paginate(10);

        return view('admin.banner.create', compact('banners'));

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

        $path = public_path() . '/images/banner/';
        $imageName = date('dmyhis') . 'banner_image.' . $request->file('image')->getClientOriginalExtension();

        $request->file('image')->move($path, $imageName);
        $data = [
            'banner_image' => url('/public') . '/images/banner/' . $imageName,
        ];

        $banner = Banner::create($data);
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
        $banner = Banner::find($id);

        if ($banner->status == 1) {
            $status = 0;
        } else {
            $status = 1;

        }

        $banner->update(['status' => $status]);
        $banner->save();
        return Redirect::route('admin.banner.index')->with('success', 'Banner Image Status Updated successfully');

    }
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        Banner::findOrFail($id)->delete();
        return Redirect::route('admin.banner.index')->with('error', 'Banner Image Deleted Successfully');

    }
}
