<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = Group::settings();
        $sq = $request->all();

        if (Auth::user()->type=='1'){
            $rows = Group::where('employees_id',Auth::user()->id)->where(function ($q) use ($sq,$settings) {
                foreach ($sq as $key => $value) {
                    if(in_array($key,$settings['table']) && $value){
                        $q->orWhere($key, 'like', "%{$value}%");
                    }
                }
            })->orderByRaw('id DESC')->paginate($settings['pl']);
        }else {
            $rows = Group::where(function ($q) use ($sq, $settings) {
                foreach ($sq as $key => $value) {
                    if (in_array($key, $settings['table']) && $value) {
                        $q->orWhere($key, 'like', "%{$value}%");
                    }
                }
            })->orderByRaw('id DESC')->paginate($settings['pl']);
        }
        return view('group.index', compact('rows', 'settings','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Group::settings();
        return view('group.create', compact('settings'));
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

        ]);
        $request->merge(['password' => bcrypt($request->password)]);
        $request->merge(['employees_id' => Auth::user()->id]);
        Group::create($request->all());

        return redirect()->route('group.index')->with('success',__('group.delr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Group::settings();
        $model = Group::find($id);
        return view('group.edit',compact('model','settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Group::settings();
        $model = Group::find($id);
        return view('group.edit',compact('model','settings'));
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

        ]);

        $request->merge(['employees_id' => Auth::user()->id]);
        $model = Group::find($id);
        $model->update($request->all());

        return redirect()->route('group.index')->with('success',__('group.upr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Group::find($id)->delete();

        return redirect()->route('group.index')
            ->with('success',__('group.dek'));
    }
}
