<?php

namespace App\Http\Middleware;

use App\Mail\Sendmail;
use App\Models\Employee;
use App\Models\Finance;
use App\Models\Notifications;
use App\Models\Settings;
use App\Models\Tasks;
use App\Models\Templates;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class IsUserOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $user = Auth::user();
        if($user->id){
            $expiresAt = Carbon::now()->addMinutes(5);

            Employee::find($user->id)->update([
                'online_user' => $expiresAt
            ]);
        }

            if(Auth::user()->ip != $request->ip()){
                Employee::find(Auth::user()->id)->update(['ip'=>$request->ip()]);

                $Templates = Templates::find(5);
                $details = [
                    'title' => $Templates->name,
                    'body' => $Templates->text
                ];
                if(strpos(Employee::find(Auth::user()->id)->email,"@")){
                    Mail::to(Employee::find(Auth::user()->id)->email)->send(new Sendmail($details));
                }
            }

            // Копирование задач, если есть
            if(Tasks::orWhere('cycle_status',0)->orWhere('cycle_status',1)->count()>0){



                foreach (Tasks::orWhere('cycle_status',0)->orWhere('cycle_status',1)->get() as $value) {
                    if(!empty($value['cycle']) or $value['cycle_status']==1){


                        $time = 86400 * $value['cycle'];

                        if($value['cycle_status']==1){$time=time()+1000000000;}
                            if((strtotime($value['created_at'])+$time)<time() || (strtotime($value['date_cycle']))<time()){
                               // dd($value['date_cycle']);
                                $id = $value['id'];
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
                                    'status' => $thisTask->status,
                                    'date_cycle' => ($value['cycle_status']==1 && $value['date_cycle']!='0000-00-00 00:00:00')?date('Y-m-d H:i:s',strtotime("+1 month", strtotime($value['date_cycle']))):date('Y-m-d H:i:s'),
                                    'cycle_status' => $thisTask->cycle_status
                                ];
                                Tasks::find($id)->update(['cycle_status' => 2]);

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

                            }
                    }else {
                            Tasks::find($value['id'])->update(['cycle_status' => 2]);
                    }
                    break;
                }

            }
        }
        return $next($request);
    }
}
