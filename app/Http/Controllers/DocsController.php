<?php

namespace App\Http\Controllers;

use App\Models\Docs;
use App\Models\Employee;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

//use PhpOffice\PhpWord\PhpWord;

//use PhpOffice\PhpWord\TemplateProcessor;



class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('docs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if($request->id){
        $file = base_path('storage/app/templ.docx');

       // $phpWord = new PhpWord();
            $thisEl = Finance::find($request->id);
            $thisEm = Employee::find($thisEl->employees_id);

        $phpword = new \PhpOffice\PhpWord\TemplateProcessor($file);
       // $phpWord= $phpWord->
        $phpword->setValue('{{name}}',$thisEm->name);
            $phpword->setValue('{{price}}',$thisEl->price);
        $phpword->setValue('{{text}}',$thisEl->name);

        $phpword->saveAs(base_path('storage/app/edited.docx'));

        return Storage::download('edited.docx');
        }else {
            $file = base_path('storage/app/a.docx');
            $phpword = new \PhpOffice\PhpWord\TemplateProcessor($file);
            // $phpWord= $phpWord->
            $phpword->setValue('{{name}}',$request->name);
            $phpword->setValue('{{name2}}',$request->name2);
            $phpword->setValue('{{sum}}',$request->sum);
            $phpword->setValue('{{text}}',$request->text);
            $phpword->setValue('{{num}}',$request->num);
            $phpword->setValue('{{date}}',$request->date);
            $phpword->setValue('{{service}}',$request->service);
            $phpword->setValue('{{rek}}',$request->rek);
            $phpword->setValue('{{rek2}}',$request->rek2);

            $phpword->saveAs(base_path('storage/app/edited.docx'));

            return Storage::download('edited.docx');
        }
        //return view('docs.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Docs  $docs
     * @return \Illuminate\Http\Response
     */
    public function show(Docs $docs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Docs  $docs
     * @return \Illuminate\Http\Response
     */
    public function edit(Docs $docs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Docs  $docs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Docs $docs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Docs  $docs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Docs $docs)
    {
        //
    }
}
