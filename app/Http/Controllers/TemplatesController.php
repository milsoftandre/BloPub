<?php

namespace App\Http\Controllers;

use App\Models\Templates;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = Templates::settings();
        $sq = $request->all();
        $rows = Templates::where(function ($q) use ($sq,$settings) {
            foreach ($sq as $key => $value) {
                if(in_array($key,$settings['table']) && $value){
                    $q->orWhere($key, 'like', "%{$value}%");
                }
            }
        })->orderByRaw('id DESC')->paginate($settings['pl']);

        return view('templates.index', compact('rows', 'settings','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Templates::settings();
        return view('templates.create', compact('settings'));
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

        ]);
        $request->merge(['password' => bcrypt($request->password)]);

        Templates::create($request->all());

        return redirect()->route('templates.index')->with('success',__('templates.delr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Templates::settings();
        $model = Templates::find($id);
        return view('templates.edit',compact('model','settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Templates::settings();
        $model = Templates::find($id);
        return view('templates.edit',compact('model','settings'));
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
        ]);


        $model = Templates::find($id);
        $model->update($request->all());

        return redirect()->route('templates.index')->with('success',__('templates.upr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Templates::find($id)->delete();

        return redirect()->route('templates.index')
            ->with('success',__('templates.dek'));
    }
}
