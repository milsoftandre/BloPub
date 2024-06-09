<?php

namespace App\Http\Controllers;

use App\Mail\Sendmail;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Templates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->type==2){
            return redirect()->route('dashboard');
        }
        $settings = Employee::settings(2);
        $sq = $request->all();
        $type = 1;
        if (Auth::user()->type=='1'){
            $rows = Employee::where('type',$type)->where('status','!=',(($request->status)?'0':'1'))->where('employees_id',(Auth::user()->employees_id)?Auth::user()->employees_id:Auth::user()->id)->where(function ($q) use ($sq,$settings) {
                foreach ($sq as $key => $value) {
                    if(in_array($key,$settings['table']) && $value && $key !='status'){
                        $q->orWhere($key, 'like', "%{$value}%");
                    }
                }
            })->orderByRaw('id DESC')->paginate($settings['pl']);
        }else {
        $rows = Employee::where('type',$type)->where('status','!=',(($request->status)?'0':'1'))->where(function ($q) use ($sq,$settings) {
            foreach ($sq as $key => $value) {
                if(in_array($key,$settings['table']) && $value && $key !='status'){
                    $q->orWhere($key, 'like', "%{$value}%");
                }
            }
        })->orderByRaw('id DESC')->paginate($settings['pl']);
        }
        return view('client.index', compact('rows', 'settings','request','type'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->type==2){
            return redirect()->route('dashboard');
        }
        $settings = Employee::settings(1,1);
        return view('client.create', compact('settings'));
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
            'email' => 'required|unique:employees',
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],


        ]);
        $request->merge(['password' => bcrypt($request->password)]);

        $request->merge(['lname' => ($request->lname)?$request->lname:'']);
        $request->merge(['dir' => ($request->dir)?$request->dir:'']);
        $request->merge(['inn' => ($request->inn)?$request->inn:'']);
        $request->merge(['inn' => ($request->inn)?$request->inn:'']);
        $request->merge(['ogrn' => ($request->ogrn)?$request->ogrn:'']);
        $request->merge(['uadres' => ($request->uadres)?$request->uadres:'']);
        $request->merge(['rs' => ($request->rs)?$request->rs:'']);
        $request->merge(['bname' => ($request->bname)?$request->bname:'']);
        $request->merge(['badres' => ($request->badres)?$request->badres:'']);
        $request->merge(['bkor' => ($request->bkor)?$request->bkor:'']);
        $request->merge(['bic' => ($request->bic)?$request->bic:'']);

        $request->merge(['kpp' => ($request->kpp)?$request->kpp:'']);
        $request->merge(['position' => ($request->position)?$request->position:'']);
        $request->merge(['swift' => ($request->swift)?$request->swift:'']);
        $request->merge(['tel' => ($request->tel)?$request->tel:'']);
        $request->merge(['code' => ($request->code)?$request->code:'']);
        $request->merge(['lang' => ($request->lang)?$request->lang:'']);


        $request->merge(['ip' => ($request->ip)?$request->ip:'']);
        $request->merge(['lastdatecode' => ($request->lastdatecode)?$request->lastdatecode:date('Y-m-d H:i:s')]);
        $request->merge(['type' => 1]);

        $request->merge(['apiips' => ($request->apiips)?$request->apiips:'']);
        $request->merge(['partner_id' => ($request->partner_id)?$request->partner_id:0]);
        $request->merge(['prec' => ($request->prec)?$request->prec:0]);
        $request->merge(['promo' => ($request->promo)?$request->promo:'']);

        if (Auth::user()->type=='1'){
            $request->merge(['employees_id' => Auth::user()->id]);
        }else {
            if(!$request->password) { $request->merge(['employees_id' => 0]); }
        }

         $id = Employee::create($request->all());
        if (Auth::user()->type!='1') {
            Group::create([
                'name' => 'Общая',
                'employees_id' => $id->id
            ]);
        }
        return redirect()->route('client.index')->with('success',__('client.delr'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Employee::settings(2);
        $model = Employee::find($id);
        return view('client.edit',compact('model','settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->type==2){
            return redirect()->route('dashboard');
        }
        $settings = Employee::settings(1,1);
        $model = Employee::find($id);
        return view('client.edit',compact('model','settings'));
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
            'email' => 'required',

        ]);


        $request->merge(['lname' => ($request->lname)?$request->lname:'']);
        $request->merge(['dir' => ($request->dir)?$request->dir:'']);
        $request->merge(['inn' => ($request->inn)?$request->inn:'']);
        $request->merge(['inn' => ($request->inn)?$request->inn:'']);
        $request->merge(['ogrn' => ($request->ogrn)?$request->ogrn:'']);
        $request->merge(['uadres' => ($request->uadres)?$request->uadres:'']);
        $request->merge(['rs' => ($request->rs)?$request->rs:'']);
        $request->merge(['bname' => ($request->bname)?$request->bname:'']);
        $request->merge(['badres' => ($request->badres)?$request->badres:'']);
        $request->merge(['bkor' => ($request->bkor)?$request->bkor:'']);
        $request->merge(['bic' => ($request->bic)?$request->bic:'']);

        $request->merge(['kpp' => ($request->kpp)?$request->kpp:'']);
        $request->merge(['position' => ($request->position)?$request->position:'']);
        $request->merge(['swift' => ($request->swift)?$request->swift:'']);
        $request->merge(['tel' => ($request->tel)?$request->tel:'']);
        $request->merge(['code' => ($request->code)?$request->code:'']);
        $request->merge(['lang' => ($request->lang)?$request->lang:'']);


        $request->merge(['ip' => ($request->ip)?$request->ip:'']);
        $request->merge(['lastdatecode' => ($request->lastdatecode)?$request->lastdatecode:date('Y-m-d H:i:s')]);


        $request->merge(['apiips' => ($request->apiips)?$request->apiips:'']);
        $request->merge(['partner_id' => ($request->partner_id)?$request->partner_id:0]);
        $request->merge(['prec' => ($request->prec)?$request->prec:0]);
        $request->merge(['promo' => ($request->promo)?$request->promo:'']);

        if (trim($request->get('password')) == '') {
            $data = $request->except('password');
        }else {
            $request->merge(['password' => bcrypt($request->password)]);
            $data = $request->all();
        }
        if (Auth::user()->type=='1'){
            $request->merge(['employees_id' => Auth::user()->id]);
        }else {
            if(!$request->password) { $request->merge(['employees_id' => 0]); }
        }
        $model = Employee::find($id);
      //  print_r($request); exit;
       $model->update($data);

        return redirect()->route('client.index')->with('success',__('client.upr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //  Employee::find($id)->delete();
        if(Employee::find($id)->status==0) {
            //Employee::find($id)->delete();
            Employee::find($id)->update([
                'status' => 1
            ]);

            $Templates = Templates::find(6);
            $details = [
                'title' => $Templates->name,
                'body' => $Templates->text
            ];
            if(strpos(Employee::find($id)->email,"@")){
                Mail::to(Employee::find($id)->email)->send(new Sendmail($details));
            }

        }else {
            Employee::find($id)->update([
                'status' => 0
            ]);
        }
        return redirect()->route('client.index')
            ->with('success',__('client.dek'));
    }
}
