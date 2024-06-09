<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/messages', function (Request $request) {
    if(\App\Models\Messages::where('room_id',$request->room_id)->count()>0){
    return \App\Models\Messages::where('room_id',$request->room_id)->get();
    }else {
        return ['1'];
    }
});


Route::post('/register', function (Request $request) {

    $thisUser = \App\Models\Employee::where('token',$request->token)->firstOrFail();
      //dd($thisUser);
   if($thisUser->id){

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees',
            'password'   => ['required', \Illuminate\Validation\Rules\Password::defaults()],


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

        $request->merge(['token' => ($request->token)?$request->token:'']);


        if(!$request->eid){
            if ($thisUser->type=='1'){
                $request->merge(['employees_id' => $thisUser->id]);

            }else {
                if($thisUser->id){
                    $request->merge(['employees_id' => $thisUser->id]);
                }

            }
        }else {
            $request->merge(['employees_id' => 0]);
        }

        $id = \App\Models\Employee::create($request->all());

        if($request->return){


            return Redirect::to($request->return);
        }

        return [
            'data'=>$id,
            'status'=>200
        ];

    }else {
        return [
            'text'=> 'Error token',
            'status'=>500
        ];
    }
});


Route::get('/finance', function (Request $request) {

    $thisUser = \App\Models\Employee::where('token',$request->token)->firstOrFail();
    //  dd($thisUser[0]->id);
    if($thisUser->id){

        return [
            'data'=> \App\Models\Finance::where('employees_id',$thisUser->id)->get(),
            'status'=>200
        ];
    }else {
        return [
            'text'=> 'Error token',
            'status'=>500
        ];
    }
});

Route::get('/withdrawal', function (Request $request) {

    $thisUser = \App\Models\Employee::where('token',$request->token)->firstOrFail();
    //  dd($thisUser[0]->id);
    if($thisUser->id){

        return [
            'data'=> \App\Models\Withdrawal::where('employees_id',$thisUser->id)->get(),
            'status'=>200
        ];
    }else {
        return [
            'text'=> 'Error token',
            'status'=>500
        ];
    }
});

Route::get('/tasks', function (Request $request) {

    $thisUser = \App\Models\Employee::where('token',$request->token)->firstOrFail();
    //  dd($thisUser[0]->id);
    if($thisUser->id){

        return [
            'data'=> \App\Models\Tasks::orWhere('make_id',$thisUser->id)->orWhere('create_id',$thisUser->id)->get(),
            'status'=>200
        ];
    }else {
        return [
            'text'=> 'Error token',
            'status'=>500
        ];
    }
});

Route::post('/edittasks', function (Request $request) {

    $thisUser = \App\Models\Employee::where('token',$request->token)->firstOrFail();
    //  dd($thisUser[0]->id);
    if($thisUser->id){

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
        $model = \App\Models\Tasks::find($request->id);

        $settings = \App\Models\Tasks::settings(1);
        foreach ($settings['form'] as $fname => $field){
            if(((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($request->$fname)):$request->$fname)!=(((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($model->$fname)):$model->$fname))){
                \App\Models\Logs::create([
                    'employees_id' => $thisUser->id,
                    'task_id' =>$request->id,
                    'text' => $settings['attr'][$fname].': '.((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($request->$fname)):$request->$fname).'/'.((strpos('-'.$fname.'-',"date"))?date('d.m.Y', strtotime($model->$fname)):$model->$fname).''
                ]);
            }
        }


        // if price be more than start
        if($model->price<$request->price){
            if($thisUser->employees_id){
                $modelEmp = \App\Models\Employee::find($thisUser->employees_id);
            }else {
                $modelEmp = \App\Models\Employee::find($thisUser->id);
            }


            $newPrice = $request->price-$model->price;

            $adminS = \App\Models\Settings::find(1);
            if(!$request->make_id) {
                $removePrice = ($newPrice * ($adminS->commissionnone / 100)) + $newPrice;
            }else {
                $removePrice = ($newPrice * ($adminS->commission / 100)) + $newPrice;
            }
            $balance = $modelEmp->balance;

            $modelEmp->balance = ($balance - $removePrice);
            $modelEmp->update();

            \App\Models\Finance::create([
                'name' => 'Обновление задачи',
                'price' => $newPrice,
                'type' => '1',
                'employees_id' => $thisUser->id
            ]);


            // Зачисление администратору
            if(!$request->make_id) {
                $removePriceAdmin = ($newPrice * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($newPrice * ($adminS->commission / 100));
            }
            $admin = \App\Models\Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance + $removePriceAdmin)
            ]);
            \App\Models\Finance::create([
                'name' => 'Начисление за задачи - '.$request->name,
                'price' => $removePriceAdmin,
                'type' => '0',
                'employees_id' => 1
            ]);


        }



        if($model->price>$request->price){
            if($thisUser->employees_id){
                $modelEmp = \App\Models\Employee::find($thisUser->employees_id);
            }else {
                $modelEmp = \App\Models\Employee::find($thisUser->id);
            }


            $newPrice = $model->price-$request->price;

            $adminS = \App\Models\Settings::find(1);
            if(!$request->make_id) {
                $removePrice = $newPrice - ($newPrice * ($adminS->commissionnone / 100));
            }else {
                $removePrice = $newPrice - ($newPrice * ($adminS->commission / 100));
            }
            $balance = $modelEmp->balance;

            $modelEmp->balance = ($balance + $removePrice);
            $modelEmp->update();

            \App\Models\Finance::create([
                'name' => 'Обновление задачи',
                'price' => $newPrice,
                'type' => '0',
                'employees_id' => $thisUser->id
            ]);


            // Зачисление администратору
            if(!$request->make_id) {
                $removePriceAdmin = ($newPrice * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($newPrice * ($adminS->commission / 100));
            }
            $admin = \App\Models\Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance - $removePriceAdmin)
            ]);
            \App\Models\Finance::create([
                'name' => 'Списание за задачи - '.$request->name,
                'price' => $removePriceAdmin,
                'type' => '1',
                'employees_id' => 1
            ]);


        }

        $u = $model->update($request->all());

        if($request->file('files')){
            foreach ($request->file('files') as $file){
                $thisname = time().'--'.$file->getClientOriginalName();
                $file->storeAs('tasks', $thisname);
                \App\Models\Taskfiles::create([
                    'name'=> $thisname,
                    'task_id'=>$request->id
                ]);
            }
        }

        return [
            'data'=> $u,
            'status'=>200
        ];
    }else {
        return [
            'text'=> 'Error token',
            'status'=>500
        ];
    }
});

