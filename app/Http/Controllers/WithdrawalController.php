<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = Withdrawal::settings(2);
        $sq = $request->all();
        if(Auth::user()->type==0){
            $rows = Withdrawal::where(function ($q) use ($sq,$settings) {
                foreach ($sq as $key => $value) {
                    if(in_array($key,$settings['table']) && $value){
                        $q->orWhere($key, 'like', "%{$value}%");
                    }
                }
            })->orderByRaw('id DESC')->paginate($settings['pl']);
        }else {
            $rows = Withdrawal::where('user_id',Auth::user()->id)->where(function ($q) use ($sq,$settings) {
                foreach ($sq as $key => $value) {
                    if(in_array($key,$settings['table']) && $value){
                        $q->orWhere($key, 'like', "%{$value}%");
                    }
                }
            })->orderByRaw('id DESC')->paginate($settings['pl']);
        }

        return view('withdrawal.index', compact('rows', 'settings','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Withdrawal::settings(1);
        return view('withdrawal.create', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->type==2) {
            $request->merge(['text' => __('withdrawal.zay') . date("d.m.Y")]);
            $request->merge(['user_id' => Auth::user()->id]);

            $model = Employee::find(Auth::user()->id);
            if($model->balance>=$request->price){
            $model->update([
                'balance' => ($model->balance - $request->price)
            ]);

            Finance::create([
                'name' => __('withdrawal.zay') . date("d.m.Y"),
                'price' => $request->price,
                'type' => 1,
                'employees_id' =>Auth::user()->id
            ]);
            }else {
                return redirect()->route('withdrawal.create')->withErrors(['msg' => __('withdrawal.more')]);
            }
        }

        $request->validate([
            'text' => 'required',
            'price' => 'required',
            'user_id' => 'required'
        ]);


        Withdrawal::create($request->all());


        return redirect()->route('withdrawal.index')->with('success',__('withdrawal.delr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Withdrawal::settings();
        $model = Withdrawal::find($id);
        return view('withdrawal.edit',compact('model','settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Withdrawal::settings(1);
        $model = Withdrawal::find($id);
        return view('withdrawal.edit',compact('model','settings'));
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
            'price' => 'required',
        ]);


        $model = Withdrawal::find($id);
        $model->update($request->all());

        return redirect()->route('withdrawal.index')->with('success',__('withdrawal.upr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->type==2){
            return redirect()->route('dashboard');
        }
        Withdrawal::find($id)->delete();

        return redirect()->route('withdrawal.index')
            ->with('success',__('withdrawal.dek'));
    }

    public function ch(Request $request)
    {


        if($request->status==1){
            Withdrawal::find($request->id)->update(['status' => 1]);
        }
        return redirect()->route('withdrawal.index')
            ->with('success',__('withdrawal.supd'));



    }
}
