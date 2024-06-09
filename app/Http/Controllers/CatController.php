<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = Cat::settings();
        $sq = $request->all();
        $rows = Cat::where(function ($q) use ($sq,$settings) {
            foreach ($sq as $key => $value) {
                if(in_array($key,$settings['table']) && $value){
                    $q->orWhere($key, 'like', "%{$value}%");
                }
            }
        })->orderByRaw('id DESC')->paginate($settings['pl']);

        return view('cat.index', compact('rows', 'settings','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Cat::settings();
        return view('cat.create', compact('settings'));
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
            'name_en' => 'required',

        ]);
        $request->merge(['password' => bcrypt($request->password)]);

        Cat::create($request->all());

        return redirect()->route('cat.index')->with('success',__('cat.delr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Cat::settings();
        $model = Cat::find($id);
        return view('cat.edit',compact('model','settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Cat::settings();
        $model = Cat::find($id);
        return view('cat.edit',compact('model','settings'));
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
            'name_en' => 'required',
        ]);


        $model = Cat::find($id);
        $model->update($request->all());

        return redirect()->route('cat.index')->with('success',__('cat.upr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Cat::find($id)->delete();

        return redirect()->route('cat.index')
            ->with('success',__('cat.dek'));
    }
}