Route::post('/addtasks', function (Request $request) {

    $thisUser = \App\Models\Employee::where('token',$request->token)->firstOrFail();
    //  dd($thisUser[0]->id);
    if($thisUser->id){

        $request->merge(['create_id' => $thisUser->id]);
        $request->validate([
            'name' => 'required',
            'text' => 'required',
            'price' => [
                'required',
                function ($attribute, $value, $fail,$thisUser) {
                    if ($thisUser->type=='1') {
                        if($thisUser->employees_id){
                            $model = \App\Models\Employee::find($thisUser->employees_id);
                        }else {
                            $model = \App\Models\Employee::find($thisUser->id);
                        }
                        $adminS = \App\Models\Settings::find(1);

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

        $id = \App\Models\Tasks::create($request->all());

        if ($thisUser->type=='1') {



            if($thisUser->employees_id){
                $model = \App\Models\Employee::find($thisUser->employees_id);
            }else {
                $model = \App\Models\Employee::find($thisUser->id);
            }

            $adminS = \App\Models\Settings::find(1);
            if(!$request->make_id) {
                $removePrice = ($request->price * ($adminS->commissionnone / 100)) + $request->price;
            }else {
                $removePrice = ($request->price * ($adminS->commission / 100)) + $request->price;
            }
            $balance = $model->balance;

            $model->balance = ($balance - $removePrice);
            $model->update();

            \App\Models\Finance::create([
                'name' => 'Создание задачи',
                'price' => $request->price,
                'type' => '1',
                'employees_id' => $thisUser->id
            ]);


            // Зачисление администратору
            if(!$request->make_id) {
                $removePriceAdmin = ($request->price * ($adminS->commissionnone / 100));
            }else {
                $removePriceAdmin = ($request->price * ($adminS->commission / 100));
            }
            $admin = \App\Models\Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance + $removePriceAdmin)
            ]);
            \App\Models\Finance::create([
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

        return [
            'data'=> \App\Models\Tasks::orWhere('make_id',$thisUser->id)->orWhere('create_id',$thisUser->id)->get(),
            'status'=>200
        ];
    }else {
        return [
            'text'=> 'Error token',
            'status'=>500
        ];
    }
});


Route::get('/tasksdestroy', function (Request $request) {

    $thisUser = \App\Models\Employee::where('token',$request->token)->firstOrFail();
    //  dd($thisUser[0]->id);

    if($thisUser->id){
        $id = $thisUser->id;
        foreach (\App\Models\Tasks::where('id', $id)->get() as $value) {

            $model = \App\Models\Employee::find($value['create_id']);


            $adminS = \App\Models\Settings::find(1);
            if(!$value['make_id']) {
                $removePrice = ($value->price * ($adminS->commissionnone / 100)) + $value->price;
            }else {
                $removePrice = ($value->price * ($adminS->commission / 100)) + $value->price;
            }
            $balance = $model->balance;

            $model->balance = ($balance + $removePrice);
            $model->update();

            \App\Models\Finance::create([
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
            $admin = \App\Models\Employee::find(1);
            $admin->update([
                'balance' => ($admin->balance - $removePriceAdmin)
            ]);
            \App\Models\Finance::create([
                'name' => 'Начисление за задачи - пересчет'.$value['name'],
                'price' => $removePriceAdmin,
                'type' => '0',
                'employees_id' => 1
            ]);

        }

        //Tasks::find($id)->delete();
        $t = \App\Models\Tasks::find($id)->update([
            'status' => 6
        ]);
        return [
            'data'=> $t,
            'status'=>200
        ];
    }else {
        return [
            'text'=> 'Error token',
            'status'=>500
        ];
    }
});
