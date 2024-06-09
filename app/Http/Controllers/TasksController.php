<?php

namespace App\Http\Controllers;

use App\Mail\Sendmail;
use App\Models\Employee;
use App\Models\Finance;
use App\Models\Group;
use App\Models\Logs;
use App\Models\Notifications;
use App\Models\Settings;
use App\Models\Taskfiles;
use App\Models\Tasks;
use App\Models\Templates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // Notifications::find(5)->delete();

        $settings = Tasks::settings(2);
        $sq = $request->all();
        if (Auth::user()->type=='1'){
            $rows = Tasks::where('status',($request->status)?'=':'!=',($request->status)?$request->status:'6')->where('create_id',Auth::user()->id)->where(function ($q) use ($sq,$settings) {
                foreach ($sq as $key => $value) {
                    if(in_array($key,$settings['table']) && $value){
                        $q->where($key, 'like', "%{$value}%");
                    }
                    if(in_array($key,$settings['table']) && $value==0){
                        $q->where($key, 'like', "%{$value}%");
                    }
                    if($key=='date_from' && $value){
                        $q->whereDate('created_at', '>=', date('Y-m-d', strtotime($value)));
                    }

                    if($key=='date_to' && $value){
                        $q->whereDate('created_at', '<=', date('Y-m-d', strtotime($value)));
                    }

                }
            })->orderByRaw('id DESC')->paginate($settings['pl']);
        }elseif (Auth::user()->type=='2'){
        $rows = Tasks::where('make_id',Auth::user()->id)->where(function ($q) use ($sq,$settings) {
            foreach ($sq as $key => $value) {
                if(in_array($key,$settings['table']) && $value){
                    $q->where($key, 'like', "%{$value}%");
                }
                if(in_array($key,$settings['table']) && $value==0){
                    $q->where($key, 'like', "%{$value}%");
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
        $rows = Tasks::where('status',($request->status)?'=':'!=',($request->status)?$request->status:'6')->where(function ($q) use ($sq,$settings) {
            foreach ($sq as $key => $value) {
                if(in_array($key,$settings['table']) && $value){
                    $q->where($key, 'like', "%{$value}%");
                }
                if(in_array($key,$settings['table']) && $value==0){
                    $q->where($key, 'like', "%{$value}%");
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

        $groups = Group::select('id', 'name')->where('employees_id',Auth::user()->id)->pluck('name', 'id')->prepend(__('tasks.groupsc'), '')->toArray();
        return view('tasks.index', compact('rows', 'settings','request', 'groups'));
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
        $settings = Tasks::settings(1);
        return view('tasks.create', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->merge(['create_id' => Auth::id()]);
        $request->validate([
            'name' => 'required',
            'text' => 'required',
            'price' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (Auth::user()->type=='1') {
                        if(Auth::user()->employees_id){
                            $model = Employee::find(Auth::user()->employees_id);
                        }else {
                            $model = Employee::find(Auth::id());
                        }
                        $adminS = Settings::find(1);

                            $removePrice = ($value * ($adminS->commission / 100)) + $value;

                        if ($model->balance  < $removePrice) {
                            $fail('Ваш баланс меньше суммы задачи');
                        }
                    }
                },
            ],
            'end_date' => 'required',
            'create_id' => 'required',
            'make_id' => 'required',
//            'cat_id' => 'required',
//            'service_id' => 'required',
//            'group_id' => 'required',
        ],[
            'name.required' => 'Укажите название задачи',
            'text.required' => 'Укажите описание задачи',
            'end_date.required' => 'Укажите дату задачи',
            'price.required' => 'Укажите стоимость задачи',
        ]);
        if(!$request->url){ $request->merge(['url'=>'']); }
        if(!$request->rek){ $request->merge(['rek'=>'']); }
        if(!$request->comment){ $request->merge(['comment'=>'']); }
        if(!$request->status){ $request->merge(['status'=>0]); }
        if(!$request->cat_id){ $request->merge(['cat_id'=>0]); }
        if(!$request->service_id){ $request->merge(['service_id'=>0]); }
        if(!$request->group_id){ $request->merge(['group_id'=>0]); }

        if(!$request->cycle){ $request->merge(['cycle'=>0]); }
        if(!$request->cycle_status){ $request->merge(['cycle_status'=>0]); }
        if($request->date_cycle){ $request->merge(['cycle_status'=>1]); }


        if(!$request->date_cycle){ $request->merge(['date_cycle'=>date('Y-m-d H:i:s')]); }

        $id = Tasks::create($request->all());

        if (Auth::user()->type=='1') {



            if(Auth::user()->employees_id){
                $model = Employee::find(Auth::user()->employees_id);
            }else {
            $model = Employee::find(Auth::id());
            }

            $adminS = Settings::find(1);
            if(!$request->make_id) {
                $removePrice = ($request->price * ($adminS->commissionnone / 100)) + $request->price;
            }else {
                $removePrice = ($request->price * ($adminS->commission / 100)) + $request->price;
            }
            $balance = $model->balance;

            $model->balance = ($balance - $removePrice);
            $model->update();

            Finance::create([
                'name' => 'Создание задачи',
                'price' => $request->price,
                'type' => '1',
                'employees_id' => Auth::id()
            ]);


            // Зачисление администратору
            if(!$request->make_id) {
                $removePriceAdmin = ($request->price * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($request->price * ($adminS->commission / 100));
            }
            $admin = Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance + $removePriceAdmin)
            ]);
            Finance::create([
                'name' => 'Начисление за задачи - '.$id->name,
                'price' => $removePriceAdmin,
                'type' => '0',
                'employees_id' => 1
            ]);

        }

        if($request->file('files')) {
            foreach ($request->file('files') as $file) {
                $thisname = time() . '--' . $file->getClientOriginalName();
                $file->storeAs('tasks', $thisname);
                Taskfiles::create([
                    'name' => $thisname,
                    'task_id' => $id->id
                ]);
            }
        }

        if($request->make_id) {
            // Отправка исполнителю

            $Templates = Templates::find(4);
            $details = [
                'title' => $Templates->name,
                'body' => $Templates->text
            ];
            if(strpos(Employee::find($request->make_id)->email,"@")){
            Mail::to(Employee::find($request->make_id)->email)->send(new Sendmail($details));
            }
            Notifications::create([
                'user_id' => $request->make_id,
                'status' => 0,
                'text' => 'Вам добавлена новая задача'
            ]);
        }

        return redirect()->route('tasks.index')->with('success',__('tasks.sadd'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settings = Tasks::settings(1);
        $model = Tasks::find($id);
        return view('tasks.show',compact('model','settings'));
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
        $settings = Tasks::settings(1);
        $model = Tasks::find($id);
        return view('tasks.edit',compact('model','settings'));
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
            'price' => 'required',
            'end_date' => 'required',
            'make_id' => 'required',
//            'cat_id' => 'required',
//            'service_id' => 'required',
//            'group_id' => 'required',

        ],[
            'name.required' => 'Укажите название задачи',
            'text.required' => 'Укажите описание задачи',
            'end_date.required' => 'Укажите дату задачи',
            'price.required' => 'Укажите стоимость задачи',
        ]);
        if(!$request->url){ $request->merge(['url'=>'']); }
        if(!$request->rek){ $request->merge(['rek'=>'']); }
        if(!$request->comment){ $request->merge(['comment'=>'']); }
        if(!$request->status){ $request->merge(['status'=>0]); }
        if(!$request->cat_id){ $request->merge(['cat_id'=>0]); }
        if(!$request->service_id){ $request->merge(['service_id'=>0]); }
        if(!$request->group_id){ $request->merge(['group_id'=>0]); }
        if(!$request->cycle){ $request->merge(['cycle'=>0]); }
        if(!$request->cycle_status){ $request->merge(['cycle_status'=>0]); }
       // dd($request->rek);
        $model = Tasks::find($id);

        $settings = Tasks::settings(1);
        foreach ($settings['form'] as $fname => $field){
            if(((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($request->$fname)):$request->$fname)!=(((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($model->$fname)):$model->$fname))){
                Logs::create([
                    'employees_id' => Auth::user()->id,
                    'task_id' =>$id,
                    'text' => $settings['attr'][$fname].': '.((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($request->$fname)):$request->$fname).'/'.((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($model->$fname)):$model->$fname).''
                ]);
            }
        }


        // if price be more than start
        if($model->price<$request->price){
            if(Auth::user()->employees_id){
                $modelEmp = Employee::find(Auth::user()->employees_id);
            }else {
                $modelEmp = Employee::find(Auth::id());
            }


            $newPrice = $request->price-$model->price;

            $adminS = Settings::find(1);
            if(!$request->make_id) {
                $removePrice = ($newPrice * ($adminS->commissionnone / 100)) + $newPrice;
            }else {
                $removePrice = ($newPrice * ($adminS->commission / 100)) + $newPrice;
            }
            $balance = $modelEmp->balance;

            $modelEmp->balance = ($balance - $removePrice);
            $modelEmp->update();

            Finance::create([
                'name' => 'Обновление задачи',
                'price' => $newPrice,
                'type' => '1',
                'employees_id' => Auth::id()
            ]);


            // Зачисление администратору
            if(!$request->make_id) {
                $removePriceAdmin = ($newPrice * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($newPrice * ($adminS->commission / 100));
            }
            $admin = Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance + $removePriceAdmin)
            ]);
            Finance::create([
                'name' => 'Начисление за задачи - '.$request->name,
                'price' => $removePriceAdmin,
                'type' => '0',
                'employees_id' => 1
            ]);


        }



        if($model->price>$request->price){
            if(Auth::user()->employees_id){
                $modelEmp = Employee::find(Auth::user()->employees_id);
            }else {
                $modelEmp = Employee::find(Auth::id());
            }


            $newPrice = $model->price-$request->price;

            $adminS = Settings::find(1);
            if(!$request->make_id) {
                $removePrice = $newPrice - ($newPrice * ($adminS->commissionnone / 100));
            }else {
                $removePrice = $newPrice - ($newPrice * ($adminS->commission / 100));
            }
            $balance = $modelEmp->balance;

            $modelEmp->balance = ($balance + $removePrice);
            $modelEmp->update();

            Finance::create([
                'name' => 'Обновление задачи',
                'price' => $newPrice,
                'type' => '0',
                'employees_id' => Auth::id()
            ]);


            // Зачисление администратору
            if(!$request->make_id) {
                $removePriceAdmin = ($newPrice * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($newPrice * ($adminS->commission / 100));
            }
            $admin = Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance - $removePriceAdmin)
            ]);
            Finance::create([
                'name' => 'Списание за задачи - '.$request->name,
                'price' => $removePriceAdmin,
                'type' => '1',
                'employees_id' => 1
            ]);


        }

        $model->update($request->all());

        if($request->file('files')){
            foreach ($request->file('files') as $file){
                $thisname = time().'--'.$file->getClientOriginalName();
                $file->storeAs('tasks', $thisname);
                Taskfiles::create([
                    'name'=> $thisname,
                    'task_id'=>$id
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('success',__('tasks.supd'));
    }



    public function copy(Request $request)
    {
        $id = $request->id;
        $thisTask = Tasks::find($id);

        $copyArr = [
            'name' => $thisTask->name,
            'url' => $thisTask->url,
            'text' => $thisTask->text,
            'price' => $thisTask->price,
            'end_date' => $thisTask->end_date,
            'create_id' => $thisTask->create_id,
            'make_id' => $thisTask->make_id,
            'cat_id' => $thisTask->cat_id,
            'service_id' => $thisTask->service_id,
            'group_id' => $thisTask->group_id,
            'rek' => $thisTask->rek,
            'comment' => $thisTask->comment,
            'status' => 0,
        ];


        $id = Tasks::create($copyArr);

        if (Auth::user()->type=='1') {



            if(Auth::user()->employees_id){
                $model = Employee::find(Auth::user()->employees_id);
            }else {
                $model = Employee::find(Auth::id());
            }

            $adminS = Settings::find(1);
            if(!$thisTask->make_id) {
                $removePrice = ($thisTask->price * ($adminS->commissionnone / 100)) + $thisTask->price;
            }else {
                $removePrice = ($thisTask->price * ($adminS->commission / 100)) + $thisTask->price;
            }
            $balance = $model->balance;

            $model->balance = ($balance - $removePrice);
            $model->update();

            Finance::create([
                'name' => 'Создание задачи',
                'price' => $thisTask->price,
                'type' => '1',
                'employees_id' => Auth::id()
            ]);


            // Зачисление администратору
            if(!$thisTask->make_id) {
                $removePriceAdmin = ($thisTask->price * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($thisTask->price * ($adminS->commission / 100));
            }
            $admin = Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance + $removePriceAdmin)
            ]);
            Finance::create([
                'name' => 'Начисление за задачи - '.$id->name,
                'price' => $removePriceAdmin,
                'type' => '0',
                'employees_id' => 1
            ]);

        }

//        if($thisTask->file('files')) {
//            foreach ($thisTask->file('files') as $file) {
//                $thisname = time() . '--' . $file->getClientOriginalName();
//                $file->storeAs('tasks', $thisname);
//                Taskfiles::create([
//                    'name' => $thisname,
//                    'task_id' => $id->id
//                ]);
//            }
//        }

        if($thisTask->make_id) {
            // Отправка исполнителю

            $Templates = Templates::find(4);
            $details = [
                'title' => $Templates->name,
                'body' => $Templates->text
            ];
            if(strpos(Employee::find($thisTask->make_id)->email,"@")){
                Mail::to(Employee::find($thisTask->make_id)->email)->send(new Sendmail($details));
            }
            Notifications::create([
                'user_id' => $thisTask->make_id,
                'status' => 0,
                'text' => 'Вам добавлена новая задача'
            ]);
        }

        return redirect()->route('tasks.index');
    }
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        foreach (Tasks::where('id', $id)->get() as $value) {

            $model = Employee::find($value['create_id']);


            $adminS = Settings::find(1);
            if(!$value['make_id']) {
                $removePrice = ($value->price * ($adminS->commissionnone / 100)) + $value->price;
            }else {
                $removePrice = ($value->price * ($adminS->commission / 100)) + $value->price;
            }
            $balance = $model->balance;

            $model->balance = ($balance + $removePrice);
            $model->update();

            Finance::create([
                'name' => 'Удаление задачи (пересчет)',
                'price' => $value->price,
                'type' => '0',
                'employees_id' => $value['create_id']
            ]);


            // Зачисление администратору
            if(!$value['make_id']) {
                $removePriceAdmin = ($value['price'] * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($value['price'] * ($adminS->commission / 100));
            }
            $admin = Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance - $removePriceAdmin)
            ]);
            Finance::create([
                'name' => 'Начисление за задачи - пересчет'.$value['name'],
                'price' => $removePriceAdmin,
                'type' => '0',
                'employees_id' => 1
            ]);

        }

        //Tasks::find($id)->delete();
        Tasks::find($id)->update([
            'status' => 6
        ]);
        return redirect()->route('tasks.index')
            ->with('success',__('tasks.sdel'));
    }


    public function ch(Request $request)
    {

        // обновление цикла
        if($request->start){
            $model = Tasks::find($request->id);

            if($model->date_cycle && $model->date_cycle!='0000-00-00 00:00:00'){
                Tasks::find($request->id)->update([
                    'cycle_status' => 1
                ]);
            }

            if($model->cycle){
                Tasks::find($request->id)->update([
                    'cycle_status' => 0
                ]);
            }
            return true;
        }
        if($request->stop){
            Tasks::find($request->id)->update([
                'cycle_status' => 2
            ]);
            return true;
        }
        $id = $request->id;
        $status = $request->status;
        Tasks::find($id)->update([
            'status' => $status
        ]);

        if($status==5 && Tasks::find($id)->make_id){
            Finance::create([
                'name' => 'Оплата задачи',
                'price' => Tasks::find($id)->price,
                'type' => '0',
                'employees_id' => Tasks::find($id)->make_id
            ]);

            $model = Employee::find(Tasks::find($id)->make_id);

            $model->update([
                'balance' => ($model->balance + Tasks::find($id)->price)
            ]);

            // Отправка исполнителю
            $Templates = Templates::find(1);
            $details = [
                'title' => $Templates->name,
                'body' => $Templates->text
            ];
            if(strpos(Employee::find(Tasks::find($id)->make_id)->email,"@")) {
                Mail::to(Employee::find(Tasks::find($id)->make_id)->email)->send(new Sendmail($details));
            }

            Notifications::create([
                'user_id' => Tasks::find($id)->make_id,
                'status' => 0,
                'text' => 'Задача выполнена, клиент подтвердил оплату - '.Tasks::find($id)->name
            ]);

            // Зачисление агенту
            $thisT = Tasks::find($id);

            if(Employee::find($thisT->create_id)->partner_id){
                Finance::create([
                    'name' => 'Оплата задачи от '.Employee::find($thisT->create_id)->name,
                    'price' => Tasks::find($id)->price,
                    'type' => '0',
                    'employees_id' => Employee::find($thisT->create_id)->partner_id
                ]);

                $model = Employee::find(Employee::find($thisT->create_id)->partner_id);
                $p = Tasks::find($id)->price * ($model->prec / 100);
                $model->update([
                    'balance' => ($model->balance + $p)
                ]);
            }

        }

        if($status==2){
            // Отправка на проверке
            $Templates = Templates::find(2);
            $details = [
                'title' => $Templates->name,
                'body' => $Templates->text
            ];

            if(strpos(Employee::find(Tasks::find($id)->create_id)->email,"@")) {
                Mail::to(Employee::find(Tasks::find($id)->create_id)->email)->send(new Sendmail($details));
            }
            Notifications::create([
                'user_id' => Tasks::find($id)->create_id,
                'status' => 0,
                'text' => 'Исполнитель подтвердил выполнение - '.Tasks::find($id)->name
            ]);
        }
        if($status==3){
            // Отправка на доработку
            $Templates = Templates::find(3);
            $details = [
                'title' => $Templates->name,
                'body' => $Templates->text
            ];


            if(strpos(Employee::find(Tasks::find($id)->make_id)->email,"@")) {
                Mail::to(Employee::find(Tasks::find($id)->make_id)->email)->send(new Sendmail($details));
            }
            Notifications::create([
                'user_id' => Tasks::find($id)->make_id,
                'status' => 0,
                'text' => 'Клиент отправил на доработку задачу '.Tasks::find($id)->name
            ]);
        }
        return redirect()->route('tasks.index')
            ->with('success',__('tasks.supd'));
    }


    public function delfiles(Request $request)
    {
        if(Taskfiles::find($request->id) && Storage::delete('tasks/'.Taskfiles::find($request->id)->name)){
            return Taskfiles::find($request->id)->delete();
        }
        return response()->view('', [], 500);

    }


    public function updatech(Request $request)
    {

        if($request->del){

            foreach (Tasks::whereIn('id', $request->ids)->get() as $value) {

                    $model = Employee::find($value['create_id']);


                $adminS = Settings::find(1);
                if(!$value['make_id']) {
                    $removePrice = ($value->price * ($adminS->commissionnone / 100)) + $value->price;
                }else {
                    $removePrice = ($value->price * ($adminS->commission / 100)) + $value->price;
                }
                $balance = $model->balance;

                $model->balance = ($balance + $removePrice);
                $model->update();

                Finance::create([
                    'name' => 'Удаление задачи (пересчет)',
                    'price' => $value->price,
                    'type' => '0',
                    'employees_id' => $value['create_id']
                ]);


                // Зачисление администратору
                if(!$value['make_id']) {
                    $removePriceAdmin = ($value['price'] * ($adminS->commissionnone / 100));
                }else {
                    $removePriceAdmin = ($value['price'] * ($adminS->commission / 100));
                }
                $admin = Employee::find(1);
                $admin->update([
                    'balance' => ($admin->balance - $removePriceAdmin)
                ]);
                Finance::create([
                    'name' => 'Начисление за задачи - пересчет'.$value['name'],
                    'price' => $removePriceAdmin,
                    'type' => '0',
                    'employees_id' => 1
                ]);

            }

            Tasks::whereIn('id', $request->ids)->delete();
        }else {


            if($request->change_status || $request->change_status==0){
                Tasks::whereIn('id', $request->ids)->update(['status' => $request->change_status]);
            }

            if($request->change_group){
                Tasks::whereIn('id', $request->ids)->update(['group_id' => $request->change_group]);
            }
        }


    }
}
