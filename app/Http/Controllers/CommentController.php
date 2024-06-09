<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if($request->task_id){
            $thisRoom = $request->task_id;
            $mes = Comment::where('task_id',$request->task_id)->get();
        }else {
            $mes = [];
            $thisRoom = 0;
        }

        return view('chat', compact('mes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->text && $request->task_id){
            return Comment::create([
                'employees_id' => Auth::user()->id,
                'task_id' =>$request->task_id,
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
        if($request->task_id){
            $thistask = $request->task_id;
            $mes = Comment::where('task_id',$request->task_id)->get();
        }else {
            $mes = [];
            $thisRoom = 0;
        }


        return view('mes', compact('mes','thistask'));
    }
}
