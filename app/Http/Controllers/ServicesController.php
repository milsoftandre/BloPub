<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = Services::settings();
        $sq = $request->all();
        $rows = Services::where(function ($q) use ($sq,$settings) {
            foreach ($sq as $key => $value) {
                if(in_array($key,$settings['table']) && $value){
                    $q->orWhere($key, 'like', "%{$value}%");
                }
            }
        })->orderByRaw('id DESC')->paginate($settings['pl']);

        return view('services.index', compact('rows', 'settings','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Services::settings();
        return view('services.create', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'text' => 'required',
            'name_en' => 'required',
            'text_en' => 'required',
        ]);


        Services::create($request->all());

        return redirect()->route('services.index')->with('success',__('services.delr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Services::settings();
        $model = Services::find($id);
        return view('services.edit',compact('model','settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Services::settings();
        $model = Services::find($id);
        return view('services.edit',compact('model','settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'text' => 'required',
            'name_en' => 'required',
            'text_en' => 'required',
        ]);


        $model = Services::find($id);
        $model->update($request->all());

        return redirect()->route('services.index')->with('success',__('services.upr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Services::find($id)->delete();

        return redirect()->route('services.index')
            ->with('success',__('services.dek'));
    }
}
