<?php

namespace App\Http\Controllers;

use App\Models\BannerApp;
use App\Models\Course;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function startApp(){
        $data = array(
            'banners' => BannerApp::all(),
        );
        return response()->json($data);
    }
    public function index()
    {
         
        $data = array(
            'banners' => BannerApp::all(),
        );

        return view('banner.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=array(
            'user' => auth()->user(),
        );
        return view('banner.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bannerApp = new BannerApp();
        $bannerApp->description=$request->description;
        $bannerApp->icon = $request->icon;
        $bannerApp->save();

        $request->session()->flash('activity', 'Banner adicionado');
        return redirect()->to('/admin/banner');

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
        $banner = BannerApp::findOrFail($id);
       
        $banner->delete($id);
        session()->flash('activity', 'Banner apagado com sucesso');

        return redirect('/admin/banner');
    }
}
