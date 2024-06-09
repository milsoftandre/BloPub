<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settings = Finance::settings(2);
        $sq = $request->all();
        if(Auth::user()->type==0){
        $rows = Finance::where(function ($q) use ($sq,$settings) {
            foreach ($sq as $key => $value) {
                if(in_array($key,$settings['table']) && $value){
                    $q->orWhere($key, 'like', "%{$value}%");
                }
                if($key=='date_from' && $value){
                    $q->whereDate('created_at', '>=', date('Y-m-d', strtotime($value)));
                }

                if($key=='date_to' && $value){
                    $q->whereDate('created_at', '<=', date('Y-m-d', strtotime($value)));
                }
            }
        })->orderByRaw('id DESC')->paginate($settings['pl']);
        }else {
            $rows = Finance::where('employees_id',Auth::user()->id)->where(function ($q) use ($sq,$settings) {
                foreach ($sq as $key => $value) {
                    if(in_array($key,$settings['table']) && $value){
                        $q->orWhere($key, 'like', "%{$value}%");
                    }
                    if($key=='date_from' && $value){
                        $q->whereDate('created_at', '>=', date('Y-m-d', strtotime($value)));
                    }

                    if($key=='date_to' && $value){
                        $q->whereDate('created_at', '<=', date('Y-m-d', strtotime($value)));
                    }
                }
            })->orderByRaw('id DESC')->paginate($settings['pl']);
        }

        return view('finance.index', compact('rows', 'settings','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(Auth::user()->type!=0){
            return redirect()->route('dashboard');
        }
        $settings = Finance::settings(1);
        return view('finance.create', compact('settings'));
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
            'price' => 'required',
            'employees_id' => 'required'
        ]);


        Finance::create($request->all());

        if($request->employees_id){
            if($request->type==0){
                $model = Employee::find($request->employees_id);
                $model->update([
                    'balance' => ($model->balance + $request->price)
                ]);
            }else {
                $model = Employee::find($request->employees_id);
                $model->update([
                    'balance' => ($model->balance - $request->price)
                ]);
            }
        }
        return redirect()->route('finance.index')->with('success',__('finance.delr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Finance::settings();
        $model = Finance::find($id);
        return view('finance.edit',compact('model','settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->type!=0){
            return redirect()->route('dashboard');
        }
        $settings = Finance::settings(1);
        $model = Finance::find($id);
        return view('finance.edit',compact('model','settings'));
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


        $model = Finance::find($id);
        $model->update($request->all());

        return redirect()->route('finance.index')->with('success',__('finance.upr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->type!=0){
            return redirect()->route('dashboard');
        }
        Finance::find($id)->delete();

        return redirect()->route('finance.index')
            ->with('success',__('finance.dek'));
    }
}
