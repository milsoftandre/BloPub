<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->room_id){
            $thisRoom = $request->room_id;
            $mes = Messages::where('room_id',$request->room_id)->orderBy('id', 'ASC')->get();
        }else {
            $mes = [];
            $thisRoom = 0;
        }

        if(Rooms::where('employees_id_from',Auth::user()->id)->where('employees_id_to',$request->uid)->count()==0 && Rooms::where('employees_id_from',$request->uid)->where('employees_id_to',Auth::user()->id)->count() == 0 && $request->uid){
            Rooms::create([
                'employees_id_from' => Auth::user()->id,
                'employees_id_to' => $request->uid
            ]);
        }

        $rooms = Rooms::orWhere('employees_id_from',Auth::user()->id)->orWhere('employees_id_to',Auth::user()->id)->get();


            return view('chat', compact('mes', 'rooms','thisRoom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->text && $request->room_id){

            if(Rooms::find($request->room_id)->employees_id_from == Auth::user()->id){
            Rooms::where('id', $request->room_id)->update(['up_to' => 1]);
            }else {
                Rooms::where('id', $request->room_id)->update(['up_from' => 1]);
            }
        return Messages::create([
            'employees_id' => Auth::user()->id,
            'room_id' =>$request->room_id,
            'text' => $request->text
        ]);
        }else {
            return false;
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        if($request->del){
            $isNew = Rooms::where('employees_id_from', Auth::user()->id)->where('id',$request->del)->count();
            $isNew2 = Rooms::where('employees_id_to', Auth::user()->id)->where('id',$request->del)->count();
//print_r($isNew); print_r($isNew2);
            if($isNew>0 || $isNew2>0){
                Rooms::where('id',$request->del)->delete();
                Messages::where('room_id',$request->room_id)->delete();
                    return true;
            }
            return false;
        }

        if($request->new){
            $isNew = Rooms::where('employees_id_from', Auth::user()->id)->where('up_from',1)->count();
            $isNew2 = Rooms::where('employees_id_to', Auth::user()->id)->where('up_to',1)->count();
//print_r($isNew); print_r($isNew2);
            if($isNew>0 || $isNew2>0){
                return 1;
            }

            return 0;
        }



        if($request->room_id){

            if($request->read) {
//                print_r(Rooms::where('employees_id_from', Auth::user()->id)->where('up_from',1)->get());
//                print_r(Rooms::where('employees_id_to', Auth::user()->id)->where('up_to',1)->get());
                foreach (Rooms::where('employees_id_from', Auth::user()->id)->where('up_from',1)->get() as $r){
                    Rooms::where('id', $r->id)->update(['up_from' => 0]);
                }
                foreach (Rooms::where('employees_id_to', Auth::user()->id)->where('up_to',1)->get() as $r){
                    Rooms::where('id', $r->id)->update(['up_to' => 0]);
                }
//                if (Rooms::find($request->room_id)->employees_id_from == Auth::user()->id) {
//                    Rooms::where('id', $request->room_id)->update(['up_from' => 0]);
//                } else {
//                    Rooms::where('id', $request->room_id)->update(['up_to' => 0]);
//                }
            }
            $thisRoom = $request->room_id;
            $mes = Messages::where('room_id',$request->room_id)->orderBy('id', 'DESC')->get();
        }else {
            $mes = [];
            $thisRoom = 0;
        }
        return view('mes', compact('mes','thisRoom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
